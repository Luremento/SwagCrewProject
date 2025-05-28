<!-- Модальное окно для создания плейлиста -->
<div id="create-playlist-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75 dark:bg-gray-900"></div>
        </div>
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all dark:bg-gray-800 sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">

            <!-- Добавляем индикатор загрузки -->
            <div id="playlist-loading"
                class="hidden absolute inset-0 bg-white bg-opacity-75 dark:bg-gray-800 dark:bg-opacity-75 flex items-center justify-center z-10">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div>
            </div>

            <form id="create-playlist-form" action="{{ route('playlists.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <!-- ИСПРАВЛЕНИЕ: Добавляем скрытое поле для redirect_with_track_id -->
                <input type="hidden" id="redirect-with-track-id" name="redirect_with_track_id" value="">

                <div class="bg-white px-4 pt-5 pb-4 dark:bg-gray-800 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 w-full text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white" id="modal-title">
                                Создать плейлист
                            </h3>

                            <!-- Контейнер для ошибок -->
                            <div id="playlist-errors"
                                class="hidden mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded dark:bg-red-900 dark:border-red-600 dark:text-red-200">
                                <ul id="playlist-errors-list"></ul>
                            </div>

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
                                        <!-- ИСПРАВЛЕНИЕ: Добавляем value="1" для чекбокса -->
                                        <input type="checkbox" id="playlist-public" name="is_public" value="1"
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
                    <button type="submit" id="create-playlist-submit"
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
            const createPlaylistForm = document.getElementById('create-playlist-form');
            const playlistLoading = document.getElementById('playlist-loading');
            const playlistErrors = document.getElementById('playlist-errors');
            const playlistErrorsList = document.getElementById('playlist-errors-list');

            // Функция для показа ошибок
            function showErrors(errors) {
                playlistErrorsList.innerHTML = '';
                Object.keys(errors).forEach(key => {
                    errors[key].forEach(error => {
                        const li = document.createElement('li');
                        li.textContent = error;
                        playlistErrorsList.appendChild(li);
                    });
                });
                playlistErrors.classList.remove('hidden');
            }

            // Функция для скрытия ошибок
            function hideErrors() {
                playlistErrors.classList.add('hidden');
                playlistErrorsList.innerHTML = '';
            }

            // Функция для сброса формы
            function resetForm() {
                createPlaylistForm.reset();
                hideErrors();
                // Сброс предпросмотра обложки
                coverPreview.innerHTML = `
                    <div class="flex h-full w-full items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 002 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                `;
            }

            // ИСПРАВЛЕНИЕ: Обработка отправки формы через AJAX
            if (createPlaylistForm) {
                createPlaylistForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    hideErrors();
                    playlistLoading.classList.remove('hidden');

                    const formData = new FormData(this);

                    fetch(this.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            playlistLoading.classList.add('hidden');

                            if (data.success) {
                                // Успешное создание
                                createPlaylistModal.classList.add('hidden');
                                resetForm();

                                // Показываем уведомление об успехе
                                if (typeof showNotification === 'function') {
                                    showNotification(data.message, 'success');
                                } else {
                                    alert(data.message);
                                }

                                // Перенаправляем или обновляем страницу
                                if (data.redirect_url) {
                                    window.location.href = data.redirect_url;
                                } else {
                                    window.location.reload();
                                }
                            } else if (data.errors) {
                                showErrors(data.errors);
                            }
                        })
                        .catch(error => {
                            playlistLoading.classList.add('hidden');
                            console.error('Error:', error);
                            alert('Произошла ошибка при создании плейлиста');
                        });
                });
            }

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
            function openCreatePlaylistModal(trackId = null) {
                if (createPlaylistModal) {
                    // Устанавливаем ID трека, если передан
                    if (trackId) {
                        document.getElementById('redirect-with-track-id').value = trackId;
                    }

                    createPlaylistModal.classList.remove('hidden');
                    resetForm();

                    // Фокус на поле названия
                    setTimeout(() => {
                        document.getElementById('playlist-name').focus();
                    }, 100);
                }

                const addToPlaylistModal = document.getElementById('add-to-playlist-modal');
                if (addToPlaylistModal) {
                    addToPlaylistModal.classList.add('hidden');
                }
            }

            if (createNewPlaylistBtn) {
                createNewPlaylistBtn.addEventListener('click', function() {
                    const trackId = this.dataset.trackId || null;
                    openCreatePlaylistModal(trackId);
                });
            }

            if (openCreatePlaylistBtn) {
                openCreatePlaylistBtn.addEventListener('click', function() {
                    openCreatePlaylistModal();
                });
            }

            // Закрытие модального окна создания плейлиста
            if (cancelPlaylistCreatorBtn && createPlaylistModal) {
                cancelPlaylistCreatorBtn.addEventListener('click', function() {
                    createPlaylistModal.classList.add('hidden');
                    resetForm();
                });
            }

            // Закрытие модального окна при клике вне его
            window.addEventListener('click', function(event) {
                if (event.target === createPlaylistModal) {
                    createPlaylistModal.classList.add('hidden');
                    resetForm();
                }
            });

            // Закрытие модального окна при нажатии Escape
            window.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && createPlaylistModal && !createPlaylistModal.classList
                    .contains('hidden')) {
                    createPlaylistModal.classList.add('hidden');
                    resetForm();
                }
            });

            // Глобальная функция для открытия модального окна (может использоваться из других скриптов)
            window.openCreatePlaylistModal = openCreatePlaylistModal;
        });
    </script>
@endpush
