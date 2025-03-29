<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark:dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#4f46e5" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Material Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />

    <title>{{ $title ?? 'LexiLift' }}</title>
</head>

<body class="bg-white dark:bg-gray-900">

    <x-sidebar.sidebar />

    <main class="w-full bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
        {{ $slot }}
    </main>

</body>

</html>
