<!-- Плеер (фиксированный внизу экрана) -->
<div id="audio-player"
    class="fixed bottom-0 left-0 right-0 hidden bg-white shadow-lg dark:bg-gray-900 rounded-t-xl transition-all duration-300 z-50">
    <div class="mx-auto max-w-7xl px-4 py-3">
        <div class="flex items-center">
            <!-- Обложка и информация о треке -->
            <div class="mr-4 flex items-center">
                <div
                    class="mr-3 h-14 w-14 flex-shrink-0 overflow-hidden rounded-lg bg-gray-200 shadow-sm dark:bg-gray-700">
                    <img id="player-cover" src="/placeholder.svg" alt="Обложка трека" class="h-full w-full object-cover">
                </div>
                <div>
                    <p id="player-title" class="font-medium text-gray-900 dark:text-white">Название трека</p>
                    <p id="player-artist" class="text-sm text-gray-500 dark:text-gray-400">Исполнитель</p>
                </div>
            </div>

            <!-- Элементы управления -->
            <div class="flex-1">
                <div class="flex items-center justify-center">
                    <button type="button" id="player-prev"
                        class="mx-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.933 12.8l-5.334 3.2a1 1 0 01-1.5-.8V8a1 1 0 011.5-.8l5.334 3.2a1 1 0 010 1.6z"
                                transform="rotate(180 12 12)" />
                        </svg>
                    </button>
                    <button type="button" id="player-play"
                        class="mx-2 rounded-full bg-primary-600 p-2 text-white hover:bg-primary-700 dark:bg-primary-700 dark:hover:bg-primary-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                        </svg>
                    </button>
                    <button type="button" id="player-next"
                        class="mx-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.933 12.8l-5.334 3.2a1 1 0 01-1.5-.8V8a1 1 0 011.5-.8l5.334 3.2a1 1 0 010 1.6z" />
                        </svg>
                    </button>
                </div>
                <div class="mt-2 flex items-center">
                    <span id="player-current-time" class="mr-2 text-xs text-gray-500 dark:text-gray-400">0:00</span>
                    <div class="flex-1">
                        <div id="progress-container"
                            class="h-2 w-full overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700 cursor-pointer">
                            <div id="player-progress" class="h-full rounded-full bg-primary-600 dark:bg-primary-500"
                                style="width: 0%"></div>
                        </div>
                    </div>
                    <span id="player-duration" class="ml-2 text-xs text-gray-500 dark:text-gray-400">0:00</span>
                </div>
            </div>

            <!-- Дополнительные кнопки -->
            <div class="ml-4 flex items-center">
                <!-- Кнопка звука с выпадающим регулятором громкости -->
                <div class="relative mx-2">
                    <button type="button" id="player-volume"
                        class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                        </svg>
                    </button>
                    <!-- Выпадающий регулятор громкости -->
                    <div id="volume-control"
                        class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-lg hidden">
                        <input type="range" min="0" max="1" step="0.01" value="1"
                            id="volume-slider"
                            class="w-24 h-2 bg-gray-200 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer">
                    </div>
                </div>
                <button type="button" id="player-favorite"
                    class="mx-2 text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </button>
                <button type="button" id="player-playlist"
                    class="mx-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                </button>
                <!-- Кнопка закрытия -->
                <button type="button" id="player-close"
                    class="ml-2 text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Скрытый аудио-элемент -->
    <audio id="audio-element"></audio>
</div>

<style>
    /* Стили для регулятора громкости */
    input[type=range]::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 15px;
        height: 15px;
        background: var(--color-primary-600);
        border-radius: 50%;
        cursor: pointer;
    }

    input[type=range]::-moz-range-thumb {
        width: 15px;
        height: 15px;
        background: var(--color-primary-600);
        border-radius: 50%;
        cursor: pointer;
        border: none;
    }

    .dark input[type=range]::-webkit-slider-thumb {
        background: var(--color-primary-500);
    }

    .dark input[type=range]::-moz-range-thumb {
        background: var(--color-primary-500);
    }
</style>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Переменные для плеера
            const audioPlayer = document.getElementById('audio-player');
            const playerCover = document.getElementById('player-cover');
            const playerTitle = document.getElementById('player-title');
            const playerArtist = document.getElementById('player-artist');
            const playerPlay = document.getElementById('player-play');
            const playerProgress = document.getElementById('player-progress');
            const playerCurrentTime = document.getElementById('player-current-time');
            const playerDuration = document.getElementById('player-duration');
            const playerPrev = document.getElementById('player-prev');
            const playerNext = document.getElementById('player-next');
            const playerClose = document.getElementById('player-close');
            const progressContainer = document.getElementById('progress-container');
            const volumeButton = document.getElementById('player-volume');
            const volumeControl = document.getElementById('volume-control');
            const volumeSlider = document.getElementById('volume-slider');
            const audio = document.getElementById('audio-element') || new Audio();

            let isPlaying = false;
            let currentTrackId = null;
            let currentTrackData = null; // Сохраняем данные текущего трека
            let tracksList = [];
            let currentTrackIndex = -1;
            let isDragging = false;
            let isPlayerClosed = false; // Флаг для отслеживания закрытия плеера
            let isVolumeControlVisible = false; // Флаг для отслеживания видимости регулятора громкости

            // Кэш данных треков для быстрого доступа
            let tracksCache = {};

            // Функция для инициализации плейлиста
            function initializePlaylist() {
                // Очищаем текущий плейлист
                tracksList = [];

                // Собираем все треки на странице для создания плейлиста
                const playButtons = document.querySelectorAll('.play-button');
                playButtons.forEach(button => {
                    if (button && button.getAttribute('data-track-id')) {
                        const trackId = button.getAttribute('data-track-id');
                        if (!tracksList.includes(trackId)) {
                            tracksList.push(trackId);
                        }

                        // Добавляем обработчик события, если его еще нет
                        if (!button.hasAttribute('data-initialized')) {
                            button.setAttribute('data-initialized', 'true');
                            button.addEventListener('click', function() {
                                const trackId = this.getAttribute('data-track-id');
                                if (trackId) {
                                    playTrack(trackId);
                                }
                            });
                        }
                    }
                });

                console.log('Плейлист инициализирован:', tracksList);
            }

            // Инициализируем плейлист при загрузке страницы
            initializePlaylist();

            // Функция воспроизведения трека
            function playTrack(trackId) {
                if (!trackId) return;

                // Если плеер был закрыт, показываем его снова
                if (isPlayerClosed) {
                    audioPlayer.classList.remove('hidden');
                    isPlayerClosed = false;
                }

                // Если это тот же трек, просто переключаем воспроизведение/паузу
                if (currentTrackId === trackId && audio.src) {
                    togglePlayPause();
                    return;
                }

                currentTrackId = trackId;
                currentTrackIndex = tracksList.indexOf(trackId);

                // Проверяем, есть ли трек в кэше
                if (tracksCache[trackId]) {
                    console.log('Данные трека найдены в кэше');
                    setTrackAndPlay(tracksCache[trackId]);
                    return;
                }

                // Получаем данные трека с сервера
                fetch(`/tracks/${trackId}/data`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Ошибка при получении данных трека');
                        }
                        return response.json();
                    })
                    .then(trackData => {
                        console.log('Получены данные трека:', trackData);

                        // Сохраняем данные в кэш
                        tracksCache[trackId] = trackData;

                        // Устанавливаем и воспроизводим трек
                        setTrackAndPlay(trackData);
                    })
                    .catch(error => {
                        console.error('Ошибка:', error);
                    });
            }

            // Функция для установки трека и воспроизведения
            function setTrackAndPlay(trackData) {
                // Сохраняем данные текущего трека
                currentTrackData = trackData;

                // Проверяем наличие аудио URL
                if (!trackData.audio_url) {
                    console.error('URL аудиофайла отсутствует в данных трека');
                    return;
                }

                // Обновляем информацию в плеере
                if (playerCover) playerCover.src = trackData.cover || '/placeholder.svg';
                if (playerTitle) playerTitle.textContent = trackData.title;
                if (playerArtist) playerArtist.textContent = trackData.artist;

                // Показываем плеер
                if (audioPlayer) audioPlayer.classList.remove('hidden');

                // Настраиваем аудио
                audio.src = trackData.audio_url;
                audio.load();

                // Запускаем воспроизведение
                audio.play().then(() => {
                    isPlaying = true;
                    updatePlayButton();

                    // Обновляем счетчик прослушиваний
                    updatePlayCount(currentTrackId);

                    // Обновляем активные кнопки воспроизведения на странице
                    updatePlayButtons();
                }).catch(error => {
                    console.error('Ошибка воспроизведения:', error);
                    console.log('Проблемный URL:', trackData.audio_url);
                });
            }

            // Обновление состояния кнопок воспроизведения на странице
            function updatePlayButtons() {
                // Находим все кнопки воспроизведения
                const playButtons = document.querySelectorAll('.play-button');

                playButtons.forEach(button => {
                    const trackId = button.getAttribute('data-track-id');

                    // Если это текущий трек и он воспроизводится
                    if (trackId === currentTrackId && isPlaying) {
                        // Можно добавить класс для визуального отображения активного трека
                        button.classList.add('active-track');

                        // Можно изменить иконку на паузу
                        button.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white drop-shadow-lg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        `;
                    } else {
                        // Для остальных треков - стандартная иконка воспроизведения
                        button.classList.remove('active-track');
                        button.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white drop-shadow-lg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        `;
                    }
                });
            }

            // Функция для обновления счетчика прослушиваний
            function updatePlayCount(trackId) {
                // Отправляем запрос на сервер для увеличения счетчика прослушиваний
                fetch(`/tracks/${trackId}/play`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                            'content')
                    }
                }).catch(error => {
                    console.error('Ошибка при обновлении счетчика прослушиваний:', error);
                });
            }

            // Переключение воспроизведения/паузы
            function togglePlayPause() {
                if (isPlaying) {
                    audio.pause();
                    isPlaying = false;
                } else {
                    audio.play().catch(error => {
                        console.error('Ошибка воспроизведения:', error);
                    });
                    isPlaying = true;
                }
                updatePlayButton();
                updatePlayButtons();
            }

            // Обновление кнопки воспроизведения
            function updatePlayButton() {
                if (!playerPlay) return;

                if (isPlaying) {
                    playerPlay.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                `;
                } else {
                    playerPlay.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                    </svg>
                `;
                }
            }

            // Воспроизведение предыдущего трека
            function playPreviousTrack() {
                if (currentTrackIndex > 0) {
                    currentTrackIndex--;
                    playTrack(tracksList[currentTrackIndex]);
                }
            }

            // Воспроизведение следующего трека
            function playNextTrack() {
                if (currentTrackIndex < tracksList.length - 1) {
                    currentTrackIndex++;
                    playTrack(tracksList[currentTrackIndex]);
                }
            }

            // Закрытие плеера
            function closePlayer() {
                audio.pause();
                isPlaying = false;
                updatePlayButton();
                updatePlayButtons();
                audioPlayer.classList.add('hidden');
                isPlayerClosed = true; // Устанавливаем флаг закрытия
            }

            // Обновление иконки громкости в зависимости от уровня
            function updateVolumeIcon() {
                if (!volumeButton) return;

                const volume = audio.volume;

                if (volume === 0) {
                    // Беззвучно
                    volumeButton.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2" />
                        </svg>
                    `;
                } else if (volume < 0.5) {
                    // Низкая громкость
                    volumeButton.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072" />
                        </svg>
                    `;
                } else {
                    // Высокая громкость
                    volumeButton.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                        </svg>
                    `;
                }
            }

            // Показать/скрыть регулятор громкости
            function toggleVolumeControl() {
                if (isVolumeControlVisible) {
                    volumeControl.classList.add('hidden');
                } else {
                    volumeControl.classList.remove('hidden');
                }
                isVolumeControlVisible = !isVolumeControlVisible;
            }

            // Обработчик изменения громкости
            function handleVolumeChange(e) {
                const newVolume = parseFloat(e.target.value);
                audio.volume = newVolume;
                updateVolumeIcon();
            }

            // Обработчик для кнопки воспроизведения/паузы
            if (playerPlay) {
                playerPlay.addEventListener('click', togglePlayPause);
            }

            // Обработчики для кнопок предыдущего и следующего трека
            if (playerPrev) {
                playerPrev.addEventListener('click', playPreviousTrack);
            }

            if (playerNext) {
                playerNext.addEventListener('click', playNextTrack);
            }

            // Обработчик для кнопки закрытия
            if (playerClose) {
                playerClose.addEventListener('click', closePlayer);
            }

            // Обработчики для регулятора громкости
            if (volumeButton) {
                volumeButton.addEventListener('click', toggleVolumeControl);
            }

            if (volumeSlider) {
                volumeSlider.addEventListener('input', handleVolumeChange);
                // Инициализируем громкость
                volumeSlider.value = audio.volume;
            }

            // Закрытие регулятора громкости при клике вне его
            document.addEventListener('click', function(e) {
                if (isVolumeControlVisible && !volumeControl.contains(e.target) && e.target !==
                    volumeButton) {
                    volumeControl.classList.add('hidden');
                    isVolumeControlVisible = false;
                }
            });

            // Обновление прогресса воспроизведения
            audio.addEventListener('timeupdate', function() {
                if (!isDragging) {
                    const currentTime = audio.currentTime;
                    const duration = audio.duration || 0;
                    const progressPercent = (currentTime / duration) * 100;

                    if (playerProgress) playerProgress.style.width = `${progressPercent}%`;
                    if (playerCurrentTime) playerCurrentTime.textContent = formatTime(currentTime);
                    if (playerDuration) playerDuration.textContent = formatTime(duration);
                }
            });

            // Обработчик загрузки метаданных
            audio.addEventListener('loadedmetadata', function() {
                if (playerDuration) playerDuration.textContent = formatTime(audio.duration);
            });

            // Автоматическое воспроизведение следующего трека
            audio.addEventListener('ended', function() {
                playNextTrack();
            });

            // Обработчик ошибок аудио
            audio.addEventListener('error', function(e) {
                console.error('Ошибка аудио:', e);
                console.log('Текущий src:', audio.src);

                // Можно добавить уведомление для пользователя
                alert('Не удалось воспроизвести трек. Пожалуйста, попробуйте позже.');

                // Закрываем плеер при ошибке
                closePlayer();
            });

            // Форматирование времени в формат MM:SS
            function formatTime(seconds) {
                if (isNaN(seconds) || !isFinite(seconds)) return '0:00';

                const minutes = Math.floor(seconds / 60);
                const remainingSeconds = Math.floor(seconds % 60);
                return `${minutes}:${remainingSeconds < 10 ? '0' : ''}${remainingSeconds}`;
            }

            // Улучшенная перемотка с поддержкой drag-and-drop
            if (progressContainer) {
                // Обработчик клика для быстрой перемотки
                progressContainer.addEventListener('click', function(e) {
                    if (!isDragging) {
                        const rect = this.getBoundingClientRect();
                        const clickPosition = (e.clientX - rect.left) / rect.width;
                        if (audio.duration) {
                            audio.currentTime = clickPosition * audio.duration;
                        }
                    }
                });

                // Обработчики для drag-and-drop перемотки
                progressContainer.addEventListener('mousedown', function(e) {
                    isDragging = true;
                    updateProgressOnDrag(e);
                });

                document.addEventListener('mousemove', function(e) {
                    if (isDragging) {
                        updateProgressOnDrag(e);
                    }
                });

                document.addEventListener('mouseup', function(e) {
                    if (isDragging) {
                        const rect = progressContainer.getBoundingClientRect();
                        const clickPosition = (e.clientX - rect.left) / rect.width;

                        if (audio.duration) {
                            audio.currentTime = clickPosition * audio.duration;
                        }

                        isDragging = false;
                    }
                });

                // Функция обновления прогресса при перетаскивании
                function updateProgressOnDrag(e) {
                    const rect = progressContainer.getBoundingClientRect();
                    let clickPosition = (e.clientX - rect.left) / rect.width;

                    // Ограничиваем значение от 0 до 1
                    clickPosition = Math.max(0, Math.min(1, clickPosition));

                    // Обновляем визуальный прогресс
                    if (playerProgress) {
                        playerProgress.style.width = `${clickPosition * 100}%`;
                    }

                    // Обновляем текущее время
                    if (audio.duration) {
                        const newTime = clickPosition * audio.duration;
                        if (playerCurrentTime) {
                            playerCurrentTime.textContent = formatTime(newTime);
                        }
                    }
                }
            }

            // Экспортируем функцию воспроизведения трека в глобальную область видимости
            window.playTrack = playTrack;
            window.currentTrackId = currentTrackId;

            // Обработчик для динамически добавленных кнопок воспроизведения
            document.addEventListener('click', function(e) {
                if (e.target.closest('.play-button')) {
                    const button = e.target.closest('.play-button');
                    const trackId = button.getAttribute('data-track-id');
                    if (trackId) {
                        playTrack(trackId);
                    }
                }
            });

            // Обновляем плейлист при изменении DOM
            // Используем MutationObserver для отслеживания изменений в DOM
            const observer = new MutationObserver(function(mutations) {
                let needsUpdate = false;

                mutations.forEach(function(mutation) {
                    if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                        // Проверяем, есть ли среди добавленных узлов кнопки воспроизведения
                        mutation.addedNodes.forEach(function(node) {
                            if (node.nodeType === 1 && (node.classList?.contains(
                                        'play-button') ||
                                    node.querySelector?.('.play-button'))) {
                                needsUpdate = true;
                            }
                        });
                    }
                });

                if (needsUpdate) {
                    initializePlaylist();
                }
            });

            // Начинаем наблюдение за изменениями в DOM
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });

            // Инициализация иконки громкости
            updateVolumeIcon();
        });
    </script>
@endpush
