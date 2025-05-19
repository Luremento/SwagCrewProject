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
                        <button type="button" id="open-create-playlist-btn"
                            class="rounded-full p-1 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @if (Auth::check())
                            @if ($playlists->count() > 0)
                                @foreach ($playlists as $playlist)
                                    <a href="{{ route('playlists.show', $playlist->id) }}"
                                        class="flex items-center px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <div
                                            class="mr-3 h-10 w-10 flex-shrink-0 overflow-hidden rounded-md shadow-sm bg-gray-200 dark:bg-gray-700">
                                            @if ($playlist->cover_image)
                                                <img src="{{ asset('storage/' . $playlist->cover_image) }}"
                                                    alt="Обложка {{ $playlist->name }}" class="h-full w-full object-cover">
                                            @else
                                                <div
                                                    class="flex h-full w-full items-center justify-center
                                                        @if ($playlist->name === 'Избранное') bg-gradient-to-br from-purple-500 to-indigo-600
                                                        @elseif($loop->index % 3 == 1) bg-gradient-to-br from-blue-500 to-cyan-600
                                                        @elseif($loop->index % 3 == 2) bg-gradient-to-br from-pink-500 to-rose-600
                                                        @else bg-gradient-to-br from-green-500 to-teal-600 @endif">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="text-gray-900 dark:text-white">{{ $playlist->name }}</span>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $playlist->tracks_count }}
                                                {{ trans_choice('треков|трек|трека', $playlist->tracks_count) }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <div class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                                    У вас пока нет плейлистов. Создайте свой первый плейлист!
                                </div>
                            @endif
                        @else
                            <div class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                                <a href="{{ route('login') }}"
                                    class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">Войдите</a>,
                                чтобы создавать плейлисты
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Жанры -->
                <div class="overflow-hidden rounded-xl bg-white shadow-md dark:bg-gray-800/80 dark:backdrop-blur-sm">
                    <div class="border-b border-gray-200 bg-gray-50 px-4 py-3 dark:border-gray-700 dark:bg-gray-800">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Жанры</h3>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($genres as $genre)
                            <a href="{{ route('tracks.index', array_merge(['genre_id' => $genre->id], request()->only('view_type'))) }}"
                                class="flex items-center px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 {{ request('genre_id') == $genre->id ? 'bg-gray-100 dark:bg-gray-700/30' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5 text-primary-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                </svg>
                                <span class="text-gray-900 dark:text-white">{{ $genre->name }}</span>
                                <span
                                    class="ml-auto rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-300">{{ $genre->tracks_count }}</span>
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
                        {{-- Сохраняем выбранный жанр и тип отображения, если есть --}}
                        @if (request('genre_id'))
                            <input type="hidden" name="genre_id" value="{{ request('genre_id') }}">
                        @endif
                        @if (request('view_type'))
                            <input type="hidden" name="view_type" value="{{ request('view_type') }}">
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
                                <a href="{{ route('tracks.index', array_merge(request()->except('view_type'), ['view_type' => 'list'])) }}"
                                    class="rounded-full p-1 {{ $viewType === 'list' ? 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-white' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h7" />
                                    </svg>
                                </a>
                                <a href="{{ route('tracks.index', array_merge(request()->except('view_type'), ['view_type' => 'grid'])) }}"
                                    class="rounded-full p-1 {{ $viewType === 'grid' ? 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-white' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        <!-- Треки -->
                        @if ($viewType === 'list')
                            <!-- List view -->
                            @foreach ($tracks as $track)
                                <div class="group flex items-center px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <div class="mr-4 flex-shrink-0 relative">
                                        <div
                                            class="h-14 w-14 overflow-hidden rounded-md bg-gray-200 shadow-sm dark:bg-gray-700 flex-none">
                                            @if ($track->cover_image)
                                                <img src="{{ asset('storage/' . $track->cover_image) }}"
                                                    alt="Обложка трека" class="h-14 w-14 object-cover" loading="lazy">
                                            @else
                                                <div
                                                    class="flex h-full w-full items-center justify-center bg-gradient-to-br from-gray-300 to-gray-200 dark:from-gray-600 dark:to-gray-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <button
                                            class="play-button absolute inset-0 flex items-center justify-center bg-black bg-opacity-40 opacity-0 transition-all duration-200 group-hover:opacity-100"
                                            data-track-id="{{ $track->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-8 w-8 text-white drop-shadow-lg" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
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
                                                <button type="button" data-track-id="{{ $track->id }}"
                                                    class="add-to-favorites text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 opacity-0 transition-opacity group-hover:opacity-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                    </svg>
                                                </button>
                                                <button type="button"
                                                    class="track-options text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 opacity-0 transition-opacity group-hover:opacity-100"
                                                    onclick="openPlaylistSelector('{{ $track->id }}')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
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
                        @else
                            <!-- Grid view -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 p-6">
                                @foreach ($tracks as $track)
                                    <div
                                        class="group relative flex flex-col overflow-hidden rounded-lg bg-white shadow-md transition-all hover:shadow-lg dark:bg-gray-800">
                                        <div class="relative aspect-square overflow-hidden">
                                            @if ($track->cover_image)
                                                <img src="{{ asset('storage/' . $track->cover_image) }}"
                                                    alt="Обложка трека" class="h-full w-full object-cover"
                                                    loading="lazy">
                                            @else
                                                <div
                                                    class="flex h-full w-full items-center justify-center bg-gradient-to-br from-gray-300 to-gray-200 dark:from-gray-600 dark:to-gray-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-16 w-16 text-gray-500" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                                    </svg>
                                                </div>
                                            @endif
                                            <button
                                                class="play-button absolute inset-0 flex items-center justify-center bg-black bg-opacity-40 opacity-0 transition-all duration-200 group-hover:opacity-100"
                                                data-track-id="{{ $track->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-16 w-16 text-white drop-shadow-lg" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="flex flex-col p-4">
                                            <a href="{{ route('tracks.show', $track->id) }}"
                                                class="truncate text-base font-medium text-gray-900 hover:text-primary-600 dark:text-white dark:hover:text-primary-400">
                                                {{ $track->title }}
                                            </a>
                                            <div class="mt-1 flex items-center text-sm">
                                                <a href="{{ route('profile.index', $track->user->id) }}"
                                                    class="truncate font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                                                    {{ $track->user->name }}
                                                </a>
                                            </div>
                                            <div class="mt-2 flex items-center justify-between">
                                                <span
                                                    class="inline-flex items-center rounded-full bg-primary-50 px-2 py-0.5 text-xs font-medium text-primary-700 dark:bg-primary-900/30 dark:text-primary-400">
                                                    {{ $track->genre->name }}
                                                </span>
                                                <div class="flex items-center gap-2">
                                                    <button type="button" data-track-id="{{ $track->id }}"
                                                        class="add-to-favorites text-gray-400 hover:text-primary-600 dark:hover:text-primary-400">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                        </svg>
                                                    </button>
                                                    <button type="button"
                                                        class="track-options text-gray-400 hover:text-primary-600 dark:hover:text-primary-400"
                                                        onclick="openPlaylistSelector('{{ $track->id }}')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Пагинация -->
                <div class="mt-6 flex justify-center">
                    {{ $tracks->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Подключаем компоненты -->
    @include('components.playlist-selector')
    @include('components.playlist-creator')
@endsection
