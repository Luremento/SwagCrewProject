@extends('layouts.app')

@section('title', 'Форум')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8">
        <!-- Заголовок форума для мобильных устройств (скрыт на десктопе) -->
        <div class="mb-6 block lg:hidden">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Форум музыкантов</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Обсуждения и советы для музыкантов</p>
        </div>

        <!-- Основной контент -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-[280px_1fr]">
            <!-- Боковая панель с категориями -->
            <div class="space-y-6">
                <!-- Кнопка создания темы -->
                <a href="{{ route('thread.create') }}"
                    class="group relative flex w-full items-center justify-center overflow-hidden rounded-xl bg-gradient-to-r from-primary-600 via-primary-700 to-purple-800 px-5 py-3 font-medium text-white shadow-lg transition-all duration-300 hover:shadow-xl dark:from-primary-700 dark:via-primary-800 dark:to-purple-900">
                    <span class="relative z-10 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Создать тред
                    </span>
                </a>

                <!-- Поиск -->
                <form method="GET" action="{{ route('forum.index') }}" id="searchForm">
                    {{-- Сохраняем текущие параметры --}}
                    @if (request('category_id'))
                        <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                    @endif
                    @if (request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif

                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                            class="block w-full rounded-lg border border-gray-200 bg-gray-50 p-3 pl-10 pr-10 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder-gray-400"
                            placeholder="Поиск по форуму...">

                        {{-- Кнопка очистки поиска --}}
                        @if (request('search'))
                            <button type="button" id="clearSearch"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        @endif
                    </div>
                </form>

                {{-- Показываем результаты поиска --}}
                @if (request('search'))
                    <div class="rounded-lg bg-blue-50 p-3 dark:bg-blue-900/20">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4 text-blue-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-sm text-blue-700 dark:text-blue-300">
                                Поиск: "{{ request('search') }}"
                            </span>
                        </div>
                        @if ($themes->count() > 0)
                            <p class="mt-1 text-xs text-blue-600 dark:text-blue-400">
                                Найдено {{ $themes->count() }}
                                {{ $themes->count() == 1 ? 'результат' : ($themes->count() < 5 ? 'результата' : 'результатов') }}
                            </p>
                        @endif
                    </div>
                @endif

                <!-- Категории -->
                <div class="overflow-hidden rounded-xl bg-white shadow-md dark:bg-gray-800/80 dark:backdrop-blur-sm">
                    <div class="border-b border-gray-200 bg-gray-50 px-4 py-3 dark:border-gray-700 dark:bg-gray-800">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Категории</h3>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        {{-- Ссылка "Все категории" --}}
                        <a href="{{ route('forum.index', array_filter(['search' => request('search'), 'sort' => request('sort')])) }}"
                            class="flex items-center px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 {{ !request('category_id') ? 'bg-gray-100 dark:bg-gray-700/30' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5 text-primary-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <span class="text-gray-900 dark:text-white">Все категории</span>
                            <span
                                class="ml-auto rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                {{ $categories->sum(function ($category) {return $category->threads->count();}) }}
                            </span>
                        </a>

                        @foreach ($categories as $item)
                            <a href="{{ route('forum.index', array_filter(['category_id' => $item->id, 'search' => request('search'), 'sort' => request('sort')])) }}"
                                class="flex items-center px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 {{ request('category_id') == $item->id ? 'bg-gray-100 dark:bg-gray-700/30' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5 text-primary-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                </svg>
                                <span class="text-gray-900 dark:text-white">{{ $item->name }}</span>
                                <span
                                    class="ml-auto rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-300">{{ $item->threads->count() }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Основной контент с темами -->
            <div class="space-y-6">
                <!-- Заголовок и фильтры (только для десктопа) -->
                <div class="hidden items-center justify-between lg:flex">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Форум музыкантов</h1>
                    <form method="GET" action="{{ route('forum.index') }}">
                        {{-- Сохраняем выбранную категорию и поиск, если есть --}}
                        @if (request('category_id'))
                            <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                        @endif
                        @if (request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif

                        <select name="sort" onchange="this.form.submit()"
                            class="rounded-lg border border-gray-200 bg-gray-50 p-2 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Новые темы
                            </option>
                            <option value="most_commented" {{ request('sort') === 'most_commented' ? 'selected' : '' }}>
                                Самые обсуждаемые</option>
                        </select>
                    </form>
                </div>

                <!-- Список тем -->
                <div class="overflow-hidden rounded-xl bg-white shadow-md dark:bg-gray-800/80 dark:backdrop-blur-sm">
                    <div class="border-b border-gray-200 bg-gray-50 px-6 py-3 dark:border-gray-700 dark:bg-gray-800"></div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @if ($themes->count() > 0)
                            <!-- Темы -->
                            @foreach ($themes as $item)
                                <div class="flex items-center px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <div class="mr-4 flex-shrink-0">
                                        @if ($item->user->avatar)
                                            <img src="{{ asset('storage/avatars/' . $item->user->avatar) }}"
                                                alt="Аватар" class="h-10 w-10 rounded-full">
                                        @else
                                            <img src="{{ asset('img/default-avatar.webp') }}" alt="Аватар"
                                                class="h-10 w-10 rounded-full">
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center justify-between">
                                            <a href="{{ route('thread.show', $item->id) }}"
                                                class="truncate text-base font-medium text-gray-900 hover:text-primary-600 dark:text-white dark:hover:text-primary-400">
                                                @if (request('search'))
                                                    {!! str_ireplace(
                                                        request('search'),
                                                        '<mark class="bg-yellow-200 dark:bg-yellow-800">' . request('search') . '</mark>',
                                                        $item->title,
                                                    ) !!}
                                                @else
                                                    {{ $item->title }}
                                                @endif
                                            </a>
                                            <div
                                                class="ml-4 flex flex-shrink-0 items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
                                                <span class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                                    </svg>
                                                    {{ $item->comments->count() }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mt-1 flex items-center text-sm">
                                            <a href="{{ route('profile.index', $item->user->id) }}"
                                                class="truncate font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                                                {{ $item->user->name }}
                                            </a>
                                            <span class="mx-2 text-gray-500 dark:text-gray-400">•</span>
                                            <span
                                                class="text-gray-500 dark:text-gray-400">{{ $item->created_at->diffForHumans() }}</span>
                                            <div class="ml-2 flex">
                                                <span
                                                    class="inline-flex items-center rounded-full bg-primary-50 px-2 py-0.5 text-xs font-medium text-primary-700 dark:bg-primary-900/30 dark:text-primary-400">
                                                    {{ $item->category->name }}
                                                </span>
                                            </div>
                                        </div>
                                        {{-- Показываем превью контента при поиске --}}
                                        @if (request('search') && $item->content)
                                            <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                                @php
                                                    $content = strip_tags($item->content);
                                                    $searchTerm = request('search');
                                                    $position = stripos($content, $searchTerm);

                                                    if ($position !== false) {
                                                        $start = max(0, $position - 50);
                                                        $excerpt = substr($content, $start, 150);
                                                        if ($start > 0) {
                                                            $excerpt = '...' . $excerpt;
                                                        }
                                                        if (strlen($content) > $start + 150) {
                                                            $excerpt .= '...';
                                                        }

                                                        $highlighted = str_ireplace(
                                                            $searchTerm,
                                                            '<mark class="bg-yellow-200 dark:bg-yellow-800">' .
                                                                $searchTerm .
                                                                '</mark>',
                                                            $excerpt,
                                                        );
                                                        echo $highlighted;
                                                    } else {
                                                        echo Str::limit($content, 150);
                                                    }
                                                @endphp
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            {{-- Сообщение когда ничего не найдено --}}
                            <div class="px-6 py-12 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">
                                    @if (request('search'))
                                        Ничего не найдено
                                    @else
                                        Пока нет тем
                                    @endif
                                </h3>
                                <p class="mt-2 text-gray-500 dark:text-gray-400">
                                    @if (request('search'))
                                        Попробуйте изменить поисковый запрос или выбрать другую категорию
                                    @else
                                        Станьте первым, кто создаст тему в этой категории!
                                    @endif
                                </p>
                                @if (request('search'))
                                    <a href="{{ route('forum.index', array_filter(['category_id' => request('category_id'), 'sort' => request('sort')])) }}"
                                        class="mt-4 inline-flex items-center rounded-lg bg-primary-600 px-4 py-2 text-sm font-medium text-white hover:bg-primary-700">
                                        Очистить поиск
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Пагинация -->
                @if ($themes->hasPages())
                    <div class="mt-6 flex justify-center">
                        {{ $themes->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const searchForm = document.getElementById('searchForm');
            const clearButton = document.getElementById('clearSearch');

            // Автоматическая отправка формы при вводе (с задержкой)
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    if (this.value.length >= 3 || this.value.length === 0) {
                        searchForm.submit();
                    }
                }, 500);
            });

            // Очистка поиска
            if (clearButton) {
                clearButton.addEventListener('click', function() {
                    searchInput.value = '';
                    searchForm.submit();
                });
            }

            // Отправка формы по Enter
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    clearTimeout(searchTimeout);
                    searchForm.submit();
                }
            });
        });
    </script>
@endsection
