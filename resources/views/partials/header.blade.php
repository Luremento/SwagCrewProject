<header class="sticky top-0 z-50 bg-white/80 shadow-sm backdrop-blur-md dark:bg-gray-900/80">
    <div class="container mx-auto px-4">
        <div class="flex h-16 items-center justify-between">
            <!-- Логотип -->
            <div class="flex items-center">
                <a href="/" class="flex items-center">
                    <svg class="h-8 w-8 text-primary-600 dark:text-primary-400" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="ml-2 text-xl font-bold text-gray-900 dark:text-white">MusicHub</span>
                </a>
            </div>

            <!-- Навигация для десктопа -->
            <nav class="hidden md:flex md:items-center md:space-x-6">
                <a href="/" class="text-primary-600 dark:text-primary-400 font-medium">Главная</a>
                <a href="/"
                    class="text-gray-600 transition-colors hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400">Треки</a>
                <a href="/"
                    class="text-gray-600 transition-colors hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400">Форум</a>
                <a href="/"
                    class="text-gray-600 transition-colors hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400">Категории</a>
                <a href="/"
                    class="text-gray-600 transition-colors hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400">О
                    нас</a>
            </nav>

            <!-- Правая часть -->
            <div class="flex items-center space-x-4">
                <!-- Поиск -->
                <div class="hidden md:block">
                    <div class="relative">
                        <input type="text" placeholder="Поиск..."
                            class="w-64 rounded-full border-none bg-gray-100 pl-10 pr-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500 dark:bg-gray-800 dark:text-gray-300 dark:placeholder-gray-500">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 dark:text-gray-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Переключатель темы -->
                <button id="theme-toggle"
                    class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-100 text-gray-600 transition-colors hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 dark:hidden" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="hidden h-5 w-5 dark:block" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>

                <!-- Кнопки авторизации -->
                @guest
                    <a href="{{ route('login') }}"
                        class="hidden rounded-full bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 sm:block">
                        Войти
                    </a>
                    <a href="{{ route('register') }}"
                        class="rounded-full bg-primary-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-primary-700 dark:bg-primary-700 dark:hover:bg-primary-800">
                        Регистрация
                    </a>
                @else
                    <!-- Уведомления -->
                    <div class="relative">
                        <button
                            class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-100 text-gray-600 transition-colors hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span
                                class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-primary-600 text-xs font-bold text-white">3</span>
                        </button>
                    </div>

                    <!-- Профиль пользователя -->
                    <div class="relative">
                        <a href="{{ route('profile.index') }}">
                            <button
                                class="flex h-9 w-9 items-center justify-center overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700">
                                @if (Auth::check() && Auth::user()->avatar)
                                    <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}" alt="Аватар"
                                        class="h-full w-full object-cover">
                                @else
                                    <img src="{{ asset('img/default-avatar.webp') }}" alt="Аватар"
                                        class="h-full w-full object-cover">
                                @endif
                            </button>
                        </a>
                    </div>

                    <!-- Кнопка загрузки трека -->
                    <a href="{{ route('track.create') }}"
                        class="rounded-full bg-primary-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-primary-700 dark:bg-primary-700 dark:hover:bg-primary-800">
                        <span class="hidden sm:inline">Загрузить трек</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:hidden" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </a>
                @endguest

                <!-- Мобильное меню -->
                <button
                    class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-100 text-gray-600 transition-colors hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 md:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>
