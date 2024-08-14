<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert(
            [
                'title' => 'Admin',
                'description' => 'Am the Admin in this Application',
            ],
        );
        DB::table('roles')->insert(
            [
                'title' => 'Team',
                'description' => 'Am the Team in this Application',
            ],
        );
        DB::table('roles')->insert(
            [
                'title' => 'Client',
                'description' => 'Am the User in this Application',
            ]
        );
    }
}
