<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ComponensSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'admin123@gmail.com',
            'password' => Hash::make('password'), // Replace with secure password
        ]);

        DB::table('bayars')->insert([
            [
                'cara_bayar' => 'Tunai',                
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cara_bayar' => 'Transfer',                
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
