<?php

namespace App\View\Components\Layout;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Main extends Component
{
    public $title;
    public $theme;

    /**
     * Create a new component instance.
     */
    public function __construct($title = "Dummy", $theme = "light")
    {
        $this->title = $title;
        $this->theme = $theme;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.main');
    }
}
