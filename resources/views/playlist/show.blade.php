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

                        <!-- Кнопка удаления плейлиста -->
                        <button type="button" id="delete-playlist-btn"
                            class="inline-flex items-center rounded-lg border border-red-300 bg-white px-4 py-2 text-sm font-medium text-red-700 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:border-red-600 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-red-900/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Удалить
                        </button>
                    @endif
                </div>

                <!-- Модальное окно подтверждения удаления -->
                <div id="delete-confirmation-modal" class="fixed inset-0 z-50 hidden overflow-y-auto"
                    aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex min-h-screen items-end justify-center px-4 pb-20 pt-4 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
                        <div
                            class="inline-block transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all dark:bg-gray-800 sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
                            <div class="bg-white px-4 pb-4 pt-5 dark:bg-gray-800 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div
                                        class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/20 sm:mx-0 sm:h-10 sm:w-10">
                                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                        </svg>
                                    </div>
                                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                        <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-white"
                                            id="modal-title">
                                            Удалить плейлист
                                        </h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                Вы уверены, что хотите удалить плейлист "<span
                                                    class="font-medium">{{ $playlist->name }}</span>"?
                                                Это действие нельзя отменить. Все треки будут удалены из плейлиста.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 dark:bg-gray-700 sm:flex sm:flex-row-reverse sm:px-6">
                                <form id="delete-playlist-form" method="POST"
                                    action="{{ route('playlists.destroy', $playlist) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
                                        Удалить плейлист
                                    </button>
                                </form>
                                <button type="button" id="cancel-delete-btn"
                                    class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 dark:bg-gray-600 dark:text-white dark:ring-gray-500 dark:hover:bg-gray-500 sm:mt-0 sm:w-auto">
                                    Отмена
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Сообщения об успехе/ошибке -->
        @if (session('success'))
            <div
                class="mb-6 rounded-lg bg-green-100 border border-green-400 text-green-700 px-4 py-3 dark:bg-green-900 dark:border-green-600 dark:text-green-200">
                <div class="flex">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="ml-2">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div
                class="mb-6 rounded-lg bg-red-100 border border-red-400 text-red-700 px-4 py-3 dark:bg-red-900 dark:border-red-600 dark:text-red-200">
                <div class="flex">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="ml-2">{{ session('error') }}</span>
                </div>
            </div>
        @endif

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
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('tracks.show', $track->id) }}"
                                        class="truncate text-base font-medium text-gray-900 hover:text-primary-600 dark:text-white dark:hover:text-primary-400">
                                        {{ $track->title }}
                                    </a>
                                    <div class="ml-4 flex flex-shrink-0 items-center gap-3">
                                        @if (Auth::id() === $playlist->user_id)
                                            <form action="{{ route('playlists.remove-track', $playlist) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="track_id" value="{{ $track->id }}">
                                                <button type="submit"
                                                    class="text-gray-400 hover:text-red-600 dark:hover:text-red-400 opacity-0 transition-opacity group-hover:opacity-100"
                                                    title="Удалить из плейлиста"
                                                    onclick="return confirm('Вы уверены, что хотите удалить этот трек из плейлиста?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
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

                    <form action="{{ route('playlists.update', $playlist) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Отображение ошибок валидации -->
                        @if ($errors->any())
                            <div
                                class="mx-6 mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded dark:bg-red-900 dark:border-red-600 dark:text-red-200">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="bg-white px-4 pt-5 pb-4 dark:bg-gray-800 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">
                                        Редактировать плейлист
                                    </h3>
                                    <div class="mt-4 space-y-4">
                                        <div>
                                            <label for="edit-playlist-name"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                Название плейлиста
                                            </label>
                                            <input type="text" id="edit-playlist-name" name="name"
                                                value="{{ old('name', $playlist->name) }}"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm @error('name') border-red-500 @enderror"
                                                required>
                                            @error('name')
                                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="edit-playlist-description"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                Описание
                                            </label>
                                            <textarea id="edit-playlist-description" name="description" rows="3"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm @error('description') border-red-500 @enderror"
                                                placeholder="Добавьте описание плейлиста">{{ old('description', $playlist->description) }}</textarea>
                                            @error('description')
                                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="edit-playlist-cover"
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                Обложка плейлиста
                                            </label>
                                            <div class="mt-1 flex items-center space-x-4">
                                                <div
                                                    class="h-16 w-16 overflow-hidden rounded-md bg-gray-200 dark:bg-gray-700">
                                                    @if ($playlist->cover_image)
                                                        <img src="{{ asset('storage/' . $playlist->cover_image) }}"
                                                            alt="Текущая обложка" class="h-full w-full object-cover">
                                                    @else
                                                        <div class="flex h-full w-full items-center justify-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-6 w-6 text-gray-400" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-1">
                                                    <input type="file" id="edit-playlist-cover" name="cover_image"
                                                        accept="image/*"
                                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:text-gray-400 dark:file:bg-primary-900/30 dark:file:text-primary-400 @error('cover_image') border-red-500 @enderror">
                                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PNG, JPG до
                                                        2MB</p>
                                                    @error('cover_image')
                                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                                                            {{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-center">
                                            <input type="checkbox" id="edit-playlist-public" name="is_public"
                                                value="1"
                                                {{ old('is_public', $playlist->is_public) ? 'checked' : '' }}
                                                class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700">
                                            <label for="edit-playlist-public"
                                                class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                                Публичный плейлист
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Публичные плейлисты видны всем
                                            пользователям, приватные - только вам.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 dark:bg-gray-700 sm:flex sm:flex-row-reverse sm:px-6">
                            <button type="submit"
                                class="inline-flex w-full justify-center rounded-md border border-transparent bg-primary-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
                                Сохранить изменения
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
    @endif

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const deleteBtn = document.getElementById('delete-playlist-btn');
                const modal = document.getElementById('delete-confirmation-modal');
                const cancelBtn = document.getElementById('cancel-delete-btn');
                const modalOverlay = modal.querySelector('.fixed.inset-0.bg-gray-500');

                // Показать модальное окно
                deleteBtn?.addEventListener('click', function() {
                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                });

                // Скрыть модальное окно
                function hideModal() {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }

                cancelBtn?.addEventListener('click', hideModal);
                modalOverlay?.addEventListener('click', hideModal);

                // Закрытие по Escape
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                        hideModal();
                    }
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                // Простое открытие/закрытие модального окна
                const editPlaylistBtn = document.getElementById('edit-playlist-btn');
                const editPlaylistModal = document.getElementById('edit-playlist-modal');
                const cancelEditBtn = document.getElementById('cancel-edit');
                const modalBackdrop = document.getElementById('modal-backdrop');

                if (editPlaylistBtn && editPlaylistModal) {
                    // Открытие модального окна
                    editPlaylistBtn.addEventListener('click', function() {
                        editPlaylistModal.classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                    });

                    // Закрытие модального окна
                    function closeModal() {
                        editPlaylistModal.classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    }

                    if (cancelEditBtn) {
                        cancelEditBtn.addEventListener('click', closeModal);
                    }

                    if (modalBackdrop) {
                        modalBackdrop.addEventListener('click', closeModal);
                    }

                    // Закрытие по Escape
                    document.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape' && !editPlaylistModal.classList.contains('hidden')) {
                            closeModal();
                        }
                    });
                }

                // Автоматическое открытие модального окна при наличии ошибок валидации
                @if ($errors->any())
                    if (editPlaylistModal) {
                        editPlaylistModal.classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                    }
                @endif
            });
        </script>
    @endpush
@endsection
