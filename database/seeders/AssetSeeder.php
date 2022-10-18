<?php

namespace Database\Seeders;

use App\Models\Asset;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Asset::create([
            'name' => 'Draft Kongress',
            'filename' => 'congress-draft.pdf',
        ]);
        Asset::create([
            'name' => 'Manual Book',
            'filename' => 'manual-book.pdf',
        ]);
    }
}
