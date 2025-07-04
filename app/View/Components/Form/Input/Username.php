<?php

namespace App\View\Components\Form\Input;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Username extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $errorUsernameInput = "",
        public $exampleMessage = "Example: i_am_guest_12.",
        public $sweetenMessage = "Pick a Unique Username!"
    )
    {
        // 
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.input.username');
    }
}
