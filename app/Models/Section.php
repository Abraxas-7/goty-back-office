<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{

    protected $fillable = [
        'title',
        'description',
        'section_image_path',
        'section_order',
        'game_id'
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
