<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@saude.guarapuava.pr.gov.br'],
            [
                'name'     => 'Administrador',
                'password' => Hash::make('Admin@2026'),
            ]
        );

        $admin->assignRole('admin');
    }
}