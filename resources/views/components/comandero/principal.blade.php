<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Comandero') }}</title>

        {{-- Hojas de estilo del sistema --}}
        {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
        {{-- <link href="mobile/css/bootstrap.min.css" rel="stylesheet"> --}}

        {{-- <link rel="stylesheet" href="{{ asset('mobile/css/bootstrap.min.css') }}"> --}}
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/font-awesome-582.css') }}">
        <link rel="stylesheet" href="{{ asset('css/mdb.min.css') }}">
        <link rel="stylesheet" href="{{ asset('mobile/css/materialdesignicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('mobile/css/slick.min.css') }}">
        <link rel="stylesheet" href="{{ asset('mobile/css/slick-theme.min.css') }}">
        <link rel="stylesheet" href="{{ asset('mobile/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('mobile/css/demo.css') }}">
        {{-- <link rel="stylesheet" href="{{ asset('css/galeria.css') }}"> --}}



        @stack('style')

        @livewireStyles

    </head>

</head>

<body class="bg-light">
<div class="padding_bottom">

{{ $slot }}



        {{-- footer and scripts --}}
        @stack('modals')

        @livewireScripts
                {{-- Scripts necesarios para el sistema que se van para footer --}}
                {{-- <script src="{{ asset('mobile/js/jquery.min.js') }}" type="04a459c5a4f20d16cf01b0b3-text/javascript"></script> --}}
                {{-- <script src="{{ asset('mobile/js/bootstrap.bundle.min.js') }}" type="04a459c5a4f20d16cf01b0b3-text/javascript"></script> --}}
                <script src="{{ asset('js/app.js') }}"></script>
                <script src="{{ asset('js/mdb.min.js') }}"></script>
                <script src="{{ asset('mobile/js/slick.min.js') }}" type="04a459c5a4f20d16cf01b0b3-text/javascript"></script>
                <script src="{{ asset('mobile/js/hc-offcanvas-nav.js') }}" type="04a459c5a4f20d16cf01b0b3-text/javascript"></script>
                <script src="{{ asset('mobile/js/custom.js') }}" type="04a459c5a4f20d16cf01b0b3-text/javascript"></script>
                <script src="{{ asset('mobile/js/rocket-loader.min.js') }}" data-cf-settings="04a459c5a4f20d16cf01b0b3-|49" defer=""></script>



        @stack('scripts')
    </body>
</html>