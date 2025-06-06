<?php

namespace Database\Seeders;

use App\Models\Console;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConsolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $consoles = config('games.consoles.list');

        foreach ($consoles as $console) {
            Console::create([
                'name' => $console,
            ]);
        }
    }
}
