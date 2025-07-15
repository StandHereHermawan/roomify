<?php

namespace App\View\Components\Redirect;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Account extends Component
{
    public $color_primary;
    public $opacity;
    public $name;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $color_primary = "primary",
        $opacity = "100",
        $name = "Back to current account",
    ) {
        $this->color_primary = $color_primary;
        $this->opacity = $opacity;
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.redirect.account');
    }
}
