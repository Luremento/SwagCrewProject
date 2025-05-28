@extends('layouts.app')

@section('title', $track->title . ' - ' . $track->user->name)

@section('content')
    <div class="space-y-8">
        <!-- Основная информация о треке -->
        <div class="rounded-xl bg-white p-8 shadow-lg dark:bg-gray-800">
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                <!-- Обложка трека -->
                <div class="lg:col-span-1">
                    <div class="aspect-square overflow-hidden rounded-xl bg-gray-200 dark:bg-gray-700">
                        @if ($track->cover)
                            <img src="{{ asset('storage/covers/' . $track->cover) }}" alt="Обложка {{ $track->title }}"
                                class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full w-full items-center justify-center">
                                <svg class="h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Информация и управление -->
                <div class="lg:col-span-2">
                    <div class="space-y-6">
                        <!-- Заголовок и исполнитель -->
                        <div>
                            <h1 class="text-4xl font-bold text-gray-900 dark:text-white">{{ $track->title }}</h1>
                            <div class="mt-2 flex items-center space-x-2">
                                <a href="{{ route('profile.index', $track->user) }}"
                                    class="flex items-center space-x-2 text-lg text-primary-600 hover:text-primary-700 dark:text-primary-400">
                                    @if ($track->user->avatar)
                                        <img src="{{ asset('storage/avatars/' . $track->user->avatar) }}" alt="Аватар"
                                            class="h-8 w-8 rounded-full">
                                    @else
                                        <img src="{{ asset('img/default-avatar.webp') }}" alt="Аватар"
                                            class="h-8 w-8 rounded-full">
                                    @endif
                                    <span>{{ $track->user->name }}</span>
                                </a>
                            </div>
                        </div>

                        <!-- Жанр и дата -->
                        <div class="flex flex-wrap gap-4 text-sm text-gray-600 dark:text-gray-400">
                            @if ($track->genre)
                                <span
                                    class="inline-flex items-center rounded-full bg-primary-100 px-3 py-1 text-primary-800 dark:bg-primary-900 dark:text-primary-200">
                                    {{ $track->genre->name }}
                                </span>
                            @endif
                            <span>Загружен {{ $track->created_at->format('d.m.Y') }}</span>
                            @if ($track->duration)
                                <span>Длительность: {{ gmdate('i:s', $track->duration) }}</span>
                            @endif
                        </div>

                        <!-- Описание -->
                        @if ($track->description)
                            <div class="prose dark:prose-invert">
                                <p class="text-gray-700 dark:text-gray-300">{{ $track->description }}</p>
                            </div>
                        @endif

                        <!-- Аудиоплеер -->
                        <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-700">
                            <audio controls class="w-full">
                                <source src="{{ asset('storage/tracks/' . $track->file_path) }}" type="audio/mpeg">
                                Ваш браузер не поддерживает аудио элемент.
                            </audio>
                        </div>

                        <!-- Действия -->
                        <div class="flex flex-wrap gap-3">
                            @auth
                                <!-- Кнопка лайка -->
                                <form action="{{ route('favorites.toggle', $track) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center space-x-2 rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span>Нравится</span>
                                        <span
                                            class="rounded-full bg-red-500 px-2 py-1 text-xs">{{ $track->likes_count ?? 0 }}</span>
                                    </button>
                                </form>

                                <!-- Добавить в плейлист -->
                                @if ($playlists->count() > 0)
                                    <div class="relative" x-data="{ open: false }">
                                        <button @click="open = !open"
                                            class="flex items-center space-x-2 rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            <span>В плейлист</span>
                                        </button>

                                        <div x-show="open" @click.away="open = false"
                                            class="absolute left-0 top-full z-10 mt-2 w-64 rounded-lg bg-white shadow-lg dark:bg-gray-800">
                                            @foreach ($playlists as $playlist)
                                                <form action="{{ route('playlists.add-track', [$playlist, $track]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="flex w-full items-center justify-between px-4 py-3 text-left hover:bg-gray-50 dark:hover:bg-gray-700">
                                                        <span
                                                            class="text-gray-900 dark:text-white">{{ $playlist->name }}</span>
                                                        <span class="text-sm text-gray-500">{{ $playlist->tracks_count }}
                                                            треков</span>
                                                    </button>
                                                </form>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Поделиться -->
                                <button onclick="copyToClipboard('{{ url()->current() }}')"
                                    class="flex items-center space-x-2 rounded-lg bg-gray-600 px-4 py-2 text-white hover:bg-gray-700">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
                                    </svg>
                                    <span>Поделиться</span>
                                </button>
                            @else
                                <p class="text-gray-600 dark:text-gray-400">
                                    <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700">Войдите</a>
                                    или
                                    <a href="{{ route('register') }}"
                                        class="text-primary-600 hover:text-primary-700">зарегистрируйтесь</a>,
                                    чтобы взаимодействовать с треком
                                </p>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Похожие треки -->
        @if ($similarTracks->count() > 0)
            <div class="rounded-xl bg-white p-8 shadow-lg dark:bg-gray-800">
                <h2 class="mb-6 text-2xl font-bold text-gray-900 dark:text-white">Похожие треки</h2>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
                    @foreach ($similarTracks as $similarTrack)
                        <div class="group">
                            <a href="{{ route('tracks.show', $similarTrack) }}" class="block">
                                <div class="aspect-square overflow-hidden rounded-lg bg-gray-200 dark:bg-gray-700">
                                    @if ($similarTrack->cover)
                                        <img src="{{ asset('storage/covers/' . $similarTrack->cover) }}"
                                            alt="Обложка {{ $similarTrack->title }}"
                                            class="h-full w-full object-cover transition-transform group-hover:scale-105">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center">
                                            <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="mt-3">
                                    <h3 class="font-medium text-gray-900 dark:text-white group-hover:text-primary-600">
                                        {{ Str::limit($similarTrack->title, 30) }}
                                    </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $similarTrack->user->name }}
                                    </p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Ссылка скопирована в буфер обмена!');
            }, function(err) {
                console.error('Ошибка при копировании: ', err);
            });
        }
    </script>
@endsection
