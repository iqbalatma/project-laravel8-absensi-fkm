<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataOrganizations = [
            [
                'name' => 'Himpunan Mahasiswa Teknik Informatika',
                'shortname' => 'HMIF',
                'link_instagram' => 'https://instagram.com',
                'link_instagram' => 'https://website.com',
            ],
            [
                'name' => 'Himpunan Mahasiswa Teknik Industri',
                'shortname' => 'HMTI',
                'link_instagram' => 'https://instagram.com',
                'link_instagram' => 'https://website.com',
            ],
            [
                'name' => 'Himpunan Mahasiswa Teknik Elektro',
                'shortname' => 'HME',
                'link_instagram' => 'https://instagram.com',
                'link_instagram' => 'https://website.com',
            ],
            [
                'name' => 'Himpunan Mahasiswa Teknik Sipil',
                'shortname' => 'HMTS',
                'link_instagram' => 'https://instagram.com',
                'link_instagram' => 'https://website.com',
            ],
            [
                'name' => 'Himpunan Mahasiswa Teknik Komputer',
                'shortname' => 'HMTK',
                'link_instagram' => 'https://instagram.com',
                'link_instagram' => 'https://website.com',
            ],
            [
                'name' => 'Himpunan Mahasiswa Perencanaan Wilayah Kota',
                'shortname' => 'HMPWK',
                'link_instagram' => 'https://instagram.com',
                'link_instagram' => 'https://website.com',
            ],
            [
                'name' => 'Himpunan Mahasiswa Komputerisasi Akuntansi',
                'shortname' => 'HIMAKA',
                'link_instagram' => 'https://instagram.com',
                'link_instagram' => 'https://website.com',
            ],
            [
                'name' => 'Himpunan Mahasiswa Sistem Informasi',
                'shortname' => 'HIMASI',
                'link_instagram' => 'https://instagram.com',
                'link_instagram' => 'https://website.com',
            ],
            [
                'name' => 'Himpunan Mahasiswa Teknik Arsitektur',
                'shortname' => 'HIMARS',
                'link_instagram' => 'https://instagram.com',
                'link_instagram' => 'https://website.com',
            ],
        ];

        foreach ($dataOrganizations as $key => $organization) {
            Organization::create($organization);
        }
    }
}
