<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Noticia;

class NoticiaApiController extends Controller
{
    public function index()
    {
        $noticias = Noticia::with(['categoria', 'autor'])
            ->where('publicado', true)
            ->latest('created_at')
            ->get()
            ->map(function ($noticia) {
                return [
                    'id'        => $noticia->id,
                    'titulo'    => $noticia->titulo,
                    'resumo'    => $noticia->resumo,
                    'imagem'    => $noticia->imagem
                                    ? asset('storage/' . $noticia->imagem)
                                    : null,
                    'conteudo'  => $noticia->conteudo,
                    'categoria' => $noticia->categoria->nome ?? 'Geral',
                    'autor'     => $noticia->autor->name ?? 'Secretaria',
                    'data'      => $noticia->created_at->format('d/m/Y'),
                ];
            });

        return response()->json($noticias);
    }

    public function show($id)
    {
        $noticia = Noticia::with(['categoria', 'autor'])
            ->where('status', 'publicado')
            ->findOrFail($id);

        return response()->json([
            'id'        => $noticia->id,
            'titulo'    => $noticia->titulo,
            'resumo'    => $noticia->resumo,
            'conteudo'  => $noticia->conteudo,
            'imagem'    => $noticia->imagem
                            ? asset('storage/' . $noticia->imagem)
                            : null,
            'categoria' => $noticia->categoria->nome ?? 'Geral',
            'autor'     => $noticia->autor->name ?? 'Secretaria',
            'data'      => $noticia->created_at->format('d/m/Y'),
        ]);
    }
}