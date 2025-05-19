<div id="playlist-selector-modal" class="fixed inset-0 z-50 hidden overflow-y-auto"
    aria-labelledby="playlist-selector-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all dark:bg-gray-800 sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
            <div class="bg-white px-4 pt-5 pb-4 dark:bg-gray-800 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 w-full text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white"
                            id="playlist-selector-title">
                            Добавить трек в плейлист
                        </h3>
                        <div class="mt-4">
                            <!-- Форма для добавления трека в существующий плейлист -->
                            <form id="add-to-playlist-form"
                                action="{{ route('playlists.add-track', ['playlist' => 'PLAYLIST_ID']) }}"
                                method="POST">
                                @csrf
                                <input type="hidden" name="track_id" id="track-id-input" value="">

                                <div class="mb-4">
                                    <label for="playlist-select"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Выберите
                                        плейлист</label>
                                    <select id="playlist-select" name="playlist_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-primary-500 focus:outline-none focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                        onchange="updateFormAction(this.value)">
                                        <option value="">Выберите плейлист</option>
                                        @if (Auth::check() && isset($playlists))
                                            @foreach ($playlists as $playlist)
                                                <option value="{{ $playlist->id }}">{{ $playlist->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="mt-4 flex justify-end">
                                    <button type="button" id="cancel-playlist-selector-btn"
                                        class="mr-3 inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                                        Отмена
                                    </button>
                                    <button type="submit"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-primary-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-primary-700 dark:bg-primary-700 dark:hover:bg-primary-600">
                                        Добавить
                                    </button>
                                </div>
                            </form>

                            <div class="mt-4 flex items-center justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">или</span>
                                <button type="button" id="show-create-playlist-btn"
                                    class="text-sm font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300">
                                    Создать новый плейлист
                                </button>
                            </div>

                            <!-- Форма для создания нового плейлиста -->
                            <form id="create-playlist-form" action="{{ route('playlists.store') }}" method="POST"
                                class="mt-4 hidden">
                                @csrf
                                <input type="hidden" name="redirect_with_track_id" id="create-track-id-input"
                                    value="">

                                <div class="mb-4">
                                    <label for="new-playlist-name"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Название
                                        плейлиста</label>
                                    <input type="text" id="new-playlist-name" name="name"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                        placeholder="Введите название плейлиста" required>
                                </div>
                                <div class="mb-4">
                                    <label for="new-playlist-description"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Описание
                                        (необязательно)</label>
                                    <textarea id="new-playlist-description" name="description" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                                        placeholder="Введите описание плейлиста"></textarea>
                                </div>
                                <div class="flex items-center">
                                    <input id="new-playlist-public" name="is_public" type="checkbox"
                                        class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700">
                                    <label for="new-playlist-public"
                                        class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                        Сделать плейлист публичным
                                    </label>
                                </div>

                                <div class="mt-4 flex justify-end">
                                    <button type="button" id="back-to-select-btn"
                                        class="mr-3 inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                                        Назад
                                    </button>
                                    <button type="submit"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-primary-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-primary-700 dark:bg-primary-700 dark:hover:bg-primary-600">
                                        Создать и добавить
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Получаем элементы модального окна
        const playlistSelectorModal = document.getElementById('playlist-selector-modal');
        const addToPlaylistForm = document.getElementById('add-to-playlist-form');
        const createPlaylistForm = document.getElementById('create-playlist-form');
        const trackIdInput = document.getElementById('track-id-input');
        const createTrackIdInput = document.getElementById('create-track-id-input');
        const showCreatePlaylistBtn = document.getElementById('show-create-playlist-btn');
        const backToSelectBtn = document.getElementById('back-to-select-btn');
        const cancelPlaylistSelectorBtn = document.getElementById('cancel-playlist-selector-btn');

        // Функция для открытия модального окна
        window.openPlaylistSelector = function(trackId) {
            // Устанавливаем ID трека в скрытые поля форм
            if (trackIdInput) trackIdInput.value = trackId;
            if (createTrackIdInput) createTrackIdInput.value = trackId;

            // Отображаем модальное окно
            if (playlistSelectorModal) {
                playlistSelectorModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            // Показываем форму выбора плейлиста, скрываем форму создания
            if (addToPlaylistForm) addToPlaylistForm.classList.remove('hidden');
            if (createPlaylistForm) createPlaylistForm.classList.add('hidden');
        }

        // Функция для обновления action формы при выборе плейлиста
        window.updateFormAction = function(playlistId) {
            if (addToPlaylistForm && playlistId) {
                const newAction = addToPlaylistForm.action.replace('PLAYLIST_ID', playlistId);
                addToPlaylistForm.action = newAction;
            }
        }

        // Функция для закрытия модального окна
        function closePlaylistSelector() {
            if (playlistSelectorModal) {
                playlistSelectorModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            // Сбрасываем формы
            if (addToPlaylistForm) addToPlaylistForm.reset();
            if (createPlaylistForm) createPlaylistForm.reset();
        }

        // Обработчик для кнопки "Создать новый плейлист"
        if (showCreatePlaylistBtn) {
            showCreatePlaylistBtn.addEventListener('click', function() {
                if (addToPlaylistForm) addToPlaylistForm.classList.add('hidden');
                if (createPlaylistForm) createPlaylistForm.classList.remove('hidden');
            });
        }

        // Обработчик для кнопки "Назад"
        if (backToSelectBtn) {
            backToSelectBtn.addEventListener('click', function() {
                if (addToPlaylistForm) addToPlaylistForm.classList.remove('hidden');
                if (createPlaylistForm) createPlaylistForm.classList.add('hidden');
            });
        }

        // Обработчик для кнопки "Отмена"
        if (cancelPlaylistSelectorBtn) {
            cancelPlaylistSelectorBtn.addEventListener('click', closePlaylistSelector);
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
    });
</script>
