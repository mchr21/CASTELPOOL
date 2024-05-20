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
            @include('common.searchbox')

            <div class="widget-content">

                <div class="table-responsive">
                    <table class="table table-bordered table striped mt-1">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-white text-center">ID</th>
                                <th class="table-th text-white text-center">DESCRIPCIÓN</th>
                                <th class="table-th text-white text-center">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach es una directiva de blade --}}
                            @foreach ($roles as $role)
                                <tr>
                                    <td>
                                        <h6>{{ $role->id }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $role->name }}</h6>
                                    </td>

                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="Edit({{ $role->id }})"
                                            class="btn btn-dark mtmobile" title="Edita Registro">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="javascript:void(0)" onclick="Confirm('{{ $role->id }}')"
                                            class="btn btn-dark" title="Eliminar Registro">
                                            <i class="fas fa-trash"></i>
                                        </a>


                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $roles->links() }}
                </div>

            </div>


        </div>


    </div>

    @include('livewire.roles.form')
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.Livewire.on('role-added', msg => {
            $('#theModal').modal('hide')
            noty(msg)
        });
        window.Livewire.on('role-updated', msg => {
            $('#theModal').modal('hide')
            noty(msg)
        });
        
        window.Livewire.on('role-deleted', msg => {
            noty(msg, 2)
        })

        window.Livewire.on('role-exits', msg => {
            noty(msg)
        });
        window.Livewire.on('role-error', msg => {
            noty(msg)
        });
        window.Livewire.on('hide-modal', msg => {
            $('#theModal').modal('hide')

        });
        window.Livewire.on('show-modal', msg => {
            $('#theModal').modal('show')
        });

    });

   
    function Confirm(id)
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
            if(result.value){
                window.Livewire.dispatch('destroy', [id])
                swal.close()
            }

        })
    }
</script>
