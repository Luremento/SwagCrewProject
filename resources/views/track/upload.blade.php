@extends('layouts.app')

@section('title', 'Загрузка трека')

@section('content')
    <div class="overflow-hidden rounded-3xl bg-white shadow-xl dark:bg-gray-800/80 dark:backdrop-blur-sm">
        <div class="relative">
            <!-- Фон страницы загрузки с улучшенным градиентом -->
            <div
                class="h-64 bg-gradient-to-r from-primary-600 via-primary-700 to-purple-800 dark:from-primary-800 dark:via-primary-900 dark:to-purple-900">
                <div class="absolute inset-0 opacity-10">
                    <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <defs>
                            <pattern id="profile-pattern" patternUnits="userSpaceOnUse" width="100" height="100"
                                patternTransform="rotate(45)">
                                <path d="M25,0 L25,100 M50,0 L50,100 M75,0 L75,100" stroke="currentColor"
                                    stroke-width="1" />
                                <circle cx="25" cy="25" r="1" fill stroke-width="1" />
                                <circle cx="25" cy="25" r="1" fill="currentColor" />
                                <circle cx="75" cy="75" r="1" fill="currentColor" />
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#profile-pattern)" />
                    </svg>
                </div>
            </div>

            <!-- Заголовок страницы с улучшенным стилем -->
            <div class="absolute bottom-0 left-0 w-full p-8">
                <h1 class="text-3xl font-bold text-white drop-shadow-md">Загрузка нового трека</h1>
                <p class="mt-2 text-white/90 drop-shadow-sm">Поделитесь своей музыкой с миром</p>
            </div>
        </div>

        <!-- Форма загрузки трека -->
        <div class="p-8">
            <!-- Вывод ошибок валидации -->
            @include('components.validation-errors')

            <form id="track-upload-form" action="{{ route('tracks.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-8">
                @csrf

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                    <!-- Левая колонка: загрузка файлов -->
                    <div class="space-y-8">
                        <!-- Загрузка аудио файла -->
                        <div class="space-y-4">
                            <label class="block text-lg font-medium text-gray-900 dark:text-white">
                                Аудио файл
                                <span class="ml-1 text-sm text-primary-600 dark:text-primary-400">*</span>
                            </label>

                            <div id="audio-upload-container" class="relative">
                                <div id="audio-drop-area"
                                    class="flex h-48 cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 p-6 transition-all duration-300 hover:border-primary-500 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700/50 dark:hover:border-primary-500 dark:hover:bg-gray-700 {{ $errors->has('audio_file') ? 'border-red-500 bg-red-50 dark:border-red-800 dark:bg-red-900/20' : '' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="mb-3 h-12 w-12 text-gray-400 dark:text-gray-500 {{ $errors->has('audio_file') ? 'text-red-500 dark:text-red-400' : '' }}"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                    </svg>
                                    <p
                                        class="mb-2 text-sm text-gray-500 dark:text-gray-400 {{ $errors->has('audio_file') ? 'text-red-500 dark:text-red-400' : '' }}">
                                        <span class="font-semibold">Нажмите для загрузки</span> или перетащите файл
                                    </p>
                                    <p
                                        class="text-xs text-gray-500 dark:text-gray-400 {{ $errors->has('audio_file') ? 'text-red-500 dark:text-red-400' : '' }}">
                                        MP3, WAV или FLAC (макс. 20MB)</p>
                                </div>
                                <input type="file" id="audio-file" name="audio_file"
                                    accept="audio/mp3,audio/wav,audio/flac"
                                    class="absolute inset-0 cursor-pointer opacity-0" required>
                            </div>

                            <!-- Сообщение об ошибке для аудио файла -->
                            <x-input-error :messages="$errors->get('audio_file')" />

                            <!-- Предпросмотр аудио -->
                            <div id="audio-preview" class="hidden rounded-xl bg-gray-50 p-4 dark:bg-gray-700/50">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-full bg-primary-100 text-primary-600 dark:bg-primary-900/50 dark:text-primary-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p id="audio-filename" class="font-medium text-gray-900 dark:text-white">
                                                filename.mp3</p>
                                            <p id="audio-filesize" class="text-sm text-gray-500 dark:text-gray-400">2.5 MB
                                            </p>
                                        </div>
                                    </div>
                                    <button type="button" id="remove-audio"
                                        class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="mt-4">
                                    <div id="custom-audio-player-container"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Загрузка обложки -->
                        <div class="space-y-4">
                            <label class="block text-lg font-medium text-gray-900 dark:text-white">
                                Обложка трека
                                <span class="ml-1 text-sm text-primary-600 dark:text-primary-400">*</span>
                            </label>

                            <div id="cover-upload-container" class="relative">
                                <div id="cover-drop-area"
                                    class="flex h-48 cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 p-6 transition-all duration-300 hover:border-primary-500 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700/50 dark:hover:border-primary-500 dark:hover:bg-gray-700 {{ $errors->has('cover_image') ? 'border-red-500 bg-red-50 dark:border-red-800 dark:bg-red-900/20' : '' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="mb-3 h-12 w-12 text-gray-400 dark:text-gray-500 {{ $errors->has('cover_image') ? 'text-red-500 dark:text-red-400' : '' }}"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p
                                        class="mb-2 text-sm text-gray-500 dark:text-gray-400 {{ $errors->has('cover_image') ? 'text-red-500 dark:text-red-400' : '' }}">
                                        <span class="font-semibold">Нажмите для загрузки</span> или перетащите изображение
                                    </p>
                                    <p
                                        class="text-xs text-gray-500 dark:text-gray-400 {{ $errors->has('cover_image') ? 'text-red-500 dark:text-red-400' : '' }}">
                                        JPG, PNG или WEBP (мин. 500x500px)
                                    </p>
                                </div>
                                <input type="file" id="cover-image" name="cover_image"
                                    accept="image/jpeg,image/png,image/webp"
                                    class="absolute inset-0 cursor-pointer opacity-0" required>
                            </div>

                            <!-- Сообщение об ошибке для обложки -->
                            <x-input-error :messages="$errors->get('cover_image')" />

                            <!-- Предпросмотр обложки -->
                            <div id="cover-preview" class="hidden">
                                <div class="relative mx-auto aspect-square max-w-xs overflow-hidden rounded-xl shadow-md">
                                    <img id="cover-preview-image" src="/placeholder.svg" alt="Предпросмотр обложки"
                                        class="h-full w-full object-cover">
                                    <button type="button" id="remove-cover"
                                        class="absolute top-2 right-2 flex h-8 w-8 items-center justify-center rounded-full bg-black/50 text-white hover:bg-black/70 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Правая колонка: информация о треке -->
                    <div class="space-y-6">
                        <!-- Название трека -->
                        <div>
                            <label for="track-title" class="block text-lg font-medium text-gray-900 dark:text-white">
                                Название трека
                                <span class="ml-1 text-sm text-primary-600 dark:text-primary-400">*</span>
                            </label>
                            <input type="text" id="track-title" name="title" value="{{ old('title') }}" required
                                class="mt-2 block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500 {{ $errors->has('title') ? 'border-red-500 dark:border-red-800' : '' }}"
                                placeholder="Введите название трека">

                            <!-- Сообщение об ошибке для названия -->
                            <x-input-error :messages="$errors->get('title')" />
                        </div>

                        <!-- Жанр с автозаполнением -->
                        <div>
                            <label for="track-genre" class="block text-lg font-medium text-gray-900 dark:text-white">
                                Жанр
                                <span class="ml-1 text-sm text-primary-600 dark:text-primary-400">*</span>
                            </label>
                            <div class="relative mt-2">
                                <input type="text" id="track-genre" name="genre" value="{{ old('genre') }}"
                                    required
                                    class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500 {{ $errors->has('genre_name') ? 'border-red-500 dark:border-red-800' : '' }}"
                                    placeholder="Начните вводить жанр">
                                <input type="hidden" id="genre-id" name="genre_id" value="{{ old('genre_id') }}">
                                <div id="genre-suggestions"
                                    class="absolute z-10 mt-1 hidden max-h-60 w-full overflow-y-auto rounded-lg border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800">
                                    <!-- Сюда будут добавляться варианты жанров -->
                                </div>
                            </div>

                            <!-- Сообщение об ошибке для жанра -->
                            <x-input-error :messages="$errors->get('genre_name')" />
                            <x-input-error :messages="$errors->get('genre_id')" />
                        </div>

                        <!-- Дополнительная информация о загрузке -->
                        <div class="mt-8 rounded-lg bg-primary-50 p-4 dark:bg-primary-900/20">
                            <h3 class="flex items-center text-lg font-medium text-primary-800 dark:text-primary-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Информация о загрузке
                            </h3>
                            <ul class="mt-2 space-y-2 text-sm text-primary-700 dark:text-primary-400">
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 mt-0.5 h-4 w-4 flex-shrink-0"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Поддерживаемые форматы аудио: MP3, WAV, FLAC
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 mt-0.5 h-4 w-4 flex-shrink-0"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Максимальный размер аудио файла: 20 МБ
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 mt-0.5 h-4 w-4 flex-shrink-0"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Минимальный размер обложки: 500x500 пикселей
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 mt-0.5 h-4 w-4 flex-shrink-0"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Если нужного жанра нет в списке, вы можете создать новый
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Кнопки действий -->
                <div class="flex flex-col-reverse gap-4 pt-6 sm:flex-row sm:justify-end">
                    <a href="{{ route('profile.index', auth()->user()) }}"
                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-6 py-3 text-center font-medium text-gray-700 shadow-sm transition-colors hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Отмена
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-primary-600 px-6 py-3 text-center font-medium text-white shadow-sm transition-all hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-700 dark:hover:bg-primary-800 dark:focus:ring-primary-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        Загрузить трек
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript для интерактивности -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Обработка загрузки аудио файла
            const audioFileInput = document.getElementById('audio-file');
            const audioDropArea = document.getElementById('audio-drop-area');
            const audioPreview = document.getElementById('audio-preview');
            const audioFilename = document.getElementById('audio-filename');
            const audioFilesize = document.getElementById('audio-filesize');
            const customAudioPlayerContainer = document.getElementById('custom-audio-player-container');
            const removeAudio = document.getElementById('remove-audio');

            audioFileInput.addEventListener('change', function(e) {
                handleAudioFile(this.files[0]);
            });

            removeAudio.addEventListener('click', function() {
                audioFileInput.value = '';
                audioPreview.classList.add('hidden');
                audioDropArea.classList.remove('hidden');
                customAudioPlayerContainer.innerHTML = '';
            });

            function handleAudioFile(file) {
                if (file) {
                    // Отображаем имя файла и размер
                    audioFilename.textContent = file.name;
                    audioFilesize.textContent = formatFileSize(file.size);

                    // Создаем URL для аудио плеера
                    const audioURL = URL.createObjectURL(file);

                    // Создаем кастомный аудио плеер
                    customAudioPlayerContainer.innerHTML = `
                        <div class="custom-audio-player rounded-lg bg-white shadow-sm dark:bg-gray-800">
                            <audio id="audio-player" class="hidden">
                                <source src="${audioURL}" type="audio/mpeg">
                                Ваш браузер не поддерживает аудио элемент.
                            </audio>

                            <div class="flex items-center p-3">
                                <!-- Play/Pause Button -->
                                <button type="button" class="play-pause-btn flex h-10 w-10 items-center justify-center rounded-full bg-primary-600 text-white hover:bg-primary-700 dark:bg-primary-700 dark:hover:bg-primary-800 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="play-icon h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="pause-icon hidden h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="6" y="4" width="4" height="16"></rect>
                                        <rect x="14" y="4" width="4" height="16"></rect>
                                    </svg>
                                </button>

                                <!-- Track Info -->
                                <div class="ml-3 flex-1">
                                    <div class="flex items-center justify-between">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            <span class="current-time">0:00</span>
                                            <span class="mx-1">/</span>
                                            <span class="duration">0:00</span>
                                        </div>

                                        <!-- Volume Control -->
                                        <div class="flex items-center">
                                            <button type="button" class="volume-btn mr-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="volume-high h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                                                    <path d="M15.54 8.46a5 5 0 0 1 0 7.07"></path>
                                                    <path d="M19.07 4.93a10 10 0 0 1 0 14.14"></path>
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="volume-mute hidden h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                                                    <line x1="23" y1="9" x2="17" y2="15"></line>
                                                    <line x1="17" y1="9" x2="23" y2="15"></line>
                                                </svg>
                                            </button>
                                            <div class="volume-slider hidden w-20">
                                                <input type="range" min="0" max="100" value="100" class="h-1 w-full appearance-none rounded-full bg-gray-300 accent-primary-600 dark:bg-gray-600">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Progress Bar -->
                                    <div class="progress-container mt-2 h-1.5 w-full cursor-pointer rounded-full bg-gray-200 dark:bg-gray-700">
                                        <div class="progress-bar h-full rounded-full bg-primary-600 dark:bg-primary-500" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    // Инициализируем плеер
                    initAudioPlayer(customAudioPlayerContainer.querySelector('.custom-audio-player'));

                    // Показываем предпросмотр
                    audioDropArea.classList.add('hidden');
                    audioPreview.classList.remove('hidden');
                }
            }

            function initAudioPlayer(playerElement) {
                const audio = playerElement.querySelector('audio');
                const playPauseBtn = playerElement.querySelector('.play-pause-btn');
                const playIcon = playerElement.querySelector('.play-icon');
                const pauseIcon = playerElement.querySelector('.pause-icon');
                const currentTimeEl = playerElement.querySelector('.current-time');
                const durationEl = playerElement.querySelector('.duration');
                const progressContainer = playerElement.querySelector('.progress-container');
                const progressBar = playerElement.querySelector('.progress-bar');
                const volumeBtn = playerElement.querySelector('.volume-btn');
                const volumeHigh = playerElement.querySelector('.volume-high');
                const volumeMute = playerElement.querySelector('.volume-mute');
                const volumeSlider = playerElement.querySelector('.volume-slider');
                const volumeRange = playerElement.querySelector('.volume-slider input');

                // Инициализация
                let isDragging = false;

                // Загрузка аудио
                audio.addEventListener('loadedmetadata', function() {
                    durationEl.textContent = formatTime(audio.duration);
                });

                // Обновление времени
                audio.addEventListener('timeupdate', function() {
                    currentTimeEl.textContent = formatTime(audio.currentTime);
                    const percent = (audio.currentTime / audio.duration) * 100;
                    progressBar.style.width = `${percent}%`;

                    if (audio.ended) {
                        playIcon.classList.remove('hidden');
                        pauseIcon.classList.add('hidden');
                    }
                });

                // Воспроизведение/пауза
                playPauseBtn.addEventListener('click', function() {
                    if (audio.paused) {
                        audio.play();
                        playIcon.classList.add('hidden');
                        pauseIcon.classList.remove('hidden');
                    } else {
                        audio.pause();
                        playIcon.classList.remove('hidden');
                        pauseIcon.classList.add('hidden');
                    }
                });

                // Перемотка
                progressContainer.addEventListener('click', function(e) {
                    const rect = progressContainer.getBoundingClientRect();
                    const percent = (e.clientX - rect.left) / rect.width;
                    audio.currentTime = percent * audio.duration;
                });

                // Управление громкостью
                volumeBtn.addEventListener('click', function() {
                    volumeSlider.classList.toggle('hidden');
                });

                volumeBtn.addEventListener('mouseenter', function() {
                    volumeSlider.classList.remove('hidden');
                });

                playerElement.addEventListener('mouseleave', function() {
                    if (!isDragging) {
                        volumeSlider.classList.add('hidden');
                    }
                });

                volumeRange.addEventListener('input', function() {
                    audio.volume = this.value / 100;
                    if (this.value == 0) {
                        volumeHigh.classList.add('hidden');
                        volumeMute.classList.remove('hidden');
                    } else {
                        volumeHigh.classList.remove('hidden');
                        volumeMute.classList.add('hidden');
                    }
                });

                volumeRange.addEventListener('mousedown', function() {
                    isDragging = true;
                });

                volumeRange.addEventListener('mouseup', function() {
                    isDragging = false;
                });

                // Мьют/анмьют
                volumeBtn.addEventListener('click', function() {
                    if (audio.volume > 0) {
                        audio.dataset.prevVolume = audio.volume;
                        audio.volume = 0;
                        volumeRange.value = 0;
                        volumeHigh.classList.add('hidden');
                        volumeMute.classList.remove('hidden');
                    } else {
                        audio.volume = audio.dataset.prevVolume || 1;
                        volumeRange.value = audio.volume * 100;
                        volumeHigh.classList.remove('hidden');
                        volumeMute.classList.add('hidden');
                    }
                });
            }

            // Обработка загрузки обложки
            const coverImageInput = document.getElementById('cover-image');
            const coverDropArea = document.getElementById('cover-drop-area');
            const coverPreview = document.getElementById('cover-preview');
            const coverPreviewImage = document.getElementById('cover-preview-image');
            const removeCover = document.getElementById('remove-cover');

            coverImageInput.addEventListener('change', function(e) {
                handleCoverImage(this.files[0]);
            });

            removeCover.addEventListener('click', function() {
                coverImageInput.value = '';
                coverPreview.classList.add('hidden');
                coverDropArea.classList.remove('hidden');
                coverPreviewImage.src = '';
            });

            function handleCoverImage(file) {
                if (file) {
                    // Создаем URL для предпросмотра изображения
                    const imageURL = URL.createObjectURL(file);
                    coverPreviewImage.src = imageURL;

                    // Показываем предпросмотр
                    coverDropArea.classList.add('hidden');
                    coverPreview.classList.remove('hidden');
                }
            }

            // Автозаполнение для жанров из базы данных
            const genreInput = document.getElementById('track-genre');
            const genreIdInput = document.getElementById('genre-id');
            const genreSuggestions = document.getElementById('genre-suggestions');

            genreInput.addEventListener('input', function() {
                const value = this.value.toLowerCase().trim();

                // Очищаем предыдущие предложения
                genreSuggestions.innerHTML = '';

                // Сбрасываем ID жанра при изменении текста
                genreIdInput.value = '';

                if (value.length < 1) {
                    genreSuggestions.classList.add('hidden');
                    return;
                }

                // Запрос к API для получения жанров
                fetch(`/genres/search?query=${encodeURIComponent(value)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            genreSuggestions.classList.remove('hidden');

                            // Создаем элементы списка
                            data.forEach(genre => {
                                const item = document.createElement('div');
                                item.className =
                                    'px-4 py-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700';
                                item.textContent = genre.name;
                                item.dataset.id = genre.id;

                                item.addEventListener('click', function() {
                                    genreInput.value = genre.name;
                                    genreIdInput.value = genre.id;
                                    genreSuggestions.classList.add('hidden');
                                });

                                genreSuggestions.appendChild(item);
                            });
                        } else {
                            // Если жанров не найдено, показываем опцию "Создать новый жанр"
                            const newGenreItem = document.createElement('div');
                            newGenreItem.className =
                                'px-4 py-2 cursor-pointer text-primary-600 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-primary-400';
                            newGenreItem.innerHTML =
                                `<span class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Создать жанр "${value}"</span>`;

                            newGenreItem.addEventListener('click', function() {
                                genreInput.value = value;
                                genreIdInput.value =
                                    ''; // Оставляем пустым, чтобы контроллер создал новый жанр
                                genreSuggestions.classList.add('hidden');
                            });

                            genreSuggestions.appendChild(newGenreItem);
                            genreSuggestions.classList.remove('hidden');
                        }
                    })
                    .catch(error => {
                        console.error('Ошибка при поиске жанров:', error);
                    });
            });

            // Скрываем список при клике вне элемента
            document.addEventListener('click', function(e) {
                if (e.target !== genreInput && !genreSuggestions.contains(e.target)) {
                    genreSuggestions.classList.add('hidden');
                }
            });

            // Drag and drop для аудио
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                audioDropArea.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                audioDropArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                audioDropArea.addEventListener(eventName, unhighlight, false);
            });

            function highlight() {
                audioDropArea.classList.add('border-primary-500', 'bg-primary-50', 'dark:bg-primary-900/10');
            }

            function unhighlight() {
                audioDropArea.classList.remove('border-primary-500', 'bg-primary-50', 'dark:bg-primary-900/10');
            }

            audioDropArea.addEventListener('drop', handleAudioDrop, false);

            function handleAudioDrop(e) {
                const dt = e.dataTransfer;
                const file = dt.files[0];

                if (file && file.type.startsWith('audio/')) {
                    audioFileInput.files = dt.files;
                    handleAudioFile(file);
                }
            }

            // Drag and drop для обложки
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                coverDropArea.addEventListener(eventName, preventDefaults, false);
            });

            ['dragenter', 'dragover'].forEach(eventName => {
                coverDropArea.addEventListener(eventName, highlightCover, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                coverDropArea.addEventListener(eventName, unhighlightCover, false);
            });

            function highlightCover() {
                coverDropArea.classList.add('border-primary-500', 'bg-primary-50', 'dark:bg-primary-900/10');
            }

            function unhighlightCover() {
                coverDropArea.classList.remove('border-primary-500', 'bg-primary-50', 'dark:bg-primary-900/10');
            }

            coverDropArea.addEventListener('drop', handleCoverDrop, false);

            function handleCoverDrop(e) {
                const dt = e.dataTransfer;
                const file = dt.files[0];

                if (file && file.type.startsWith('image/')) {
                    coverImageInput.files = dt.files;
                    handleCoverImage(file);
                }
            }

            // Вспомогательная функция для форматирования размера файла
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';

                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));

                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Вспомогательная функция для форматирования времени
            function formatTime(seconds) {
                const minutes = Math.floor(seconds / 60);
                seconds = Math.floor(seconds % 60);
                return `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            }
        });
    </script>
@endsection
