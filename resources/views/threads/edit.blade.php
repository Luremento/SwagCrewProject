@extends('layouts.app')

@section('title', 'Редактирование темы')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8">
        <!-- Заголовок -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Редактирование темы</h1>
        </div>

        <!-- Форма редактирования темы -->
        <div class="overflow-hidden rounded-xl bg-white shadow-lg dark:bg-gray-800/80 dark:backdrop-blur-sm">
            <div class="p-6">
                <form action="{{ route('thread.update', $thread->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="space-y-6">
                        <!-- Заголовок -->
                        <div>
                            <label for="title"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Заголовок</label>
                            <input type="text" id="title" name="title" value="{{ $thread->title }}"
                                class="block w-full rounded-lg border border-gray-200 bg-gray-50 p-3 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                                placeholder="Заголовок темы" required>
                        </div>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror

                        <!-- Категория -->
                        <div>
                            <label for="category"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Категория</label>
                            <select id="category" name="category"
                                class="block w-full rounded-lg border border-gray-200 bg-gray-50 p-3 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $thread->category_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('category')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror

                        <!-- Теги -->
                        <div>
                            <label for="tags" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Теги
                                (через запятую)</label>
                            <input type="text" id="tags" name="tags" value="{{ $tagNames }}"
                                class="block w-full rounded-lg border border-gray-200 bg-gray-50 p-3 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                                placeholder="Например: студия, запись, микрофоны">
                        </div>
                        @error('tags')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror

                        <!-- Прикрепить трек -->
                        <div>
                            <label for="track_search" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                Прикрепить трек
                            </label>
                            <div class="space-y-3">
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" id="track_search"
                                        class="block w-full rounded-lg border border-gray-200 bg-gray-50 p-3 pl-10 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                                        placeholder="Поиск трека по названию...">
                                </div>

                                <!-- Результаты поиска треков (появляются при вводе) -->
                                <div id="track_search_results"
                                    class="hidden rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800">
                                    <div class="max-h-60 overflow-y-auto p-2">
                                        <!-- Результаты поиска будут добавлены через JavaScript -->
                                    </div>
                                </div>

                                <!-- Выбранный трек (появляется после выбора или если уже есть) -->
                                <div id="selected_track"
                                    class="{{ $thread->track ? '' : 'hidden' }} rounded-lg border border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50 p-3 shadow-sm dark:border-gray-700 dark:from-gray-800/50 dark:to-gray-800/30">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div
                                                class="mr-3 h-12 w-12 flex-shrink-0 overflow-hidden rounded-lg bg-gray-200 shadow-sm dark:bg-gray-700">
                                                @if ($thread->track && $thread->track->cover_image)
                                                    <img src="{{ asset('storage/' . $thread->track->cover_image) }}"
                                                        alt="Обложка трека" class="h-full w-full object-cover"
                                                        id="selected_track_cover">
                                                @else
                                                    <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-gray-300 to-gray-200 dark:from-gray-600 dark:to-gray-700"
                                                        id="selected_track_cover">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900 dark:text-white"
                                                    id="selected_track_title">
                                                    {{ $thread->track ? $thread->track->title : 'Название выбранного трека' }}
                                                </p>
                                                <p class="text-sm text-gray-600 dark:text-gray-400"
                                                    id="selected_track_artist">
                                                    {{ $thread->track && $thread->track->user ? $thread->track->user->name : 'Исполнитель' }}
                                                </p>
                                            </div>
                                        </div>
                                        <button type="button" id="remove_track"
                                            class="flex h-8 w-8 items-center justify-center rounded-full bg-red-100 text-red-600 hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    <input type="hidden" name="attached_track_id" id="attached_track_id"
                                        value="{{ $thread->track ? $thread->track->id : '' }}">
                                </div>
                            </div>
                        </div>
                        @error('attached_track_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror

                        <!-- Текущие прикрепленные файлы -->
                        @if ($thread->files && $thread->files->count() > 0)
                            <div>
                                <label class="mb-3 block text-sm font-medium text-gray-900 dark:text-white">
                                    Текущие файлы ({{ $thread->files->count() }})
                                </label>
                                <div
                                    class="rounded-lg border border-gray-200 bg-gradient-to-r from-amber-50 to-orange-50 p-4 dark:border-gray-700 dark:from-gray-800/50 dark:to-gray-800/30">
                                    <div
                                        class="grid gap-3 {{ $thread->files->count() > 6 ? 'sm:grid-cols-2 lg:grid-cols-3 max-h-64 overflow-y-auto pr-2' : 'sm:grid-cols-2 lg:grid-cols-3' }}">
                                        @foreach ($thread->files as $file)
                                            @php
                                                $extension = pathinfo($file->original_name, PATHINFO_EXTENSION);
                                                $icon = 'document';
                                                $bgColor = 'bg-gray-100';
                                                $iconColor = 'text-gray-500';

                                                if (in_array($extension, ['mp3', 'wav', 'ogg'])) {
                                                    $icon = 'music';
                                                    $bgColor = 'bg-purple-100';
                                                    $iconColor = 'text-purple-500';
                                                } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                                    $icon = 'image';
                                                    $bgColor = 'bg-blue-100';
                                                    $iconColor = 'text-blue-500';
                                                } elseif (in_array($extension, ['zip', 'rar'])) {
                                                    $icon = 'archive';
                                                    $bgColor = 'bg-amber-100';
                                                    $iconColor = 'text-amber-500';
                                                } elseif (in_array($extension, ['pdf'])) {
                                                    $icon = 'pdf';
                                                    $bgColor = 'bg-red-100';
                                                    $iconColor = 'text-red-500';
                                                }
                                            @endphp

                                            <div
                                                class="flex items-center justify-between rounded-lg bg-white p-3 shadow-sm transition-all hover:shadow-md dark:bg-gray-800">
                                                <div class="flex items-center min-w-0 flex-1">
                                                    <div
                                                        class="mr-3 flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full {{ $bgColor }} dark:bg-opacity-20">
                                                        @if ($icon == 'music')
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-5 w-5 {{ $iconColor }} dark:text-opacity-80"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                                            </svg>
                                                        @elseif($icon == 'image')
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-5 w-5 {{ $iconColor }} dark:text-opacity-80"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                        @elseif($icon == 'archive')
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-5 w-5 {{ $iconColor }} dark:text-opacity-80"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                                            </svg>
                                                        @elseif($icon == 'pdf')
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-5 w-5 {{ $iconColor }} dark:text-opacity-80"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                            </svg>
                                                        @else
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-5 w-5 {{ $iconColor }} dark:text-opacity-80"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                            </svg>
                                                        @endif
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <p class="truncate text-sm font-medium text-gray-700 dark:text-gray-300"
                                                            title="{{ $file->original_name }}">
                                                            {{ Str::limit($file->original_name, 25) }}
                                                        </p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                                            {{ number_format($file->size / 1024, 1) }} KB
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-2 ml-2">
                                                    <a href="{{ asset('storage/' . $file->path) }}" target="_blank"
                                                        class="flex h-8 w-8 items-center justify-center rounded-full text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>
                                                    <div class="flex items-center">
                                                        <input type="checkbox" id="delete_file_{{ $file->id }}"
                                                            name="delete_files[]" value="{{ $file->id }}"
                                                            class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-red-600 focus:ring-2 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-red-600">
                                                        <label for="delete_file_{{ $file->id }}"
                                                            class="ml-1 text-xs font-medium text-red-600 dark:text-red-400">Удалить</label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        @error('delete_files.*')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror

                        <!-- Прикрепить новые файлы -->
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                Прикрепить новые файлы
                            </label>
                            <div class="flex items-center justify-center w-full">
                                <label for="file_upload"
                                    class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-8 h-8 mb-3 text-gray-500 dark:text-gray-400" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                                class="font-semibold">Нажмите для загрузки</span> или перетащите файлы</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">ZIP, RAR, PDF, DOC, MP3, WAV
                                            (до 10MB)</p>
                                    </div>
                                    <input id="file_upload" name="files[]" type="file" class="hidden" multiple />
                                </label>
                            </div>

                            <!-- Список загруженных файлов -->
                            <div id="file_list" class="mt-3 hidden">
                                <!-- Файлы будут добавлены через JavaScript -->
                            </div>
                        </div>
                        @error('files.*')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror

                        <!-- Содержание -->
                        <div>
                            <label for="content"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Содержание</label>
                            <div
                                class="mb-2 flex rounded-t-lg border border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-800">
                                <button type="button"
                                    class="p-2 text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16m-7 6h7" />
                                    </svg>
                                </button>
                                <button type="button"
                                    class="p-2 text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </button>
                                <button type="button"
                                    class="p-2 text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </button>
                                <button type="button"
                                    class="p-2 text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                    </svg>
                                </button>
                                <button type="button"
                                    class="p-2 text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    </svg>
                                </button>
                            </div>
                            <textarea id="content" name="content" rows="10"
                                class="block w-full rounded-b-lg border border-gray-200 bg-white p-4 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                                placeholder="Опишите вашу тему подробно..." required>{{ $thread->content }}</textarea>
                        </div>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror

                        <!-- Кнопки -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('thread.show', $thread->id) }}"
                                class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700">
                                Отмена
                            </a>
                            <button type="submit"
                                class="rounded-lg bg-primary-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-700 dark:hover:bg-primary-600 dark:focus:ring-primary-800">
                                Сохранить изменения
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const trackSearch = document.getElementById('track_search');
            const trackResults = document.getElementById('track_search_results');
            const selectedTrack = document.getElementById('selected_track');
            const removeTrack = document.getElementById('remove_track');
            const attachedTrackId = document.getElementById('attached_track_id');
            let searchTimeout;

            // Показать результаты поиска при вводе
            trackSearch.addEventListener('input', function() {
                clearTimeout(searchTimeout);

                if (this.value.length > 2) {
                    // Добавляем задержку для предотвращения слишком частых запросов
                    searchTimeout = setTimeout(() => {
                        fetch(`/theme/track/search?query=${encodeURIComponent(this.value)}`)
                            .then(response => response.json())
                            .then(data => {
                                // Очищаем текущие результаты
                                trackResults.querySelector('div').innerHTML = '';

                                if (data.tracks.length > 0) {
                                    // Добавляем новые результаты
                                    data.tracks.forEach(track => {
                                        const trackElement = document.createElement(
                                            'div');
                                        trackElement.className =
                                            'track-result cursor-pointer rounded-lg p-2 hover:bg-gray-100 dark:hover:bg-gray-700';
                                        trackElement.dataset.id = track.id;
                                        trackElement.dataset.title = track.title;
                                        trackElement.dataset.artist = track.artist;
                                        trackElement.dataset.cover = track.cover;
                                        const storageBaseUrl =
                                            "{{ asset('storage') }}";
                                        trackElement.innerHTML = `
                                <div class="flex items-center">
                                    <div class="mr-3 h-10 w-10 flex-shrink-0 overflow-hidden rounded-md bg-gray-200 dark:bg-gray-700">
                                        <img src="${storageBaseUrl + '/' + track.cover}" alt="Обложка трека" class="h-full w-full object-cover">
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">${track.title}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">${track.artist}</p>
                                    </div>
                                </div>
                            `;

                                        // Добавляем обработчик клика
                                        trackElement.addEventListener('click',
                                            function() {
                                                selectTrack(this.dataset.id, this
                                                    .dataset.title, this.dataset
                                                    .artist, this.dataset.cover);
                                            });

                                        trackResults.querySelector('div').appendChild(
                                            trackElement);
                                    });

                                    trackResults.classList.remove('hidden');
                                } else {
                                    // Показываем сообщение, если треки не найдены
                                    const noResults = document.createElement('div');
                                    noResults.className =
                                        'p-3 text-center text-gray-500 dark:text-gray-400';
                                    noResults.textContent = 'Треки не найдены';
                                    trackResults.querySelector('div').appendChild(noResults);
                                    trackResults.classList.remove('hidden');
                                }
                            })
                            .catch(error => {
                                console.error('Ошибка при поиске треков:', error);
                            });
                    }, 300);
                } else {
                    trackResults.classList.add('hidden');
                }
            });

            // Функция выбора трека
            function selectTrack(id, title, artist, cover) {
                // Обновляем скрытое поле с ID трека
                attachedTrackId.value = id;

                // Обновляем отображение выбранного трека
                const trackImage = document.getElementById('selected_track_cover');
                const trackTitle = document.getElementById('selected_track_title');
                const trackArtist = document.getElementById('selected_track_artist');

                // Используем правильный путь к изображению
                const storageBaseUrl = "{{ asset('storage') }}";

                if (cover) {
                    if (trackImage.tagName === 'IMG') {
                        trackImage.src = `${storageBaseUrl}/${cover}`;
                    } else {
                        // Если это div, заменяем его на img
                        const imgElement = document.createElement('img');
                        imgElement.src = `${storageBaseUrl}/${cover}`;
                        imgElement.alt = "Обложка трека";
                        imgElement.className = "h-full w-full object-cover";
                        imgElement.id = "selected_track_cover";
                        trackImage.parentNode.replaceChild(imgElement, trackImage);
                    }
                }

                trackTitle.textContent = title;
                trackArtist.textContent = artist;

                // Показываем блок выбранного трека и скрываем результаты поиска
                selectedTrack.classList.remove('hidden');
                trackResults.classList.add('hidden');
                trackSearch.value = '';
            }

            // Удаление выбранного трека
            removeTrack.addEventListener('click', function() {
                selectedTrack.classList.add('hidden');
                attachedTrackId.value = '';
            });

            // Закрытие результатов поиска при клике вне
            document.addEventListener('click', function(event) {
                if (!trackSearch.contains(event.target) && !trackResults.contains(event.target)) {
                    trackResults.classList.add('hidden');
                }
            });

            // Обработка загрузки файлов
            const fileUpload = document.getElementById('file_upload');
            const fileList = document.getElementById('file_list');

            fileUpload.addEventListener('change', function() {
                if (this.files.length > 0) {
                    showNewFilesList(this.files, fileList);
                } else {
                    fileList.classList.add('hidden');
                }
            });

            // Функция для отображения новых файлов
            function showNewFilesList(files, container) {
                container.innerHTML = '';
                container.classList.remove('hidden');

                const fileListWrapper = document.createElement('div');
                fileListWrapper.className =
                    'rounded-lg border border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50 p-4 shadow-sm dark:border-gray-700 dark:from-gray-800/50 dark:to-gray-800/30';

                const filesContainer = document.createElement('div');
                filesContainer.className = 'space-y-3';
                fileListWrapper.appendChild(filesContainer);

                const title = document.createElement('h4');
                title.className = 'mb-3 text-sm font-medium text-gray-700 dark:text-gray-300';
                title.textContent = `Новые файлы (${files.length}):`;
                filesContainer.appendChild(title);

                // Создаем контейнер для файлов в сетке
                const filesGrid = document.createElement('div');
                if (files.length > 6) {
                    filesGrid.className =
                        'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-64 overflow-y-auto pr-2';
                } else {
                    filesGrid.className = 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3';
                }
                filesContainer.appendChild(filesGrid);

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const fileItem = createNewFileItem(file, i);
                    filesGrid.appendChild(fileItem);
                }

                container.appendChild(fileListWrapper);

                // Добавляем обработчики для кнопок удаления
                const removeButtons = container.querySelectorAll('.remove-new-file');
                removeButtons.forEach((button, index) => {
                    button.addEventListener('click', function() {
                        this.closest('.new-file-item').remove();

                        const remainingFiles = filesGrid.querySelectorAll('.new-file-item').length;
                        if (remainingFiles === 0) {
                            container.classList.add('hidden');
                            fileUpload.value = '';
                        } else {
                            // Обновляем счетчик файлов
                            const titleElement = container.querySelector('h4');
                            if (titleElement) {
                                titleElement.textContent = `Новые файлы (${remainingFiles}):`;
                            }
                        }
                    });
                });
            }

            // Функция для создания элемента нового файла
            function createNewFileItem(file, index) {
                const fileItem = document.createElement('div');
                fileItem.className =
                    'new-file-item flex items-center justify-between rounded-lg bg-white p-3 shadow-sm transition-all hover:shadow-md dark:bg-gray-800';

                // Определяем иконку в зависимости от типа файла
                let fileIcon = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                `;

                if (file.type.startsWith('audio/')) {
                    fileIcon = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                        </svg>
                    `;
                } else if (file.type.startsWith('image/')) {
                    fileIcon = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    `;
                } else if (file.name.endsWith('.zip') || file.name.endsWith('.rar')) {
                    fileIcon = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                    `;
                } else if (file.name.endsWith('.pdf')) {
                    fileIcon = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    `;
                }

                // Обрезаем длинные имена файлов
                const displayName = file.name.length > 25 ? file.name.substring(0, 22) + '...' : file.name;

                fileItem.innerHTML = `
                    <div class="flex items-center min-w-0 flex-1">
                        <div class="mr-3 flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700">
                            ${fileIcon}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-medium text-gray-700 dark:text-gray-300" title="${file.name}">${displayName}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">${(file.size / 1024).toFixed(1)} KB</p>
                        </div>
                    </div>
                    <button type="button" class="remove-new-file ml-2 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600 hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                `;

                return fileItem;
            }
        });
    </script>
@endsection
