<?php

namespace App\View\Components\Globales;

use Illuminate\View\Component;

class ModalIconos extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $datos;

    
    public function __construct($datos)
    {
        $this->datos = $datos;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.globales.modal-iconos');
    }
}
