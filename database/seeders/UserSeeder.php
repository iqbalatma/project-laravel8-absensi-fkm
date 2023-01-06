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
            'organization_id' => 1,
            'role_id' => 1,
            'email' => 'iqbalatma@gmail.com',
            'password' => Hash::make('admindito'),
        ]);

        User::factory()->count(100)->create();
    }
}
