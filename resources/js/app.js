import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", () => {
    // Получаем кнопку переключения темы
    const themeToggle = document.getElementById("theme-toggle");

    // Проверяем, есть ли сохраненная тема в localStorage
    const savedTheme = localStorage.getItem("theme");
    const systemPrefersDark = window.matchMedia(
        "(prefers-color-scheme: dark)"
    ).matches;

    // Устанавливаем тему при загрузке страницы
    if (savedTheme === "dark" || (!savedTheme && systemPrefersDark)) {
        document.documentElement.classList.add("dark");
    } else {
        document.documentElement.classList.remove("dark");
    }

    // Обработчик клика по кнопке переключения темы
    if (themeToggle) {
        themeToggle.addEventListener("click", () => {
            const isDark = document.documentElement.classList.contains("dark");

            if (isDark) {
                document.documentElement.classList.remove("dark");
                localStorage.setItem("theme", "light");
            } else {
                document.documentElement.classList.add("dark");
                localStorage.setItem("theme", "dark");
            }
        });
    }

    // Инициализация модального окна выбора плейлиста
    initPlaylistSelector();

    // Добавляем обработчики для кнопок с тремя точками (track-options)
    document.addEventListener("click", (event) => {
        const trackOptionsButton = event.target.closest(".track-options");
        if (trackOptionsButton) {
            const trackId = trackOptionsButton.getAttribute("data-track-id");
            if (trackId) {
                openPlaylistSelector(trackId);
            }
        }
    });
});

// Функция для инициализации модального окна выбора плейлиста
function initPlaylistSelector() {
    const playlistSelector = document.getElementById("playlist-selector-modal");
    if (!playlistSelector) return;

    // Получаем элементы модального окна
    const closeBtn = document.getElementById("close-playlist-selector-btn");
    const cancelBtn = document.getElementById("cancel-playlist-selector-btn");
    const playlistsList = document.getElementById("playlists-list");
    const createPlaylistBtn = document.getElementById(
        "create-playlist-from-selector-btn"
    );

    // Закрытие модального окна
    if (closeBtn) {
        closeBtn.addEventListener("click", () => {
            playlistSelector.classList.add("hidden");
        });
    }

    if (cancelBtn) {
        cancelBtn.addEventListener("click", () => {
            playlistSelector.classList.add("hidden");
        });
    }

    // Закрытие по клику вне модального окна
    playlistSelector.addEventListener("click", (event) => {
        if (event.target === playlistSelector) {
            playlistSelector.classList.add("hidden");
        }
    });

    // Закрытие по нажатию Escape
    document.addEventListener("keydown", (event) => {
        if (
            event.key === "Escape" &&
            !playlistSelector.classList.contains("hidden")
        ) {
            playlistSelector.classList.add("hidden");
        }
    });

    // Открытие модального окна создания плейлиста
    if (createPlaylistBtn) {
        createPlaylistBtn.addEventListener("click", () => {
            playlistSelector.classList.add("hidden");
            const createPlaylistModal = document.getElementById(
                "create-playlist-modal"
            );
            if (createPlaylistModal) {
                createPlaylistModal.classList.remove("hidden");
            }
        });
    }
}

// Функция для открытия модального окна выбора плейлиста
function openPlaylistSelector(trackId) {
    const playlistSelector = document.getElementById("playlist-selector-modal");
    if (!playlistSelector) return;

    const playlistsList = document.getElementById("playlists-list");
    if (!playlistsList) return;

    // Очищаем список плейлистов
    playlistsList.innerHTML =
        '<div class="flex justify-center py-4"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div></div>';

    // Показываем модальное окно
    playlistSelector.classList.remove("hidden");

    // Устанавливаем ID трека в скрытое поле
    const trackIdInput = document.getElementById("playlist-selector-track-id");
    if (trackIdInput) {
        trackIdInput.value = trackId;
    }

    // Загружаем список плейлистов
    fetch("/playlists-list")
        .then((response) => {
            if (!response.ok) {
                throw new Error("Не удалось загрузить плейлисты");
            }
            return response.json();
        })
        .then((data) => {
            if (data.playlists && data.playlists.length > 0) {
                playlistsList.innerHTML = "";
                data.playlists.forEach((playlist) => {
                    const playlistItem = document.createElement("div");
                    playlistItem.className =
                        "flex items-center px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer";
                    playlistItem.innerHTML = `
            <div class="mr-3 h-10 w-10 flex-shrink-0 overflow-hidden rounded-md shadow-sm bg-gray-200 dark:bg-gray-700">
              ${
                  playlist.cover_image
                      ? `<img src="/storage/${playlist.cover_image}" alt="Обложка ${playlist.name}" class="h-full w-full object-cover">`
                      : `<div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-blue-500 to-cyan-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                    </svg>
                  </div>`
              }
            </div>
            <div>
              <span class="text-gray-900 dark:text-white">${
                  playlist.name
              }</span>
              <p class="text-xs text-gray-500 dark:text-gray-400">${
                  playlist.tracks_count
              } ${
                        playlist.tracks_count === 1
                            ? "трек"
                            : playlist.tracks_count >= 2 &&
                              playlist.tracks_count <= 4
                            ? "трека"
                            : "треков"
                    }</p>
            </div>
          `;

                    // Добавляем обработчик клика для добавления трека в плейлист
                    playlistItem.addEventListener("click", () => {
                        addTrackToPlaylist(trackId, playlist.id);
                    });

                    playlistsList.appendChild(playlistItem);
                });
            } else {
                playlistsList.innerHTML =
                    '<div class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">У вас пока нет плейлистов. Создайте свой первый плейлист!</div>';
            }
        })
        .catch((error) => {
            console.error("Ошибка при загрузке плейлистов:", error);
            playlistsList.innerHTML =
                '<div class="px-4 py-3 text-sm text-red-500 dark:text-red-400">Ошибка при загрузке плейлистов. Пожалуйста, попробуйте позже.</div>';
        });
}

// Функция для добавления трека в плейлист
function addTrackToPlaylist(trackId, playlistId) {
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    fetch(`/playlists/${playlistId}/add-track`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
        },
        body: JSON.stringify({ track_id: trackId }),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Не удалось добавить трек в плейлист");
            }
            return response.json();
        })
        .then((data) => {
            // Закрываем модальное окно
            const playlistSelector = document.getElementById(
                "playlist-selector-modal"
            );
            if (playlistSelector) {
                playlistSelector.classList.add("hidden");
            }

            // Показываем сообщение об успехе
            alert(data.message || "Трек успешно добавлен в плейлист");
        })
        .catch((error) => {
            console.error("Ошибка при добавлении трека в плейлист:", error);
            alert(
                "Ошибка при добавлении трека в плейлист. Пожалуйста, попробуйте позже."
            );
        });
}

// Делаем функцию доступной глобально
window.openPlaylistSelector = openPlaylistSelector;
