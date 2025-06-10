<?php

// database/seeders/RoleSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::insert([
            ['nama_role' => 'Project Control'],
            ['nama_role' => 'Purchasing'],
            ['nama_role' => 'Owner'],
            ['nama_role' => 'Admin'],
        ]);
    }
}
