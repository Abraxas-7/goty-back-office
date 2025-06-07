<?php

namespace App\View\Components;

use App\Models\Console;
use App\Models\Developer;
use App\Models\Genre;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GamesSearchBar extends Component
{
    /**
     * Create a new component instance.
     */
    public $action;

    public $consoles;
    public $genres;
    public $developers;

    public function __construct($action)
    {
        $this->action = $action;

        $this->consoles = Console::orderBy('name')->get();
        $this->genres = Genre::orderBy('name')->get();
        $this->developers = Developer::orderBy('name')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.games-search-bar');
    }
}
