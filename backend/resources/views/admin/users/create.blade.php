@extends('layouts.admin')
@section('title', 'Novo Usuário')
@section('page-title', 'Novo Usuário')

@section('content')

<div class="card table-card p-4">
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label fw-semibold">Nome *</label>
                <input type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">E-mail *</label>
                <input type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Senha *</label>
                <input type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Confirmar Senha *</label>
                <input type="password" name="password_confirmation"
                       class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Papel *</label>
                <select name="role"
                        class="form-select @error('role') is-invalid @enderror" required>
                    <option value="">Selecione...</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}"
                            {{ old('role') == $role->name ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i> Criar Usuário
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Cancelar
                </a>
            </div>

        </div>
    </form>
</div>

@endsection