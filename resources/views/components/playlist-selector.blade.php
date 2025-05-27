<div id="playlist-selector-modal" class="fixed inset-0 z-50 hidden overflow-y-auto"
    aria-labelledby="playlist-selector-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-center justify-center px-4 py-6">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>

        <!-- Modal Content -->
        <div
            class="relative transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all dark:bg-gray-800 sm:w-full sm:max-w-md">
            <!-- Header -->
            <div class="relative bg-gradient-to-r from-primary-600 to-purple-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-white/20 backdrop-blur-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg font-semibold text-white" id="playlist-selector-title">
                            Добавить в плейлист
                        </h3>
                    </div>
                    <button type="button" id="close-modal-btn"
                        class="flex h-8 w-8 items-center justify-center rounded-full text-white/80 hover:bg-white/20 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <!-- Decorative elements -->
                <div class="absolute -bottom-1 left-0 right-0 h-1 bg-gradient-to-r from-primary-400 to-purple-400">
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <!-- Existing Playlist Form -->
                <div id="playlist-selection-view">
                    <form id="add-to-playlist-form"
                        action="{{ route('playlists.add-track', ['playlist' => 'PLAYLIST_ID']) }}" method="POST">
                        @csrf
                        <input type="hidden" name="track_id" id="track-id-input" value="">

                        <div class="mb-6">
                            <label for="playlist-select"
                                class="mb-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Выберите плейлист
                            </label>

                            @if (Auth::check() && isset($playlists) && $playlists->count() > 0)
                                <div class="space-y-2 max-h-48 overflow-y-auto">
                                    @foreach ($playlists as $playlist)
                                        <label
                                            class="group relative flex cursor-pointer items-center rounded-xl border-2 border-gray-200 p-4 transition-all hover:border-primary-300 hover:bg-primary-50 dark:border-gray-600 dark:hover:border-primary-500 dark:hover:bg-primary-900/20">
                                            <input type="radio" name="playlist_id" value="{{ $playlist->id }}"
                                                class="h-4 w-4 border-gray-300 text-primary-600 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700"
                                                onchange="updateFormAction(this.value)">
                                            <div class="ml-3 flex-1">
                                                <div class="flex items-center justify-between">
                                                    <span
                                                        class="font-medium text-gray-900 dark:text-white">{{ $playlist->name }}</span>
                                                    <span
                                                        class="text-xs text-gray-500 dark:text-gray-400">{{ $playlist->tracks_count }}
                                                        треков</span>
                                                </div>
                                                @if ($playlist->description)
                                                    <p
                                                        class="mt-1 text-sm text-gray-600 dark:text-gray-400 line-clamp-1">
                                                        {{ $playlist->description }}</p>
                                                @endif
                                            </div>
                                            <div class="ml-3 opacity-0 transition-opacity group-hover:opacity-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-500"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M9 5l7 7-7 7" />
                                                </svg>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <div
                                    class="rounded-xl border-2 border-dashed border-gray-300 p-8 text-center dark:border-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">У вас пока нет плейлистов
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end">
                            <div class="flex space-x-3">
                                <button type="button" id="cancel-playlist-selector-btn"
                                    class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition-colors hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                                    Отмена
                                </button>
                                <button type="submit" id="add-to-playlist-submit"
                                    class="rounded-lg bg-gradient-to-r from-primary-600 to-purple-600 px-6 py-2 text-sm font-medium text-white shadow-lg transition-all hover:from-primary-700 hover:to-purple-700 hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
                                    disabled>
                                    <span class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                        Добавить
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Create New Playlist Form -->
                <div id="create-playlist-view" class="hidden">
                    <form id="create-playlist-form" action="{{ route('playlists.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="redirect_with_track_id" id="create-track-id-input"
                            value="">

                        <div class="space-y-4">
                            <div>
                                <label for="new-playlist-name"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Название плейлиста
                                </label>
                                <div class="relative">
                                    <input type="text" id="new-playlist-name" name="name"
                                        class="block w-full rounded-lg border-gray-300 pl-10 shadow-sm transition-colors focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                        placeholder="Мой новый плейлист" required>
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="new-playlist-description"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Описание <span class="text-gray-500">(необязательно)</span>
                                </label>
                                <textarea id="new-playlist-description" name="description" rows="3"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm transition-colors focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                    placeholder="Расскажите о вашем плейлисте..."></textarea>
                            </div>

                            <div class="flex items-center">
                                <div class="relative flex items-start">
                                    <div class="flex h-5 items-center">
                                        <input id="new-playlist-public" name="is_public" type="checkbox"
                                            class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="new-playlist-public"
                                            class="font-medium text-gray-700 dark:text-gray-300">
                                            Публичный плейлист
                                        </label>
                                        <p class="text-gray-500 dark:text-gray-400">Другие пользователи смогут найти и
                                            прослушать ваш плейлист</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-6 flex justify-between">
                            <button type="button" id="back-to-select-btn"
                                class="flex items-center rounded-lg px-4 py-2 text-sm font-medium text-gray-600 transition-colors hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                                Назад
                            </button>

                            <button type="submit"
                                class="flex items-center rounded-lg bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-2 text-sm font-medium text-white shadow-lg transition-all hover:from-green-700 hover:to-emerald-700 hover:shadow-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Создать и добавить
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Получаем элементы модального окна
        const playlistSelectorModal = document.getElementById('playlist-selector-modal');
        const playlistSelectionView = document.getElementById('playlist-selection-view');
        const createPlaylistView = document.getElementById('create-playlist-view');
        const addToPlaylistForm = document.getElementById('add-to-playlist-form');
        const createPlaylistForm = document.getElementById('create-playlist-form');
        const trackIdInput = document.getElementById('track-id-input');
        const createTrackIdInput = document.getElementById('create-track-id-input');
        const showCreatePlaylistBtn = document.getElementById('show-create-playlist-btn');
        const backToSelectBtn = document.getElementById('back-to-select-btn');
        const cancelPlaylistSelectorBtn = document.getElementById('cancel-playlist-selector-btn');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const addToPlaylistSubmit = document.getElementById('add-to-playlist-submit');

        // Функция для открытия модального окна
        window.openPlaylistSelector = function(trackId) {
            // Устанавливаем ID трека в скрытые поля форм
            if (trackIdInput) trackIdInput.value = trackId;
            if (createTrackIdInput) createTrackIdInput.value = trackId;

            // Отображаем модальное окно
            if (playlistSelectorModal) {
                playlistSelectorModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');

                // Анимация появления
                setTimeout(() => {
                    playlistSelectorModal.querySelector('.transform').classList.add('scale-100');
                }, 10);
            }

            // Показываем форму выбора плейлиста, скрываем форму создания
            showPlaylistSelection();
        }

        // Функция для показа выбора плейлиста
        function showPlaylistSelection() {
            if (playlistSelectionView) playlistSelectionView.classList.remove('hidden');
            if (createPlaylistView) createPlaylistView.classList.add('hidden');
        }

        // Функция для показа создания плейлиста
        function showCreatePlaylist() {
            if (playlistSelectionView) playlistSelectionView.classList.add('hidden');
            if (createPlaylistView) createPlaylistView.classList.remove('hidden');
        }

        // Функция для обновления action формы при выборе плейлиста
        window.updateFormAction = function(playlistId) {
            if (addToPlaylistForm && playlistId) {
                const newAction = addToPlaylistForm.action.replace('PLAYLIST_ID', playlistId);
                addToPlaylistForm.action = newAction;

                // Активируем кнопку отправки
                if (addToPlaylistSubmit) {
                    addToPlaylistSubmit.disabled = false;
                }
            }
        }

        // Функция для закрытия модального окна
        function closePlaylistSelector() {
            if (playlistSelectorModal) {
                // Анимация исчезновения
                playlistSelectorModal.querySelector('.transform').classList.remove('scale-100');

                setTimeout(() => {
                    playlistSelectorModal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }, 200);
            }

            // Сбрасываем формы
            if (addToPlaylistForm) {
                addToPlaylistForm.reset();
                if (addToPlaylistSubmit) addToPlaylistSubmit.disabled = true;
            }
            if (createPlaylistForm) createPlaylistForm.reset();

            // Возвращаемся к выбору плейлиста
            showPlaylistSelection();
        }

        // Обработчики событий
        if (showCreatePlaylistBtn) {
            showCreatePlaylistBtn.addEventListener('click', showCreatePlaylist);
        }

        if (backToSelectBtn) {
            backToSelectBtn.addEventListener('click', showPlaylistSelection);
        }

        if (cancelPlaylistSelectorBtn) {
            cancelPlaylistSelectorBtn.addEventListener('click', closePlaylistSelector);
        }

        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', closePlaylistSelector);
        }

        // Закрытие модального окна при клике вне его
        window.addEventListener('click', function(event) {
            if (event.target === playlistSelectorModal) {
                closePlaylistSelector();
            }
        });

        // Закрытие модального окна при нажатии Escape
        window.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && playlistSelectorModal && !playlistSelectorModal.classList
                .contains('hidden')) {
                closePlaylistSelector();
            }
        });

        // Обработка выбора плейлиста через radio buttons
        const playlistRadios = document.querySelectorAll('input[name="playlist_id"]');
        playlistRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    updateFormAction(this.value);
                }
            });
        });

        // Анимация для radio buttons
        playlistRadios.forEach(radio => {
            const label = radio.closest('label');
            if (label) {
                radio.addEventListener('change', function() {
                    // Убираем выделение со всех элементов
                    playlistRadios.forEach(r => {
                        const l = r.closest('label');
                        if (l) {
                            l.classList.remove('border-primary-500', 'bg-primary-50',
                                'dark:border-primary-400', 'dark:bg-primary-900/30');
                            l.classList.add('border-gray-200', 'dark:border-gray-600');
                        }
                    });

                    // Выделяем выбранный элемент
                    if (this.checked) {
                        label.classList.remove('border-gray-200', 'dark:border-gray-600');
                        label.classList.add('border-primary-500', 'bg-primary-50',
                            'dark:border-primary-400', 'dark:bg-primary-900/30');
                    }
                });
            }
        });
    });
</script>

<style>
    .transform {
        transform: scale(0.95);
        transition: transform 0.2s ease-out;
    }

    .scale-100 {
        transform: scale(1);
    }

    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
