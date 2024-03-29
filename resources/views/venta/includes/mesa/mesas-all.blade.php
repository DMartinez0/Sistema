<div>
    @if (count($mesasAll))
        
        <div class="row justify-content-center click">
            @foreach ($mesasAll as $mesa)

                <div class="mx-2">
                    <a wire:click="ordenSelect({{ $mesa->id }})">

                        <figure class="figure">
                            <img src="{{ asset('img/imagenes/' . nombreMesa($mesa->clientes)) }}" class="figure-img img-fluid z-depth-2 rounded-circle"  alt="hoverable" >
                                <figcaption class="figure-caption text-center white-text" style="margin-top: -0.5rem; background-color: #f16f01; font-size:large;">
                                    <strong>{{ $mesa->nombre_mesa }}</strong>
                                </figcaption>                                
                                <figcaption class="figure-caption text-center">
                                    @if (App\System\Ventas\MesasPropiedades::cantidadSinGuardar($mesa->id))
                                        <i class="fas fa-exclamation-triangle fa-xs red-text"></i>
                                    @else
                                        <i class="fas fa-save fa-xs green-text"></i>
                                    @endif
                                   <strong>{{ $mesa->usuario }}</strong> 
                                </figcaption>

                                
                        </figure>
                    </a>
                </div>
                
            @endforeach
        </div>

    @else
        {{ mensajex('No exiten ordenes pendientes', 'danger') }}
    @endif
</div>