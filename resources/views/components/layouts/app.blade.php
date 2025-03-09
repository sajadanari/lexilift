<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@400" rel="stylesheet" />

</head>

<body>
    {{ $slot }}
</body>

</html>
