<!-- Плеер (фиксированный внизу экрана) -->
<div id="audio-player" class="fixed bottom-0 left-0 right-0 hidden bg-white shadow-lg dark:bg-gray-800">
    <div class="mx-auto max-w-7xl px-4 py-3">
        <div class="flex items-center">
            <div class="mr-4 flex items-center">
                <div
                    class="mr-3 h-12 w-12 flex-shrink-0 overflow-hidden rounded-md bg-gray-200 shadow-sm dark:bg-gray-700">
                    <img id="player-cover" src="/placeholder.svg" alt="Обложка трека" class="h-full w-full object-cover">
                </div>
                <div>
                    <p id="player-title" class="font-medium text-gray-900 dark:text-white">Название трека</p>
                    <p id="player-artist" class="text-sm text-gray-500 dark:text-gray-400">Исполнитель</p>
                </div>
            </div>
            <div class="flex-1">
                <div class="flex items-center justify-center">
                    <button type="button" id="player-prev"
                        class="mx-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12.066 11.2l5.334-3.2a1 1 0 000-1.8l-5.334-3.2a1 1 0 00-1.5.8v7.2a1 1 0 001.5.8z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.866 11.2l5.334-3.2a1 1 0 000-1.8l-5.334-3.2a1 1 0 00-1.5.8v7.2a1 1 0 001.5.8z" />
                        </svg>
                    </button>
                    <button type="button" id="player-play"
                        class="mx-2 rounded-full bg-primary-600 p-2 text-white hover:bg-primary-700 dark:bg-primary-700 dark:hover:bg-primary-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                        </svg>
                    </button>
                    <button type="button" id="player-next"
                        class="mx-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.933 12.8l-5.334 3.2a1 1 0 01-1.5-.8V8a1 1 0 011.5-.8l5.334 3.2a1 1 0 010 1.6z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.133 12.8l-5.334 3.2a1 1 0 01-1.5-.8V8a1 1 0 011.5-.8l5.334 3.2a1 1 0 010 1.6z" />
                        </svg>
                    </button>
                </div>
                <div class="mt-2 flex items-center">
                    <span id="player-current-time" class="mr-2 text-xs text-gray-500 dark:text-gray-400">0:00</span>
                    <div class="flex-1">
                        <div id="progress-container"
                            class="h-1.5 w-full overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700 cursor-pointer">
                            <div id="player-progress" class="h-full rounded-full bg-primary-600 dark:bg-primary-500"
                                style="width: 0%"></div>
                        </div>
                    </div>
                    <span id="player-duration" class="ml-2 text-xs text-gray-500 dark:text-gray-400">0:00</span>
                </div>
            </div>
            <div class="ml-4 flex items-center">
                <button type="button" id="player-volume"
                    class="mx-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                    </svg>
                </button>
                <button type="button" id="player-favorite"
                    class="mx-2 text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </button>
                <button type="button" id="player-playlist"
                    class="mx-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

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
            const audio = new Audio();
            let isPlaying = false;
            let currentTrackId = null;
            let tracksList = [];
            let currentTrackIndex = -1;

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

                // Если это тот же трек, просто переключаем воспроизведение/паузу
                if (currentTrackId === trackId && audio.src) {
                    togglePlayPause();
                    return;
                }

                currentTrackId = trackId;
                currentTrackIndex = tracksList.indexOf(trackId);

                // Получаем данные трека с сервера
                fetch(`/tracks/${trackId}/data`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Ошибка при получении данных трека');
                        }
                        return response.json();
                    })
                    .then(trackData => {
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
                            updatePlayCount(trackId);
                        }).catch(error => {
                            console.error('Ошибка воспроизведения:', error);
                        });
                    })
                    .catch(error => {
                        console.error('Ошибка:', error);
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
                    audio.play();
                    isPlaying = true;
                }
                updatePlayButton();
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

            // Обновление прогресса воспроизведения
            audio.addEventListener('timeupdate', function() {
                const currentTime = audio.currentTime;
                const duration = audio.duration || 0;
                const progressPercent = (currentTime / duration) * 100;

                if (playerProgress) playerProgress.style.width = `${progressPercent}%`;
                if (playerCurrentTime) playerCurrentTime.textContent = formatTime(currentTime);
                if (playerDuration) playerDuration.textContent = formatTime(duration);
            });

            // Автоматическое воспроизведение следующего трека
            audio.addEventListener('ended', function() {
                playNextTrack();
            });

            // Форматирование времени в формат MM:SS
            function formatTime(seconds) {
                const minutes = Math.floor(seconds / 60);
                const remainingSeconds = Math.floor(seconds % 60);
                return `${minutes}:${remainingSeconds < 10 ? '0' : ''}${remainingSeconds}`;
            }

            // Прогресс-бар с возможностью перемотки
            const progressContainer = document.getElementById('progress-container');
            if (progressContainer) {
                progressContainer.addEventListener('click', function(e) {
                    const rect = this.getBoundingClientRect();
                    const clickPosition = (e.clientX - rect.left) / rect.width;
                    if (audio.duration) {
                        audio.currentTime = clickPosition * audio.duration;
                    }
                });
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
        });
    </script>
@endpush
