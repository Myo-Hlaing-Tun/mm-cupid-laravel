<?php

namespace Database\Seeders;

use App\Models\Members;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $days = 30;
        $minUsersPerDay = 20;
        $maxUsersPerDay = 50;
        for($i = 0; $i < $days; $i++){
            $date = Carbon::now()->subDays($i);
            $numberOfUsers = rand($minUsersPerDay,$maxUsersPerDay);
            for($j = 0; $j < $numberOfUsers; $j++){
                Members::factory()->create([
                    'created_at' => $date,
                    'updated_at' => $date
                ]);
            }
        }
    }
}
