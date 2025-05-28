@extends('layouts.app')

@section('title', $track->title . ' - ' . $track->user->name)

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8">
        <div class="space-y-8">
            <!-- Основная информация о треке -->
            <div class="overflow-hidden rounded-xl bg-white shadow-md dark:bg-gray-800/80 dark:backdrop-blur-sm">
                <div class="grid grid-cols-1 gap-8 p-8 lg:grid-cols-2">
                    <!-- Обложка трека -->
                    <div class="lg:col-span-1">
                        <div
                            class="group relative aspect-square overflow-hidden rounded-xl bg-gray-200 shadow-lg dark:bg-gray-700">
                            @if ($track->cover_image)
                                <img src="{{ asset('storage/' . $track->cover_image) }}" alt="Обложка {{ $track->title }}"
                                    class="h-full w-full object-cover">
                            @else
                                <div
                                    class="flex h-full w-full items-center justify-center bg-gradient-to-br from-gray-300 to-gray-200 dark:from-gray-600 dark:to-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32 text-gray-500" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                    </svg>
                                </div>
                            @endif

                            <!-- Кнопка воспроизведения -->
                            <button
                                class="play-button absolute inset-0 flex items-center justify-center bg-black bg-opacity-40 opacity-0 transition-all duration-200 group-hover:opacity-100"
                                data-track-id="{{ $track->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-white drop-shadow-lg"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Информация и управление -->
                    <div class="lg:col-span-1">
                        <div class="space-y-6">
                            <!-- Заголовок и исполнитель -->
                            <div>
                                <h1 class="text-4xl font-bold text-gray-900 dark:text-white">{{ $track->title }}</h1>
                                <div class="mt-3 flex items-center space-x-3">
                                    <a href="{{ route('profile.show', $track->user) }}"
                                        class="flex items-center space-x-2 text-lg text-primary-600 hover:text-primary-700 dark:text-primary-400">
                                        @if ($track->user->avatar)
                                            <img src="{{ asset('storage/avatars/' . $track->user->avatar) }}" alt="Аватар"
                                                class="h-10 w-10 rounded-full">
                                        @else
                                            <img src="{{ asset('img/default-avatar.webp') }}" alt="Аватар"
                                                class="h-10 w-10 rounded-full">
                                        @endif
                                        <span class="font-medium">{{ $track->user->name }}</span>
                                    </a>
                                </div>
                            </div>

                            <!-- Жанр и метаданные -->
                            <div class="flex flex-wrap gap-3">
                                @if ($track->genre)
                                    <span
                                        class="inline-flex items-center rounded-full bg-primary-50 px-3 py-1 text-sm font-medium text-primary-700 dark:bg-primary-900/30 dark:text-primary-400">
                                        {{ $track->genre->name }}
                                    </span>
                                @endif
                                <span
                                    class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-sm text-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                    {{ $track->created_at->format('d.m.Y') }}
                                </span>
                                @if ($track->duration)
                                    <span
                                        class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-sm text-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                        {{ gmdate('i:s', $track->duration) }}
                                    </span>
                                @endif
                            </div>

                            <!-- Описание -->
                            @if ($track->description)
                                <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-700/50">
                                    <p class="text-gray-700 dark:text-gray-300">{{ $track->description }}</p>
                                </div>
                            @endif

                            <!-- Аудиоплеер -->
                            <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-700/50">
                                <audio controls class="w-full" id="track-audio">
                                    <source src="{{ asset('storage/tracks/' . $track->file_path) }}" type="audio/mpeg">
                                    Ваш браузер не поддерживает аудио элемент.
                                </audio>
                            </div>

                            <!-- Действия -->
                            <div class="flex flex-wrap gap-3">
                                @auth
                                    <!-- Кнопка лайка -->
                                    <form action="{{ route('favorites.toggle', $track->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center space-x-2 rounded-lg px-4 py-2 text-white transition-colors {{ Auth::user()->hasFavorite($track->id) ? 'bg-red-600 hover:bg-red-700' : 'bg-gray-600 hover:bg-gray-700' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                fill="{{ Auth::user()->hasFavorite($track->id) ? 'currentColor' : 'none' }}"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                            <span>{{ Auth::user()->hasFavorite($track->id) ? 'В избранном' : 'В избранное' }}</span>
                                        </button>
                                    </form>

                                    <!-- Добавить в плейлист -->
                                    @if ($playlists->count() > 0)
                                        <button type="button" onclick="openPlaylistSelector('{{ $track->id }}')"
                                            class="flex items-center space-x-2 rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            <span>В плейлист</span>
                                        </button>
                                    @endif

                                    <!-- Скачать -->
                                    <a href="{{ route('tracks.download', $track) }}"
                                        class="flex items-center space-x-2 rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <span>Скачать</span>
                                    </a>

                                    <!-- Поделиться -->
                                    <button onclick="copyToClipboard('{{ url()->current() }}')"
                                        class="flex items-center space-x-2 rounded-lg bg-purple-600 px-4 py-2 text-white hover:bg-purple-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
                                        </svg>
                                        <span>Поделиться</span>
                                    </button>
                                @else
                                    <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-700/50">
                                        <p class="text-gray-600 dark:text-gray-400">
                                            <a href="{{ route('login') }}"
                                                class="text-primary-600 hover:text-primary-700 dark:text-primary-400">Войдите</a>
                                            или
                                            <a href="{{ route('register') }}"
                                                class="text-primary-600 hover:text-primary-700 dark:text-primary-400">зарегистрируйтесь</a>,
                                            чтобы взаимодействовать с треком
                                        </p>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Похожие треки -->
            @if ($similarTracks->count() > 0)
                <div class="overflow-hidden rounded-xl bg-white shadow-md dark:bg-gray-800/80 dark:backdrop-blur-sm">
                    <div class="border-b border-gray-200 bg-gray-50 px-6 py-4 dark:border-gray-700 dark:bg-gray-800">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Похожие треки</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
                            @foreach ($similarTracks as $similarTrack)
                                <div class="group">
                                    <div
                                        class="relative aspect-square overflow-hidden rounded-lg bg-gray-200 shadow-sm dark:bg-gray-700">
                                        @if ($similarTrack->cover_image)
                                            <img src="{{ asset('storage/' . $similarTrack->cover_image) }}"
                                                alt="Обложка {{ $similarTrack->title }}"
                                                class="h-full w-full object-cover transition-transform group-hover:scale-105">
                                        @else
                                            <div
                                                class="flex h-full w-full items-center justify-center bg-gradient-to-br from-gray-300 to-gray-200 dark:from-gray-600 dark:to-gray-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-500"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                                </svg>
                                            </div>
                                        @endif

                                        <!-- Кнопка воспроизведения для похожих треков -->
                                        <button
                                            class="play-button absolute inset-0 flex items-center justify-center bg-black bg-opacity-40 opacity-0 transition-all duration-200 group-hover:opacity-100"
                                            data-track-id="{{ $similarTrack->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-12 w-12 text-white drop-shadow-lg" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="mt-3">
                                        <a href="{{ route('tracks.show', $similarTrack) }}"
                                            class="block font-medium text-gray-900 hover:text-primary-600 dark:text-white dark:hover:text-primary-400">
                                            <h3 class="truncate text-sm">{{ $similarTrack->title }}</h3>
                                        </a>
                                        <a href="{{ route('profile.show', $similarTrack->user) }}"
                                            class="text-xs text-primary-600 hover:text-primary-700 dark:text-primary-400">
                                            {{ $similarTrack->user->name }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Подключаем компоненты -->
    @include('components.playlist-selector')

    <!-- Уведомления -->
    @if (session('notification'))
        <div id="notification"
            class="fixed bottom-4 right-4 rounded-lg bg-green-50 p-4 text-green-800 shadow-lg dark:bg-green-900/30 dark:text-green-400 z-50">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('notification') }}</span>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const audio = document.getElementById('track-audio');
            const playButtons = document.querySelectorAll('.play-button');

            // Обработчик для основной кнопки воспроизведения
            const mainPlayButton = document.querySelector('.play-button[data-track-id="{{ $track->id }}"]');
            if (mainPlayButton) {
                mainPlayButton.addEventListener('click', function() {
                    if (audio.paused) {
                        audio.play();
                        // Можно добавить изменение иконки на паузу
                    } else {
                        audio.pause();
                        // Можно добавить изменение иконки на воспроизведение
                    }
                });
            }

            // Обработчик для кнопок похожих треков
            playButtons.forEach(button => {
                if (button !== mainPlayButton) {
                    button.addEventListener('click', function() {
                        const trackId = this.getAttribute('data-track-id');
                        // Переход к другому треку или загрузка в плеер
                        window.location.href = `/tracks/${trackId}`;
                    });
                }
            });

            // Автоматически скрыть уведомление
            const notification = document.getElementById('notification');
            if (notification) {
                setTimeout(() => {
                    notification.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                    setTimeout(() => {
                        notification.remove();
                    }, 500);
                }, 3000);
            }
        });

        // Функция копирования ссылки
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Создаем временное уведомление
                const notification = document.createElement('div');
                notification.className =
                    'fixed bottom-4 right-4 rounded-lg bg-blue-50 p-4 text-blue-800 shadow-lg dark:bg-blue-900/30 dark:text-blue-400 z-50';
                notification.innerHTML = `
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span>Ссылка скопирована!</span>
            </div>
        `;
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                    setTimeout(() => {
                        notification.remove();
                    }, 500);
                }, 2000);
            }, function(err) {
                console.error('Ошибка при копировании: ', err);
            });
        }

        // Функция открытия селектора плейлистов (если у вас есть такой компонент)
        function openPlaylistSelector(trackId) {
            // Ваш код для открытия модального окна выбора плейлиста
            console.log('Open playlist selector for track:', trackId);
        }
    </script>
@endsection
