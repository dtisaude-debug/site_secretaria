<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Noticia;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class NoticiaController extends Controller
{
   use AuthorizesRequests;
    // Lista todas as notícias
    public function index()
    {
        $this->authorize('criar_noticia');

        $noticias = Noticia::with(['categoria', 'autor'])
            ->latest()
            ->paginate(10);

        return view('admin.noticias.index', compact('noticias'));
    }

    // Exibe formulário de criação
    public function create()
    {
        $this->authorize('criar_noticia');
        $categorias = Categoria::all();
        return view('admin.noticias.create', compact('categorias'));
    }

    // Salva nova notícia
    public function store(Request $request)
    {
        $this->authorize('criar_noticia');

        $validated = $request->validate([
            'titulo'       => 'required|max:255',
            'resumo'       => 'required|max:500',
            'conteudo'     => 'required',
            'categoria_id' => 'required|exists:categorias,id',
            'imagem'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Upload da imagem
        $imagemPath = null;
        if ($request->hasFile('imagem')) {
            $imagemPath = $request->file('imagem')
                ->store('noticias', 'public');
        }

        Noticia::create([
            'titulo'       => $validated['titulo'],
            'slug'         => Str::slug($validated['titulo']),
            'resumo'       => $validated['resumo'],
            'conteudo'     => $validated['conteudo'],
            'categoria_id' => $validated['categoria_id'],
            'imagem'       => $imagemPath,
            'user_id'      => Auth::id(),
            'publicado'    => false,
        ]);

        return redirect()
            ->route('admin.noticias.index')
            ->with('success', 'Notícia criada com sucesso!');
    }

    // Exibe formulário de edição
    public function edit(Noticia $noticia)
    {
        $this->authorize('editar_noticia');
        $categorias = Categoria::all();
        return view('admin.noticias.edit', compact('noticia', 'categorias'));
    }

    // Atualiza notícia
    public function update(Request $request, Noticia $noticia)
    {
        $this->authorize('editar_noticia');

        $validated = $request->validate([
            'titulo'       => 'required|max:255',
            'resumo'       => 'required|max:500',
            'conteudo'     => 'required',
            'categoria_id' => 'required|exists:categorias,id',
            'imagem'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Upload de nova imagem
        if ($request->hasFile('imagem')) {
            // Remove imagem antiga
            if ($noticia->imagem) {
                Storage::disk('public')->delete($noticia->imagem);
            }
            $validated['imagem'] = $request->file('imagem')
                ->store('noticias', 'public');
        }

        $noticia->update([
            'titulo'       => $validated['titulo'],
            'slug'         => Str::slug($validated['titulo']),
            'resumo'       => $validated['resumo'],
            'conteudo'     => $validated['conteudo'],
            'categoria_id' => $validated['categoria_id'],
            'imagem'       => $validated['imagem'] ?? $noticia->imagem,
        ]);

        return redirect()
            ->route('admin.noticias.index')
            ->with('success', 'Notícia atualizada com sucesso!');
    }

    // Publica ou despublica notícia
    public function togglePublicar(Noticia $noticia)
    {
        $this->authorize('publicar_noticia');

        $noticia->update(['publicado' => !$noticia->publicado]);

        $msg = $noticia->publicado ? 'Notícia publicada!' : 'Notícia despublicada!';

        return back()->with('success', $msg);
    }

    // Exclui notícia
    public function destroy(Noticia $noticia)
    {
        $this->authorize('excluir_noticia');

        if ($noticia->imagem) {
            Storage::disk('public')->delete($noticia->imagem);
        }

        $noticia->delete();

        return back()->with('success', 'Notícia excluída com sucesso!');
    }
}