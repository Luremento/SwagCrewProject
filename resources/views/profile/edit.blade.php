@extends('layouts.app')

@section('title', 'Редактирование профиля')

@section('content')
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
                        @if (auth()->user()->avatar)
                            <img src="{{ asset('storage/avatars/' . auth()->user()->avatar) }}" alt="Аватар"
                                class="h-full w-full object-cover">
                        @else
                            <img src="{{ asset('img/default-avatar.webp') }}" alt="Аватар"
                                class="h-full w-full object-cover">
                        @endif
                    </div>
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
                </div>
            </div>

            <!-- Информация о пользователе -->
            <div class="ml-48 pb-6 pt-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Редактирование профиля</h1>
                <div class="mt-1 flex items-center">
                    <span
                        class="inline-flex items-center rounded-full bg-primary-600/90 px-3 py-1 text-sm font-medium text-white backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Настройте свой профиль
                    </span>
                </div>
            </div>

            <!-- Кнопки действий -->
            <div class="absolute bottom-0 right-0 transform translate-y-1/2 px-8">
                <a href="{{ route('profile.index', auth()->id()) }}"
                    class="group relative inline-flex overflow-hidden rounded-full bg-gray-200 px-6 py-3 font-medium text-gray-700 shadow-lg transition-all duration-300 hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                    <span class="relative z-10 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Вернуться к профилю
                    </span>
                </a>
            </div>
        </div>

        <!-- Форма редактирования профиля -->
        <div class="mt-20 px-8 py-6">
            @if (session('status'))
                <div class="mb-6 rounded-lg bg-green-100 p-4 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-lg bg-red-100 p-4 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                    <ul class="list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                <!-- Основная информация -->
                <div class="rounded-xl bg-gray-50 p-6 dark:bg-gray-700/30">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">Основная информация</h3>
                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Имя пользователя
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" id="name" name="name"
                                    value="{{ old('name', auth()->user()->name) }}"
                                    class="block w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 placeholder-gray-500 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    placeholder="Введите имя пользователя" required maxlength="50">
                            </div>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Максимум 50 символов. Должно быть
                                уникальным.</p>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Email
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="email" id="email" name="email"
                                    value="{{ old('email', auth()->user()->email) }}"
                                    class="block w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 placeholder-gray-500 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    placeholder="your.email@example.com" required>
                            </div>
                        </div>

                        <div>
                            <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                О себе
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <textarea id="bio" name="bio" rows="4"
                                    class="block w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 placeholder-gray-500 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    placeholder="Расскажите о себе...">{{ old('bio', auth()->user()->bio) }}</textarea>
                            </div>
                        </div>

                        <div>
                            <button type="submit"
                                class="inline-flex items-center justify-center rounded-lg bg-primary-600 px-6 py-3 text-center text-base font-medium text-white shadow-md transition-all duration-200 hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-700 dark:hover:bg-primary-800 dark:focus:ring-primary-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Сохранить информацию
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Смена пароля -->
                <div class="rounded-xl bg-gray-50 p-6 dark:bg-gray-700/30">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">Смена пароля</h3>
                    <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="current_password"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Текущий пароль
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="password" id="current_password" name="current_password"
                                    class="block w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 placeholder-gray-500 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    placeholder="Введите текущий пароль" required>
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Новый пароль
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="password" id="password" name="password"
                                    class="block w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 placeholder-gray-500 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    placeholder="Введите новый пароль" required>
                            </div>
                        </div>

                        <div>
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Подтверждение пароля
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="block w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 placeholder-gray-500 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    placeholder="Подтвердите новый пароль" required>
                            </div>
                        </div>

                        <div>
                            <button type="submit"
                                class="inline-flex items-center justify-center rounded-lg bg-primary-600 px-6 py-3 text-center text-base font-medium text-white shadow-md transition-all duration-200 hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-700 dark:hover:bg-primary-800 dark:focus:ring-primary-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                                Изменить пароль
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Контактная информация -->
                <div class="rounded-xl bg-gray-50 p-6 dark:bg-gray-700/30">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">Контактная информация</h3>

                    <div class="mb-6 space-y-6">
                        @foreach (['email', 'website', 'phone'] as $contactType)
                            @php
                                $contact = auth()->user()->contacts->where('type', $contactType)->first();
                                $value = $contact ? $contact->value : '';
                                $isPublic = $contact ? $contact->is_public : true;

                                $placeholder =
                                    $contactType == 'email'
                                        ? 'your.email@example.com'
                                        : ($contactType == 'website'
                                            ? 'https://yourwebsite.com'
                                            : '+7 (999) 123-45-67');

                                $label =
                                    $contactType == 'email'
                                        ? 'Email'
                                        : ($contactType == 'website'
                                            ? 'Веб-сайт'
                                            : 'Телефон');
                            @endphp

                            <form action="{{ route('contacts.update', $contactType) }}" method="POST"
                                class="space-y-4">
                                @csrf
                                @method('PUT')

                                <div>
                                    <label for="{{ $contactType }}"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ $label }}
                                    </label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input type="text" id="{{ $contactType }}" name="value"
                                            value="{{ old('value', $value) }}"
                                            class="block w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 placeholder-gray-500 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                            placeholder="{{ $placeholder }}">
                                    </div>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="is_public_{{ $contactType }}" name="is_public"
                                            value="1" {{ $isPublic ? 'checked' : '' }}
                                            class="h-5 w-5 rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700">
                                        <label for="is_public_{{ $contactType }}"
                                            class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Публичный
                                        </label>
                                    </div>

                                    <button type="submit"
                                        class="inline-flex items-center justify-center rounded-lg bg-primary-600 px-4 py-2 text-center text-sm font-medium text-white shadow-md transition-all duration-200 hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-700 dark:hover:bg-primary-800 dark:focus:ring-primary-800">
                                        Сохранить
                                    </button>
                                </div>
                            </form>
                        @endforeach
                    </div>
                </div>

                <!-- Социальные сети -->
                <div class="rounded-xl bg-gray-50 p-6 dark:bg-gray-700/30">
                    <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">Социальные сети</h3>

                    <div class="mb-6 space-y-6">
                        @foreach (['vk', 'tiktok', 'telegram'] as $platform)
                            @php
                                $socialLink = auth()->user()->socialLinks->where('platform', $platform)->first();
                                $url = $socialLink ? $socialLink->url : '';

                                $prefix =
                                    $platform == 'vk' ? 'vk.com/' : ($platform == 'tiktok' ? 'tiktok.com/@' : 't.me/');

                                $placeholder =
                                    $platform == 'vk' ? 'username' : ($platform == 'tiktok' ? 'username' : 'username');
                            @endphp

                            <form action="{{ route('social-links.update', $platform) }}" method="POST"
                                class="space-y-4">
                                @csrf
                                @method('PUT')

                                <div>
                                    <label for="{{ $platform }}"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ ucfirst($platform) }}
                                    </label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="flex rounded-lg shadow-sm">
                                            <span
                                                class="inline-flex items-center rounded-l-lg border border-r-0 border-gray-300 bg-gray-200 px-4 py-3 text-sm text-gray-600 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400">
                                                {{ $prefix }}
                                            </span>
                                            <input type="text" id="{{ $platform }}" name="url"
                                                value="{{ old('url', $url) }}"
                                                class="block w-full flex-1 rounded-none rounded-r-lg border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 placeholder-gray-500 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                                placeholder="{{ $placeholder }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="inline-flex items-center justify-center rounded-lg bg-primary-600 px-4 py-2 text-center text-sm font-medium text-white shadow-md transition-all duration-200 hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-700 dark:hover:bg-primary-800 dark:focus:ring-primary-800">
                                        Сохранить
                                    </button>
                                </div>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
