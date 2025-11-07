<?php

namespace Database\Seeders;

use App\Models\Paste;
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
        User::factory(10)->has(Paste::factory()->count(2))->create();
        Paste::factory(15)->create();
    }
}
