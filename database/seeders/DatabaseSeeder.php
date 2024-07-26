<?php

namespace Database\Seeders;

use App\Models\Members;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
            UsersSeeder::class,
        ]);
        $this->call([
            SettingSeeder::class,
        ]);
        $this->call([
            CitiesSeeder::class,
        ]);
        $this->call([
            HobbiesSeeder::class,
        ]);
        $this->call([
            RolePermissionSeeder::class,
        ]);
        Members::factory()->count(50)->create();
    }
}
