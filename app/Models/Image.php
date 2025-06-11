<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['game_id', 'gallery_image_path', 'image_order'];

    public function game()
    {
        return $this->belongsTo(Game::class)->orderBy('image_order');
    }
}
