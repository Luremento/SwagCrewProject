import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", function () {
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
    themeToggle.addEventListener("click", function () {
        const isDark = document.documentElement.classList.contains("dark");

        if (isDark) {
            document.documentElement.classList.remove("dark");
            localStorage.setItem("theme", "light");
        } else {
            document.documentElement.classList.add("dark");
            localStorage.setItem("theme", "dark");
        }
    });
});
