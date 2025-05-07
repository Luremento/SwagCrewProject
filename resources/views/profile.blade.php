@extends('layouts.app')

@php
    function pluralRussian($count, $one, $few, $many)
    {
        $mod10 = $count % 10;
        $mod100 = $count % 100;
        if ($mod10 == 1 && $mod100 != 11) {
            return $one;
        } elseif ($mod10 >= 2 && $mod10 <= 4 && ($mod100 < 10 || $mod100 >= 20)) {
            return $few;
        } else {
            return $many;
        }
    }
    $followersCount = $user->followers->count();
    $followersLabel = pluralRussian($followersCount, 'подписчик', 'подписчика', 'подписчиков');
    $followingCount = $user->following->count();
    $followingLabel = pluralRussian($followingCount, 'подписка', 'подписки', 'подписок');
@endphp

@section('title', 'Профиль пользователя')

@section('content')
    <!-- Шапка профиля -->
    <div class="overflow-hidden rounded-3xl bg-white shadow-xl dark:bg-gray-800/80 dark:backdrop-blur-sm">
        <div class="relative">
            <!-- Фон профиля -->
            <div
                class="h-64 bg-gradient-to-r from-primary-600 via-primary-700 to-purple-800 dark:from-primary-800 dark:via-primary-900 dark:to-purple-900">
                <div class="absolute inset-0 opacity-10">
                    <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <defs>
                            <pattern id="profile-pattern" patternUnits="userSpaceOnUse" width="100" height="100"
                                patternTransform="rotate(45)">
                                <path d="M25,0 L25,100 M50,0 L50,100 M75,0 L75,100" stroke="currentColor"
                                    stroke-width="1" />
                                <circle cx="25" cy="25" r="1" fill stroke-width="1" />
                                <circle cx="25" cy="25" r="1" fill="currentColor" />
                                <circle cx="75" cy="75" r="1" fill="currentColor" />
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#profile-pattern)" />
                    </svg>
                </div>
            </div>

            <!-- Аватар и основная информация -->
            <div class="absolute bottom-0 left-0 transform translate-y-1/2 px-8">
                <div class="relative">
                    <div
                        class="relative h-36 w-36 overflow-hidden rounded-full border-4 border-white shadow-xl dark:border-gray-800">
                        @if ($user->avatar)
                            <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="Аватар"
                                class="h-full w-full object-cover">
                        @else
                            <img src="{{ asset('img/default-avatar.webp') }}" alt="Аватар"
                                class="h-full w-full object-cover">
                        @endif
                    </div>
                    @auth
                        @if (auth()->id() === $user->id)
                            <form action="{{ route('profile.avatar.upload') }}" method="POST" enctype="multipart/form-data"
                                id="avatar-upload-form">
                                @csrf
                                <input type="file" name="avatar" id="avatar-input" class="hidden" accept="image/*"
                                    onchange="document.getElementById('avatar-upload-form').submit();">
                                <label for="avatar-input"
                                    class="absolute bottom-3 right-3 flex h-10 w-10 cursor-pointer items-center justify-center rounded-full bg-primary-600 text-white shadow-lg transition-all duration-200 hover:bg-primary-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </label>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Информация о пользователе -->
            <div class="ml-48 pb-6 pt-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h1>
                <div class="mt-1 flex items-center">
                    <span
                        class="inline-flex items-center rounded-full bg-primary-600/90 px-3 py-1 text-sm font-medium text-white backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Проверенный музыкант
                    </span>
                </div>
            </div>

            <!-- Кнопки действий -->
            @auth
                <div class="absolute bottom-0 right-0 transform translate-y-1/2 px-8">
                    @if (auth()->id() === $user->id)
                        <a href="/"
                            class="group relative inline-flex overflow-hidden rounded-full bg-primary-600 px-6 py-3 font-medium text-white shadow-lg transition-all duration-300 hover:bg-primary-700">
                            <span class="relative z-10 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                Редактировать профиль
                            </span>
                        </a>
                    @else
                        <div class="flex space-x-3">
                            @if (Auth::user()->following->contains($user->id))
                                <form action="{{ route('unfollow', $user) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="rounded-full bg-gray-300 px-6 py-3 font-medium text-gray-800 hover:bg-gray-400 dark:bg-gray-600 dark:text-white dark:hover:bg-gray-500">
                                        Отписаться
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('follow', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="rounded-full bg-primary-600 px-6 py-3 font-medium text-white hover:bg-primary-700">
                                        Подписаться
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>
            @endauth
        </div>

        <!-- Статистика профиля -->
        <div class="mt-20 grid grid-cols-2 gap-4 px-8 py-6 sm:grid-cols-3 md:grid-cols-4">
            <div
                class="flex flex-col items-center rounded-xl bg-gray-50 p-4 transition-all duration-300 hover:bg-gray-100 dark:bg-gray-700/50 dark:hover:bg-gray-700">
                <div class="text-3xl font-bold text-primary-600 dark:text-primary-400">42</div>
                <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Трека</div>
            </div>
            <div
                class="flex flex-col items-center rounded-xl bg-gray-50 p-4 transition-all duration-300 hover:bg-gray-100 dark:bg-gray-700/50 dark:hover:bg-gray-700">
                <div class="text-3xl font-bold text-primary-600 dark:text-primary-400">{{ $followersCount }}</div>
                <div class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ $followersLabel }}</div>
            </div>
            <div
                class="flex flex-col items-center rounded-xl bg-gray-50 p-4 transition-all duration-300 hover:bg-gray-100 dark:bg-gray-700/50 dark:hover:bg-gray-700">
                <div class="text-3xl font-bold text-primary-600 dark:text-primary-400">{{ $followingCount }}</div>
                <div class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ $followingLabel }}</div>
            </div>
            <div
                class="flex flex-col items-center rounded-xl bg-gray-50 p-4 transition-all duration-300 hover:bg-gray-100 dark:bg-gray-700/50 dark:hover:bg-gray-700">
                <div class="text-3xl font-bold text-primary-600 dark:text-primary-400">18</div>
                <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Тем на форуме</div>
            </div>
        </div>

        <!-- Информация о пользователе -->
        <div class="border-t border-gray-200 px-8 py-8 dark:border-gray-700">
            @if ($user->bio)
                <h2 class="mb-6 text-2xl font-bold text-gray-900 dark:text-white">О себе</h2>
                <p class="mb-8 text-lg leading-relaxed text-gray-600 dark:text-gray-400">
                    {{ $user->bio }}
                </p>
            @endif

            <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                <div class="rounded-xl bg-gray-50 p-6 dark:bg-gray-700/30">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">Контакты</h3>
                    <ul class="space-y-3">
                        <li class="flex items-center text-gray-600 dark:text-gray-400">
                            <div
                                class="mr-3 flex h-10 w-10 items-center justify-center rounded-full bg-primary-100 text-primary-600 dark:bg-primary-900/50 dark:text-primary-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span class="text-lg">alex@example.com</span>
                        </li>
                        <li class="flex items-center text-gray-600 dark:text-gray-400">
                            <div
                                class="mr-3 flex h-10 w-10 items-center justify-center rounded-full bg-primary-100 text-primary-600 dark:bg-primary-900/50 dark:text-primary-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-lg">alexmusic.com</span>
                        </li>
                    </ul>
                </div>
                <div class="rounded-xl bg-gray-50 p-6 dark:bg-gray-700/30">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">Социальные сети</h3>
                    <div class="flex flex-wrap gap-4">
                        <a href="#"
                            class="flex h-12 w-12 items-center justify-center rounded-full bg-white text-gray-600 shadow-md transition-all duration-200 hover:-translate-y-1 hover:bg-primary-50 hover:text-primary-600 hover:shadow-lg dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-primary-400">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#"
                            class="flex h-12 w-12 items-center justify-center rounded-full bg-white text-gray-600 shadow-md transition-all duration-200 hover:-translate-y-1 hover:bg-primary-50 hover:text-primary-600 hover:shadow-lg dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-primary-400">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#"
                            class="flex h-12 w-12 items-center justify-center rounded-full bg-white text-gray-600 shadow-md transition-all duration-200 hover:-translate-y-1 hover:bg-primary-50 hover:text-primary-600 hover:shadow-lg dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-primary-400">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                        <a href="#"
                            class="flex h-12 w-12 items-center justify-center rounded-full bg-white text-gray-600 shadow-md transition-all duration-200 hover:-translate-y-1 hover:bg-primary-50 hover:text-primary-600 hover:shadow-lg dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-primary-400">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10c5.51 0 10-4.48 10-10S17.51 2 12 2zm6.605 4.61a8.502 8.502 0 011.93 5.314c-.281-.054-3.101-.629-5.943-.271-.065-.141-.12-.293-.184-.445a25.416 25.416 0 00-.564-1.236c3.145-1.28 4.577-3.124 4.761-3.362zM12 3.475c2.17 0 4.154.813 5.662 2.148-.152.216-1.443 1.941-4.48 3.08-1.399-2.57-2.95-4.675-3.189-5A8.687 8.687 0 0112 3.475zm-3.633.803a53.896 53.896 0 013.167 4.935c-3.992 1.063-7.517 1.04-7.896 1.04a8.581 8.581 0 014.729-5.975zM3.453 12.01v-.26c.37.01 4.512.065 8.775-1.215.25.477.477.965.694 1.453-.109.033-.228.065-.336.098-4.404 1.42-6.747 5.303-6.942 5.629a8.522 8.522 0 01-2.19-5.705zM12 20.547a8.482 8.482 0 01-5.239-1.8c.152-.315 1.888-3.656 6.703-5.337.022-.01.033-.01.054-.022a35.318 35.318 0 011.823 6.475 8.4 8.4 0 01-3.341.684zm4.761-1.465c-.086-.52-.542-3.015-1.659-6.084 2.679-.423 5.022.271 5.314.369a8.468 8.468 0 01-3.655 5.715z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Вкладки профиля -->
    <div class="mt-10">
        <div class="border-b border-gray-200 dark:border-gray-700">
            <nav class="-mb-px flex space-x-8">
                <a href="#"
                    class="border-primary-500 text-primary-600 dark:text-primary-400 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                    Треки
                </a>
                <a href="#"
                    class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:text-gray-300 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                    Темы на форуме
                </a>
                <a href="#"
                    class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:text-gray-300 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                    Плейлисты
                </a>
                <a href="#"
                    class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:border-gray-600 dark:hover:text-gray-300 whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                    Подписки
                </a>
            </nav>
        </div>

        <!-- Содержимое вкладки "Треки" -->
        <div class="mt-8">
            <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    <span class="relative">
                        Треки пользователя
                        <span class="absolute -bottom-1 left-0 h-1 w-1/2 rounded bg-primary-500"></span>
                    </span>
                </h2>
                <div class="flex items-center">
                    <span class="mr-3 text-gray-600 dark:text-gray-400">Сортировать:</span>
                    <select
                        class="rounded-full border-none bg-gray-100 px-4 py-2 text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-gray-300">
                        <option>Новые</option>
                        <option>Популярные</option>
                        <option>По рейтингу</option>
                    </select>
                </div>
            </div>

            <div class="space-y-6">
                <!-- Треки (цикл по 5) -->
                @php
                    $tracks = [
                        [
                            'title' => 'Ночной город',
                            'album' => 'Городские истории',
                            'rating' => '4.8',
                            'genres' => ['Электронная', 'Техно'],
                            'description' =>
                                'Атмосферный трек, вдохновленный ночными городскими пейзажами и неоновыми огнями. Глубокие басы и мелодичные синтезаторы создают ощущение движения по ночному городу.',
                            'plays' => '2.3K',
                            'likes' => '156',
                            'comments' => '42',
                            'date' => '12.03.2023',
                        ],
                        [
                            'title' => 'Летний бриз',
                            'album' => 'Времена года',
                            'rating' => '4.5',
                            'genres' => ['Электронная', 'Чилаут'],
                            'description' =>
                                'Легкий и воздушный трек, передающий атмосферу теплого летнего дня. Мягкие мелодии и расслабленный ритм создают ощущение безмятежности и спокойствия.',
                            'plays' => '1.8K',
                            'likes' => '124',
                            'comments' => '36',
                            'date' => '05.02.2023',
                        ],
                        [
                            'title' => 'Глубокий космос',
                            'album' => 'Космическая одиссея',
                            'rating' => '4.9',
                            'genres' => ['Электронная', 'Эмбиент'],
                            'description' =>
                                'Атмосферный эмбиент-трек, вдохновленный космическими пейзажами и глубинами вселенной. Плавные текстуры и пространственные звуки создают ощущение невесомости и бесконечности.',
                            'plays' => '3.2K',
                            'likes' => '218',
                            'comments' => '64',
                            'date' => '18.01.2023',
                        ],
                        [
                            'title' => 'Цифровой дождь',
                            'album' => 'Киберпанк',
                            'rating' => '4.7',
                            'genres' => ['Электронная', 'IDM'],
                            'description' =>
                                'Футуристический трек с глитч-элементами и сложными ритмическими структурами. Вдохновлен эстетикой киберпанка и научной фантастикой.',
                            'plays' => '1.5K',
                            'likes' => '98',
                            'comments' => '27',
                            'date' => '03.12.2022',
                        ],
                        [
                            'title' => 'Утренний свет',
                            'album' => 'Рассвет',
                            'rating' => '4.6',
                            'genres' => ['Электронная', 'Эмбиент'],
                            'description' =>
                                'Спокойный и медитативный трек, передающий атмосферу раннего утра. Нежные мелодии и мягкие текстуры создают ощущение пробуждения и нового начала.',
                            'plays' => '2.1K',
                            'likes' => '145',
                            'comments' => '38',
                            'date' => '22.11.2022',
                        ],
                    ];
                @endphp

                @foreach ($tracks as $track)
                    <div
                        class="group overflow-hidden rounded-2xl bg-white shadow-lg transition-all duration-300 hover:shadow-xl dark:bg-gray-800/80 dark:backdrop-blur-sm">
                        <div class="flex flex-col p-6 sm:flex-row sm:items-center">
                            <div
                                class="relative mb-6 aspect-square w-full overflow-hidden rounded-xl sm:mb-0 sm:mr-6 sm:w-48">
                                <img src="https://via.placeholder.com/300" alt="Обложка трека"
                                    class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div
                                    class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                    <button
                                        class="flex h-16 w-16 items-center justify-center rounded-full bg-primary-600/90 text-white shadow-lg backdrop-blur-sm transition-all duration-300 hover:scale-110 hover:bg-primary-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="mb-4 flex flex-wrap items-start justify-between gap-2">
                                    <div>
                                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $track['title'] }}
                                        </h3>
                                        <p class="mt-1 text-gray-600 dark:text-gray-400">Альбом: {{ $track['album'] }}</p>
                                    </div>
                                    <div
                                        class="flex items-center rounded-full bg-yellow-50 px-3 py-1 dark:bg-yellow-900/30">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <span
                                            class="ml-1 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $track['rating'] }}</span>
                                    </div>
                                </div>
                                <div class="mb-4 flex flex-wrap gap-2">
                                    @foreach ($track['genres'] as $genre)
                                        <span
                                            class="rounded-full bg-gray-100 px-3 py-1 text-sm font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-300">{{ $genre }}</span>
                                    @endforeach
                                </div>
                                <p class="mb-6 text-gray-600 line-clamp-2 dark:text-gray-400">
                                    {{ $track['description'] }}
                                </p>
                                <div class="flex flex-wrap items-center justify-between gap-4">
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center text-gray-500 dark:text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                            </svg>
                                            <span class="text-sm font-medium">{{ $track['plays'] }}</span>
                                        </div>
                                        <div class="flex items-center text-gray-500 dark:text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                            <span class="text-sm font-medium">{{ $track['likes'] }}</span>
                                        </div>
                                        <div class="flex items-center text-gray-500 dark:text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                            </svg>
                                            <span class="text-sm font-medium">{{ $track['comments'] }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Опубликовано:
                                            {{ $track['date'] }}</span>
                                        <div
                                            class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-500 transition-colors hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-400 dark:hover:bg-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Темы на форуме -->
            <div class="mt-16 mb-8">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white mb-8">
                    <span class="relative">
                        Темы на форуме
                        <span class="absolute -bottom-1 left-0 h-1 w-1/2 rounded bg-primary-500"></span>
                    </span>
                </h2>

                <div class="space-y-4">
                    @php
                        $topics = [
                            [
                                'title' => 'Как создать глубокий бас в техно-треках?',
                                'category' => 'Продакшн',
                                'replies' => '24',
                                'views' => '342',
                                'date' => '15.04.2023',
                                'is_pinned' => true,
                            ],
                            [
                                'title' => 'Обзор нового синтезатора Model X',
                                'category' => 'Оборудование',
                                'replies' => '18',
                                'views' => '256',
                                'date' => '02.04.2023',
                                'is_pinned' => false,
                            ],
                            [
                                'title' => 'Ищу музыкантов для совместного проекта',
                                'category' => 'Коллаборации',
                                'replies' => '32',
                                'views' => '478',
                                'date' => '28.03.2023',
                                'is_pinned' => false,
                            ],
                            [
                                'title' => 'Как продвигать свою музыку в 2023 году',
                                'category' => 'Маркетинг',
                                'replies' => '45',
                                'views' => '612',
                                'date' => '15.03.2023',
                                'is_pinned' => false,
                            ],
                            [
                                'title' => 'Лучшие плагины для мастеринга',
                                'category' => 'Продакшн',
                                'replies' => '29',
                                'views' => '387',
                                'date' => '05.03.2023',
                                'is_pinned' => false,
                            ],
                        ];
                    @endphp

                    @foreach ($topics as $topic)
                        <div
                            class="group rounded-xl bg-white p-5 shadow-md transition-all duration-300 hover:shadow-lg dark:bg-gray-800/80 dark:backdrop-blur-sm">
                            <div class="flex flex-wrap items-center justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                            <a href="#" class="hover:text-primary-600 dark:hover:text-primary-400">
                                                {{ $topic['title'] }}
                                            </a>
                                        </h3>
                                        @if ($topic['is_pinned'])
                                            <span
                                                class="inline-flex items-center rounded-full bg-primary-100 px-2.5 py-0.5 text-xs font-medium text-primary-800 dark:bg-primary-900/30 dark:text-primary-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-3 w-3"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                                </svg>
                                                Закреплено
                                            </span>
                                        @endif
                                    </div>
                                    <div class="mt-1 flex items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
                                        <span
                                            class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                            {{ $topic['category'] }}
                                        </span>
                                        <span>{{ $topic['date'] }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-6">
                                    <div class="flex items-center gap-1 text-gray-500 dark:text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                        </svg>
                                        <span class="text-sm">{{ $topic['replies'] }}</span>
                                    </div>
                                    <div class="flex items-center gap-1 text-gray-500 dark:text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span class="text-sm">{{ $topic['views'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Пагинация -->
            <div class="mt-10 flex justify-center">
                <nav class="inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                    <a href="#"
                        class="relative inline-flex items-center rounded-l-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700">
                        <span class="sr-only">Предыдущая</span>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" aria-current="page"
                        class="relative z-10 inline-flex items-center border border-primary-500 bg-primary-50 px-4 py-2 text-sm font-medium text-primary-600 dark:border-primary-500 dark:bg-primary-900/30 dark:text-primary-200">
                        1
                    </a>
                    <a href="#"
                        class="relative inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700">
                        2
                    </a>
                    <a href="#"
                        class="relative inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700">
                        3
                    </a>
                    <span
                        class="relative inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400">
                        ...
                    </span>
                    <a href="#"
                        class="relative inline-flex items-center rounded-r-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700">
                        <span class="sr-only">Следующая</span>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </nav>
            </div>
        </div>
    </div>
@endsection
