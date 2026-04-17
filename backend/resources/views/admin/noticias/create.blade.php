@extends('layouts.admin')
@section('title', 'Nova Notícia')
@section('page-title', 'Nova Notícia')

@section('content')

<div class="card table-card p-4">

    <form action="{{ route('admin.noticias.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-3">

            <div class="col-12">
                <label class="form-label fw-semibold">Título *</label>
                <input type="text" name="titulo"
                       class="form-control @error('titulo') is-invalid @enderror"
                       value="{{ old('titulo') }}" placeholder="Título da notícia" required>
                @error('titulo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Categoria *</label>
                <select name="categoria_id"
                        class="form-select @error('categoria_id') is-invalid @enderror" required>
                    <option value="">Selecione...</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}"
                            {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nome }}
                        </option>
                    @endforeach
                </select>
                @error('categoria_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Imagem de Capa</label>
                <input type="file" name="imagem"
                       class="form-control @error('imagem') is-invalid @enderror"
                       accept="image/*" id="imagemInput">
                <div class="form-text">JPG, PNG ou WebP. Máx: 2MB</div>
                @error('imagem')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                {{-- Preview da imagem --}}
                <img id="imagemPreview" src="#" alt="Preview"
                     class="mt-2 rounded d-none"
                     style="max-height:150px;object-fit:cover">
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Resumo *</label>
                <textarea name="resumo" rows="2"
                          class="form-control @error('resumo') is-invalid @enderror"
                          placeholder="Breve descrição da notícia (máx. 500 caracteres)"
                          maxlength="500" required>{{ old('resumo') }}</textarea>
                @error('resumo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Conteúdo *</label>
                <textarea name="conteudo" rows="10"
                          class="form-control @error('conteudo') is-invalid @enderror"
                          placeholder="Conteúdo completo da notícia..." required>{{ old('conteudo') }}</textarea>
                @error('conteudo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i> Salvar Notícia
                </button>
                <a href="{{ route('admin.noticias.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Cancelar
                </a>
            </div>

        </div>
    </form>
</div>

@endsection

@section('scripts')
<script>
    // Preview da imagem antes de enviar
    document.getElementById('imagemInput').addEventListener('change', function(e) {
        const preview = document.getElementById('imagemPreview');
        const file = e.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('d-none');
        }
    });
</script>
@endsection