@extends('layouts.app')

@section('title', 'Главная страница')

@section('content')
    <!-- Главный баннер -->
    <div
        class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-primary-600 via-primary-700 to-purple-800 dark:from-primary-800 dark:via-primary-900 dark:to-purple-900">
        <div class="absolute inset-0 opacity-10">
            <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <defs>
                    <pattern id="hero-pattern" patternUnits="userSpaceOnUse" width="100" height="100"
                        patternTransform="rotate(45)">
                        <path d="M25,0 L25,100 M50,0 L50,100 M75,0 L75,100" stroke="currentColor" stroke-width="1" />
                        <circle cx="25" cy="25" r="1" fill="currentColor" />
                        <circle cx="75" cy="75" r="1" fill="currentColor" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#hero-pattern)" />
            </svg>
        </div>

        <div class="relative z-10 px-6 py-16 sm:px-12 lg:px-16">
            <div class="mx-auto max-w-7xl">
                <div class="grid items-center gap-12 lg:grid-cols-2">
                    <div class="max-w-2xl">
                        <h1 class="mb-6 text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl">
                            <span class="block">Делитесь своей</span>
                            <span
                                class="block bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">музыкой
                                с миром</span>
                        </h1>
                        <p class="mb-8 max-w-lg text-xl text-white/80">
                            Загружайте треки, общайтесь с другими музыкантами и получайте отзывы от сообщества. Ваша музыка
                            заслуживает быть услышанной.
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <a href="/"
                                class="group relative overflow-hidden rounded-full bg-white px-8 py-3 font-medium text-primary-600 shadow-lg transition-all duration-300 hover:bg-gray-100">
                                <span class="relative z-10">Начать сейчас</span>
                                <span
                                    class="absolute left-0 top-0 -z-10 h-full w-0 rounded-full bg-gradient-to-r from-primary-100 to-primary-50 transition-all duration-300 group-hover:w-full"></span>
                            </a>
                            <a href="/"
                                class="group relative overflow-hidden rounded-full bg-white/20 px-8 py-3 font-medium text-white shadow-lg backdrop-blur-sm transition-all duration-300 hover:bg-white/30">
                                <span class="relative z-10 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    </svg>
                                    Как это работает
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="relative hidden lg:block">
                        <div class="relative mx-auto aspect-square max-w-md overflow-hidden rounded-2xl shadow-2xl">
                            <img src="{{ asset('storage/' . $track->cover_image) }}" alt="Музыкальная платформа"
                                class="h-full w-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-xl font-bold text-white">{{ $track->title }}</h3>
                                        <p class="text-sm text-white/80">{{ $track->user->name }}</p>
                                    </div>
                                    <button
                                        class="flex h-12 w-12 items-center justify-center rounded-full bg-primary-600/90 text-white shadow-lg backdrop-blur-sm transition-all duration-300 hover:scale-110 hover:bg-primary-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="absolute -bottom-6 -left-12 h-64 w-64 rounded-full bg-purple-600/30 blur-3xl"></div>
                        <div class="absolute -right-12 -top-6 h-64 w-64 rounded-full bg-primary-600/30 blur-3xl"></div>
                    </div>
                </div>

                <!-- Статистика -->
                <div class="mt-16 grid grid-cols-2 gap-8 border-t border-white/20 pt-10 sm:grid-cols-4">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-white">10K+</div>
                        <div class="mt-2 text-sm text-white/70">Музыкантов</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-white">50K+</div>
                        <div class="mt-2 text-sm text-white/70">Треков</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-white">120K+</div>
                        <div class="mt-2 text-sm text-white/70">Прослушиваний</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-white">5K+</div>
                        <div class="mt-2 text-sm text-white/70">Обсуждений</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Популярные треки -->
    <div class="mt-20">
        <div class="mb-10 flex flex-wrap items-center justify-between gap-4">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                <span class="relative">
                    Популярные треки
                    <span class="absolute -bottom-1 left-0 h-1 w-1/2 rounded bg-primary-500"></span>
                </span>
            </h2>
            <a href="/"
                class="group flex items-center text-primary-600 transition-colors hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                <span>Смотреть все</span>
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="ml-1 h-5 w-5 transition-transform duration-300 group-hover:translate-x-1" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            <!-- Трек 1 -->
            <div
                class="group overflow-hidden rounded-2xl bg-white shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:bg-gray-800/80 dark:backdrop-blur-sm">
                <div class="relative">
                    <div class="aspect-square overflow-hidden">
                        <img src="https://via.placeholder.com/400" alt="Обложка трека"
                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">
                    </div>
                    <div
                        class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                        <button
                            class="flex h-16 w-16 items-center justify-center rounded-full bg-primary-600/90 text-white shadow-lg backdrop-blur-sm transition-all duration-300 hover:scale-110 hover:bg-primary-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            </svg>
                        </button>
                    </div>
                    <div
                        class="absolute right-3 top-3 flex items-center rounded-full bg-black/50 px-3 py-1 backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4 text-yellow-500" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <span class="text-sm font-medium text-white">4.9</span>
                    </div>
                </div>
                <div class="p-5">
                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Ночной город</h3>
                    <div class="mb-3 flex items-center">
                        <img src="https://via.placeholder.com/40" alt="Аватар" class="mr-3 h-8 w-8 rounded-full">
                        <a href="/"
                            class="text-sm font-medium text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400">Александр
                            Иванов</a>
                    </div>
                    <div class="mb-4 flex flex-wrap gap-2">
                        <span
                            class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-300">Электронная</span>
                        <span
                            class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-300">Техно</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-gray-500 dark:text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            </svg>
                            <span class="text-sm font-medium">2.3K</span>
                        </div>
                        <div class="flex items-center text-gray-500 dark:text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <span class="text-sm font-medium">156</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Трек 2 -->
            <div
                class="group overflow-hidden rounded-2xl bg-white shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:bg-gray-800/80 dark:backdrop-blur-sm">
                <div class="relative">
                    <div class="aspect-square overflow-hidden">
                        <img src="https://via.placeholder.com/400" alt="Обложка трека"
                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">
                    </div>
                    <div
                        class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                        <button
                            class="flex h-16 w-16 items-center justify-center rounded-full bg-primary-600/90 text-white shadow-lg backdrop-blur-sm transition-all duration-300 hover:scale-110 hover:bg-primary-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            </svg>
                        </button>
                    </div>
                    <div
                        class="absolute right-3 top-3 flex items-center rounded-full bg-black/50 px-3 py-1 backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4 text-yellow-500" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <span class="text-sm font-medium text-white">4.7</span>
                    </div>
                </div>
                <div class="p-5">
                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Летний бриз</h3>
                    <div class="mb-3 flex items-center">
                        <img src="https://via.placeholder.com/40" alt="Аватар" class="mr-3 h-8 w-8 rounded-full">
                        <a href="/"
                            class="text-sm font-medium text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400">Мария
                            Петрова</a>
                    </div>
                    <div class="mb-4 flex flex-wrap gap-2">
                        <span
                            class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-300">Электронная</span>
                        <span
                            class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-300">Чилаут</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-gray-500 dark:text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            </svg>
                            <span class="text-sm font-medium">1.8K</span>
                        </div>
                        <div class="flex items-center text-gray-500 dark:text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <span class="text-sm font-medium">124</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Трек 3 -->
            <div
                class="group overflow-hidden rounded-2xl bg-white shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:bg-gray-800/80 dark:backdrop-blur-sm">
                <div class="relative">
                    <div class="aspect-square overflow-hidden">
                        <img src="https://via.placeholder.com/400" alt="Обложка трека"
                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">
                    </div>
                    <div
                        class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                        <button
                            class="flex h-16 w-16 items-center justify-center rounded-full bg-primary-600/90 text-white shadow-lg backdrop-blur-sm transition-all duration-300 hover:scale-110 hover:bg-primary-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            </svg>
                        </button>
                    </div>
                    <div
                        class="absolute right-3 top-3 flex items-center rounded-full bg-black/50 px-3 py-1 backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4 text-yellow-500" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <span class="text-sm font-medium text-white">4.8</span>
                    </div>
                </div>
                <div class="p-5">
                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Глубокий космос</h3>
                    <div class="mb-3 flex items-center">
                        <img src="https://via.placeholder.com/40" alt="Аватар" class="mr-3 h-8 w-8 rounded-full">
                        <a href="/"
                            class="text-sm font-medium text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400">Дмитрий
                            Смирнов</a>
                    </div>
                    <div class="mb-4 flex flex-wrap gap-2">
                        <span
                            class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-300">Электронная</span>
                        <span
                            class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-300">Эмбиент</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-gray-500 dark:text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            </svg>
                            <span class="text-sm font-medium">3.2K</span>
                        </div>
                        <div class="flex items-center text-gray-500 dark:text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <span class="text-sm font-medium">218</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Трек 4 -->
            <div
                class="group overflow-hidden rounded-2xl bg-white shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:bg-gray-800/80 dark:backdrop-blur-sm">
                <div class="relative">
                    <div class="aspect-square overflow-hidden">
                        <img src="https://via.placeholder.com/400" alt="Обложка трека"
                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">
                    </div>
                    <div
                        class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                        <button
                            class="flex h-16 w-16 items-center justify-center rounded-full bg-primary-600/90 text-white shadow-lg backdrop-blur-sm transition-all duration-300 hover:scale-110 hover:bg-primary-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            </svg>
                        </button>
                    </div>
                    <div
                        class="absolute right-3 top-3 flex items-center rounded-full bg-black/50 px-3 py-1 backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4 text-yellow-500" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <span class="text-sm font-medium text-white">4.6</span>
                    </div>
                </div>
                <div class="p-5">
                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Городские ритмы</h3>
                    <div class="mb-3 flex items-center">
                        <img src="https://via.placeholder.com/40" alt="Аватар" class="mr-3 h-8 w-8 rounded-full">
                        <a href="/"
                            class="text-sm font-medium text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400">Елена
                            Козлова</a>
                    </div>
                    <div class="mb-4 flex flex-wrap gap-2">
                        <span
                            class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-300">Хип-хоп</span>
                        <span
                            class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-300">Инструментал</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-gray-500 dark:text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            </svg>
                            <span class="text-sm font-medium">1.9K</span>
                        </div>
                        <div class="flex items-center text-gray-500 dark:text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <span class="text-sm font-medium">142</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Популярные обсуждения -->
    <div class="mt-20">
        <div class="mb-10 flex flex-wrap items-center justify-between gap-4">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                <span class="relative">
                    Популярные обсуждения
                    <span class="absolute -bottom-1 left-0 h-1 w-1/2 rounded bg-primary-500"></span>
                </span>
            </h2>
            <a href="{{ route('forum.index') }}"
                class="group flex items-center text-primary-600 transition-colors hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                <span>Смотреть все</span>
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="ml-1 h-5 w-5 transition-transform duration-300 group-hover:translate-x-1" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>

        <div class="space-y-6">
            @foreach ($popularThreads as $item)
                <div
                    class="group overflow-hidden rounded-2xl bg-white shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:bg-gray-800/80 dark:backdrop-blur-sm">
                    <div class="p-6">
                        <div class="mb-4 flex items-center justify-between">
                            <div class="flex items-center">
                                @if ($item->user->avatar)
                                    <img src="{{ asset('storage/avatars/' . $item->user->avatar) }}" alt="Аватар"
                                        class="mr-3 h-10 w-10 rounded-full">
                                @else
                                    <img src="{{ asset('img/default-avatar.webp') }}" alt="Аватар"
                                        class="mr-3 h-10 w-10 rounded-full">
                                @endif
                                <div>
                                    <a href="{{ route('profile.index', $item->user->id) }}"
                                        class="font-medium text-gray-900 hover:text-primary-600 dark:text-white dark:hover:text-primary-400">{{ $item->user->name }}</a>
                                </div>
                            </div>
                            <div
                                class="flex items-center rounded-full bg-primary-50 px-3 py-1 text-primary-600 dark:bg-primary-900/30 dark:text-primary-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                                <span class="text-sm font-medium">{{ $item->category->name }}</span>
                            </div>
                        </div>
                        <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">
                            <a href="{{ route('thread.show', $item->id) }}"
                                class="hover:text-primary-600 dark:hover:text-primary-400">{{ $item->title }}</a>
                        </h3>
                        <p class="mb-4 text-gray-600 line-clamp-2 dark:text-gray-400">
                            {{ $item->content }}
                        </p>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($item->tags as $tag)
                                <span
                                    class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-300">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                        <div class="mt-6 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="flex items-center text-gray-500 dark:text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                    <span class="text-sm font-medium">{{ $item->comments_count }}</span>
                                </div>
                            </div>
                            <a href="{{ route('thread.show', $item->id) }}"
                                class="rounded-full bg-primary-50 px-4 py-2 text-sm font-medium text-primary-600 transition-colors hover:bg-primary-100 dark:bg-primary-900/30 dark:text-primary-400 dark:hover:bg-primary-900/50">
                                Присоединиться
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Присоединяйтесь к сообществу -->
    <div
        class="mt-20 rounded-3xl bg-gradient-to-r from-primary-600 via-primary-700 to-purple-800 dark:from-primary-800 dark:via-primary-900 dark:to-purple-900">
        <div class="relative overflow-hidden px-6 py-16 sm:px-12 lg:px-16">
            <div class="absolute inset-0 opacity-10">
                <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <defs>
                        <pattern id="join-pattern" patternUnits="userSpaceOnUse" width="100" height="100"
                            patternTransform="rotate(45)">
                            <path d="M25,0 L25,100 M50,0 L50,100 M75,0 L75,100" stroke="currentColor" stroke-width="1" />
                            <circle cx="25" cy="25" r="1" fill="currentColor" />
                            <circle cx="75" cy="75" r="1" fill="currentColor" />
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#join-pattern)" />
                </svg>
            </div>

            <div class="relative z-10 mx-auto max-w-4xl text-center">
                <h2 class="mb-6 text-4xl font-bold tracking-tight text-white sm:text-5xl">
                    Присоединяйтесь к сообществу музыкантов
                </h2>
                <p class="mb-10 text-xl text-white/80">
                    Создавайте, делитесь и обсуждайте музыку вместе с тысячами других музыкантов.
                    Регистрируйтесь сейчас и станьте частью нашего творческого сообщества.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="/"
                        class="group relative overflow-hidden rounded-full bg-white px-8 py-3 font-medium text-primary-600 shadow-lg transition-all duration-300 hover:bg-gray-100">
                        <span class="relative z-10">Зарегистрироваться</span>
                        <span
                            class="absolute left-0 top-0 -z-10 h-full w-0 rounded-full bg-gradient-to-r from-primary-100 to-primary-50 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="/"
                        class="group relative overflow-hidden rounded-full bg-white/20 px-8 py-3 font-medium text-white shadow-lg backdrop-blur-sm transition-all duration-300 hover:bg-white/30">
                        <span class="relative z-10">Узнать больше</span>
                    </a>
                </div>
            </div>

            <div class="absolute -bottom-24 -left-24 h-64 w-64 rounded-full bg-purple-600/30 blur-3xl"></div>
            <div class="absolute -right-24 -top-24 h-64 w-64 rounded-full bg-primary-600/30 blur-3xl"></div>
        </div>
    </div>
@endsection
