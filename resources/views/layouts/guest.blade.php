<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    @if (Route::is('home') || Route::is('user.validate'))
        <link rel="stylesheet" href="https://ualetudinis.serveo.net/global.css">
        <link rel="stylesheet" href="https://ualetudinis.serveo.net/css/login.css">
    @endif

    <link rel="stylesheet" href="https://ualetudinis.serveo.net/build/assets/app-8ybRkurH.css">
    <script src="https://ualetudinis.serveo.net/build/assets/app-z-Rg4TxU.js"></script>

    {{-- LINKS CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles()
</head>

<body class="antialiased bg-[#e5e7eb] m-0">
    {{ $slot }}

    @livewireScripts

    <script src="{{ asset('/js/login.js') }}"></script>

    {{-- jQuery e Toastr.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- Configuração do Toastr --}}
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "timeOut": "6000",
        };

        $(document).ready(function() {
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    toastr.error("{{ $error }}");
                @endforeach
            @elseif (session('deslogado'))
                toastr.success("{{ session('deslogado') }}");
            @endif
        });
    </script>
</body>

</html>
