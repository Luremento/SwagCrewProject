<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Авторизация') - MusicHub</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Стили -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Скрипты -->
    <script>
        // Проверяем тему при загрузке страницы до отрисовки контента
        if (localStorage.getItem('theme') === 'dark' ||
            (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="h-full bg-gradient-to-b from-gray-50 to-gray-100 font-sans antialiased dark:from-gray-900 dark:to-gray-800">
    <div class="flex min-h-full flex-col">
        <main class="flex min-h-screen items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
            @yield('content')
        </main>
    </div>
</body>

</html>
