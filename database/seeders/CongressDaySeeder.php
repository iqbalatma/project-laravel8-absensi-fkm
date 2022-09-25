<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CongressDaySeeder extends Seeder
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
    		DB::table('congress_days')->insert([
    			'location' => $faker->name,
    			'h_day' => $faker->dateTime(),
                'created_at'=>$faker->dateTime(),
    		]);
    	}
    }
}
