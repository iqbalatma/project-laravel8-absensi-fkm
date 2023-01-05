<?php

namespace Database\Seeders;

use App\Models\CongressDay;
use Illuminate\Database\Seeder;

class CongressDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CongressDay::factory()->count(50)->create();
    }
}
