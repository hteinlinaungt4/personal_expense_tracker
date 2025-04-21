<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Income;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        User::factory()->count(2)->create(); // or manually add if needed
        Category::insert([
            ['id' => 1, 'name' => 'Salary', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Freelance', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Others', 'created_at' => now(), 'updated_at' => now()],
        ]);

        Income::factory()->count(30)->create();

    }
}
