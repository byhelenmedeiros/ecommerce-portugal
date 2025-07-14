<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Garante que o role 'admin' exista
        $role = Role::firstOrCreate(['name' => 'admin']);

        // Cria o utilizador admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@site.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin123'),
            ]
        );

        // Atribui a role
        $admin->assignRole($role);
    }
}
