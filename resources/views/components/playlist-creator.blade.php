<!-- Модальное окно для создания плейлиста -->
<div id="create-playlist-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75 dark:bg-gray-900"></div>
        </div>
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all dark:bg-gray-800 sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
            <form id="create-playlist-form" action="{{ route('playlists.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 dark:bg-gray-800 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 w-full text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white" id="modal-title">
                                Создать плейлист
                            </h3>
                            <div class="mt-4">
                                <div class="mb-4">
                                    <label for="playlist-name"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Название
                                        плейлиста</label>
                                    <input type="text" id="playlist-name" name="name"
                                        class="mt-1 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                                        placeholder="Введите название плейлиста" required>
                                </div>
                                <div class="mb-4">
                                    <label for="playlist-description"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Описание
                                        (необязательно)</label>
                                    <textarea id="playlist-description" name="description" rows="3"
                                        class="mt-1 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                                        placeholder="Добавьте описание плейлиста"></textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="playlist-cover"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Обложка
                                        плейлиста (необязательно)</label>
                                    <div class="mt-1 flex items-center">
                                        <div id="cover-preview"
                                            class="mr-3 h-20 w-20 overflow-hidden rounded-md bg-gray-200 dark:bg-gray-700">
                                            <div class="flex h-full w-full items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <label for="playlist-cover"
                                            class="cursor-pointer rounded-md bg-white px-3 py-2 text-sm font-medium text-primary-600 shadow-sm hover:text-primary-700 dark:bg-gray-700 dark:text-primary-400 dark:hover:text-primary-300">
                                            Загрузить
                                        </label>
                                        <input type="file" id="playlist-cover" name="cover_image" class="hidden"
                                            accept="image/*">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="playlist-public" name="is_public"
                                            class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700"
                                            checked>
                                        <label for="playlist-public"
                                            class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Публичный
                                            плейлист</label>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Публичные плейлисты видны
                                        всем пользователям, приватные - только вам.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 dark:bg-gray-700 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="submit"
                        class="inline-flex w-full justify-center rounded-lg bg-primary-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:bg-primary-700 dark:hover:bg-primary-600 sm:ml-3 sm:w-auto sm:text-sm">
                        Создать
                    </button>
                    <button type="button" id="cancel-playlist-creator-btn"
                        class="mt-3 inline-flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Отмена
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Модальное окно создания плейлиста
            const createPlaylistModal = document.getElementById('create-playlist-modal');
            const createNewPlaylistBtn = document.getElementById('create-new-playlist-btn');
            const openCreatePlaylistBtn = document.getElementById('open-create-playlist-btn');
            const cancelPlaylistCreatorBtn = document.getElementById('cancel-playlist-creator-btn');
            const playlistCoverInput = document.getElementById('playlist-cover');
            const coverPreview = document.getElementById('cover-preview');

            // Предпросмотр обложки
            if (playlistCoverInput && coverPreview) {
                playlistCoverInput.addEventListener('change', function(e) {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            coverPreview.innerHTML =
                                `<img src="${e.target.result}" class="h-full w-full object-cover" alt="Предпросмотр обложки">`;
                        }
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }

            // Открытие модального окна создания плейлиста
            if (createNewPlaylistBtn) {
                createNewPlaylistBtn.addEventListener('click', function() {
                    if (createPlaylistModal) {
                        createPlaylistModal.classList.remove('hidden');
                    }

                    const addToPlaylistModal = document.getElementById('add-to-playlist-modal');
                    if (addToPlaylistModal) {
                        addToPlaylistModal.classList.add('hidden');
                    }
                });
            }

            if (openCreatePlaylistBtn) {
                openCreatePlaylistBtn.addEventListener('click', function() {
                    if (createPlaylistModal) {
                        createPlaylistModal.classList.remove('hidden');
                    }
                });
            }

            // Закрытие модального окна создания плейлиста
            if (cancelPlaylistCreatorBtn && createPlaylistModal) {
                cancelPlaylistCreatorBtn.addEventListener('click', function() {
                    createPlaylistModal.classList.add('hidden');
                });
            }

            // Закрытие модального окна при клике вне его
            window.addEventListener('click', function(event) {
                if (event.target === createPlaylistModal) {
                    createPlaylistModal.classList.add('hidden');
                }
            });

            // Закрытие модального окна при нажатии Escape
            window.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && createPlaylistModal && !createPlaylistModal.classList
                    .contains('hidden')) {
                    createPlaylistModal.classList.add('hidden');
                }
            });
        });
    </script>
@endpush
