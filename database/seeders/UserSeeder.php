<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'iqbal atma muliawan',
            'student_id' => '10117124',
            'generation' => '2017',
            'phone_number' => '0895351172040',
            'organization_id'=> 1,
            'role_id'=> 1,
            'email' => 'iqbalatma@gmail.com',
            'password'=> Hash::make('admindito'),
        ]);
        // $faker = Factory::create('id_ID');
 
    	// for($i = 1; $i <= 100; $i++){
    	// 	DB::table('users')->insert([
        //         'name' => $faker->name(),
        //         'student_id'=> $faker->unique()->numerify('########'),
        //         'generation'=> $faker->numberBetween(2000, 2022),
        //         'phone_number'=> $faker->phoneNumber(),
        //         'organization_id'=> $faker->numberBetween(1,9),
        //         'role_id'=> $faker->numberBetween(1,5),
        //         'email'=> $faker->unique()->email(),
        //         'password'=> Hash::make('admin'),
        //         'personal_token' => Str::random(16),
    	// 	]);
    	// }

    }
}
