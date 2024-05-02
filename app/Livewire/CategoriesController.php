<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class CategoriesController extends Component
{

    use WithFileUploads;
    use WithPagination;

    public $name, $search, $image, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Categorías';
       // $this->search = '';
    }

    public function render()
    {
       
        if(strlen($this->search) > 0)
           $data = Category::where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
           
           
       else
            $data = Category::orderBy('id', 'asc')->paginate($this->pagination);
            //dd($this->search);
        return view('livewire.category.categories', ['categories' => $data])
            ->extends('layouts.theme.app')
            ->section('content');

                
    }
}
