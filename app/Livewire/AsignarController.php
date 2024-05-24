<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB ;

class AsignarController extends Component
{
    use WithPagination;

    public $role, $componentName, $permisosSelected = [], $old_permissions =[];
    private $pagination = 10;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->role = 'Elegir';
        $this->componentName ='Asignar Permisos';       
    }
// el metodo render--obtener todos los permisos q tenemos en el sistema ordenarlos y organizarlos en una paginacion
    public function render()
    {         
        $permisos = Permission::select('name','id', DB::raw("0 as checked"))//obtenemos el name id y lo concatenamos una tercera columna q por defecto tiene valor cero qu  se llama checket 
        ->orderBy('name','asc')
        ->paginate($this->pagination);     
        
        if($this->role != 'Elegir')
        {     
           
                            // la siguiente consulta eloquent, lo sig hace es lo mismo en una consulta sql;
                                            // SELECT * FROM permissions
                                            // JOIN role_has_permissions AS rp
                                            // ON rp.permission_id = permissions.id;
                                            // WHERE rp.role_id = [role_id];                              
            $list = Permission::join('role_has_permissions as rp','rp.permission_id','permissions.id')                         
            ->where('role_id', $this->role)
            ->pluck('permissions.id') //extaelos valores de la columna id   de la tabla permissions de los resultados filtrados
            ->toArray(); //Convierte la colección resultante en un array PHP.
            $this->old_permissions = $list;  //Asigna el array resultante a la propiedad old_permissions del objeto actual.          
            
        }

        if($this->role != 'Elegir') 
        {
            $i = 0;
            foreach ($permisos as $permiso) {
                $role = Role::find($this->role); // vamos a buscar el rol q selecciona el ususario
                $tienePermiso = $role->hasPermissionTo($permiso->name); // hasPermissionTo valida si tiene asignado ese permiso
                if($tienePermiso) { 
                   $permiso->checked = 1;
              
                   
                }
            }
        }
                  //  dd($permiso->checked);


        return view('livewire.asignar.component',[
            'roles' => Role::orderBy('name','asc')->get(),  // a nuestra vista ya estamos pasando 'roles' los cuales dibujaremos en el select
            'permisos' => $permisos,                        // tambien los permisos    
            // 'permisosSelected' => $this->permisosSelected,
            // 'old_permissions' => $this->old_permissions
        ])->extends('layouts.theme.app')->section('content');
    }


    public $listeners = ['revokeall' => 'RemoveAll'];


    public function RemoveAll()
    {
       if($this->role =='Elegir')
       {
        $this->dispatch('sync-error','Selecciona un role válido');
        return;
    }
    //en caso de que el usuario si selecciono un rol, buscamos:
    $role = Role::find($this->role);
    $role->syncPermissions([0]); // REVOCA PERMISOS..sincronizamos todos los permisos-- en este caso estamos removiendo los permisos por eso cero
    $this->dispatch('removeall',"Se revocaron todos los permisos al role $role->name ");

}


public function SyncAll()
{
    if($this->role =='Elegir')
    {

        $this->dispatch('sync-error','Selecciona un role válido');
        return;
    }
//en caso de que el usuario si selecciono un rol, buscamos:
    $role = Role::find($this->role);
    $permisos = Permission::pluck('id')->toArray(); //pluck nos permite obtener la o las comlumnas que queremos obtener en este caso id
    $role->syncPermissions($permisos);// sincronizamos todos los permisos

    $this->dispatch('syncall',"Se sincronizaron todos los permisos al role $role->name ");
}


public function syncPermiso($state, $permisoName)
{
    if($this->role !='Elegir')
    {
        $roleName = Role::find($this->role);

        if($state)
        {
            $roleName->givePermissionTo($permisoName);
            $this->dispatch('permi',"Permiso asignado correctamente ");

        } else {
            $roleName->revokePermissionTo($permisoName);
            $this->dispatch('permi',"Permiso eliminado correctamente ");
        }

    } else {
        $this->dispatch('permi',"Elige un role válido");
    }
    
}




}
