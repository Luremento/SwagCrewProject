<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Музыкальный Форум') - MusicHub</title>
    <meta name="description" content="Форум для музыкантов и любителей музыки">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // Проверяем тему при загрузке страницы до отрисовки контента
        if (localStorage.getItem('theme') === 'dark' ||
            (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
            .content-auto {
                content-visibility: auto;
            }
        }
    </style>
</head>

<body class="min-h-screen bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 transition-colors duration-200">
    <div class="flex flex-col min-h-screen">
        @include('partials.header')

        <main class="flex-grow container mx-auto px-4 py-4">
            @yield('content')
        </main>

        @include('partials.footer')

        <!-- Аудио-плеер -->
        @include('components.audio-player')
    </div>

    <!-- JavaScript для переключения темы -->
    <script>
        function toggleDarkMode() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark')
                localStorage.theme = 'light'
            } else {
                document.documentElement.classList.add('dark')
                localStorage.theme = 'dark'
            }
        }
    </script>

    @stack('scripts')
</body>

</html>
