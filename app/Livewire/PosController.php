<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Denomination;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Exception;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PosController extends Component
{
    //===========1==========
    public $total, $itemsQuantity, $efectivo, $change;

    //===========4=========
    public function mount()
    {
        $this->efectivo = 0;
        $this->change = 0;
        //otener el total del carrito//
        $this->total  = Cart::getTotal();
        //obtener cantidad de productos agredados al carrito//
        $this->itemsQuantity = Cart::getTotalQuantity();
        
    }

    //===========2==========
    public function render()
    {
        return view('livewire.pos.component', [
            'denominations' => Denomination::orderBy('value', 'desc')->get(),
            'cart' => Cart::getContent()->sortBy('name')
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }
    //===========3==========
    // agregar efectivo / denominations
    public function ACash($value)    {
          

         //   $this->efectivo += ($value == 0 ? $this->total : $value);

if($value == 0 ){
    $this->efectivo =  $this->total;
    $this->change = 0;
    
}else{
    $this->efectivo +=  $value;
    $this->change = ($this->efectivo - $this->total);
   // dd($this->change);

}



            
        //    dd($this->change);
      
    }
    //===========5 listeners==========

    // escuchar eventos---declaramos los listeners para capturar los eventos que se envian desde el frontend y manejarlos en el backend
    protected $listeners = [
        //tenemos un evento que vamos a escuchar desde el front cuando utilice el lector de cod barras =>  y vamos a mandar a llamar un metodo que se llama ScanCode
        'scan-code'  =>  'ScanCode',
        'removeItem' => 'removeItem',
        'clearCart'  => 'clearCart',
        'saveSale'   => 'saveSale',
        'clearCoins'   => 'clearCoins'

    ];

    //metodo que se encarga de recibir el cod de barras y lo busca en base de datos para agregar al carrito  en caso de exitir lo actualiza
    // buscar y agregar producto por escaner y/o manual
    public function ScanCode($barcode, $cant = 1)
    {              
           // dd($barcode);
        $product = Product::where('barcode', $barcode)->first(); //retorna el pr1mer elemento encontrado el la bd

        if ($product == null || empty($product))  //validamos si el producto es encontrado prod == 0 o la buqueda nos devolvio un resultado vacio
        {          
            $this->dispatch('scan-notfound', 'El producto no esta registrado');
        } else {

            //si el producto ya exite dentro del carrito le pasamos el id del producto
            if ($this->InCart($product->id)) {
               // dd($product);
                //si el producto ya exite dentro del carrito le pasamos el id del producto llamamos al metodo increaseqty el id del prodcuto 
                $this->increaseQty($product->id); //incrementamos al carrito -... si ya tiene uno entonces incrementamos a 2
                return;
            }            
     
            if ($product->stock < 1) {
                $this->dispatch('no-stock', 'Stock insuficiente :/');
                return;
            }
            //adicionamos el producto al carrito
         //  Cart::add(array($product->id, $product->name, $product->price, $product->image));
         Cart::add($product->id, $product->name, $product->price,$cant, $product->image);
    //          $carro = Cart::getContent();
    //    dd($carro);

            // tambien se tiene que actualizar el total con la sumatoria total del carrito 
            $this->total = Cart::getTotal();
            $this->dispatch('scan-ok', 'producto agregado'); 
        }
       //dd($product);
        
    }
    //metodo de incart le pasamos el id// validara si el id del producto ya existe en el carrito
    public function InCart($productId)
    {
        $exist = Cart::get($productId);
        if ($exist)
            return true;
        else
            return false;
    }
    // actualiza la cantidad de la existencia del producto en nuetro carrito
    public function increaseQty($productId, $cant = 1)
    {
        $title = ''; //variable para retornar el mensaje en la vista---segun la acciona  a realizar
        $product = Product::find($productId);
        $exist = Cart::get($productId);
        if ($exist)
            $title = 'cantidad Actualizada';
        else
            $title = 'Producto Agregado';
        if ($exist) 
        {
            if ($product->stock < ($cant + $exist->quantity)) 
            {
                $this->dispatch('no-stock', 'Stock insuficiente :/');
                return;
            }                
        }
        // cuando se usa el metodo add internamente valida si el producto existe
        //si no exite lo crea y si exite lo actualiza la cantidad
        Cart::add($product->id, $product->name, $product->price,$cant, $product->image);
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity(); //muestra el total de productos 
        $this->dispatch('scan-ok', $title);
        }

    // actualizar cantidad item en carrito
    //remplazara la informacion completa dentro del carrito
	public function updateQty($productId, $cant = 1)
	{
		$title = '';
        $product = Product::find($productId);
        $exist = Cart::get($productId);
        if ($exist)
            $title = 'cantidad Actualizada';
        else
            $title = 'Producto Agregado';

        if ($exist)
        {
            if ($product->stock < $cant)
            {
                $this->dispatch('no-stock', 'Stock insuficiente :/');
                return;
            }
        }
        //aqui no solo actualizaremos la cantidad sino
//removemos el carrito para luego volver a insertar nuevamente
      $this->removeItem($productId);
        
        if($cant > 0)
        {
            Cart::add($product->id, $product->name, $product->price,$cant, $product->image);                          
        }
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->dispatch('scan-ok', $title);
	}


    public function removeItem($productId)
    {        
        Cart::remove($productId);        
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->dispatch('scan-ok', 'Producto Eliminado');
    }

    	// decrementar cantidad item en carrito
	public function decreaseQty($productId)
	{
        $item = Cart::get($productId);
        Cart::remove($productId);
		$newQty = ($item->quantity) - 1;
        if($newQty > 0)        
            Cart::add($item->id, $item->name, $item->price, $newQty, $item->attributes[0]);
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();
            $this->dispatch('scan-ok', 'Cantidad Actualizada');       
    }


    public function clearCart()
	{
		Cart::clear();
        $this->efectivo = 0;
        $this->change = 0;
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();
        $this->dispatch('scan-ok', 'Carrito vacio');
	}

    public function clearCoins()
	{
		$this->efectivo = 0;
        $this->change = 0;
       
	}
    public function saveSale()
	{
		if ($this->total <= 0) {
			$this->dispatch('sale-error', 'AGEGA PRODUCTOS A LA VENTA');
			return;
		}
		if ($this->efectivo <= 0) {
			$this->dispatch('sale-error', 'INGRESA EL EFECTIVO');
			return;
		}
		if ($this->total > $this->efectivo) {
			$this->dispatch('sale-error', 'EL EFECTIVO DEBE SER MAYOR O IGUAL AL TOTAL');
			return;
		}
        //CUANDO SE ALMACENA LA VENTA ES NECESARIA REALIZARLA DENTRO DE UNA TRASNSACCION 
        //porque se estamos afectando diferentes tablas
        //por ejemplo estamos insertandp en detalle de ventas, en venta y estamos actualizando el stock en tabla productos

		DB::beginTransaction(); //INICIANDO LA TRANSACCION       
//almacenar la venta y despues el detalle
		try {
            //guardar la venta

			$sale = Sale::create([
				'total' => $this->total,
				'items' => $this->itemsQuantity,
				'cash' => $this->efectivo,
				'change' => $this->change,
				'user_id' => Auth()->user()->id
			]);  //hasta aqui estamos almacenando nuestra venta y le guardamos en la var $sale

			if ($sale) {   //si nuestra venta se guardo
				$items = Cart::getContent();  
              
                //recupera productos del carrito
				foreach ($items as  $item) {  //recorremos
					SaleDetail::create([  //guardamos el detalle
						'price' => $item->price,
						'quantity' => $item->quantity,
						'product_id' => $item->id,
						'sale_id' => $sale->id,
					]);

					//update stock
					$product = Product::find($item->id);  // abrimos una variable, en esa variable asigna la busqueda del producto //rescata el id del producto
					$product->stock = $product->stock - $item->quantity;//actualiza el stok restando lo q esta saliendo
					$product->save();
				}
			}
			DB::commit(); //conformamos la transaccion el la base de datos

			//$this->printTicket($sale->id);
			Cart::clear();   //ahora limiamos el carrito y reinicializamos las veriables
			$this->efectivo = 0;
			$this->change = 0;
			$this->total = Cart::getTotal();
			$this->itemsQuantity = Cart::getTotalQuantity();
			$this->dispatch('sale-ok', 'Venta registrada con éxito');

            // $ticket = $this->buildTicket($sale);/////////////// habilitar
			// $d = $this->Encrypt($ticket);

			//$this->dispatch('print-ticket', $d);

			$this->dispatch('print-ticket', $sale->id); /////////////////////// deshabilitar

		} catch (Exception $e) {
			DB::rollback(); //desasemos los cambios
			$this->dispatch('sale-error', $e->getMessage());
		}
	}

    public function printTicket($sale)
	{
		return Redirect::to("print://$sale->id");
	}
    

}
