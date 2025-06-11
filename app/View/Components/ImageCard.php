<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ImageCard extends Component
{
    public $path;
    public $alt;

    public function __construct($path, $alt)
    {
        $this->path = $path;
        $this->alt = $alt;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.image-card');
    }
}
