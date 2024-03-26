<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'create']);
        Permission::create(['name' => 'read']);
        Permission::create(['name' => 'update']);
        Permission::create(['name' => 'delete']);
        Permission::create(['name' => 'export']);
        Permission::create(['name' => 'payment']);
        Permission::create(['name' => 'sewa']);
        Permission::create(['name' => 'verifikasi']);

        $role = Role::create(['name' => 'Pelanggan'])
            ->givePermissionTo(['sewa', 'payment']);

        $role = Role::create(['name' => 'Manager'])
            ->givePermissionTo(['read', 'export']);

        $role = Role::create(['name' => 'Admin'])
            ->givePermissionTo(Permission::all());
    }
}
