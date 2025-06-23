<?php

namespace Database\Seeders;

use App\Models\Console;
use App\Models\Developer;
use App\Models\Game;
use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
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

            $slug = Str::slug($game['title']);

            $newGame = new Game();

            $newGame->title = $game['title'];
            $newGame->rating = $game['rating'];
            $newGame->slug = $slug;
            $newGame->developer_id = $developer->id;
            $newGame->short_description = $game['description'];
            $newGame->release_date = $game['release_date'];

            if (array_key_exists('cover_image', $game)) {
                $newGame->cover_image = $game['cover_image'];
            }

            $newGame->save();

            if (!empty($game['consoles'])) {
                $consoleIds = Console::whereIn('name', $game['consoles'])->pluck('id');
                $newGame->consoles()->sync($consoleIds);
            }

            if (!empty($game['genres'])) {
                $genreIds = Genre::whereIn('name', $game['genres'])->pluck('id');
                $newGame->genres()->sync($genreIds);
            }

            if (!empty($game['sections'])) {
                foreach ($game['sections'] as $sectionData) {
                    $newGame->sections()->create([
                        'title' => $sectionData['title'],
                        'description' => $sectionData['description'],
                        'section_order' => $sectionData['section_order'],
                        'section_image_path' => $sectionData['section_image_path'],
                    ]);
                }
            }

            if (!empty($game['images'])) {
                foreach ($game['images'] as $imageData) {
                    $newGame->images()->create([
                        'gallery_image_path' => $imageData['gallery_image_path'],
                        'image_order' => $imageData['image_order'],
                    ]);
                }
            }
        }
    }
}
