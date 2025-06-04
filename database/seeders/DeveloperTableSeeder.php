<?php

namespace Database\Seeders;

use App\Models\Developer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeveloperTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $developers = config('games.developers.list');

        foreach ($developers as $developer) {
            Developer::create([
                'name' => $developer,
            ]);
        }
    }
}
