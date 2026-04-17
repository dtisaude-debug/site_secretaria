@extends('layouts.admin')
@section('title', 'Editar Papel')
@section('page-title', 'Editar Papel')

@section('content')

<div class="card table-card p-4">
    <form action="{{ route('admin.roles.update', $role) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label fw-semibold">Nome do Papel *</label>
                <input type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $role->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Permissões *</label>
                <div class="row g-2">
                    @foreach($permissions as $permission)
                    <div class="col-md-4 col-sm-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                   name="permissions[]"
                                   value="{{ $permission->name }}"
                                   id="perm_{{ $permission->id }}"
                                   {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                            <label class="form-check-label" for="perm_{{ $permission->id }}">
                                {{ str_replace('_', ' ', ucfirst($permission->name)) }}
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i> Atualizar Papel
                </button>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Cancelar
                </a>
            </div>

        </div>
    </form>
</div>

@endsection