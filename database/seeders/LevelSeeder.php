<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('levels')->insert([
            [
                'nama_level' => 'superadmin',                
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_level' => 'admin',                
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_level' => 'user',                
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
