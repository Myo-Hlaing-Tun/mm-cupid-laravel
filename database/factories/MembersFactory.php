<?php

namespace Database\Factories;

use App\Models\Cities;
use App\Models\Members;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Members>
 */
class MembersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Members::class;
     public function definition()
    {
        $faker = $this->faker;
        
        $gender         = $faker->randomElement([1,2]);
        $partner_gender = $gender == 1 ? 2 : 1;
        $partnerMinAge  = $faker->numberBetween(18, 55);
        $partnerMaxAge  = $faker->numberBetween($partnerMinAge, 55);
        $cityIds = Cities::pluck('id')->toArray();

        return [
            'username' => $faker->userName,
            'email' => $faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'phone' => '09' . $faker->randomNumber(9, true),
            'email_confirm_code' => md5($faker->unique()->safeEmail),
            'gender' => $gender,
            'date_of_birth' => $faker->dateTimeBetween('-55 years', '-18 years')->format('Y-m-d'),
            'education' => $faker->sentence(2),
            'city_id' => $faker->randomElement($cityIds),
            'height_feet' => $faker->randomElement([4,5,6]),
            'height_inches' => $faker->numberBetween(0, 11),
            'status' => 0,
            'about' => $faker->word,
            'work' => $faker->jobTitle,
            'religion' => $faker->numberBetween(0, 8),
            'thumb' => $faker->word . $faker->randomElement([".jpeg",".jpg",".png"]),
            'partner_gender' => $partner_gender,
            'partner_min_age' => $partnerMinAge,
            'partner_max_age' => $partnerMaxAge,
            'point' => 1000,
            'view_count' => 0,
            'cron_job_number' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
