<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creación de Roles
        $admin = Role::create(['name' => 'admin', 'description' => 'Administrador']);
        $editor = Role::create(['name' => 'editor', 'description' => 'Editor']);

        // Asignación de permisos al Rol
        // Permisos para el modelo User
        Permission::create(['name' => 'user.index', 'description' => 'Listar usuarios'])->syncRoles([$admin, $editor]);
        Permission::create(['name' => 'user.create', 'description' => 'Crear nuevo usuario'])->syncRoles([$admin]);
        Permission::create(['name' => 'user.store', 'description' => 'Guardar nuevo usuario'])->syncRoles([$admin]);
        Permission::create(['name' => 'user.show', 'description' => 'Ver usuario'])->syncRoles([$admin, $editor]);
        Permission::create(['name' => 'user.edit', 'description' => 'Editar usuarios'])->syncRoles([$admin]);
        Permission::create(['name' => 'user.update', 'description' => 'Actualizar usuarios'])->syncRoles([$admin]);
        Permission::create(['name' => 'user.destroy', 'description' => 'Eliminar usuarios'])->syncRoles([$admin]);
        // Permisos para el modelo Role
        Permission::create(['name' => 'role.index', 'description' => 'Listar roles'])->syncRoles([$admin]);
        Permission::create(['name' => 'role.create', 'description' => 'Crear nuevo rol'])->syncRoles([$admin]);
        Permission::create(['name' => 'role.store', 'description' => 'Guardar nuevo roles'])->syncRoles([$admin]);
        Permission::create(['name' => 'role.edit', 'description' => 'Editar roles'])->syncRoles([$admin]);
        Permission::create(['name' => 'role.update', 'description' => 'Actualizar roles'])->syncRoles([$admin]);
        Permission::create(['name' => 'role.destroy', 'description' => 'Eliminar roles'])->syncRoles([$admin]);
    }
}
