<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Material Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

    <title>{{ $title ?? 'Page Title' }}</title>

    @stack('styles')

    @livewireStyles

</head>

<body>
    <x-sidebar.admin-sidebar />

    <main>
        {{ $slot }}
    </main>

    @livewireScripts
</body>

</html>
