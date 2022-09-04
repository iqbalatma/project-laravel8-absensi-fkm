<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataRoles = [
                "superadmin","admin", "participant", "guest", "alumni"
        ];

        foreach ($dataRoles as $key => $role) {
            Role::create(['name' =>$role]);
        }
    }
}
