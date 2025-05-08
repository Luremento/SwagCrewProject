@extends('layouts.app')

@section('title', 'Создание новой темы')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8">
        <!-- Заголовок -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Создание новой темы</h1>
        </div>

        <!-- Форма создания темы -->
        <div class="overflow-hidden rounded-xl bg-white shadow-lg dark:bg-gray-800/80 dark:backdrop-blur-sm">
            <div class="p-6">
                <form action="{{ route('thread.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-6">
                        <!-- Заголовок -->
                        <div>
                            <label for="title"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Заголовок</label>
                            <input type="text" id="title" name="title"
                                class="block w-full rounded-lg border border-gray-200 bg-gray-50 p-3 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                                placeholder="Заголовок темы" required>
                        </div>

                        <!-- Категория -->
                        <div>
                            <label for="category"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Категория</label>
                            <select id="category" name="category"
                                class="block w-full rounded-lg border border-gray-200 bg-gray-50 p-3 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Теги -->
                        <div>
                            <label for="tags" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Теги
                                (через запятую)</label>
                            <input type="text" id="tags" name="tags"
                                class="block w-full rounded-lg border border-gray-200 bg-gray-50 p-3 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                                placeholder="Например: студия, запись, микрофоны">
                        </div>

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
                                        <!-- Пример результата поиска -->
                                        <div
                                            class="track-result cursor-pointer rounded-lg p-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <div class="flex items-center">
                                                <div
                                                    class="mr-3 h-10 w-10 flex-shrink-0 overflow-hidden rounded-md bg-gray-200 dark:bg-gray-700">
                                                    <img src="https://via.placeholder.com/40" alt="Обложка трека"
                                                        class="h-full w-full object-cover">
                                                </div>
                                                <div>
                                                    <p class="font-medium text-gray-900 dark:text-white">Название трека</p>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">Исполнитель</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Конец примера -->
                                    </div>
                                </div>

                                <!-- Выбранный трек (появляется после выбора) -->
                                <div id="selected_track"
                                    class="hidden rounded-lg border border-gray-200 bg-gray-50 p-3 dark:border-gray-700 dark:bg-gray-800">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div
                                                class="mr-3 h-12 w-12 flex-shrink-0 overflow-hidden rounded-md bg-gray-200 dark:bg-gray-700">
                                                <img src="https://via.placeholder.com/48" alt="Обложка трека"
                                                    class="h-full w-full object-cover" id="selected_track_cover">
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-white"
                                                    id="selected_track_title">Название выбранного трека</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400"
                                                    id="selected_track_artist">Исполнитель</p>
                                            </div>
                                        </div>
                                        <button type="button" id="remove_track" class="...">
                                            <!-- Иконка удаления -->
                                        </button>
                                    </div>
                                    <input type="hidden" name="attached_track_id" id="attached_track_id" value="">
                                </div>
                            </div>
                        </div>

                        <!-- Прикрепить файлы -->
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                Прикрепить файлы
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
                            <div id="file_list" class="mt-3 space-y-2 hidden">
                                <!-- Пример загруженного файла -->
                                <div class="flex items-center justify-between rounded-lg bg-gray-50 p-2 dark:bg-gray-700">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="mr-2 h-5 w-5 text-gray-500 dark:text-gray-400" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <span class="text-sm text-gray-700 dark:text-gray-300">example-file.pdf</span>
                                    </div>
                                    <button type="button"
                                        class="remove-file rounded-full p-1 text-gray-500 hover:bg-gray-200 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <!-- Конец примера -->
                            </div>
                        </div>

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
                                placeholder="Опишите вашу тему подробно..." required></textarea>
                        </div>

                        <!-- Кнопки -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('forum.index') }}"
                                class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700">
                                Отмена
                            </a>
                            <button type="submit"
                                class="rounded-lg bg-primary-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-700 dark:hover:bg-primary-600 dark:focus:ring-primary-800">
                                Опубликовать тему
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
                                trackResults.innerHTML = '';

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
                                        const storageBaseUrl = "{{ asset('storage') }}";
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

                                        trackResults.appendChild(trackElement);
                                    });

                                    trackResults.classList.remove('hidden');
                                } else {
                                    // Показываем сообщение, если треки не найдены
                                    const noResults = document.createElement('div');
                                    noResults.className =
                                        'p-3 text-center text-gray-500 dark:text-gray-400';
                                    noResults.textContent = 'Треки не найдены';
                                    trackResults.appendChild(noResults);
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
                const trackImage = selectedTrack.querySelector('img');
                const trackTitle = selectedTrack.querySelector('p:first-of-type');
                const trackArtist = selectedTrack.querySelector('p:last-of-type');

                // Используем правильный путь к изображению
                const storageBaseUrl = "{{ asset('storage') }}";
                trackImage.src = cover ? `${storageBaseUrl}/${cover}` : 'https://via.placeholder.com/48';
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
        });
    </script>
@endsection
