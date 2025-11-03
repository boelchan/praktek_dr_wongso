<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@app.com',
            'password' => bcrypt('123'),
        ]);
        User::factory()->create([
            'name' => 'Qurry',
            'email' => 'qurry@gmail.com',
            'password' => bcrypt('123'),
        ]);
        User::factory()->create([
            'name' => 'Mohammad Tayyib',
            'email' => 'tayyip@gmail.com',
            'password' => bcrypt('123'),
        ]);
    }
}
