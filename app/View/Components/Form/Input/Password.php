<?php

namespace App\View\Components\Form\Input;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Password extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $errorPasswordInput = "",
        public $exampleMessage = "Example: Rahasia@1234",
        public $sweetenMessage = "Please take notes to remember your password."
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.input.password');
    }
}
