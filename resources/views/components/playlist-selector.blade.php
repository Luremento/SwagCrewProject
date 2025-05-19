@extends('layouts.app')

@section('title', $playlist->name)

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8">
        <div class="mb-8 flex flex-col md:flex-row md:items-end">
            <div class="mb-4 flex-shrink-0 md:mb-0 md:mr-6">
                <div class="h-48 w-48 overflow-hidden rounded-xl shadow-lg">
                    @if ($playlist->cover_image)
                        <img src="{{ asset('storage/' . $playlist->cover_image) }}" alt="{{ $playlist->name }}"
                            class="h-full w-full object-cover">
                    @else
                        <div
                            class="flex h-full w-full items-center justify-center bg-gradient-to-br
                            @if ($playlist->name === 'Избранное') from-purple-500 to-indigo-600
                            @elseif($playlist->id % 3 == 1) from-blue-500 to-cyan-600
                            @elseif($playlist->id % 3 == 2) from-pink-500 to-rose-600
                            @else from-green-500 to-teal-600 @endif">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                            </svg>
                        </div>
                    @endif
                </div>
            </div>
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $playlist->name }}</h1>
                @if ($playlist->description)
                    <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $playlist->description }}</p>
                @endif
                <div class="mt-4 flex items-center text-sm text-gray-500 dark:text-gray-400">
                    <span>{{ $playlist->tracks->count() }}
                        {{ trans_choice('треков|трек|трека', $playlist->tracks->count()) }}</span>
                    <span class="mx-2">•</span>
                    <span>Создан {{ $playlist->created_at->diffForHumans() }}</span>
                    <span class="mx-2">•</span>
                    <span>{{ $playlist->is_public ? 'Публичный' : 'Приватный' }}</span>
                </div>
                <div class="mt-4 flex space-x-3">
                    @if ($playlist->tracks->count() > 0)
                        <button type="button" id="play-all-btn"
                            class="inline-flex items-center rounded-lg bg-primary-600 px-4 py-2 text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:bg-primary-700 dark:hover:bg-primary-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            </svg>
                            Воспроизвести все
                        </button>
                    @endif
                    @if (Auth::id() === $playlist->user_id)
                        <button type="button" id="edit-playlist-btn"
                            class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            Редактировать
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Список треков -->
        <div class="overflow-hidden rounded-xl bg-white shadow-md dark:bg-gray-800/80 dark:backdrop-blur-sm">
            <div class="border-b border-gray-200 bg-gray-50 px-6 py-3 dark:border-gray-700 dark:bg-gray-800">
                <h3 class="font-semibold text-gray-900 dark:text-white">Треки</h3>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @if ($playlist->tracks->count() > 0)
                    @foreach ($playlist->tracks as $track)
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
                                        @if (Auth::id() === $playlist->user_id)
                                            <form action="{{ route('playlists.remove-track', $playlist->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="track_id" value="{{ $track->id }}">
                                                <button type="submit"
                                                    onclick="return confirm('Вы уверены, что хотите удалить этот трек из плейлиста?')"
                                                    class="remove-from-playlist text-gray-400 hover:text-red-600 dark:hover:text-red-400 opacity-0 transition-opacity group-hover:opacity-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                        <button type="button" data-track-id="{{ $track->id }}"
                                            class="track-options text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 opacity-0 transition-opacity group-hover:opacity-100">
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
                @else
                    <div class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-12 w-12" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                        </svg>
                        <p class="text-lg font-medium">В этом плейлисте пока нет треков</p>
                        <p class="mt-2">Добавьте треки, чтобы начать слушать музыку</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Подключаем компоненты -->
    @include('components.audio-player')
    @include('components.playlist-selector')
    @include('components.edit-playlist-modal')

    @if (Auth::id() === $playlist->user_id)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Обработчик для кнопки "Воспроизвести все"
                const playAllBtn = document.getElementById('play-all-btn');
                if (playAllBtn) {
                    playAllBtn.addEventListener('click', function() {
                        const firstTrackButton = document.querySelector('.play-button');
                        if (firstTrackButton) {
                            firstTrackButton.click();
                        }
                    });
                }
            });
        </script>
    @endif
@endsection
