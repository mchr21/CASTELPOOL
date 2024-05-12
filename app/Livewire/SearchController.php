<?php

namespace App\Livewire;

use Livewire\Component;

class SearchController extends Component
{
   public $search; 
    public function render()
    {
        return view('livewire.search'); ///cuando hagamos esta busqueda --en el html al hacer el emit  ------> hacemos el scrippt en el html para escuchar el evento
    }
}
