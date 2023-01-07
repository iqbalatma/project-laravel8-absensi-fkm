<?php

namespace Database\Seeders;

use App\Models\OrganizerNotification;
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
        OrganizerNotification::factory()->count(100)->create();
    }
}
