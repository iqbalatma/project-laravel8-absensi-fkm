<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CheckinStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');
 
    	for($i = 1; $i <= 100; $i++){
    		DB::table('checkin_statuses')->insert([
                'checkin_status' => $faker->boolean(),
                'user_id' => $faker->unique()->numberBetween(1,100),
                'congress_day_id' => $faker->numberBetween(1,100),
                'created_at' => $faker->dateTime(),
                'last_checkin_time' => $faker->dateTime(),
    		]);
    	}
    }
}
