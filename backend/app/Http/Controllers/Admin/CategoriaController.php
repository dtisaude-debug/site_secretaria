<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoriaController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('gerenciar_categorias');
        $categorias = Categoria::withCount('noticias')->paginate(10);
        return view('admin.categorias.index', compact('categorias'));
    }

    public function store(Request $request)
    {
        $this->authorize('gerenciar_categorias');

        $validated = $request->validate([
            'nome' => 'required|unique:categorias,nome|max:100',
        ]);

        Categoria::create($validated);

        return back()->with('success', 'Categoria criada com sucesso!');
    }

    public function update(Request $request, Categoria $categoria)
    {
        $this->authorize('gerenciar_categorias');

        $validated = $request->validate([
            'nome' => 'required|unique:categorias,nome,' . $categoria->id . '|max:100',
        ]);

        $categoria->update($validated);

        return back()->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy(Categoria $categoria)
    {
        $this->authorize('gerenciar_categorias');

        if ($categoria->noticias()->count() > 0) {
            return back()->with('error', 'Não é possível excluir uma categoria com notícias!');
        }

        $categoria->delete();
        return back()->with('success', 'Categoria excluída com sucesso!');
    }
}