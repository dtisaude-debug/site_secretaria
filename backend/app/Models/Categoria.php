<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Categoria extends Model
{
    protected $fillable = ['nome', 'slug'];

    // Gera o slug automaticamente ao criar
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($categoria) {
            $categoria->slug = Str::slug($categoria->nome);
        });
    }

    // Relacionamento: uma categoria tem várias notícias
    public function noticias()
    {
        return $this->hasMany(Noticia::class);
    }
}