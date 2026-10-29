<?php

use App\Permission;
use App\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Crea roles, permisos y usuarios de prueba.
     * Contraseña de todos los usuarios de prueba: password
     */
    public function run()
    {
        // Roles
        $userRole = Role::firstOrCreate(['name' => Role::USER], ['display_name' => 'Usuario']);
        $adminRole = Role::firstOrCreate(['name' => Role::ADMIN], ['display_name' => 'Administrador']);

        // Permisos
        $manageUsers = Permission::firstOrCreate(
            ['name' => Permission::MANAGE_USERS],
            ['display_name' => 'Administrar usuarios (CRUD)']
        );
        $changePasswords = Permission::firstOrCreate(
            ['name' => Permission::CHANGE_PASSWORDS],
            ['display_name' => 'Cambiar contraseñas de usuarios y administradores']
        );

        // Admin 1: solo administra usuarios (CRUD)
        $admin1 = User::firstOrCreate(['email' => 'admin1@example.com'], [
            'name' => 'Admin Usuarios',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);
        $admin1->permissions()->sync([$manageUsers->id]);

        // Admin 2: solo cambia contraseñas
        $admin2 = User::firstOrCreate(['email' => 'admin2@example.com'], [
            'name' => 'Admin Contraseñas',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);
        $admin2->permissions()->sync([$changePasswords->id]);

        // Usuario normal
        User::firstOrCreate(['email' => 'user@example.com'], [
            'name' => 'Usuario Demo',
            'password' => Hash::make('password'),
            'role_id' => $userRole->id,
        ]);
    }
}
