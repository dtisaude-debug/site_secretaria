@extends('layouts.admin')
@section('title', 'Notícias')
@section('page-title', 'Gerenciar Notícias')

@section('content')

<div class="card table-card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h6 class="mb-0 fw-semibold">
            <i class="fas fa-newspaper me-2 text-primary"></i>Todas as Notícias
        </h6>
        @can('criar_noticia')
        <a href="{{ route('admin.noticias.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Nova Notícia
        </a>
        @endcan
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Título</th>
                    <th>Categoria</th>
                    <th>Autor</th>
                    <th>Status</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($noticias as $noticia)
                <tr>
                    <td>
                        <img
                            src="{{ $noticia->imagem_url }}"
                            alt="{{ $noticia->titulo }}"
                            style="width:50px;height:50px;object-fit:cover;border-radius:8px"
                        >
                    </td>
                    <td class="fw-semibold">{{ Str::limit($noticia->titulo, 35) }}</td>
                    <td>
                        <span class="badge bg-light text-dark">
                            {{ $noticia->categoria->nome }}
                        </span>
                    </td>
                    <td>{{ $noticia->autor->name }}</td>
                    <td>
                        @if($noticia->publicado)
                            <span class="badge badge-publicado">Publicado</span>
                        @else
                            <span class="badge badge-rascunho">Rascunho</span>
                        @endif
                    </td>
                    <td class="text-muted small">{{ $noticia->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">

                            @can('publicar_noticia')
                            <form action="{{ route('admin.noticias.publicar', $noticia) }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm {{ $noticia->publicado ? 'btn-warning' : 'btn-success' }}"
                                        title="{{ $noticia->publicado ? 'Despublicar' : 'Publicar' }}">
                                    <i class="fas {{ $noticia->publicado ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                </button>
                            </form>
                            @endcan

                            @can('editar_noticia')
                            <a href="{{ route('admin.noticias.edit', $noticia) }}"
                               class="btn btn-sm btn-outline-primary" title="Editar">
                                <i class="fas fa-pen"></i>
                            </a>
                            @endcan

                            @can('excluir_noticia')
                            <form action="{{ route('admin.noticias.destroy', $noticia) }}" method="POST"
                                  onsubmit="return confirm('Deseja excluir esta notícia?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Excluir">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endcan

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                        Nenhuma notícia encontrada.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($noticias->hasPages())
    <div class="card-footer bg-white">
        {{ $noticias->links() }}
    </div>
    @endif
</div>

@endsection