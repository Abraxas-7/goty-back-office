<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function game()
    {
        return $this->belongsTo(Game::class)->orderBy('image_order');
    }
}
