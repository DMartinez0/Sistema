<x-principal-layout>

    {{-- Contenido --}}

    @livewire('cuentas.por-cobrar')

    {{-- contenido  --}}

   
   @push('modals')

    @endpush

    @push('scripts')
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>


    <script>
        Livewire.on('deleteCuenta', categoryId => {
            Swal.fire(
                'Importante!',
                'No se puede borrar un credito, si desea anular la factura debe ir a la opción de anular factura',
                'error'
                )
        });


        Livewire.on('deleteAbono', categoryId => {
            Swal.fire({
                title: '¿Esta seguro?',
                text: "¡No se puede revertir esta acción!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Si, Eliminar!'
                }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('cuentas.por-cobrar', 'EliminarCuentaAbono', categoryId);

                }
            })
        });



        window.addEventListener('mensaje', event => {
                toastr.success(event.detail.texto, event.detail.titulo, {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": false,
                    "positionClass": "md-toast-top-right", 
                    "preventDuplicates": true,
                    "onclick": null,
                    "showDuration": 100,
                    "hideDuration": 100,
                    "timeOut": 2000,
                    "extendedTimeOut": 1000,
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                    }) 
            });


            Livewire.on('error', ()=>{
            Swal.fire({
                icon: 'error',
                title: '¡Error al Agregar!',
                text: 'No se puede agregar el abono, revise sus datos',
                })
            });

            Livewire.on('creado', ()=>{
                Swal.fire(
                    'CUENTA CREADA',
                    'Puede continuar agregando cuentas o abonos',
                    'success'
                )
            });

            window.addEventListener('closeModal', event => {
                $('#' + event.detail.modal).modal('hide');
            });


    </script>
    @endpush

</x-principal-layout>