<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Fatta Surya',
            'role'=> 'admin',
            'email' => 'admin@example.com',
            'password'=> bcrypt('admin@example.com'),
            
        ]);

        \App\Models\User::factory()->create([
            'name' => 'fatta',
            'role'=> 'siswa',
            'email' => 'siswa@siswa.com',
            'password'=> bcrypt('siswa@siswa.com'),
            
        ]);

        \App\Models\User::factory()->create([
            'name' => 'surya bank',
            'role'=> 'bank',
            'email' => 'admin@bank.com',
            'password'=> bcrypt('admin@bank.com'),
            
        ]);

        \App\Models\User::factory()->create([
            'name' => 'siswa1',
            'role'=> 'siswa',
            'email' => 'siswa1@Gmail.com',
            'password'=> bcrypt('siswa1@Gmail.com'),
            
        ]);
    }
}
