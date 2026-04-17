@extends('layouts.admin')
@section('title', 'Papéis')
@section('page-title', 'Gerenciar Papéis')

@section('content')

<div class="card table-card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h6 class="mb-0 fw-semibold">
            <i class="fas fa-user-shield me-2 text-primary"></i>Papéis do Sistema
        </h6>
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Novo Papel
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Papel</th>
                    <th>Permissões</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $role)
                <tr>
                    <td class="fw-semibold">{{ ucfirst($role->name) }}</td>
                    <td>
                        @foreach($role->permissions as $perm)
                            <span class="badge bg-light text-dark me-1 mb-1">
                                {{ str_replace('_', ' ', $perm->name) }}
                            </span>
                        @endforeach
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.roles.edit', $role) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-pen"></i>
                            </a>
                            @if($role->name !== 'admin')
                            <form action="{{ route('admin.roles.destroy', $role) }}" method="POST"
                                  onsubmit="return confirm('Deseja excluir este papel?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted py-4">
                        Nenhum papel encontrado.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection