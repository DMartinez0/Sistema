<?php

namespace App\Http\Livewire\Historial;

use App\System\Historial\Historial;
use Livewire\Component;
use Carbon\Carbon;

class Ordenes extends Component
{
    use Historial;

    public $tipo_fecha;
    public $fecha1, $fecha2;
    public $datos = [];


    public function mount(){
        $this->tipo_fecha = 1;
        $this->aplicarFechas();
    }


    public function render()
    {
        return view('livewire.historial.ordenes');
    }


    public function aplicarFechas(){
        $this->formatFechas();

        if ($this->tipo_fecha == 1) {

            $this->datos = $this->ordenesUnica($this->fecha1);
        } else {
            $this->datos = $this->ordenesMultiple($this->fecha1, $this->fecha2);
        }
    }



    public function formatFechas(){
        if ($this->tipo_fecha == 1) {
            if(!$this->fecha1){ $this->fecha1 = date('d-m-Y'); 
            } else {
                $this->fecha1 = formatJustFecha($this->fecha1);
            }
        } else {
            if(!$this->fecha1){ $this->fecha1 = date('Y-m-01'); } else {
                $this->fecha1 = $this->fecha1;
            }
            if(!$this->fecha2){ $this->fecha2 = Carbon::now()->endOfMonth()->toDateTimeString();  } else {
                $this->fecha2 = $this->fecha2;
            }         
        }
    }






}
