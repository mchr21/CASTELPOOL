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
                                <th class="table-th text-white">IMAGEN</th>
                                <th class="table-th text-white">ACTIONS</th>
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
                                        <img src="{{ asset('storage/categories' . $category->image) }}"
                                            alt="imagen de ejemplo" height="70" width="80" class="rounded">
                                    </span>
                                    </td>
                              

                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="Edit({{ $category->id }})"
                                            class="btn btn-dark mtmobile" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="javascript:void(0)" onclick="confirm('{{ $category->id }}')"
                                            class="btn btn-dark" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>


                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    Pagination
                </div>

            </div>


        </div>


    </div>

    @include('livewire.category.form')
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('category-added', msg => { //registrar
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('category-updated', msg => { //actualizar
            $('#theModal').modal('hide')
            noty(msg)
        });
        window.livewire.on('category-deleted', msg => { //eliminar
            noty(msg)
        });
        window.livewire.on('hide-modal', msg => { //evento que indica ocultar la modal
            $('#theModal').modal('hide')
        });
        window.livewire.on('modal-show', msg => { //evento que indica mostrar la modal
            $('#theModal').modal('show')
        });
        window.livewire.on('hidden.bs.modal',
            msg => { //evento para mostrar el mesaje "nombre categoria requerido" para mostrar y ocultar el mesaje "nombre categoria requerido" al  volver a abrir desaparezca
                $('.er').css('display', 'none')
            });

    });



    function Confirm(id) //confirmar eliminar registro 
    {

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
            if (result.value) {
                window.livewire.emit('deleteRow', id)
                swal.close()
            }

        })
    }
</script>
