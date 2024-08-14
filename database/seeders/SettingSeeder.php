<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            'company_name' => 'Vest Pro',
            'company_phone' => '00011122233',
            'company_email' => 'info@example.com',
            'currency' => '$',
            'language' => 'english',
            'min_withdrawal' => 1000,
        ]);
    }
}
