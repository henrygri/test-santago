<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\DBSeeder;
use Database\Seeders\RuoliSeeder;
use Database\Seeders\SettoriSeeder;
use Database\Seeders\ServiceSeeder;
use Database\Seeders\DisciplineSeeder;
use Database\Seeders\StagingUserRoleSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // RolesAndPermissionsSeeder::class,
            // DBSeeder::class,
            // RuoliSeeder::class,
            // SettoriSeeder::class,
            // StagingUserRoleSeeder::class,
            // ServiceSeeder::class,
            DisciplineSeeder::class,
        ]);
    }
}
