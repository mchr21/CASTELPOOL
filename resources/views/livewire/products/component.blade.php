<div class="row sales layout-top-spacing">

    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal"
                            data-target="#theModal">Agregar</a>
                    </li>
                </ul>
            </div>
            {{-- search --}}
            @include('common.searchbox')

            <div class="widget-content">

                <div class="table-responsive">
                    <table class="table table-bordered table striped mt-1">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-white">DESCRIPCIÓN</th>
                                <th class="table-th text-white text-center">BARCODE</th>
                                <th class="table-th text-white text-center">CATEGORÍA</th>
                                <th class="table-th text-white text-center">PRECIO</th>
                                <th class="table-th text-white text-center">STOCK</th>
                                <th class="table-th text-white text-center">INV. MIN</th>
                                <th class="table-th text-white text-center">IMAGEN</th>
                                <th class="table-th text-white text-center">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $product)
                                <tr>
                                    <td> <h6 class="text-left">{{ $product->name }}</h6></td>
                                    <td><h6 class="text-center">{{ $product->barcode }}</h6></td>
                                    <td><h6 class="text-center">{{ $product->category }}</h6></td>
                                    <td><h6 class="text-center">{{ $product->price }}</h6></td>
                                    <td><h6 class="text-center">{{ $product->stock }}</h6></td>
                                    <td><h6 class="text-center">{{ $product->alerts }}</h6></td>
                                    <td class="text-center">
                                        <span>
                                            <img src="{{ asset('storage/products/' . $product->imagen) }}"
                                                alt="imagen de ejemplo" height="70" width="80" class="rounded">
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="Edit({{ $product->id }})"
                                            class="btn btn-dark mtmobile" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="javascript:void(0)" onclick="Confirm('{{ $product->id }}')"
                                            class="btn btn-dark" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>


                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    {{ $data->links() }}
                </div>

            </div>


        </div>


    </div>

    @include('livewire.products.form')
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.Livewire.on('product-added', msg => {
            $('#theModal').modal('hide')
        });
        window.Livewire.on('product-updated', msg => {
            $('#theModal').modal('hide')
        });
        window.Livewire.on('product-deleted', msg => {
            // noty
        });
        window.Livewire.on('modal-show', msg => {
            $('#theModal').modal('show')
        });
        window.Livewire.on('modal-hide', msg => {
            $('#theModal').modal('hide')
        });
        window.Livewire.on('hidden.bs.modal', msg => {
            $('.er').css('display', 'none')
        });

        $('#theModal').on('hidden.bs.modal', function(e){
            $('.er').css('display', 'none')
        });
        
        
    });




    function Confirm(id, products)
	{	
        if(products > 0)
        {
            swal('NO SE PUEDE ELIMINAR LA CATEGORIA PORQUE TIENE PRODUCTOS RELACIONADOS')
            return;
        }

		swal({
			title: 'CONFIRMAR',
			text: '¿CONFIRMAS ELIMINAR EL REGISTRO?',
			type: 'warning',
			showCancelButton: true,
			cancelButtonText: 'Cerrar',
			cancelButtonColor: '#fff',
			confirmButtonColor: '#3B3F5C',
			confirmButtonText: 'Aceptar'
		}).then(function(result) {
			if(result.value){
				window.Livewire.dispatch('deleteRow', [id])
				swal.close()
			}

		})
	}
</script>
