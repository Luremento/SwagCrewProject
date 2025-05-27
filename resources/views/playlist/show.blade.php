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
                        <button type="button" id="delete-playlist-btn"
                            class="inline-flex items-center rounded-lg border border-red-300 bg-white px-4 py-2 text-sm font-medium text-red-700 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:border-red-600 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-red-900/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Удалить плейлист
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
            <div class="divide-y divide-gray-200 dark:divide-gray-700" id="tracks-list">
                @if ($playlist->tracks->count() > 0)
                    @foreach ($playlist->tracks as $track)
                        <div class="group flex items-center px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50"
                            data-track-id="{{ $track->id }}">
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
                                            <button type="button" data-track-id="{{ $track->id }}"
                                                class="remove-from-playlist text-gray-400 hover:text-red-600 dark:hover:text-red-400 opacity-0 transition-opacity group-hover:opacity-100"
                                                title="Удалить из плейлиста">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
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
                    <div class="px-6 py-8 text-center text-gray-500 dark:text-gray-400" id="empty-state">
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

    <!-- Модальное окно редактирования плейлиста -->
    @if (Auth::id() === $playlist->user_id)
        <div id="edit-playlist-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
            <div class="flex min-h-screen items-center justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="modal-backdrop"></div>

                <span class="hidden sm:inline-block sm:h-screen sm:align-middle">&#8203;</span>

                <div
                    class="inline-block transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all dark:bg-gray-800 sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
                    <form id="edit-playlist-form" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="bg-white px-4 pt-5 pb-4 dark:bg-gray-800 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">
                                        Редактировать плейлист
                                    </h3>
                                    <div class="mt-4 space-y-4">
                                        <div>
                                            <label for="playlist-name"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                Название плейлиста
                                            </label>
                                            <input type="text" id="playlist-name" name="name"
                                                value="{{ $playlist->name }}"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                                required>
                                        </div>

                                        <div>
                                            <label for="playlist-description"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                Описание
                                            </label>
                                            <textarea id="playlist-description" name="description" rows="3"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">{{ $playlist->description }}</textarea>
                                        </div>

                                        <div>
                                            <label for="playlist-cover"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                Обложка плейлиста
                                            </label>
                                            <input type="file" id="playlist-cover" name="cover_image"
                                                accept="image/*"
                                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:text-gray-400 dark:file:bg-primary-900/30 dark:file:text-primary-400">
                                        </div>

                                        <div class="flex items-center">
                                            <input type="checkbox" id="playlist-public" name="is_public" value="1"
                                                {{ $playlist->is_public ? 'checked' : '' }}
                                                class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700">
                                            <label for="playlist-public"
                                                class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                                Публичный плейлист
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 dark:bg-gray-700 sm:flex sm:flex-row-reverse sm:px-6">
                            <button type="submit"
                                class="inline-flex w-full justify-center rounded-md border border-transparent bg-primary-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
                                Сохранить
                            </button>
                            <button type="button" id="cancel-edit"
                                class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 sm:mt-0 sm:w-auto sm:text-sm">
                                Отмена
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Модальное окно подтверждения удаления плейлиста -->
        <div id="delete-playlist-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
            <div class="flex min-h-screen items-center justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="delete-modal-backdrop"></div>

                <span class="hidden sm:inline-block sm:h-screen sm:align-middle">&#8203;</span>

                <div
                    class="inline-block transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all dark:bg-gray-800 sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
                    <div class="bg-white px-4 pt-5 pb-4 dark:bg-gray-800 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">
                                    Удалить плейлист
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Вы уверены, что хотите удалить плейлист "{{ $playlist->name }}"? Это действие
                                        нельзя отменить.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 dark:bg-gray-700 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="button" id="confirm-delete-playlist"
                            class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
                            Удалить
                        </button>
                        <button type="button" id="cancel-delete-playlist"
                            class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 sm:mt-0 sm:w-auto sm:text-sm">
                            Отмена
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Подключаем компоненты -->
    @include('components.playlist-selector')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Получаем CSRF токен
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

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

            @if (Auth::id() === $playlist->user_id)
                // Модальное окно редактирования плейлиста
                const editPlaylistBtn = document.getElementById('edit-playlist-btn');
                const editPlaylistModal = document.getElementById('edit-playlist-modal');
                const editPlaylistForm = document.getElementById('edit-playlist-form');
                const cancelEditBtn = document.getElementById('cancel-edit');
                const modalBackdrop = document.getElementById('modal-backdrop');

                // Открытие модального окна редактирования
                editPlaylistBtn.addEventListener('click', function() {
                    editPlaylistModal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                });

                // Закрытие модального окна
                function closeEditModal() {
                    editPlaylistModal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }

                cancelEditBtn.addEventListener('click', closeEditModal);
                modalBackdrop.addEventListener('click', closeEditModal);

                // Обработка формы редактирования
                editPlaylistForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);

                    fetch(`/playlists/{{ $playlist->id }}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'X-HTTP-Method-Override': 'PUT'
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                window.location.reload();
                            } else {
                                alert('Произошла ошибка при обновлении плейлиста');
                            }
                        })
                        .catch(error => {
                            console.error('Ошибка:', error);
                            alert('Произошла ошибка при обновлении плейлиста');
                        });
                });

                // Модальное окно удаления плейлиста
                const deletePlaylistBtn = document.getElementById('delete-playlist-btn');
                const deletePlaylistModal = document.getElementById('delete-playlist-modal');
                const confirmDeleteBtn = document.getElementById('confirm-delete-playlist');
                const cancelDeleteBtn = document.getElementById('cancel-delete-playlist');
                const deleteModalBackdrop = document.getElementById('delete-modal-backdrop');

                // Открытие модального окна удаления
                deletePlaylistBtn.addEventListener('click', function() {
                    deletePlaylistModal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                });

                // Закрытие модального окна удаления
                function closeDeleteModal() {
                    deletePlaylistModal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }

                cancelDeleteBtn.addEventListener('click', closeDeleteModal);
                deleteModalBackdrop.addEventListener('click', closeDeleteModal);

                // Подтверждение удаления плейлиста
                confirmDeleteBtn.addEventListener('click', function() {
                    fetch(`/playlists/{{ $playlist->id }}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                window.location.href = '/playlists';
                            } else {
                                alert('Произошла ошибка при удалении плейлиста');
                            }
                        })
                        .catch(error => {
                            console.error('Ошибка:', error);
                            alert('Произошла ошибка при удалении плейлиста');
                        });
                });

                // Обработчик для удаления трека из плейлиста
                document.querySelectorAll('.remove-from-playlist').forEach(button => {
                    button.addEventListener('click', function() {
                        const trackId = this.getAttribute('data-track-id');
                        const trackElement = this.closest('[data-track-id]');

                        if (confirm('Вы уверены, что хотите удалить этот трек из плейлиста?')) {
                            fetch(`/playlists/{{ $playlist->id }}/remove-track`, {
                                    method: 'DELETE',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': csrfToken
                                    },
                                    body: JSON.stringify({
                                        track_id: trackId
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        // Удаляем элемент из DOM с анимацией
                                        trackElement.style.transition =
                                            'opacity 0.3s ease-out, transform 0.3s ease-out';
                                        trackElement.style.opacity = '0';
                                        trackElement.style.transform = 'translateX(-100%)';

                                        setTimeout(() => {
                                            trackElement.remove();

                                            // Проверяем, остались ли треки
                                            const remainingTracks = document
                                                .querySelectorAll('[data-track-id]');
                                            if (remainingTracks.length === 0) {
                                                // Показываем пустое состояние
                                                const tracksList = document
                                                    .getElementById('tracks-list');
                                                tracksList.innerHTML = `
                                                <div class="px-6 py-8 text-center text-gray-500 dark:text-gray-400" id="empty-state">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                                    </svg>
                                                    <p class="text-lg font-medium">В этом плейлисте пока нет треков</p>
                                                    <p class="mt-2">Добавьте треки, чтобы начать слушать музыку</p>
                                                </div>
                                            `;

                                                // Скрываем кнопку "Воспроизвести все"
                                                const playAllBtn = document
                                                    .getElementById('play-all-btn');
                                                if (playAllBtn) {
                                                    playAllBtn.style.display = 'none';
                                                }
                                            }
                                        }, 300);
                                    } else {
                                        alert(
                                            'Произошла ошибка при удалении трека из плейлиста');
                                    }
                                })
                                .catch(error => {
                                    console.error('Ошибка при удалении трека из плейлиста:',
                                        error);
                                    alert(
                                        'Произошла ошибка при удалении трека из плейлиста. Пожалуйста, попробуйте еще раз.');
                                });
                        }
                    });
                });
            @endif

            // Закрытие модальных окон по нажатию Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const editModal = document.getElementById('edit-playlist-modal');
                    const deleteModal = document.getElementById('delete-playlist-modal');

                    if (editModal && !editModal.classList.contains('hidden')) {
                        editModal.classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    }

                    if (deleteModal && !deleteModal.classList.contains('hidden')) {
                        deleteModal.classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    }
                }
            });
        });
    </script>
@endsection
