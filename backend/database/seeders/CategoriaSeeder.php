<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            'Saúde Geral',
            'Campanhas',
            'Prevenção',
            'Boletim Oficial',
            'Vigilância Sanitária',
            'Saúde Mental',
        ];

        foreach ($categorias as $nome) {
            Categoria::firstOrCreate(['nome' => $nome]);
        }
    }
}