<?php

namespace Database\Seeders;

use App\Models\OrganizierNotification;
use Illuminate\Database\Seeder;

class OrganizierNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrganizierNotification::create(['message'=> "Selamat datang peserta kongress"]);
    }
}
