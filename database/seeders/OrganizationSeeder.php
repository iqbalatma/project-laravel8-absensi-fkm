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
                'link_instagram' => 'https://www.instagram.com/hmifunikom/',
                'link_website' => 'https://hmif.unikom.ac.id',
            ],
            [
                'name' => 'Himpunan Mahasiswa Teknik Industri',
                'shortname' => 'HMTI',
                'link_instagram' => 'https://www.instagram.com/hmti_unikom/',
                'link_website' => 'https://hmti.unikom.ac.id',
            ],
            [
                'name' => 'Himpunan Mahasiswa Teknik Elektro',
                'shortname' => 'HME',
                'link_instagram' => 'https://www.instagram.com/hmeunikom/',
                'link_website' => 'https://hme.unikom.ac.id',
            ],
            [
                'name' => 'Himpunan Mahasiswa Teknik Sipil',
                'shortname' => 'HMTS',
                'link_instagram' => 'https://www.instagram.com/hmts_unikom/',
                'link_website' => 'https://hmts.unikom.ac.id',
            ],
            [
                'name' => 'Himpunan Mahasiswa Teknik Komputer',
                'shortname' => 'HMTK',
                'link_instagram' => 'https://www.instagram.com/htk.unikom/',
                'link_website' => 'https://htk.unikom.ac.id',
            ],
            [
                'name' => 'Himpunan Mahasiswa Perencanaan Wilayah Kota',
                'shortname' => 'HMPWK',
                'link_instagram' => 'https://www.instagram.com/hmpwkunikom/',
                'link_website' => 'https://hmpwk.unikom.ac.id',
            ],
            [
                'name' => 'Himpunan Mahasiswa Komputerisasi Akuntansi',
                'shortname' => 'HIMAKA',
                'link_instagram' => 'https://www.instagram.com/himaka_unikom/',
                'link_website' => 'https://himaka.unikom.ac.id',
            ],
            [
                'name' => 'Himpunan Mahasiswa Sistem Informasi',
                'shortname' => 'HIMASI',
                'link_instagram' => 'https://www.instagram.com/hima_si/',
                'link_website' => 'https://hima_si.unikom.ac.id',
            ],
            [
                'name' => 'Himpunan Mahasiswa Teknik Arsitektur',
                'shortname' => 'HIMARS',
                'link_instagram' => 'https://www.instagram.com/himarsunikom/',
                'link_website' => 'https://himars.unikom.ac.id',
            ],
        ];

        foreach ($dataOrganizations as $key => $organization) {
            Organization::create($organization);
        }
    }
}
