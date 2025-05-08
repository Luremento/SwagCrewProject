@extends('layouts.app')

@section('title', 'Какое оборудование лучше для домашней студии?')

@section('content')
    <div class="mx-auto max-w-5xl py-8">
        <!-- Навигация -->
        <div class="mb-6">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="/"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Главная
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <a href="{{ route('forum.index') }}"
                                class="ml-1 text-sm font-medium text-gray-700 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white md:ml-2">
                                Форум
                            </a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400 md:ml-2">
                                Какое оборудование лучше для домашней студии?
                            </span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Основная тема -->
        <div class="overflow-hidden rounded-xl bg-white shadow-lg dark:bg-gray-800/80 dark:backdrop-blur-sm">
            <div class="p-6">
                <div class="mb-6 flex items-center justify-between">
                    <div class="flex items-center">
                        <img src="https://via.placeholder.com/40" alt="Аватар" class="mr-3 h-10 w-10 rounded-full">
                        <div>
                            <a href="#"
                                class="font-medium text-gray-900 hover:text-primary-600 dark:text-white dark:hover:text-primary-400">
                                Александр Иванов
                            </a>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Опубликовано 2 дня назад</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div
                            class="flex items-center rounded-full bg-primary-50 px-3 py-1 text-primary-600 dark:bg-primary-900/30 dark:text-primary-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                            <span class="text-sm font-medium">Обсуждение</span>
                        </div>
                        <button
                            class="rounded-full p-2 text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <h1 class="mb-4 text-2xl font-bold text-gray-900 dark:text-white">
                    Какое оборудование лучше для домашней студии?
                </h1>
                <div class="mb-6 flex flex-wrap gap-2">
                    <span
                        class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                        Оборудование
                    </span>
                    <span
                        class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                        Студия
                    </span>
                    <span
                        class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                        Запись
                    </span>
                </div>

                <!-- Прикрепленный трек -->
                <div class="mb-6 rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800">
                    <div class="flex items-center">
                        <div class="mr-4 flex-shrink-0">
                            <div class="relative h-16 w-16 overflow-hidden rounded-md bg-gray-200 dark:bg-gray-700">
                                <img src="https://via.placeholder.com/64" alt="Обложка трека"
                                    class="h-full w-full object-cover">
                                <button
                                    class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 opacity-0 transition-opacity hover:opacity-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Название трека</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Исполнитель</p>
                            <div class="mt-2 flex items-center">
                                <div class="flex items-center">
                                    <button
                                        class="mr-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                    <div class="w-48 rounded-full bg-gray-200 dark:bg-gray-700">
                                        <div class="h-1.5 w-1/3 rounded-full bg-primary-600 dark:bg-primary-500"></div>
                                    </div>
                                    <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">1:23 / 3:45</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Прикрепленные файлы -->
                <div class="mb-6 rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800">
                    <h3 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">Прикрепленные файлы:</h3>
                    <div class="space-y-2">
                        <div class="flex items-center rounded-lg bg-white p-2 dark:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5 text-gray-500 dark:text-gray-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                            </svg>
                            <span class="mr-2 text-sm text-gray-700 dark:text-gray-300">example-audio.mp3</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">(2.4 MB)</span>
                            <a href="#"
                                class="ml-auto rounded-full p-1 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </a>
                        </div>
                        <div class="flex items-center rounded-lg bg-white p-2 dark:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5 text-gray-500 dark:text-gray-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="mr-2 text-sm text-gray-700 dark:text-gray-300">studio-setup.pdf</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">(1.2 MB)</span>
                            <a href="#"
                                class="ml-auto rounded-full p-1 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="prose max-w-none dark:prose-invert">
                    <p>
                        Привет всем! Я начинающий музыкант и хочу собрать домашнюю студию для записи вокала и гитары. Какие
                        микрофоны, аудиоинтерфейсы и мониторы посоветуете? Бюджет ограничен, но хочется получить достойное
                        качество звука.
                    </p>
                    <p>
                        Я уже изучил некоторые варианты, но информации так много, что сложно сделать выбор. Особенно
                        интересуют:
                    </p>
                    <ul>
                        <li>Микрофоны для записи вокала и акустической гитары</li>
                        <li>Аудиоинтерфейсы начального уровня с хорошими предусилителями</li>
                        <li>Мониторные наушники для сведения</li>
                        <li>Студийные мониторы (если останется бюджет)</li>
                    </ul>
                    <p>
                        Буду благодарен за любые советы и рекомендации от опытных музыкантов!
                    </p>
                </div>
                <div class="mt-6 flex items-center justify-between border-t border-gray-200 pt-6 dark:border-gray-700">
                    <div class="flex items-center gap-4">
                        <button
                            class="flex items-center text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                            </svg>
                            <span class="text-sm font-medium">42</span>
                        </button>
                        <button
                            class="flex items-center text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.095c.5 0 .905-.405.905-.905 0-.714.211-1.412.608-2.006L17 13V4m-7 10h2" />
                            </svg>
                            <span class="text-sm font-medium">3</span>
                        </button>
                        <button
                            class="flex items-center text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                            </svg>
                            <span class="text-sm font-medium">Поделиться</span>
                        </button>
                    </div>
                    <button
                        class="flex items-center text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                        <span class="text-sm font-medium">Сохранить</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Комментарии -->
        <div class="mt-8">
            <h2 class="mb-6 text-xl font-bold text-gray-900 dark:text-white">Комментарии (8)</h2>

            <div class="space-y-6">
                <!-- Комментарий 1 -->
                <div class="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800/80 dark:backdrop-blur-sm">
                    <div class="mb-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <img src="https://via.placeholder.com/40" alt="Аватар" class="mr-3 h-10 w-10 rounded-full">
                            <div>
                                <a href="#"
                                    class="font-medium text-gray-900 hover:text-primary-600 dark:text-white dark:hover:text-primary-400">
                                    Мария Петрова
                                </a>
                                <p class="text-sm text-gray-500 dark:text-gray-400">2 дня назад</p>
                            </div>
                        </div>
                        <button
                            class="rounded-full p-2 text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                            </svg>
                        </button>
                    </div>

                    <!-- Прикрепленный трек в комментарии -->
                    <div
                        class="mb-4 rounded-lg border border-gray-200 bg-gray-50 p-3 dark:border-gray-700 dark:bg-gray-700">
                        <div class="flex items-center">
                            <div class="mr-3 flex-shrink-0">
                                <div class="relative h-12 w-12 overflow-hidden rounded-md bg-gray-200 dark:bg-gray-600">
                                    <img src="https://via.placeholder.com/48" alt="Обложка трека"
                                        class="h-full w-full object-cover">
                                    <button
                                        class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 opacity-0 transition-opacity hover:opacity-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Пример звучания микрофона
                                    Rode NT1-A</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Мария Петрова</p>
                                <div class="mt-1 flex items-center">
                                    <button
                                        class="mr-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                        </svg>
                                    </button>
                                    <div class="w-32 rounded-full bg-gray-200 dark:bg-gray-600">
                                        <div class="h-1 w-1/2 rounded-full bg-primary-600 dark:bg-primary-500"></div>
                                    </div>
                                    <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">0:45 / 1:30</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="prose max-w-none dark:prose-invert">
                        <p>
                            Привет! Я недавно собрала домашнюю студию, могу поделиться опытом. Для начала рекомендую:
                        </p>
                        <ul>
                            <li><strong>Микрофон:</strong> Rode NT1-A или Audio-Technica AT2020 - оба отличные варианты для
                                начинающих.</li>
                            <li><strong>Аудиоинтерфейс:</strong> Focusrite Scarlett 2i2 или PreSonus AudioBox USB - надежные
                                и доступные.</li>
                            <li><strong>Наушники:</strong> Audio-Technica ATH-M50x или Beyerdynamic DT 770 Pro - хороший
                                звук для мониторинга.</li>
                        </ul>
                        <p>
                            Начни с этого набора, а потом уже можно думать о мониторах и акустической обработке помещения.
                        </p>
                    </div>

                    <!-- Прикрепленные файлы в комментарии -->
                    <div
                        class="mt-4 rounded-lg border border-gray-200 bg-gray-50 p-3 dark:border-gray-700 dark:bg-gray-700">
                        <div class="flex items-center rounded-lg bg-white p-2 dark:bg-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4 text-gray-500 dark:text-gray-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="mr-2 text-xs text-gray-700 dark:text-gray-300">microphone-comparison.pdf</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">(850 KB)</span>
                            <a href="#"
                                class="ml-auto rounded-full p-1 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-500 dark:hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="mt-4 flex items-center gap-4">
                        <button
                            class="flex items-center text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                            </svg>
                            <span class="text-sm font-medium">18</span>
                        </button>
                        <button
                            class="text-sm font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                            Ответить
                        </button>
                    </div>
                </div>

                <!-- Форма добавления комментария -->
                <div class="rounded-xl bg-white p-6 shadow-lg dark:bg-gray-800/80 dark:backdrop-blur-sm">
                    <h3 class="mb-4 text-lg font-bold text-gray-900 dark:text-white">Добавить комментарий</h3>
                    <form action="#" method="POST" enctype="multipart/form-data">
                        <div class="mb-4">
                            <div
                                class="mb-2 flex rounded-t-lg border border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-800">
                                <button type="button"
                                    class="p-2 text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16m-7 6h7" />
                                    </svg>
                                </button>
                                <button type="button"
                                    class="p-2 text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </button>
                                <button type="button"
                                    class="p-2 text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </button>
                            </div>
                            <textarea rows="4"
                                class="block w-full rounded-b-lg border border-gray-200 bg-white p-4 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                                placeholder="Напишите ваш комментарий..."></textarea>
                        </div>

                        <!-- Прикрепить трек к комментарию -->
                        <div class="mb-4">
                            <button type="button"
                                class="flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                </svg>
                                Прикрепить трек
                            </button>
                        </div>

                        <!-- Прикрепить файлы к комментарию -->
                        <div class="mb-4">
                            <button type="button"
                                class="flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                                Прикрепить файлы
                            </button>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="rounded-lg bg-primary-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-700 dark:hover:bg-primary-600 dark:focus:ring-primary-800">
                                Отправить комментарий
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Функционал для воспроизведения треков
            const playButtons = document.querySelectorAll('.relative button');

            playButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Здесь должна быть логика воспроизведения трека
                    console.log('Воспроизведение трека');
                });
            });

            // Модальное окно для прикрепления трека к комментарию
            const attachTrackButton = document.querySelector('button:contains("Прикрепить трек")');
            if (attachTrackButton) {
                attachTrackButton.addEventListener('click', function() {
                    // Здесь должна быть логика открытия модального окна для поиска треков
                    console.log('Открытие модального окна для поиска треков');
                });
            }

            // Модальное окно для прикрепления файлов к комментарию
            const attachFilesButton = document.querySelector('button:contains("Прикрепить файлы")');
            if (attachFilesButton) {
                attachFilesButton.addEventListener('click', function() {
                    // Здесь должна быть логика открытия модального окна для загрузки файлов
                    console.log('Открытие модального окна для загрузки файлов');
                });
            }
        });
    </script>
@endsection
