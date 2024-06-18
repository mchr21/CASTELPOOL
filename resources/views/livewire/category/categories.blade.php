<div class="row sales layout-top-spacing">

    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <li>
                        @can('Category_Create')

                        <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal"
                        data-target="#theModal">Agregar</a>
                    @endcan
                        </li>
                </ul>
            </div>
            {{-- search --}}
            @can('Category_Search')
            @include('common.searchbox')

           
            @endcan

            <div class="widget-content">

                <div class="table-responsive">
                    <table class="table table-bordered table striped mt-1">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-white">DESCRIPCIÓN</th>
                                <th class="table-th text-white text- text-center">IMAGEN</th>
                                <th class="table-th text-white text-center">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>
                                        <h6>{{ $category->name }}</h6>
                                    </td>
                                    <td class="text-center">
                                     <span>
                                        <img src="{{ asset('storage/' . $category->imagen) }}"
                                        alt="imagen de ejemplo" height="70" width="80" class="rounded">
                                    </span>
                                    </td>
                              

                                    <td class="text-center">
                                        @can('Category_Update')
                                        
                                        <a href="javascript:void(0)" wire:click="Edit({{ $category->id }})"
                                            class="btn btn-dark mtmobile" title="Edit" >
                                            <i class="fas fa-edit"></i>
                                            </a>
                                            @endcan
                                            

                                       @if($category->products->count() < 1)
                                       @can('Category_Destroy')
                                       
                                       <a href="javascript:void(0)" onclick="Confirm('{{ $category->id }}', '{{$category->products->count()}} ')"
                                        class="btn btn-dark" title="Delete">
                                        <i class="fas fa-trash"></i>
                                        </a>
                                    @endcan
                                        
                                       @endif
                                       {{-- {{$category->products->count()}} 

                                        {{$category->Imagen}} --}}

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- Pagination --}}
                    {{$categories->links()}}
                </div>

            </div>


        </div>


    </div>

    @include('livewire.category.form')
</div>

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script> --}}
<script>
    
    document.addEventListener('DOMContentLoaded', function() {

        // --------------AQUI ESTABA BLOQUENDO LA PALABRA window.livewire.on cambie por window.Livewire.on
        // window.livewire.on('show-modal', msg =>{
		// 	$('#theModal').modal('show')
		// });
       
        // --------------ESTA FUNCIONA DE OTRA MANERA
            // document.addEventListener('DOMContentLoaded', function() {
            //     Livewire.on('show-modal', (data) => {
            //         $('#theModal').modal('show');
            //         console.log(data.message); // Accede a los datos enviados con el evento
            //     });
            // });/


            window.Livewire.on('show-modal', msg =>{
			$('#theModal').modal('show')
		});


            window.Livewire.on('category-added', msg => {
            $('#theModal').modal('hide') ; 
            noty(msg); 
    //         console.log('Mensaje a mostrar:', msg); // Imprimir el mensaje que se va a mostrar
    // toastr.success(msg);
        });

        window.Livewire.on('category-deleted', msg => {
            noty(msg, 2)
        })




        window.Livewire.on('category-updated', msg =>{
			$('#theModal').modal('hide')
            noty(msg); 
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
