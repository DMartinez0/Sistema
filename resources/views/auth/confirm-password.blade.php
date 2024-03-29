<x-no-login>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <a class="d-flex justify-content-center mb-4" href="/login">
                @if (isLatam() == true)
                <img src="{{ asset('img/logo/latamPOS.png') }}" height="100" width="100" alt="LatamPOS">
                @else
                <img src="{{ asset('img/logo/hibrido_logo.png') }}" height="100" width="100" alt="Hibrido">
                @endif
            </a>
        </x-slot>

        <div class="card-body">

            <div class="mb-3 text-sm text-muted">
                {{ __('Esta es un área segura de la aplicación. Por favor, confirme su contraseña antes de continuar.') }}
            </div>

            <x-jet-validation-errors class="mb-2" />

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div>
                    <x-jet-label for="password" value="{{ __('Password') }}" />
                    <x-jet-input id="password" type="password" name="password" required autocomplete="current-password" autofocus />
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <x-jet-button class="ml-4">
                        {{ __('Confirmar') }}
                    </x-jet-button>
                </div>
            </form>
        </div>
    </x-jet-authentication-card>
</x-no-login>
