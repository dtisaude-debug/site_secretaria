@extends('layouts.admin')
@section('title', 'Categorias')
@section('page-title', 'Gerenciar Categorias')

@section('content')

<div class="row g-4">

    {{-- Formulário de nova categoria --}}
    <div class="col-md-4">
        <div class="card table-card p-4">
            <h6 class="fw-semibold mb-3">
                <i class="fas fa-plus me-2 text-primary"></i>Nova Categoria
            </h6>
            <form action="{{ route('admin.categorias.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nome *</label>
                    <input type="text" name="nome"
                           class="form-control @error('nome') is-invalid @enderror"
                           value="{{ old('nome') }}"
                           placeholder="Ex: Campanhas" required>
                    @error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-save me-2"></i> Salvar
                </button>
            </form>
        </div>
    </div>

    {{-- Lista de categorias --}}
    <div class="col-md-8">
        <div class="card table-card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold">
                    <i class="fas fa-tags me-2 text-primary"></i>Categorias Cadastradas
                </h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Slug</th>
                            <th>Notícias</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categorias as $categoria)
                        <tr>
                            <td class="fw-semibold">{{ $categoria->nome }}</td>
                            <td><code>{{ $categoria->slug }}</code></td>
                            <td>
                                <span class="badge bg-light text-dark">
                                    {{ $categoria->noticias_count }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">

                                    {{-- Editar inline --}}
                                    <button class="btn btn-sm btn-outline-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $categoria->id }}">
                                        <i class="fas fa-pen"></i>
                                    </button>

                                    {{-- Excluir --}}
                                    <form action="{{ route('admin.categorias.destroy', $categoria) }}"
                                          method="POST"
                                          onsubmit="return confirm('Deseja excluir esta categoria?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- Modal de edição --}}
                        <div class="modal fade" id="editModal{{ $categoria->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title fw-semibold">Editar Categoria</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.categorias.update', $categoria) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="modal-body">
                                            <label class="form-label fw-semibold">Nome *</label>
                                            <input type="text" name="nome"
                                                   class="form-control"
                                                   value="{{ $categoria->nome }}" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary"
                                                    data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save me-1"></i> Salvar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Nenhuma categoria encontrada.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($categorias->hasPages())
            <div class="card-footer bg-white">
                {{ $categorias->links() }}
            </div>
            @endif
        </div>
    </div>

</div>

@endsection