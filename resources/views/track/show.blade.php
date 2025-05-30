@extends('layouts.app')

@section('title', $track->title)

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            <!-- Основная информация о треке -->
            <div class="lg:col-span-2">
                <!-- Карточка трека -->
                <div class="overflow-hidden rounded-xl bg-white shadow-lg dark:bg-gray-800">
                    <div
                        class="aspect-video relative overflow-hidden bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-800">
                        @if ($track->cover_image)
                            <img src="{{ asset('storage/' . $track->cover_image) }}" alt="Обложка {{ $track->title }}"
                                class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full w-full items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                </svg>
                            </div>
                        @endif

                        <!-- Кнопка воспроизведения -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <button
                                class="play-button flex h-20 w-20 items-center justify-center rounded-full bg-white/90 shadow-lg transition-all hover:bg-white hover:scale-110"
                                data-track-id="{{ $track->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-800" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="p-6">
                        <!-- Заголовок и информация -->
                        <div class="mb-4">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $track->title }}</h1>
                            <div class="mt-2 flex items-center space-x-4">
                                <a href="{{ route('profile.index', $track->user->id) }}"
                                    class="flex items-center space-x-2 text-primary-600 hover:text-primary-700 dark:text-primary-400">
                                    <div
                                        class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                        <span class="text-sm font-medium">{{ substr($track->user->name, 0, 1) }}</span>
                                    </div>
                                    <span class="font-medium">{{ $track->user->name }}</span>
                                </a>
                                <span class="text-gray-500 dark:text-gray-400">•</span>
                                <span
                                    class="text-gray-500 dark:text-gray-400">{{ $track->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <!-- Жанр -->
                        <div class="mb-4">
                            <span
                                class="inline-flex items-center rounded-full bg-primary-50 px-3 py-1 text-sm font-medium text-primary-700 dark:bg-primary-900/30 dark:text-primary-400">
                                {{ $track->genre->name }}
                            </span>
                        </div>

                        <!-- Аудио плеер -->
                        @if ($track->audioFile())
                            <div class="mb-6">
                                <audio controls class="w-full">
                                    <source src="{{ asset('storage/' . $track->audioFile()->path) }}" type="audio/mpeg">
                                    Ваш браузер не поддерживает аудио элемент.
                                </audio>
                            </div>
                        @endif

                        <!-- Действия -->
                        <div class="flex items-center space-x-4">
                            <!-- Лайк -->
                            @auth
                                <form action="{{ route('favorites.toggle', $track->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center space-x-2 rounded-lg px-4 py-2 transition-colors {{ Auth::user()->hasFavorite($track->id) ? 'bg-red-50 text-red-600 hover:bg-red-100 dark:bg-red-900/30 dark:text-red-400' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-400' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                            fill="{{ Auth::user()->hasFavorite($track->id) ? 'currentColor' : 'none' }}"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                        <span>{{ Auth::user()->hasFavorite($track->id) ? 'В избранном' : 'В избранное' }}</span>
                                    </button>
                                </form>
                            @endauth

                            <!-- Добавить в плейлист -->
                            @auth
                                <button onclick="openPlaylistSelector('{{ $track->id }}')"
                                    class="flex items-center space-x-2 rounded-lg bg-gray-50 px-4 py-2 text-gray-600 transition-colors hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    <span>Добавить в плейлист</span>
                                </button>
                            @endauth

                            <!-- Поделиться -->
                            <button onclick="copyToClipboard('{{ route('tracks.show', $track->id) }}')"
                                class="flex items-center space-x-2 rounded-lg bg-gray-50 px-4 py-2 text-gray-600 transition-colors hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
                                </svg>
                                <span>Поделиться</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Комментарии -->
                <div class="mt-8 overflow-hidden rounded-xl bg-white shadow-lg dark:bg-gray-800">
                    <div class="border-b border-gray-200 bg-gray-50 px-6 py-4 dark:border-gray-700 dark:bg-gray-800">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Комментарии</h3>
                    </div>

                    <!-- Форма добавления комментария -->
                    @auth
                        <div class="border-b border-gray-200 p-6 dark:border-gray-700">
                            <form action="{{ route('comments.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="track_id" value="{{ $track->id }}">
                                <div class="flex space-x-4">
                                    <div
                                        class="h-10 w-10 flex-shrink-0 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                        <span
                                            class="text-sm font-medium text-gray-600 dark:text-gray-300">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <textarea name="content" rows="3" placeholder="Напишите комментарий..."
                                            class="w-full rounded-lg border border-gray-200 bg-gray-50 p-3 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder-gray-400"
                                            required></textarea>
                                        <div class="mt-3 flex justify-end">
                                            <button type="submit"
                                                class="rounded-lg bg-primary-600 px-4 py-2 text-white transition-colors hover:bg-primary-700 dark:bg-primary-700 dark:hover:bg-primary-600">
                                                Отправить
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="border-b border-gray-200 p-6 dark:border-gray-700">
                            <div class="text-center">
                                <p class="text-gray-500 dark:text-gray-400">
                                    <a href="{{ route('login') }}"
                                        class="text-primary-600 hover:text-primary-700 dark:text-primary-400">Войдите</a>, чтобы
                                    оставить комментарий
                                </p>
                            </div>
                        </div>
                    @endauth

                    <!-- Список комментариев -->
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        {{-- Здесь будут комментарии, когда вы их добавите в контроллер --}}
                        {{-- @forelse($track->comments as $comment) --}}
                        <div class="p-6">
                            <div class="flex space-x-4">
                                <div
                                    class="h-10 w-10 flex-shrink-0 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-300">U</span>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2">
                                        <span class="font-medium text-gray-900 dark:text-white">Пользователь</span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">2 часа назад</span>
                                    </div>
                                    <p class="mt-1 text-gray-700 dark:text-gray-300">Отличный трек! Очень нравится
                                        звучание.</p>
                                </div>
                            </div>
                        </div>
                        {{-- @empty --}}
                        <div class="p-6 text-center">
                            <p class="text-gray-500 dark:text-gray-400">Пока нет комментариев. Будьте первым!</p>
                        </div>
                        {{-- @endforelse --}}
                    </div>
                </div>
            </div>

            <!-- Боковая панель -->
            <div class="space-y-6">
                <!-- Плейлисты пользователя -->
                @auth
                    @if ($playlists->count() > 0)
                        <div class="overflow-hidden rounded-xl bg-white shadow-lg dark:bg-gray-800">
                            <div class="border-b border-gray-200 bg-gray-50 px-4 py-3 dark:border-gray-700 dark:bg-gray-800">
                                <h3 class="font-semibold text-gray-900 dark:text-white">Ваши плейлисты</h3>
                            </div>
                            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($playlists as $playlist)
                                    <a href="{{ route('playlists.show', $playlist->id) }}"
                                        class="flex items-center px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <div
                                            class="mr-3 h-10 w-10 flex-shrink-0 overflow-hidden rounded-md bg-gray-200 dark:bg-gray-700">
                                            @if ($playlist->cover_image)
                                                <img src="{{ asset('storage/' . $playlist->cover_image) }}"
                                                    alt="Обложка {{ $playlist->name }}" class="h-full w-full object-cover">
                                            @else
                                                <div
                                                    class="flex h-full w-full items-center justify-center bg-gradient-to-br from-primary-500 to-purple-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="text-gray-900 dark:text-white">{{ $playlist->name }}</span>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $playlist->tracks_count }}
                                                треков</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endauth

                <!-- Похожие треки -->
                @if ($similarTracks->count() > 0)
                    <div class="overflow-hidden rounded-xl bg-white shadow-lg dark:bg-gray-800">
                        <div class="border-b border-gray-200 bg-gray-50 px-4 py-3 dark:border-gray-700 dark:bg-gray-800">
                            <h3 class="font-semibold text-gray-900 dark:text-white">Похожие треки</h3>
                        </div>
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($similarTracks as $similarTrack)
                                <div class="group flex items-center px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <div class="mr-3 flex-shrink-0 relative">
                                        <div class="h-12 w-12 overflow-hidden rounded-md bg-gray-200 dark:bg-gray-700">
                                            @if ($similarTrack->cover_image)
                                                <img src="{{ asset('storage/' . $similarTrack->cover_image) }}"
                                                    alt="Обложка трека" class="h-full w-full object-cover">
                                            @else
                                                <div
                                                    class="flex h-full w-full items-center justify-center bg-gradient-to-br from-gray-300 to-gray-200 dark:from-gray-600 dark:to-gray-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500"
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
                                            data-track-id="{{ $similarTrack->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <a href="{{ route('tracks.show', $similarTrack->id) }}"
                                            class="block truncate text-sm font-medium text-gray-900 hover:text-primary-600 dark:text-white dark:hover:text-primary-400">
                                            {{ $similarTrack->title }}
                                        </a>
                                        <a href="{{ route('profile.index', $similarTrack->user->id) }}"
                                            class="block truncate text-xs text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400">
                                            {{ $similarTrack->user->name }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Подключаем компоненты -->
    @auth
        @include('components.playlist-selector')
    @endauth

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
        // Автоматически скрыть уведомление
        @if (session('notification'))
            setTimeout(() => {
                const notification = document.getElementById('notification');
                if (notification) {
                    notification.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                    setTimeout(() => notification.remove(), 500);
                }
            }, 3000);
        @endif

        // Копирование ссылки
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                // Показать уведомление о копировании
                const notification = document.createElement('div');
                notification.className =
                    'fixed bottom-4 right-4 rounded-lg bg-blue-50 p-4 text-blue-800 shadow-lg dark:bg-blue-900/30 dark:text-blue-400 z-50';
                notification.innerHTML = `
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
                <span>Ссылка скопирована!</span>
            </div>
        `;
                document.body.appendChild(notification);
                setTimeout(() => {
                    notification.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                    setTimeout(() => notification.remove(), 500);
                }, 2000);
            });
        }

        // Обработчики кнопок воспроизведения
        document.addEventListener('DOMContentLoaded', function() {
            const playButtons = document.querySelectorAll('.play-button');
            playButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const trackId = this.getAttribute('data-track-id');
                    console.log('Play track:', trackId);
                    // Здесь ваш код для воспроизведения трека
                });
            });
        });
    </script>
@endsection
