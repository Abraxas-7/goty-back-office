<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EditBar extends Component
{
    public $return;
    public $edit;
    public $delete;
    public $item;

    public function __construct($return, $edit, $delete, $item)
    {
        $this->return = $return;
        $this->edit = $edit;
        $this->delete = $delete;
        $this->item = $item;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.edit-bar');
    }
}
