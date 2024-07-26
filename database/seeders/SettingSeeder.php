<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting')->truncate();
        DB::table('setting')->insert([
            'id' => 1,
            'point' => 1000,
            'company_logo' => "20240505110253_66374b3db7d20cupid-32x32.png",
            'company_name' => "mm-cupid",
            'company_email' => "mmcupid@gmail.com",
            'company_phone' => "+9595094984",
            'company_address' => "No 1004, 20th Street,Latha Township,Yangon",
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => 1,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => 1
        ]);
    }
}
