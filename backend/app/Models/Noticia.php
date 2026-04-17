<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Noticia extends Model
{
    protected $fillable = [
        'titulo',
        'slug',
        'resumo',
        'conteudo',
        'imagem',
        'publicado',
        'categoria_id',
        'user_id',
    ];

    protected $casts = [
        'publicado' => 'boolean',
    ];

    // Gera o slug automaticamente ao criar
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($noticia) {
            $noticia->slug = Str::slug($noticia->titulo);
        });
    }

    // Relacionamentos
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function autor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // URL da imagem
    public function getImagemUrlAttribute(): string
    {
        return $this->imagem
            ? asset('storage/' . $this->imagem)
            : asset('images/no-image.png');
    }
}