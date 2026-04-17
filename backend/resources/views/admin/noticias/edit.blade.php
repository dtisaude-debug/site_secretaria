@extends('layouts.admin')
@section('title', 'Editar Notícia')
@section('page-title', 'Editar Notícia')

@section('content')

<div class="card table-card p-4">

    <form action="{{ route('admin.noticias.update', $noticia) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-3">

            <div class="col-12">
                <label class="form-label fw-semibold">Título *</label>
                <input type="text" name="titulo"
                       class="form-control @error('titulo') is-invalid @enderror"
                       value="{{ old('titulo', $noticia->titulo) }}" required>
                @error('titulo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Categoria *</label>
                <select name="categoria_id" class="form-select" required>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}"
                            {{ $noticia->categoria_id == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Imagem de Capa</label>
                {{-- Imagem atual --}}
                @if($noticia->imagem)
                    <div class="mb-2">
                        <img src="{{ $noticia->imagem_url }}" alt="Imagem atual"
                             style="height:80px;object-fit:cover;border-radius:8px">
                        <small class="text-muted d-block mt-1">Imagem atual</small>
                    </div>
                @endif
                <input type="file" name="imagem"
                       class="form-control" accept="image/*" id="imagemInput">
                <div class="form-text">Deixe vazio para manter a imagem atual</div>
                <img id="imagemPreview" src="#" alt="Preview"
                     class="mt-2 rounded d-none"
                     style="max-height:150px;object-fit:cover">
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Resumo *</label>
                <textarea name="resumo" rows="2"
                          class="form-control @error('resumo') is-invalid @enderror"
                          maxlength="500" required>{{ old('resumo', $noticia->resumo) }}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Conteúdo *</label>
                <textarea name="conteudo" rows="10"
                          class="form-control" required>{{ old('conteudo', $noticia->conteudo) }}</textarea>
            </div>

            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i> Atualizar Notícia
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