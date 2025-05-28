<footer class="mt-10 bg-gray-50 pt-16 dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 gap-8 pb-12 md:grid-cols-2 lg:grid-cols-4">
            <!-- Логотип и описание -->
            <div>
                <div class="flex items-center">
                    <svg class="h-10 w-10 text-primary-600 dark:text-primary-400" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="ml-2 text-xl font-bold text-gray-900 dark:text-white">MusicHub</span>
                </div>
                <p class="mt-4 text-gray-600 dark:text-gray-400">
                    Платформа для музыкантов и любителей музыки. Делитесь своими треками, обсуждайте музыкальные темы и
                    находите единомышленников.
                </p>
            </div>

            <!-- Навигация -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Навигация</h3>
                <ul class="mt-4 space-y-3">
                    <li>
                        <a href="{{ route('index') }}"
                            class="text-gray-600 transition-colors hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400">Главная</a>
                    </li>
                    <li>
                        <a href="{{ route('tracks.index') }}"
                            class="text-gray-600 transition-colors hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400">Треки</a>
                    </li>
                    <li>
                        <a href="{{ route('forum.index') }}"
                            class="text-gray-600 transition-colors hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400">Форум</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Нижняя часть футера -->
        <div class="border-t border-gray-200 py-6 dark:border-gray-800">
            <div class="flex flex-col items-center justify-between space-y-4 sm:flex-row sm:space-y-0">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    &copy; 2023 MusicHub. Все права защищены.
                </p>
                <div class="flex space-x-6">
                    <a href="/"
                        class="text-sm text-gray-600 transition-colors hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400">
                        Условия использования
                    </a>
                    <a href="/"
                        class="text-sm text-gray-600 transition-colors hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400">
                        Политика конфиденциальности
                    </a>
                    <a href="/"
                        class="text-sm text-gray-600 transition-colors hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400">
                        Помощь
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
