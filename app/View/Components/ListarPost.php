<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class ListarPost extends Component
{
    /**
     * Create a new component instance.
     */
    #creamos la propiedad para que la registre 
    public $posts; 
    #Le pasamo la variable que le enviamos desde la declaracion del componente debe tener el mismo nombre 
    public function __construct($posts)
    {
        $this->posts=$posts; 
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.listar-post');
    }
}
