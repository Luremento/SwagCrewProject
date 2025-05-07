<div class="custom-audio-player rounded-lg bg-white shadow-sm dark:bg-gray-800">
    <audio id="{{ $id ?? 'audio-player' }}" class="hidden">
        <source src="{{ $src ?? '' }}" type="audio/mpeg">
        Ваш браузер не поддерживает аудио элемент.
    </audio>

    <div class="flex items-center p-3">
        <!-- Play/Pause Button -->
        <button type="button"
            class="play-pause-btn flex h-10 w-10 items-center justify-center rounded-full bg-primary-600 text-white hover:bg-primary-700 dark:bg-primary-700 dark:hover:bg-primary-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="play-icon h-5 w-5" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="5 3 19 12 5 21 5 3"></polygon>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="pause-icon hidden h-5 w-5" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                    <button type="button"
                        class="volume-btn mr-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="volume-high h-5 w-5" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                            <path d="M15.54 8.46a5 5 0 0 1 0 7.07"></path>
                            <path d="M19.07 4.93a10 10 0 0 1 0 14.14"></path>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="volume-mute hidden h-5 w-5" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                            <line x1="23" y1="9" x2="17" y2="15"></line>
                            <line x1="17" y1="9" x2="23" y2="15"></line>
                        </svg>
                    </button>
                    <div class="volume-slider hidden w-20">
                        <input type="range" min="0" max="100" value="100"
                            class="h-1 w-full appearance-none rounded-full bg-gray-300 accent-primary-600 dark:bg-gray-600">
                    </div>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="progress-container mt-2 h-1.5 w-full cursor-pointer rounded-full bg-gray-200 dark:bg-gray-700">
                <div class="progress-bar h-full rounded-full bg-primary-600 dark:bg-primary-500" style="width: 0%">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Инициализация всех аудио плееров на странице
        document.querySelectorAll('.custom-audio-player').forEach(function(playerElement) {
            initAudioPlayer(playerElement);
        });

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

            // Форматирование времени
            function formatTime(seconds) {
                const minutes = Math.floor(seconds / 60);
                seconds = Math.floor(seconds % 60);
                return `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            }
        }
    });
</script>
