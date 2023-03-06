<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'editor']);
        Permission::create(['name' => 'admin']);

        // create roles and assign created permissions

        $role = Role::create(['name' => 'operator'])
            ->givePermissionTo(['editor']);

        $role = Role::create(['name' => 'admin'])
            ->givePermissionTo(['admin']);
    }
}
