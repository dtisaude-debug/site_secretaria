<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Permissões disponíveis no sistema
        $permissoes = [
            'criar_noticia',
            'editar_noticia',
            'excluir_noticia',
            'publicar_noticia',
            'gerenciar_usuarios',
            'gerenciar_roles',
            'gerenciar_categorias',
        ];

        // Cria as permissões
        foreach ($permissoes as $permissao) {
            Permission::firstOrCreate(['name' => $permissao]);
        }

        // Cria os papéis e atribui permissões

        // Admin → acesso total
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions($permissoes);

        // Editor → pode tudo com notícias + categorias
        $editor = Role::firstOrCreate(['name' => 'editor']);
        $editor->syncPermissions([
            'criar_noticia',
            'editar_noticia',
            'publicar_noticia',
            'gerenciar_categorias',
        ]);

        // Redator → só cria e edita, não publica
        $redator = Role::firstOrCreate(['name' => 'redator']);
        $redator->syncPermissions([
            'criar_noticia',
            'editar_noticia',
        ]);
    }
}