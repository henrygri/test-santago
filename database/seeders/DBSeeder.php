<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class DBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'superadmin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
        ]);
        // assign role & permissions
        $user->assignRole('admin') && $user->givePermissionTo('admin');
    }
}
