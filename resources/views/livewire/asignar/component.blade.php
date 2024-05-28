<div class="row sales layout-top-spacing">

    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }}</b>
                </h4>

            </div>

            <div class="widget-content">
                <div class="form-inline">
                    <div class="form-group mr-5">
                        <select wire:model ="role" class="form-control">
                            
                            <option value="Elegir" selected>== Selecciona el Role ==</option>
                            @foreach($roles as $role)
                            
                            <option value="{{$role->id}}" >{{$role->name}}</option>
                            @endforeach
                        </select>
                        
                    </div>


                    
                    {{-- mandamos llamar el metodo del backend -->SyncAll()" --}}

                    <button wire:click.prevent="SyncAll()" type="button"
                        class="btn btn-dark mbmobile inblock mr-5">Sincronizar Todos</button>

                    {{-- aqui el metodo que mandamos a llamar es Revocar(), es un metodo de JavaScript --}}
                    <button onclick="Revocar()" type="button" class="btn btn-dark mbmobile mr-5">Revocar Todos</button>
                </div>

                <div class="row" mt-3>
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table striped mt-1">
                                <thead class="text-white" style="background: #3B3F5C">
                                    <tr>
                                        <th class="table-th text-white text-center">ID</th>
                                        <th class="table-th text-white text-center">PERMISO</th>
                                        <th class="table-th text-white text-center">ROLES CON EL PERMISO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($permisos as $permiso)
                                    <tr>
                                        <td><h6 class="text-center">{{$permiso->id}}</h6></td>
                                        <td class="text-center">
                                           <div class="n-check">    {{-- contenedor del checkbox --}}
                                                <label class="new-control new-checkbox checkbox-primary">   {{-- estilos al checkbox --}}
                                                    
                                                   

                                                    <input type="checkbox"
                                                    wire:change="syncPermiso($('#p' + {{ $permiso->id }}).is(':checked'), '{{ $permiso->name}}' )" {{-- Este atributo usa Livewire para llamar a la función syncPermiso cuando se cambia el estado del checkbox. La función recibe dos parámetros: --}}
                                                    id="p{{ $permiso->id }}"
                                                    value="{{ $permiso->id }}" 
                                                     class="new-control-input"   {{-- Clase CSS para el checkbox. --}}
                                                    {{ $permiso->checked == 1 ? 'checked' : '' }} {{-- Esto determina si el checkbox está marcado o no al cargar la página. Si checked es igual a 1, el checkbox estará marcado. --}}

                                                    >
                                                     <span class="new-control-indicator"></span>  {{--Este span se usa para mostrar un indicador visual del estado del checkbox (marcado o desmarcado), y es estilizado con CSS. --}}
                                                     <h6>{{ $permiso->name}}</h6> {{--Muestra el nombre del permiso junto al checkbox --}}
                                                </label>
                                            </div> 
                                        </td>
                                        <td class="text-center">

                                            {{-- <h6>{{ $permisoCounts[$permiso->name] }}</h6> --}}
                                            <h6>{{ \App\Models\User::permission($permiso->name)->count() }}</h6>
                                            
                                        </td>

                                    </tr>
                                    
                                    



                                    @endforeach
                                </tbody>
                            </table>
                            {{$permisos->links()}}
                        </div>
                    </div>
                    
                </div>

            </div>


        </div>


    </div>
   
</div>


<script>
    document.addEventListener('DOMContentLoaded', function(){
        
        window.Livewire.on('sync-error', Msg => {
            noty(Msg)
        })
        window.Livewire.on('permi', Msg => {
            noty(Msg)
        })
        window.Livewire.on('syncall', Msg => {
            noty(Msg)
        })
        window.Livewire.on('removeall', Msg => {
            noty(Msg)
        })


    });


    function Revocar()
    {   

        swal({
            title: 'CONFIRMAR',
            text: '¿CONFIRMAS REVOCAR TODOS LOS PERMISOS?',
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#fff',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if(result.value){
                window.Livewire.dispatch('revokeall')
                
                swal.close()
            }

        })
    }

</script>




            </div>


        </div>


    </div>

    Include Form
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {

    });
</script>
