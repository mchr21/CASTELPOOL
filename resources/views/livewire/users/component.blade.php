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
                                <th class="table-th text-white">USUARIO</th>
                                <th class="table-th text-white text-center">TELÉFONO</th>
                                <th class="table-th text-white text-center">EMAIL</th>
                                <th class="table-th text-white text-center">PERFIL</th>
                                <th class="table-th text-white text-center">STATUS</th>
                                <th class="table-th text-white text-center">IMAGEN</th>
                                <th class="table-th text-white text-center">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $r)
                                <tr>
                                    <td><h6>{{ $r->name }}</h6></td>
                                    <td class="text-center"><h6>{{ $r->phone }}</h6></td>
                                    <td class="text-center"><h6>{{ $r->email }}</h6> </td>
                                    <td class="text-center">
                                        <span class="badge {{ $r->status == 'Active' ? 'badge-success' : 'badge-danger' }}     {{--agrega un coloor u otro en base al estado del usuario --}}
                                         text-uppercase">{{ $r->status }}</span> {{--uppercase para ponerlo siempre en mayuscula --}}
                                    </td>
                                    <td class="text-center text-uppercase">
                                        <h6>{{$r->profile}}</h6>
                                        {{-- <small><b>Roles:</b>{{implode(',',$r->getRoleNames()->toArray())}}</small> --}}
                                    </td>
                                    {{-- tarea: personalizar la imagen para que siempre se muestre algo --- asesor--}}
                                    {{-- <td class="text-center"> --}}
                                        {{-- @if ($r->image != null)
                                            <img class="card-img-top img-fluid" alt="imagen"
                                                src="{{ asset('storage/' . $r->image) }}">
                                        @endif --}}                            
                                        {{-- <span>
                                            <img src="{{ asset('storage/users' . $r->image) }}"
                                                alt="imagen" height="70" width="80" class="rcard-img-top img-fluid">
                                        </span>
                                    </td> --}}



                                    <td class="text-center">
                                        <span>
                                            <img src="{{ asset('storage/' . $r->imagen) }}"
                                                alt="imagen" height="70" width="80" class="rcard-img-top img-fluid">
                                        </span>
                                    </td>


                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="edit({{ $r->id }})"
                                            class="btn btn-dark mtmobile" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if (auth()->user()->id != $r->id)
                                            <a href="javascript:void(0)" onclick="Confirm('{{ $r->id }}')"
                                                class="btn btn-dark" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        @endif


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

    @include('livewire.users.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        window.Livewire.on('user-added', Msg => {
            $('#theModal').modal('hide')
            resetInputFile()
            noty(Msg)
        })
        window.Livewire.on('user-updated', Msg => {
            $('#theModal').modal('hide')
            resetInputFile()
            noty(Msg)
        })
        window.Livewire.on('user-deleted', Msg => {           
            noty(Msg)
        })
        window.Livewire.on('hide-modal', Msg => {           
            $('#theModal').modal('hide')
        })
        window.Livewire.on('show-modal', Msg => {           
            $('#theModal').modal('show')
        })
        window.Livewire.on('user-withsales', Msg => {     //se lleva a cabo al eliminar a un susuario-     
            noty(Msg)                                       //si tiene  ventas relacionadas, no se puede eliminar usuario y emite este msj
        })

    })

    function resetInputFile()
    {        
        $('input[type=file]').val('');
    }
    

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
                window.Livewire.dispatch('deleteRow', [id])
                swal.close()
            }

        })
    }
    

</script>