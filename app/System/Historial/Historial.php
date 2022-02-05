<?php
namespace App\System\Historial;

use App\Models\CorteDeCaja;
use App\Models\EfectivoGastos;
use App\Models\EfectivoRemesas;
use App\Models\TicketOrden;
use App\Models\TicketProducto;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/*
Los tipos de impresion se distribuiran asi:
1. Pre Cuenta
2. Comanda (produsctos guardados)
3. Factura (Ya cancelada, independiente si es factura, tickeet, ccf. etc)
4. Comanda (Productos Eliminados)

*/

trait Historial {


    public function ventasUnica($fecha){
        return TicketProducto::select('cod', 'producto','pv','total', 'num_fact', 'orden', 'tipo_venta', 
                                                DB::raw('sum(total) as totales, cod'), 
                                                DB::raw('sum(descuento) as descuentos, cod'), 
                                                DB::raw('count(*) as cantidad, cod'))
                                              ->where('edo', 1)
                                              ->whereDay('created_at', $fecha)
                                              ->groupBy('cod')
                                              ->orderBy('cantidad', 'desc')
                                              ->get();
    }


    public function ventasMultiple($fecha1, $fecha2){
        return TicketProducto::select('cod', 'producto','pv','total', 'num_fact', 'orden', 'tipo_venta', 
                                                DB::raw('sum(total) as totales, cod'), 
                                                DB::raw('sum(descuento) as descuentos, cod'), 
                                                DB::raw('count(*) as cantidad, cod'))
                                            ->where('edo', 1)
                                            ->whereBetween('created_at', [$fecha1, $fecha2])
                                            ->groupBy('cod')
                                            ->orderBy('cantidad', 'desc')
                                            ->get();
    }


    public function gastosUnica($fecha){
        return EfectivoGastos::whereDay('created_at', $fecha)
                                ->with('banco')
                                ->orderBy('tiempo', 'desc')
                                ->get();
    }

    public function gastosMultiple($fecha1, $fecha2){
        return EfectivoGastos::whereBetween('created_at', [$fecha1, $fecha2])
                                ->with('banco')
                                ->orderBy('tiempo', 'desc')
                                ->get();
    }


    public function remesasUnica($fecha){
        return EfectivoRemesas::whereDay('created_at', $fecha)
                                ->with('banco')
                                ->orderBy('tiempo', 'desc')
                                ->get();
    }

    public function remesasMultiple($fecha1, $fecha2){
        return EfectivoRemesas::whereBetween('created_at', [$fecha1, $fecha2])
                                ->with('banco')
                                ->orderBy('tiempo', 'desc')
                                ->get();
    }



    public function cortesRango($fecha1, $fecha2){
        return CorteDeCaja::whereBetween('updated_at', [$fecha1, $fecha2])
                                            ->orderBy('tiempo', 'desc')
                                            ->with('user')
                                            ->get();
    }


    public function cortesUnica($fecha1){
        return CorteDeCaja::whereDay('updated_at', $fecha1)
                                            ->orderBy('tiempo', 'desc')
                                            ->with('user')
                                            ->get();
    }


    public function meserosUnica($fecha, $usuario){
        return TicketOrden::addSelect(['usuario' => User::select('name')
                            ->whereColumn('empleado', 'users.id')])
                            ->whereDay('created_at', $fecha)
                            ->orderBy('empleado', 'desc')
                            ->where('empleado', $usuario)
                            ->get();
    }


    public function meserosMultiple($fecha1, $fecha2, $usuario){
        return TicketOrden::addSelect(['usuario' => User::select('name')
                                ->whereColumn('empleado', 'users.id')])
                                ->whereBetween('created_at', [$fecha1, $fecha2])
                                ->orderBy('empleado', 'desc')
                                ->where('empleado', $usuario)
                                ->get();
    }


    public function ordenesUnica($fecha){
        return TicketOrden::whereDay('created_at', '04')
                                ->orderBy('tiempo', 'desc')
                                ->get();
    }

    public function ordenesMultiple($fecha1, $fecha2){
        return TicketOrden::whereBetween('created_at', [$fecha1, $fecha2])
                                ->orderBy('tiempo', 'desc')
                                ->get();
    }




    public function eliminadosUnica($fecha){
        return TicketProducto::addSelect(['user' => User::select('name')
                                ->whereColumn('usuario', 'users.id')])
                                ->addSelect(['user_borrado' => User::select('name')
                                ->whereColumn('usuario_borrado', 'users.id')])
                                ->whereDay('created_at', $fecha)
                                ->where('edo', 2)
                                ->with('subOpcion')
                                ->orderBy('orden', 'desc')
                                ->get();
    }


    public function eliminadosMultiple($fecha1, $fecha2){
        return TicketProducto::addSelect(['user' => User::select('name')
                                ->whereColumn('usuario', 'users.id')])
                                ->addSelect(['user_borrado' => User::select('name')
                                ->whereColumn('usuario_borrado', 'users.id')])
                                ->whereBetween('created_at', [$fecha1, $fecha2])
                                ->where('edo', 2)
                                ->with('subOpcion')
                                ->orderBy('orden', 'desc')
                                ->get();
    }

    

}