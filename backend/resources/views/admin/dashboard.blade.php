@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Cards de estatísticas --}}
<div class="row g-3 mb-4">

    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="icon" style="background:#dbeafe">
                    <i class="fas fa-newspaper text-primary"></i>
                </div>
                <div>
                    <div class="text-muted small">Total de Notícias</div>
                    <div class="fw-bold fs-4">{{ \App\Models\Noticia::count() }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="icon" style="background:#dcfce7">
                    <i class="fas fa-check-circle text-success"></i>
                </div>
                <div>
                    <div class="text-muted small">Publicadas</div>
                    <div class="fw-bold fs-4">{{ \App\Models\Noticia::where('publicado', true)->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="icon" style="background:#fef3c7">
                    <i class="fas fa-clock text-warning"></i>
                </div>
                <div>
                    <div class="text-muted small">Rascunhos</div>
                    <div class="fw-bold fs-4">{{ \App\Models\Noticia::where('publicado', false)->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="icon" style="background:#f3e8ff">
                    <i class="fas fa-users text-purple" style="color:#7c3aed"></i>
                </div>
                <div>
                    <div class="text-muted small">Usuários</div>
                    <div class="fw-bold fs-4">{{ \App\Models\User::count() }}</div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Últimas notícias --}}
<div class="card table-card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h6 class="mb-0 fw-semibold">
            <i class="fas fa-newspaper me-2 text-primary"></i>Últimas Notícias
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
                    <th>Título</th>
                    <th>Categoria</th>
                    <th>Autor</th>
                    <th>Status</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                @forelse(\App\Models\Noticia::with(['categoria','autor'])->latest()->take(5)->get() as $noticia)
                <tr>
                    <td class="fw-semibold">{{ Str::limit($noticia->titulo, 40) }}</td>
                    <td>
                        <span class="badge bg-light text-dark">
                            {{ $noticia->categoria->nome }}
                        </span>
                    </td>
                    <td>{{ $noticia->autor->name }}</td>
                    <td>
                        @if($noticia->publicado)
                            <span class="badge badge-publicado">
                                <i class="fas fa-circle me-1" style="font-size:0.5rem"></i>Publicado
                            </span>
                        @else
                            <span class="badge badge-rascunho">
                                <i class="fas fa-circle me-1" style="font-size:0.5rem"></i>Rascunho
                            </span>
                        @endif
                    </td>
                    <td class="text-muted small">{{ $noticia->created_at->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                        Nenhuma notícia cadastrada ainda.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection