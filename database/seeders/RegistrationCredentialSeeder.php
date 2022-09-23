<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegistrationCredentialSeeder extends Seeder
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
    		DB::table('registration_credentials')->insert([
                'token' => Str::random(16),
                'is_active' => $faker->numberBetween(0, 1),
                'role_id' =>$faker->numberBetween(1,5),
                'organization_id'=>$faker->numberBetween(1,9),
                'limit'=>$faker->numberBetween(0,1000),
                'created_at'=>$faker->dateTime(),
    		]);
    	}
    }
}
