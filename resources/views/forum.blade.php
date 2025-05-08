@extends('layouts.app')

@section('title', 'Форум')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8">
        <!-- Заголовок форума для мобильных устройств (скрыт на десктопе) -->
        <div class="mb-6 block lg:hidden">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Форум музыкантов</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Обсуждения и советы для музыкантов</p>
        </div>

        <!-- Основной контент -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-[280px_1fr]">
            <!-- Боковая панель с категориями -->
            <div class="space-y-6">
                <!-- Кнопка создания темы -->
                <a href="{{ route('thread.create') }}"
                    class="group relative flex w-full items-center justify-center overflow-hidden rounded-xl bg-gradient-to-r from-primary-600 via-primary-700 to-purple-800 px-5 py-3 font-medium text-white shadow-lg transition-all duration-300 hover:shadow-xl dark:from-primary-700 dark:via-primary-800 dark:to-purple-900">
                    <span class="relative z-10 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Создать тред
                    </span>
                </a>

                <!-- Поиск -->
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text"
                        class="block w-full rounded-lg border border-gray-200 bg-gray-50 p-3 pl-10 text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder-gray-400"
                        placeholder="Поиск по форуму...">
                </div>

                <!-- Категории -->
                <div class="overflow-hidden rounded-xl bg-white shadow-md dark:bg-gray-800/80 dark:backdrop-blur-sm">
                    <div class="border-b border-gray-200 bg-gray-50 px-4 py-3 dark:border-gray-700 dark:bg-gray-800">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Категории</h3>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($categories as $item)
                            <a href="#"
                                class="flex items-center px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5 text-primary-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                </svg>
                                <span class="text-gray-900 dark:text-white">{{ $item->name }}</span>
                                <span
                                    class="ml-auto rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-300">{{ $item->threads->count() }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Основной контент с темами -->
            <div class="space-y-6">
                <!-- Заголовок и фильтры (только для десктопа) -->
                <div class="hidden items-center justify-between lg:flex">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Форум музыкантов</h1>
                    <div class="flex items-center gap-3">
                        <select
                            class="rounded-lg border border-gray-200 bg-gray-50 p-2 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="latest">Новые темы</option>
                            <option value="popular">Популярные</option>
                            <option value="most_viewed">Самые просматриваемые</option>
                            <option value="most_commented">Самые обсуждаемые</option>
                        </select>
                    </div>
                </div>

                <!-- Список тем -->
                <div class="overflow-hidden rounded-xl bg-white shadow-md dark:bg-gray-800/80 dark:backdrop-blur-sm">
                    <div class="border-b border-gray-200 bg-gray-50 px-6 py-3 dark:border-gray-700 dark:bg-gray-800"></div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        <!-- Темы -->
                        @foreach ($themes as $item)
                            <div class="flex items-center px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <div class="mr-4 flex-shrink-0">
                                    @if ($item->user->avatar)
                                        <img src="{{ asset('storage/avatars/' . $item->user->avatar) }}" alt="Аватар"
                                            class="h-10 w-10 rounded-full">
                                    @else
                                        <img src="{{ asset('img/default-avatar.webp') }}" alt="Аватар"
                                            class="h-10 w-10 rounded-full">
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center justify-between">
                                        <a href="{{ route('thread.show', $item->id) }}"
                                            class="truncate text-base font-medium text-gray-900 hover:text-primary-600 dark:text-white dark:hover:text-primary-400">
                                            {{ $item->title }}
                                        </a>
                                        <div
                                            class="ml-4 flex flex-shrink-0 items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
                                            <span class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                                </svg>
                                                86
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mt-1 flex items-center text-sm">
                                        <a href="{{ route('profile.index', $item->user->id) }}"
                                            class="truncate font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                                            {{ $item->user->name }}
                                        </a>
                                        <span class="mx-2 text-gray-500 dark:text-gray-400">•</span>
                                        <span class="text-gray-500 dark:text-gray-400">{{ $item->created_at }}</span>
                                        <div class="ml-2 flex">
                                            <span
                                                class="inline-flex items-center rounded-full bg-primary-50 px-2 py-0.5 text-xs font-medium text-primary-700 dark:bg-primary-900/30 dark:text-primary-400">
                                                {{ $item->category->name }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Пагинация -->
                <div class="mt-6 flex justify-center">
                    <nav class="flex items-center space-x-2">
                        <a href="#"
                            class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                            <span class="sr-only">Предыдущая</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <a href="#"
                            class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-medium text-white hover:bg-primary-700 dark:bg-primary-700 dark:hover:bg-primary-600">1</a>
                        <a href="#"
                            class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">2</a>
                        <a href="#"
                            class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">3</a>
                        <span
                            class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300">...</span>
                        <a href="#"
                            class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">8</a>
                        <a href="#"
                            class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                            <span class="sr-only">Следующая</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
