<header class="sticky top-0 z-50 bg-white/80 shadow-sm backdrop-blur-md dark:bg-gray-900/80">
    <div class="container mx-auto px-4">
        <div class="flex h-16 items-center justify-between">
            <!-- Логотип -->
            <div class="flex items-center">
                <a href="{{ route('index') }}" class="flex items-center">
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
                <a href="{{ route('index') }}"
                    class="{{ request()->routeIs('index') ? 'text-primary-600 dark:text-primary-400 font-medium' : 'text-gray-600 transition-colors hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400' }}">
                    Главная
                </a>

                <a href="{{ route('tracks.index') }}"
                    class="{{ request()->routeIs('tracks.index') ? 'text-primary-600 dark:text-primary-400 font-medium' : 'text-gray-600 transition-colors hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400' }}">
                    Треки
                </a>

                <a href="{{ route('forum.index') }}"
                    class="{{ request()->routeIs('forum.index') ? 'text-primary-600 dark:text-primary-400 font-medium' : 'text-gray-600 transition-colors hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400' }}">
                    Форум
                </a>
                @if (Auth::user() && Auth::user()->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                        class="{{ request()->routeIs('admin.dashboard') ? 'text-primary-600 dark:text-primary-400 font-medium' : 'text-gray-600 transition-colors hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400' }}">
                        Панель администратора
                    </a>
                @endif
            </nav>

            <!-- Правая часть -->
            <div class="flex items-center space-x-4">
                <!-- Поиск -->
                <div class="hidden md:block">
                    <div class="relative" id="searchContainer">
                        <form action="{{ route('search.index') }}" method="GET" id="searchForm">
                            <input type="text" name="q" id="searchInput" value="{{ request('q') }}"
                                placeholder="Поиск пользователей, треков, тем..."
                                class="w-64 rounded-full border-none bg-gray-100 pl-10 pr-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500 dark:bg-gray-800 dark:text-gray-300 dark:placeholder-gray-500"
                                autocomplete="off">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 dark:text-gray-400"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </form>

                        <!-- Выпадающий список с предложениями -->
                        <div id="searchSuggestions"
                            class="absolute top-full left-0 right-0 mt-1 hidden rounded-lg border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800 z-50">
                            <div class="max-h-80 overflow-y-auto p-2" id="suggestionsList">
                                <!-- Предложения будут добавлены через JavaScript -->
                            </div>
                            <div class="border-t border-gray-200 p-2 dark:border-gray-700">
                                <button type="submit" form="searchForm"
                                    class="flex w-full items-center rounded-lg px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    Показать все результаты
                                </button>
                            </div>
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

                <!-- Кнопки авторизации для десктопа -->
                @guest
                    <a href="{{ route('login') }}"
                        class="hidden rounded-full bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 sm:block">
                        Войти
                    </a>
                    <a href="{{ route('register') }}"
                        class="hidden sm:block rounded-full bg-primary-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-primary-700 dark:bg-primary-700 dark:hover:bg-primary-800">
                        Регистрация
                    </a>
                @else
                    <!-- Профиль пользователя -->
                    <div class="relative hidden md:block">
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
                        class="hidden sm:block rounded-full bg-primary-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-primary-700 dark:bg-primary-700 dark:hover:bg-primary-800">
                        Загрузить трек
                    </a>
                @endguest

                <!-- Кнопка мобильного меню -->
                <button id="mobile-menu-button"
                    class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-100 text-gray-600 transition-colors hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 md:hidden">
                    <svg id="hamburger-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg id="close-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Мобильное меню -->
    <div id="mobile-menu"
        class="hidden md:hidden bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
        <div class="container mx-auto px-4 py-4">
            <!-- Поиск в мобильном меню -->
            <div class="mb-4">
                <form action="{{ route('search.index') }}" method="GET">
                    <div class="relative">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Поиск..."
                            class="w-full rounded-full border-none bg-gray-100 pl-10 pr-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500 dark:bg-gray-800 dark:text-gray-300 dark:placeholder-gray-500">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 dark:text-gray-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Навигация -->
            <nav class="space-y-2">
                <a href="{{ route('index') }}"
                    class="block rounded-lg px-3 py-2 text-base font-medium {{ request()->routeIs('index') ? 'bg-primary-100 text-primary-700 dark:bg-primary-900 dark:text-primary-300' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }}">
                    Главная
                </a>

                <a href="{{ route('tracks.index') }}"
                    class="block rounded-lg px-3 py-2 text-base font-medium {{ request()->routeIs('tracks.index') ? 'bg-primary-100 text-primary-700 dark:bg-primary-900 dark:text-primary-300' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }}">
                    Треки
                </a>

                <a href="{{ route('forum.index') }}"
                    class="block rounded-lg px-3 py-2 text-base font-medium {{ request()->routeIs('forum.index') ? 'bg-primary-100 text-primary-700 dark:bg-primary-900 dark:text-primary-300' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }}">
                    Форум
                </a>

                @if (Auth::user() && Auth::user()->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                        class="block rounded-lg px-3 py-2 text-base font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-primary-100 text-primary-700 dark:bg-primary-900 dark:text-primary-300' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }}">
                        Панель администратора
                    </a>
                @endif
            </nav>

            <!-- Разделитель -->
            <div class="my-4 border-t border-gray-200 dark:border-gray-700"></div>

            <!-- Пользовательские действия -->
            @guest
                <div class="space-y-2">
                    <a href="{{ route('login') }}"
                        class="block rounded-lg bg-gray-100 px-3 py-2 text-center text-base font-medium text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                        Войти
                    </a>
                    <a href="{{ route('register') }}"
                        class="block rounded-lg bg-primary-600 px-3 py-2 text-center text-base font-medium text-white hover:bg-primary-700 dark:bg-primary-700 dark:hover:bg-primary-800">
                        Регистрация
                    </a>
                </div>
            @else
                <div class="space-y-2">
                    <!-- Профиль пользователя в мобильном меню -->
                    <a href="{{ route('profile.index') }}"
                        class="flex items-center rounded-lg px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800">
                        <div
                            class="mr-3 flex h-8 w-8 items-center justify-center overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700">
                            @if (Auth::check() && Auth::user()->avatar)
                                <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}" alt="Аватар"
                                    class="h-full w-full object-cover">
                            @else
                                <img src="{{ asset('img/default-avatar.webp') }}" alt="Аватар"
                                    class="h-full w-full object-cover">
                            @endif
                        </div>
                        Мой профиль
                    </a>

                    <a href="{{ route('track.create') }}"
                        class="block rounded-lg bg-primary-600 px-3 py-2 text-center text-base font-medium text-white hover:bg-primary-700 dark:bg-primary-700 dark:hover:bg-primary-800">
                        Загрузить трек
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full rounded-lg px-3 py-2 text-left text-base font-medium text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20">
                            Выйти
                        </button>
                    </form>
                </div>
            @endguest
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Поиск функциональность
            const searchInput = document.getElementById('searchInput');
            const searchSuggestions = document.getElementById('searchSuggestions');
            const suggestionsList = document.getElementById('suggestionsList');
            const searchForm = document.getElementById('searchForm');
            let searchTimeout;

            if (searchInput) {
                // Показать/скрыть предложения
                searchInput.addEventListener('focus', function() {
                    if (this.value.length >= 2) {
                        searchSuggestions.classList.remove('hidden');
                    }
                });

                // Поиск предложений при вводе
                searchInput.addEventListener('input', function() {
                    const query = this.value.trim();

                    clearTimeout(searchTimeout);

                    if (query.length < 2) {
                        searchSuggestions.classList.add('hidden');
                        return;
                    }

                    searchTimeout = setTimeout(() => {
                        fetch(`{{ route('search.suggestions') }}?q=${encodeURIComponent(query)}`)
                            .then(response => response.json())
                            .then(data => {
                                suggestionsList.innerHTML = '';

                                if (data.length > 0) {
                                    data.forEach(item => {
                                        const suggestionItem = createSuggestionItem(
                                            item);
                                        suggestionsList.appendChild(suggestionItem);
                                    });
                                    searchSuggestions.classList.remove('hidden');
                                } else {
                                    searchSuggestions.classList.add('hidden');
                                }
                            })
                            .catch(error => {
                                console.error('Ошибка поиска:', error);
                            });
                    }, 300);
                });

                // Отправка формы по Enter
                searchInput.addEventListener('keydown', function(event) {
                    if (event.key === 'Enter') {
                        searchSuggestions.classList.add('hidden');
                    }
                });
            }

            // Создание элемента предложения
            function createSuggestionItem(item) {
                const div = document.createElement('div');
                div.className =
                    'flex items-center rounded-lg px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer';

                const typeIcons = {
                    user: '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>',
                    track: '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" /></svg>',
                    thread: '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>'
                };

                div.innerHTML = `
                    <div class="mr-3 flex h-8 w-8 items-center justify-center rounded-full bg-gray-200 dark:bg-gray-600">
                        ${item.avatar ? `<img src="${item.avatar}" alt="" class="h-full w-full rounded-full object-cover">` : `<div class="text-gray-500 dark:text-gray-400">${typeIcons[item.type]}</div>`}
                    </div>
                    <div class="flex-1">
                        <div class="text-sm font-medium text-gray-900 dark:text-white">${item.title}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">${item.subtitle}</div>
                    </div>
                `;

                div.addEventListener('click', function() {
                    window.location.href = item.url;
                });

                return div;
            }

            // Скрыть предложения при клике вне
            document.addEventListener('click', function(event) {
                const searchContainer = document.getElementById('searchContainer');
                if (searchContainer && !searchContainer.contains(event.target)) {
                    searchSuggestions.classList.add('hidden');
                }
            });

            // Мобильное меню
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const hamburgerIcon = document.getElementById('hamburger-icon');
            const closeIcon = document.getElementById('close-icon');

            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    const isHidden = mobileMenu.classList.contains('hidden');

                    if (isHidden) {
                        // Открыть меню
                        mobileMenu.classList.remove('hidden');
                        hamburgerIcon.classList.add('hidden');
                        closeIcon.classList.remove('hidden');
                        document.body.style.overflow = 'hidden'; // Предотвратить скролл
                    } else {
                        // Закрыть меню
                        mobileMenu.classList.add('hidden');
                        hamburgerIcon.classList.remove('hidden');
                        closeIcon.classList.add('hidden');
                        document.body.style.overflow = ''; // Восстановить скролл
                    }
                });

                // Закрыть меню при клике на ссылку
                const mobileMenuLinks = mobileMenu.querySelectorAll('a');
                mobileMenuLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        mobileMenu.classList.add('hidden');
                        hamburgerIcon.classList.remove('hidden');
                        closeIcon.classList.add('hidden');
                        document.body.style.overflow = '';
                    });
                });

                // Закрыть меню при изменении размера экрана
                window.addEventListener('resize', function() {
                    if (window.innerWidth >= 768) { // md breakpoint
                        mobileMenu.classList.add('hidden');
                        hamburgerIcon.classList.remove('hidden');
                        closeIcon.classList.add('hidden');
                        document.body.style.overflow = '';
                    }
                });
            }
        });
    </script>
</header>
