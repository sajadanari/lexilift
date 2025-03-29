<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#4f46e5">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Material Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />

    <title>{{ $title ?? 'LexiLift' }}</title>
</head>

<body>

    <x-sidebar.sidebar />

    <main>
        {{ $slot }}
    </main>

</body>

</html>
