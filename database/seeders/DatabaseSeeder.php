<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (\App\Models\User::count() == 0) {
            \App\Models\User::factory(1)->create();
            \App\Models\Author::factory(10)->create();
            \App\Models\Book::factory(10)->create();
            \App\Models\BookAuthor::factory(10)->create();
        }
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
