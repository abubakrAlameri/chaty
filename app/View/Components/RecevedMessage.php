<?php

namespace App\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class RecevedMessage extends Component
{
     public $message;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
        //
    }

    public function firstLitter()
    {
        return  Str::upper($this->message->name[0]);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.receved-message');
    }
}
