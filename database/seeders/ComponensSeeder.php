<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComponensSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kajians')->insert([
            [
                'nama_kajian' => 'Kamis',                
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kajian' => 'Sabtu',                
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kajian' => 'Ahad',                
                'created_at' => now(),
                'updated_at' => now(),
            ],
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
