<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['nama_role' => 'Admin'],
            ['nama_role' => 'project control'],
            ['nama_role' => 'purchasing'],
            ['nama_role' => 'owner'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['nama_role' => $role['nama_role']]
            );
        }
    }
}
