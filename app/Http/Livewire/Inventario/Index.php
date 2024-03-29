<?php

namespace App\Http\Livewire\Inventario;

use App\Common\Helpers;
use App\Models\InvDependiente;
use App\Models\Inventario;
use App\Models\InvHistorial;
use App\Models\InvUnidades;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{

    protected $listeners = ['EliminarProducto' => 'destroy'];

    public $unidades;
    public $producto, $cantidad, $minimo, $mostrar, $unidad = 1;

    public $cantSumas, $comSumas;
    public $cantRestas, $comRestas;
    public $proSelected;

    public $productos = [];

    public $historial = [];
    public $search;


    public function mount(){
        $this->unidadesMedida();
        $this->getProductos();
        $this->search = NULL;

    }


    public function render()
    {

        if ($this->search) {
            $this->productos = Inventario::where('producto', '!=', NULL)
                    ->where('producto', 'LIKE', '%'.$this->search.'%')
                    ->with('medida')
                    ->where('edo', 1)
                    ->orderBy('id', 'DESC')
                    ->get();
        } else {
            $this->getProductos();
        }

        return view('livewire.inventario.index');
    }



    public function getProductos(){
        $this->productos = Inventario::with('medida')->where('edo', 1)->orderBy('id', 'DESC')->get();
    }


    public function btnAddProducto(){

        $this->validate([
            'producto' => 'required',
            'cantidad' => 'required',
        ]);

        $inv = Inventario::create([
            'producto' => $this->producto,
            'cantidad' => $this->cantidad,
            'minimo' => $this->minimo,
            'mostrar' => $this->mostrar,
            'unidad' => $this->unidad,
            'edo' => 1,
            'clave' => Helpers::hashId(),
            'tiempo' => Helpers::timeId(),
            'td' => session('sistema.td')
        ]);


        InvHistorial::create([
            'producto' => $inv->id,
            'cantidad' => $this->cantidad,
            'comentario' => "Inventario inicial",
            'tipo' => 1, // 1 sumas , 2 Restas
            'usuario' => session('config_usuario_id'),

            'clave' => Helpers::hashId(),
            'tiempo' => Helpers::timeId(),
            'td' => session('sistema.td')
        ]);


        $this->emit('creado');
        
        $this->reset(['producto', 'cantidad', 'minimo', 'mostrar','unidad']);
        $this->getProductos();
    }


    public function unidadesMedida(){

        if (!InvUnidades::count()) {
            $sql = database_path('inv_unidades.sql');
            DB::unprepared(file_get_contents($sql)); 
            InvUnidades::where('td', '<>', session('sistema.td'))->update(['td' => session('sistema.td'), 'tiempo' => Helpers::timeId()]);
        }
        $this->unidades = InvUnidades::all();
    }




    public function seleccionarProducto($pro){
        $this->proSelected = $pro;
    }



    public function btnSumas(){

        $pro = Inventario::where('id', $this->proSelected)->first();
        
        if ($this->cantSumas) {
            
            if ($pro->update(['cantidad' => $pro->cantidad + $this->cantSumas, 'tiempo' => Helpers::timeId()])) {
                InvHistorial::create([
                    'producto' => $this->proSelected,
                    'cantidad' => $this->cantSumas,
                    'comentario' => $this->comSumas,
                    'tipo' => 1, // 1 sumas , 2 Restas
                    'usuario' => session('config_usuario_id'),
        
                    'clave' => Helpers::hashId(),
                    'tiempo' => Helpers::timeId(),
                    'td' => session('sistema.td')
                ]);
        
                $this->dispatchBrowserEvent('mensaje', 
                ['titulo' => 'Realizado', 
                'texto' => 'Se agregaron ' . $this->comSumas . ' al inventario']);
    
                $this->getProductos();
    
            }
            
        } else {
            $this->dispatchBrowserEvent('error', 
            ['titulo' => 'Error!', 
            'texto' => 'Ha ocurrido un error al ingresar la cantidad']);
        }

        $this->reset(['proSelected', 'cantSumas', 'comSumas']);



    }



    public function btnRestas(){
        
        $pro = Inventario::where('id', $this->proSelected)->first();
        
        if ($this->cantRestas) {
            if ($pro->update(['cantidad' => $pro->cantidad - $this->cantRestas, 'tiempo' => Helpers::timeId()])) {
                InvHistorial::create([
                    'producto' => $this->proSelected,
                    'cantidad' => $this->cantRestas,
                    'comentario' => $this->comRestas,
                    'tipo' => 2, // 1 sumas , 2 Restas
                    'usuario' => session('config_usuario_id'),
        
                    'clave' => Helpers::hashId(),
                    'tiempo' => Helpers::timeId(),
                    'td' => session('sistema.td')
                ]);
        
                $this->dispatchBrowserEvent('mensaje', 
                ['titulo' => 'Realizado', 
                'texto' => 'Se descontaron ' . $this->comRestas . ' del inventario']);
    
                $this->getProductos();
    
            } 
        } else {
            $this->dispatchBrowserEvent('error', 
            ['titulo' => 'Errorr!', 
            'texto' => 'Ha ocurrido un error al ingresar la cantidad']);
        }


        $this->reset(['proSelected', 'cantRestas', 'comRestas']);



    }



    public function detallesProducto($pro){
        $this->proSelected = $pro;

        $this->historial = InvHistorial::addSelect(['user' => User::select('name')
                                        ->whereColumn('usuario', 'users.id')])
                                        ->where('producto', $pro)
                                        ->orderBy('id', 'desc')
                                        ->get();
    }

    public function destroy($iden){

        $dependientes = InvDependiente::where('producto', $iden)->count();

        if ($dependientes > 0) {
            $this->dispatchBrowserEvent('error', 
            ['titulo' => 'Errorr!', 
            'texto' => 'No puede eliminar este elemento por que tiene productos dependientes']);
        } else {
            Inventario::find($iden)->delete();
            InvHistorial::where('producto', $iden)->delete();
            $this->dispatchBrowserEvent('mensaje', 
            ['titulo' => 'Realizado', 
            'texto' => 'Elemento Eliminado Correctamente']);
        }

        $this->getProductos();
    }

    public function cancelar(){
        $this->reset(['search']);
    }



}
