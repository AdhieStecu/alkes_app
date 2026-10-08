<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-950">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Alkes App - Registrasi & Manajemen Profil</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

        <script>
            window.__AUTH_USER__ = @json(Auth::user());
            window.__CSRF_TOKEN__ = "{{ csrf_token() }}";
        </script>

        <!-- Scripts and Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="h-full antialiased bg-slate-950 text-slate-100 font-sans selection:bg-emerald-500 selection:text-white">
        <div id="app" class="h-full"></div>
    </body>
</html>
