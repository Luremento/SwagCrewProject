<!-- Модальное окно для редактирования плейлиста -->
<div id="edit-playlist-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75 dark:bg-gray-900"></div>
        </div>
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all dark:bg-gray-800 sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
            <form action="{{ route('playlists.update', $playlist->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="bg-white px-4 pt-5 pb-4 dark:bg-gray-800 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 w-full text-center sm:mt-0 sm:text-left">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white" id="modal-title">
                                Редактировать плейлист
                            </h3>
                            <div class="mt-4 space-y-4">
                                <!-- Название плейлиста -->
                                <div>
                                    <label for="name"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Название плейлиста
                                    </label>
                                    <input type="text" name="name" id="name" value="{{ $playlist->name }}"
                                        required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">
                                </div>

                                <!-- Описание плейлиста -->
                                <div>
                                    <label for="description"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Описание (необязательно)
                                    </label>
                                    <textarea name="description" id="description" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">{{ $playlist->description }}</textarea>
                                </div>

                                <!-- Обложка плейлиста -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Обложка плейлиста
                                    </label>
                                    <div class="mt-1 flex items-center">
                                        <div class="h-24 w-24 overflow-hidden rounded-md bg-gray-100 dark:bg-gray-700">
                                            @if ($playlist->cover_image)
                                                <img src="{{ asset('storage/' . $playlist->cover_image) }}"
                                                    alt="Обложка плейлиста" class="h-full w-full object-cover"
                                                    id="cover-preview">
                                            @else
                                                <div class="flex h-full w-full items-center justify-center bg-gray-200 dark:bg-gray-700"
                                                    id="cover-placeholder">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                                <img src="/placeholder.svg" alt="Предпросмотр обложки"
                                                    class="hidden h-full w-full object-cover" id="cover-preview">
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="relative">
                                                <input type="file" name="cover_image" id="cover_image"
                                                    accept="image/*"
                                                    class="absolute inset-0 h-full w-full cursor-pointer opacity-0">
                                                <label for="cover_image"
                                                    class="inline-flex cursor-pointer items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                                                    Выбрать файл
                                                </label>
                                            </div>
                                            @if ($playlist->cover_image)
                                                <div class="mt-2">
                                                    <label class="inline-flex items-center">
                                                        <input type="checkbox" name="remove_cover"
                                                            class="rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700">
                                                        <span
                                                            class="ml-2 text-sm text-gray-600 dark:text-gray-400">Удалить
                                                            обложку</span>
                                                    </label>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Приватность плейлиста -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Приватность
                                    </label>
                                    <div class="mt-2 space-y-2">
                                        <div class="flex items-center">
                                            <input type="radio" id="is_public_true" name="is_public" value="1"
                                                {{ $playlist->is_public ? 'checked' : '' }}
                                                class="h-4 w-4 border-gray-300 text-primary-600 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700">
                                            <label for="is_public_true"
                                                class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                                Публичный (виден всем)
                                            </label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" id="is_public_false" name="is_public" value="0"
                                                {{ !$playlist->is_public ? 'checked' : '' }}
                                                class="h-4 w-4 border-gray-300 text-primary-600 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700">
                                            <label for="is_public_false"
                                                class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                                Приватный (виден только вам)
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 dark:bg-gray-700 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="submit"
                        class="inline-flex w-full justify-center rounded-lg bg-primary-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:bg-primary-700 dark:hover:bg-primary-600 sm:ml-3 sm:w-auto sm:text-sm">
                        Сохранить
                    </button>
                    <button type="button" id="cancel-edit-playlist-btn"
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
            // Модальное окно редактирования плейлиста
            const editPlaylistModal = document.getElementById('edit-playlist-modal');
            const editPlaylistBtn = document.getElementById('edit-playlist-btn');
            const cancelEditPlaylistBtn = document.getElementById('cancel-edit-playlist-btn');

            // Открытие модального окна редактирования плейлиста
            if (editPlaylistBtn) {
                editPlaylistBtn.addEventListener('click', function() {
                    if (editPlaylistModal) {
                        editPlaylistModal.classList.remove('hidden');
                    }
                });
            }

            // Закрытие модального окна редактирования плейлиста
            if (cancelEditPlaylistBtn) {
                cancelEditPlaylistBtn.addEventListener('click', function() {
                    if (editPlaylistModal) {
                        editPlaylistModal.classList.add('hidden');
                    }
                });
            }

            // Предпросмотр обложки плейлиста
            const coverInput = document.getElementById('cover_image');
            const coverPreview = document.getElementById('cover-preview');
            const coverPlaceholder = document.getElementById('cover-placeholder');

            if (coverInput && coverPreview) {
                coverInput.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            coverPreview.src = e.target.result;
                            coverPreview.classList.remove('hidden');
                            if (coverPlaceholder) {
                                coverPlaceholder.classList.add('hidden');
                            }
                        };

                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }
        });
    </script>
@endpush
