<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{

    //  MANY TO MANY
    public function consoles()
    {
        return $this->belongsToMany(Console::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }


    // HAS MANY
    public function sections()
    {
        return $this->hasMany(Section::class)->orderBy('section_order');
    }

    public function images()
    {
        return $this->hasMany(Image::class)->orderBy('image_order');
    }


    // BELONG TO
    public function developer()
    {
        return $this->belongsTo(Developer::class);
    }
}
