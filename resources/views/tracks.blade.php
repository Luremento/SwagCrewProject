@extends('layouts.app')

@section('title', 'Треки')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8">
        <!-- Заголовок для мобильных устройств (скрыт на десктопе) -->
        <div class="mb-6 block lg:hidden">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Треки</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Слушайте и делитесь музыкой</p>
        </div>

        <!-- Основной контент -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-[280px_1fr]">
            <!-- Боковая панель с плейлистами и фильтрами -->
            <div class="space-y-6">
                <!-- Кнопка загрузки трека -->
                <a href="{{ route('track.create') }}"
                    class="group relative flex w-full items-center justify-center overflow-hidden rounded-xl bg-gradient-to-r from-primary-600 via-primary-700 to-purple-800 px-5 py-3 font-medium text-white shadow-lg transition-all duration-300 hover:shadow-xl dark:from-primary-700 dark:via-primary-800 dark:to-purple-900">
                    <span class="relative z-10 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Загрузить трек
                    </span>
                </a>

                <!-- Поиск -->
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text"
                        class="block w-full rounded-lg border border-gray-200 bg-gray-50 p-3 pl-10 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder-gray-400"
                        placeholder="Поиск треков...">
                </div>

                <!-- Мои плейлисты -->
                <div class="overflow-hidden rounded-xl bg-white shadow-md dark:bg-gray-800/80 dark:backdrop-blur-sm">
                    <div
                        class="flex items-center justify-between border-b border-gray-200 bg-gray-50 px-4 py-3 dark:border-gray-700 dark:bg-gray-800">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Мои плейлисты</h3>
                        <button type="button"
                            class="rounded-full p-1 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        <a href="#" class="flex items-center px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <div
                                class="mr-3 h-10 w-10 flex-shrink-0 overflow-hidden rounded-md bg-gradient-to-br from-purple-500 to-indigo-600 shadow-sm">
                                <div class="flex h-full w-full items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <span class="text-gray-900 dark:text-white">Избранное</span>
                                <p class="text-xs text-gray-500 dark:text-gray-400">24 трека</p>
                            </div>
                        </a>
                        <a href="#" class="flex items-center px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <div
                                class="mr-3 h-10 w-10 flex-shrink-0 overflow-hidden rounded-md bg-gradient-to-br from-blue-500 to-cyan-600 shadow-sm">
                                <div class="flex h-full w-full items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <span class="text-gray-900 dark:text-white">Для работы</span>
                                <p class="text-xs text-gray-500 dark:text-gray-400">12 треков</p>
                            </div>
                        </a>
                        <a href="#" class="flex items-center px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <div
                                class="mr-3 h-10 w-10 flex-shrink-0 overflow-hidden rounded-md bg-gradient-to-br from-pink-500 to-rose-600 shadow-sm">
                                <div class="flex h-full w-full items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <span class="text-gray-900 dark:text-white">Тренировка</span>
                                <p class="text-xs text-gray-500 dark:text-gray-400">8 треков</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Жанры -->
                <div class="overflow-hidden rounded-xl bg-white shadow-md dark:bg-gray-800/80 dark:backdrop-blur-sm">
                    <div class="border-b border-gray-200 bg-gray-50 px-4 py-3 dark:border-gray-700 dark:bg-gray-800">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Жанры</h3>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($genres as $genre)
                            <a href="{{ route('tracks.index', ['genre_id' => $genre->id]) }}"
                                class="flex items-center px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 {{ request('genre_id') == $genre->id ? 'bg-gray-100 dark:bg-gray-700/30' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5 text-primary-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                </svg>
                                <span class="text-gray-900 dark:text-white">{{ $genre->name }}</span>
                                <span
                                    class="ml-auto rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-300">{{ $genre->tracks->count() }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Основной контент с треками -->
            <div class="space-y-6">
                <!-- Заголовок и фильтры (только для десктопа) -->
                <div class="hidden items-center justify-between lg:flex">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Треки</h1>
                    <form method="GET" action="{{ route('tracks.index') }}">
                        {{-- Сохраняем выбранный жанр, если есть --}}
                        @if (request('genre_id'))
                            <input type="hidden" name="genre_id" value="{{ request('genre_id') }}">
                        @endif

                        <select name="sort" onchange="this.form.submit()"
                            class="rounded-lg border border-gray-200 bg-gray-50 p-2 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Новые треки
                            </option>
                            <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Популярные
                            </option>
                        </select>
                    </form>
                </div>

                <!-- Список треков -->
                <div class="overflow-hidden rounded-xl bg-white shadow-md dark:bg-gray-800/80 dark:backdrop-blur-sm">
                    <div class="border-b border-gray-200 bg-gray-50 px-6 py-3 dark:border-gray-700 dark:bg-gray-800">
                        <div class="flex items-center justify-between">
                            <h3 class="font-semibold text-gray-900 dark:text-white">
                                {{ request('genre_id') ? $currentGenre->name : 'Все треки' }}
                            </h3>
                            <div class="flex items-center space-x-2">
                                <button type="button"
                                    class="rounded-full p-1 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h7" />
                                    </svg>
                                </button>
                                <button type="button"
                                    class="rounded-full p-1 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        <!-- Треки -->
                        @foreach ($tracks as $track)
                            <div class="group flex items-center px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <div class="mr-4 flex-shrink-0 relative">
                                    <div
                                        class="h-14 w-14 overflow-hidden rounded-md bg-gray-200 shadow-sm dark:bg-gray-700 flex-none">
                                        @if ($track->cover_image)
                                            <img src="{{ asset('storage/' . $track->cover_image) }}" alt="Обложка трека"
                                                class="h-14 w-14 object-cover">
                                        @else
                                            <div
                                                class="flex h-full w-full items-center justify-center bg-gradient-to-br from-gray-300 to-gray-200 dark:from-gray-600 dark:to-gray-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <button
                                        class="play-button absolute inset-0 flex items-center justify-center bg-black bg-opacity-40 opacity-0 transition-all duration-200 group-hover:opacity-100"
                                        data-track-id="{{ $track->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white drop-shadow-lg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center justify-between">
                                        <a href="{{ route('tracks.show', $track->id) }}"
                                            class="truncate text-base font-medium text-gray-900 hover:text-primary-600 dark:text-white dark:hover:text-primary-400">
                                            {{ $track->title }}
                                        </a>
                                        <div class="ml-4 flex flex-shrink-0 items-center gap-3">
                                            <button type="button"
                                                class="text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 opacity-0 transition-opacity group-hover:opacity-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                </svg>
                                            </button>
                                            <button type="button"
                                                class="text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 opacity-0 transition-opacity group-hover:opacity-100 track-options">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mt-1 flex items-center text-sm">
                                        <a href="{{ route('profile.index', $track->user->id) }}"
                                            class="truncate font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                                            {{ $track->user->name }}
                                        </a>
                                        <span class="mx-2 text-gray-500 dark:text-gray-400">•</span>
                                        <span
                                            class="text-gray-500 dark:text-gray-400">{{ $track->created_at->diffForHumans() }}</span>
                                        <div class="ml-2 flex">
                                            <span
                                                class="inline-flex items-center rounded-full bg-primary-50 px-2 py-0.5 text-xs font-medium text-primary-700 dark:bg-primary-900/30 dark:text-primary-400">
                                                {{ $track->genre->name }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Пагинация -->
                <div class="mt-6 flex justify-center">
                    <nav class="flex items-center space-x-2">
                        <a href="#"
                            class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                            <span class="sr-only">Предыдущая</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <a href="#"
                            class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-medium text-white hover:bg-primary-700 dark:bg-primary-700 dark:hover:bg-primary-600">1</a>
                        <a href="#"
                            class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">2</a>
                        <a href="#"
                            class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">3</a>
                        <span
                            class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">...</span>
                        <a href="#"
                            class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">8</a>
                        <a href="#"
                            class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                            <span class="sr-only">Следующая</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Плеер (фиксированный внизу экрана) -->
    <div id="audio-player" class="fixed bottom-0 left-0 right-0 hidden bg-white shadow-lg dark:bg-gray-800">
        <div class="mx-auto max-w-7xl px-4 py-3">
            <div class="flex items-center">
                <div class="mr-4 flex items-center">
                    <div
                        class="mr-3 h-12 w-12 flex-shrink-0 overflow-hidden rounded-md bg-gray-200 shadow-sm dark:bg-gray-700">
                        <img id="player-cover" src="/placeholder.svg" alt="Обложка трека"
                            class="h-full w-full object-cover">
                    </div>
                    <div>
                        <p id="player-title" class="font-medium text-gray-900 dark:text-white">Название трека</p>
                        <p id="player-artist" class="text-sm text-gray-500 dark:text-gray-400">Исполнитель</p>
                    </div>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-center">
                        <button type="button" id="player-prev"
                            class="mx-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12.066 11.2l5.334-3.2a1 1 0 000-1.8l-5.334-3.2a1 1 0 00-1.5.8v7.2a1 1 0 001.5.8z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.866 11.2l5.334-3.2a1 1 0 000-1.8l-5.334-3.2a1 1 0 00-1.5.8v7.2a1 1 0 001.5.8z" />
                            </svg>
                        </button>
                        <button type="button" id="player-play"
                            class="mx-2 rounded-full bg-primary-600 p-2 text-white hover:bg-primary-700 dark:bg-primary-700 dark:hover:bg-primary-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            </svg>
                        </button>
                        <button type="button" id="player-next"
                            class="mx-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11.933 12.8l-5.334 3.2a1 1 0 01-1.5-.8V8a1 1 0 011.5-.8l5.334 3.2a1 1 0 010 1.6z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18.133 12.8l-5.334 3.2a1 1 0 01-1.5-.8V8a1 1 0 011.5-.8l5.334 3.2a1 1 0 010 1.6z" />
                            </svg>
                        </button>
                    </div>
                    <div class="mt-2 flex items-center">
                        <span id="player-current-time" class="mr-2 text-xs text-gray-500 dark:text-gray-400">0:00</span>
                        <div class="flex-1">
                            <div class="h-1.5 w-full overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700">
                                <div id="player-progress" class="h-full rounded-full bg-primary-600 dark:bg-primary-500"
                                    style="width: 0%"></div>
                            </div>
                        </div>
                        <span id="player-duration" class="ml-2 text-xs text-gray-500 dark:text-gray-400">0:00</span>
                    </div>
                </div>
                <div class="ml-4 flex items-center">
                    <button type="button" id="player-volume"
                        class="mx-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                        </svg>
                    </button>
                    <button type="button" id="player-favorite"
                        class="mx-2 text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                    <button type="button" id="player-playlist"
                        class="mx-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно для создания плейлиста -->
    <div id="create-playlist-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75 dark:bg-gray-900"></div>
            </div>
            <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all dark:bg-gray-800 sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
                <div class="bg-white px-4 pt-5 pb-4 dark:bg-gray-800 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 w-full text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white" id="modal-title">
                                Создать плейлист
                            </h3>
                            <div class="mt-4">
                                <div class="mb-4">
                                    <label for="playlist-name"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Название
                                        плейлиста</label>
                                    <input type="text" id="playlist-name"
                                        class="mt-1 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                                        placeholder="Введите название плейлиста">
                                </div>
                                <div>
                                    <label for="playlist-description"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Описание
                                        (необязательно)</label>
                                    <textarea id="playlist-description" rows="3"
                                        class="mt-1 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                                        placeholder="Добавьте описание плейлиста"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 dark:bg-gray-700 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" id="create-playlist-btn"
                        class="inline-flex w-full justify-center rounded-lg bg-primary-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:bg-primary-700 dark:hover:bg-primary-600 sm:ml-3 sm:w-auto sm:text-sm">
                        Создать
                    </button>
                    <button type="button" id="cancel-playlist-btn"
                        class="mt-3 inline-flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Отмена
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно для добавления трека в плейлист -->
    <div id="add-to-playlist-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75 dark:bg-gray-900"></div>
            </div>
            <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all dark:bg-gray-800 sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
                <div class="bg-white px-4 pt-5 pb-4 dark:bg-gray-800 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 w-full text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white" id="modal-title">
                                Добавить в плейлист
                            </h3>
                            <div class="mt-4">
                                <div class="max-h-60 overflow-y-auto">
                                    <div class="space-y-2">
                                        <div
                                            class="flex items-center rounded-lg p-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <input type="checkbox" id="playlist-1"
                                                class="mr-2 h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700">
                                            <label for="playlist-1"
                                                class="flex-1 cursor-pointer text-gray-900 dark:text-white">Избранное</label>
                                        </div>
                                        <div
                                            class="flex items-center rounded-lg p-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <input type="checkbox" id="playlist-2"
                                                class="mr-2 h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700">
                                            <label for="playlist-2"
                                                class="flex-1 cursor-pointer text-gray-900 dark:text-white">Для
                                                работы</label>
                                        </div>
                                        <div
                                            class="flex items-center rounded-lg p-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <input type="checkbox" id="playlist-3"
                                                class="mr-2 h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700">
                                            <label for="playlist-3"
                                                class="flex-1 cursor-pointer text-gray-900 dark:text-white">Тренировка</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center justify-between">
                                    <button type="button" id="create-new-playlist-btn"
                                        class="flex items-center text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                        Создать новый плейлист
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 dark:bg-gray-700 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" id="add-to-playlist-btn"
                        class="inline-flex w-full justify-center rounded-lg bg-primary-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:bg-primary-700 dark:hover:bg-primary-600 sm:ml-3 sm:w-auto sm:text-sm">
                        Добавить
                    </button>
                    <button type="button" id="cancel-add-to-playlist-btn"
                        class="mt-3 inline-flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Отмена
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Переменные для плеера
            const audioPlayer = document.getElementById('audio-player');
            const playerCover = document.getElementById('player-cover');
            const playerTitle = document.getElementById('player-title');
            const playerArtist = document.getElementById('player-artist');
            const playerPlay = document.getElementById('player-play');
            const playerProgress = document.getElementById('player-progress');
            const playerCurrentTime = document.getElementById('player-current-time');
            const playerDuration = document.getElementById('player-duration');
            const audio = new Audio();
            let isPlaying = false;

            // Обработчики для кнопок воспроизведения треков
            const playButtons = document.querySelectorAll('.play-button');
            playButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const trackId = this.getAttribute('data-track-id');
                    playTrack(trackId);
                });
            });

            // Функция воспроизведения трека
            function playTrack(trackId) {
                // В реальном приложении здесь будет запрос к API для получения данных трека
                // Для примера используем моковые данные
                const trackData = {
                    id: trackId,
                    title: 'Название трека',
                    artist: 'Исполнитель',
                    cover: 'https://via.placeholder.com/48',
                    url: 'https://example.com/track.mp3'
                };

                // Обновляем информацию в плеере
                playerCover.src = trackData.cover;
                playerTitle.textContent = trackData.title;
                playerArtist.textContent = trackData.artist;

                // Показываем плеер
                audioPlayer.classList.remove('hidden');

                // Настраиваем аудио
                audio.src = trackData.url;
                audio.load();

                // Запускаем воспроизведение
                audio.play().then(() => {
                    isPlaying = true;
                    updatePlayButton();
                }).catch(error => {
                    console.error('Ошибка воспроизведения:', error);
                });
            }

            // Обновление кнопки воспроизведения
            function updatePlayButton() {
                if (isPlaying) {
                    playerPlay.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    `;
                } else {
                    playerPlay.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                        </svg>
                    `;
                }
            }

            // Обработчик для кнопки воспроизведения/паузы
            playerPlay.addEventListener('click', function() {
                if (isPlaying) {
                    audio.pause();
                    isPlaying = false;
                } else {
                    audio.play();
                    isPlaying = true;
                }
                updatePlayButton();
            });

            // Обновление прогресса воспроизведения
            audio.addEventListener('timeupdate', function() {
                const currentTime = audio.currentTime;
                const duration = audio.duration || 0;
                const progressPercent = (currentTime / duration) * 100;

                playerProgress.style.width = `${progressPercent}%`;
                playerCurrentTime.textContent = formatTime(currentTime);
                playerDuration.textContent = formatTime(duration);
            });

            // Форматирование времени в формат MM:SS
            function formatTime(seconds) {
                const minutes = Math.floor(seconds / 60);
                const remainingSeconds = Math.floor(seconds % 60);
                return `${minutes}:${remainingSeconds < 10 ? '0' : ''}${remainingSeconds}`;
            }

            // Модальное окно создания плейлиста
            const createPlaylistModal = document.getElementById('create-playlist-modal');
            const createNewPlaylistBtn = document.getElementById('create-new-playlist-btn');
            const cancelPlaylistBtn = document.getElementById('cancel-playlist-btn');
            const createPlaylistBtn = document.getElementById('create-playlist-btn');

            // Открытие модального окна создания плейлиста
            createNewPlaylistBtn.addEventListener('click', function() {
                createPlaylistModal.classList.remove('hidden');
                document.getElementById('add-to-playlist-modal').classList.add('hidden');
            });

            // Закрытие модального окна создания плейлиста
            cancelPlaylistBtn.addEventListener('click', function() {
                createPlaylistModal.classList.add('hidden');
            });

            // Создание плейлиста
            createPlaylistBtn.addEventListener('click', function() {
                const playlistName = document.getElementById('playlist-name').value;
                const playlistDescription = document.getElementById('playlist-description').value;

                if (playlistName.trim() === '') {
                    alert('Введите название плейлиста');
                    return;
                }

                // В реальном приложении здесь будет запрос к API для создания плейлиста
                console.log('Создан плейлист:', playlistName, playlistDescription);

                // Закрываем модальное окно
                createPlaylistModal.classList.add('hidden');
            });

            // Модальное окно добавления в плейлист
            const addToPlaylistModal = document.getElementById('add-to-playlist-modal');
            const cancelAddToPlaylistBtn = document.getElementById('cancel-add-to-playlist-btn');
            const addToPlaylistBtn = document.getElementById('add-to-playlist-btn');

            // Открытие модального окна добавления в плейлист
            document.querySelectorAll('.track-options').forEach(button => {
                button.addEventListener('click', function() {
                    addToPlaylistModal.classList.remove('hidden');
                });
            });

            // Закрытие модального окна добавления в плейлист
            cancelAddToPlaylistBtn.addEventListener('click', function() {
                addToPlaylistModal.classList.add('hidden');
            });

            // Добавление в плейлист
            addToPlaylistBtn.addEventListener('click', function() {
                const selectedPlaylists = [];
                document.querySelectorAll('#add-to-playlist-modal input[type="checkbox"]:checked').forEach(
                    checkbox => {
                        selectedPlaylists.push(checkbox.id);
                    });

                if (selectedPlaylists.length === 0) {
                    alert('Выберите хотя бы один плейлист');
                    return;
                }

                // В реальном приложении здесь будет запрос к API для добавления трека в плейлисты
                console.log('Трек добавлен в плейлисты:', selectedPlaylists);

                // Закрываем модальное окно
                addToPlaylistModal.classList.add('hidden');
            });
        });
    </script>
@endsection
