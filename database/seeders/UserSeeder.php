<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'role_id' => 1,
            'referral_code' => bin2hex(random_bytes(5)),
            'username' => 'Admin',
            'fullname' => 'Main Admin',
            'email' => 'admin@vesttradesolutions.com',
            'password' => Hash::make('12345678'),
            'isVerified' => true,
        ]);
    }
}
