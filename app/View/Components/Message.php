<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Message extends Component
{
    public $type , $message , $size;
    public function __construct($type,$message,$size)
    {
        $this->type = $type;
        $this->message = $message;
        $this->size = $size;
    }

    
    public function humenSize(){
        $orders = ['K','M','G','T','P','E','Z','Y'];
        $e = floor(log($this->size)/log(1024));
        $result = round($this->size / pow(1024,$e) , 2);
        $order = $e == 0 ? 'B' : $orders[$e - 1] . 'B';
        return "$result$order";
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.message');
    }
}
