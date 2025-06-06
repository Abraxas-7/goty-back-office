<?php

namespace Database\Seeders;

use App\Models\Console;
use App\Models\Developer;
use App\Models\Game;
use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = config('games.games');

        foreach ($games as $game) {

            $developer = Developer::where('name', $game['developer'])->first();

            $newgame = Game::create([
                'title' => $game['title'],
                'developer_id' => $developer?->id,
                'short_description' => $game['description'],
                'release_date' => $game['release_date'],
            ]);

            if (!empty($game['consoles'])) {
                $consoleIds = Console::whereIn('name', $game['consoles'])->pluck('id');
                $newgame->consoles()->sync($consoleIds);
            }

            // Agganciare generi esistenti
            if (!empty($game['genres'])) {
                $genreIds = Genre::whereIn('name', $game['genres'])->pluck('id');
                $newgame->genres()->sync($genreIds);
            }
        }
    }
}
