<?php

namespace App\Livewire;
use Livewire\Component;
use App\Models\User;
use App\Models\Sale;
use Illuminate\Support\Carbon;
//use Carbon\Carbon;//para trabajar laas fechas

class CashoutController extends Component
{
    public $fromDate, $toDate, $userid, $total, $items, $sales, $details; //definimos las propiedades publicas

    public function mount()
    {
        $this->fromDate = null;
        $this->toDate = null;
        $this->userid = 0;
        $this->total =0;
        $this->sales = [];
        $this->details = [];
    }

    public function render() //renderizar nuestra vista principal se va a pasar unicamente a nuestra vista la lista usuaros del sistema
    {
        return view('livewire.cashout.component', [
            'users' => User::orderBy('name','asc')->get()            
        ])->extends('layouts.theme.app')
        ->section('content');
        
    }


    public function Consultar()//AQUI ESTAMOS CONSULTANDO TODAS LAS VENTAS
    {

        $fi= Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
        $ff= Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59';

        $this->sales = Sale::whereBetween('created_at', [$fi, $ff] )
        ->where('status', 'Paid')
        ->where('user_id', $this->userid)
        ->get();

        $this->total = $this->sales ? $this->sales->sum('total') : 0;
        $this->items = $this->sales ? $this->sales->sum('items') : 0;

    
    }


    public function viewDetails(Sale $sale)//AQUI PASAMOS UNA VENTA Y OBTENEMOS LOS DETALLES DE ESA VENTA
    {
       $fi= Carbon::parse($this->fromDate)->format('Y-m-d') . ' 00:00:00';
       $ff= Carbon::parse($this->toDate)->format('Y-m-d') . ' 23:59:59';
      
       $this->details = Sale::join('sale_details as d','d.sale_id','sales.id')
       ->join('products as p','p.id','d.product_id')
       ->select('d.sale_id','p.name as product','d.quantity','d.price')//selecionamos las columnas que necesitamos
       ->whereBetween('sales.created_at', [$fi, $ff])//para obtener informacion de esas fechas
       ->where('sales.status', 'PAID')//que muestre detalle de la venta que solo sea pagado
       ->where('sales.user_id', $this->userid)//que el usuario sea el que estamos seleccionando en el select de la vista principal
       ->where('sales.id', $sale->id)//filtramos donde la venta(sales.id) sea igual a la venta que nos estan pasando ($sale->id)
       ->get();//para obtener la informacion 

       $this->dispatch('show-modal','open modal');//evento para que en el front se muestre la modal
        
   }


   public function Print()
   {
       
   }

}



