<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="./images/tih-logo-zip-file/png/logo-no-background.png" sizes="16x16" type="image/png">
    <link rel="icon" href="./images/tih-logo-zip-file/png/logo-no-background.png" sizes="32x32" type="image/png">
    <link rel="icon" href="./images/tih-logo-zip-file/png/logo-no-background.png" sizes="48x48" type="image/png">
    <link rel="icon" href="./images/tih-logo-zip-file/png/logo-no-background.png" sizes="64x64" type="image/png">
    <link rel="icon" href="./images/tih-logo-zip-file/png/logo-no-background.png" sizes="128x128" type="image/png">
    <link rel="icon" href="./images/tih-logo-zip-file/png/logo-no-background.png" sizes="256x256" type="image/png">
    <link rel="icon" href="./images/tih-logo-zip-file/svg/logo-no-background.svg" type="image/svg+xml">


    <title inertia>{{ config('app.name', 'TecnoInformática') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/c20daae918.js" crossorigin="anonymous"></script>
    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia
</body>

</html>
