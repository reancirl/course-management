<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CoursesAndCategoriesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'reancirl@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password')
        ]);
        
        $this->call(CoursesAndCategoriesSeeder::class);
    }
}
