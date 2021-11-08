<?php

namespace App\Http\Livewire\Directorio;

use App\Common\Helpers;
use App\Models\Cliente;
use Livewire\Component;
use Livewire\WithPagination;

class Clientes extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $datos = [];

    protected $listeners = ['EliminarCliente' => 'destroy'];

    protected $rules = [
        'nombre' => 'required',
        'direccion' => 'required',
        'telefono' => 'required'
    ];

    public $nombre, 
            $identidad, 
            $telefono, 
            $direccion, 
            $email, 
            $nacimiento, 
            $documento, 
            $registro, 
            $cliente, 
            $giro, 
            $departamento_doc, 
            $direccion_doc, 
            $comentarios;



    public function render()
    {
        $clientes = $this->getClientes();
        return view('livewire.directorio.clientes', compact('clientes'));
    }



    public function destroy($id)
    {
        $cliente = Cliente::find($id);
        $cliente->delete();
        // $this->emit('deleted'); // otra forma de emitir el evento
        $this->dispatchBrowserEvent('mensaje', 
        ['clase' => 'success', 
        'titulo' => 'Realizado', 
        'texto' => 'Cliente Eliminado correctamente']);
    }




    public function getClientes(){
        return  Cliente::latest('id')
                    ->paginate(6);
    }


    public function btnAddCliente(){

        $this->validate();

        Cliente::create([
                    'nombre' => $this->nombre,
                    'identidad' => $this->identidad,
                    'direccion' => $this->direccion,
                    'telefono' => $this->telefono,
                    'email' => $this->email,
                    'nacimiento' => $this->nacimiento,
                    'documento' => $this->documento,
                    'registro' => $this->registro,
                    'cliente' => $this->cliente,
                    'giro' => $this->giro,
                    'departamento_doc' => $this->departamento_doc,
                    'direccion_doc' => $this->direccion_doc,
                    'edo' => 1,
                    'comentarios' => $this->comentarios,
                    'clave' => Helpers::hashId(),
                    'tiempo' => Helpers::timeId(),
                    'td' => config('sistema.td')
                ]);

        
        $this->reset();
        $this->emit('creado'); // manda el mensaje de creado

    }


}
