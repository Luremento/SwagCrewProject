@extends('layouts.auth')

@section('title', 'Регистрация')

@section('content')
    <div class="w-full max-w-md">
        <div class="mb-8 text-center">
            <a href="{{ route('index') }}" class="inline-flex items-center">
                <svg class="h-10 w-10 text-primary-600 dark:text-primary-400" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="ml-3 text-2xl font-bold text-gray-900 dark:text-white">MusicHub</span>
            </a>
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900 dark:text-white">Создайте аккаунт</h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Или
                <a href="{{ route('login') }}"
                    class="font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300">
                    войдите в существующий аккаунт
                </a>
            </p>
        </div>

        <!-- Общие ошибки -->
        @if (
            $errors->any() &&
                !$errors->has('name') &&
                !$errors->has('email') &&
                !$errors->has('password') &&
                !$errors->has('password_confirmation'))
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 dark:border-red-800 dark:bg-red-900/20">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                            Ошибка регистрации
                        </h3>
                        <div class="mt-1 text-sm text-red-700 dark:text-red-300">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Сообщения об успехе -->
        @if (session('status'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 dark:border-green-800 dark:bg-green-900/20">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.236 4.53L7.53 10.53a.75.75 0 00-1.06 1.06l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800 dark:text-green-200">
                            {{ session('status') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="overflow-hidden rounded-2xl bg-white shadow-xl dark:bg-gray-800/80 dark:backdrop-blur-sm">
            <div class="px-6 py-8 sm:px-10">
                <form class="space-y-6" action="{{ route('register') }}" method="POST" id="registerForm">
                    @csrf

                    <!-- Имя пользователя -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Имя пользователя
                        </label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 {{ $errors->has('name') ? 'text-red-400' : '' }}"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                                </svg>
                            </div>
                            <input id="name" name="name" type="text" autocomplete="name" required
                                value="{{ old('name') }}"
                                class="block w-full pl-10 pr-3 py-3 rounded-lg border {{ $errors->has('name') ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-primary-500 focus:ring-primary-500' }} bg-gray-50 text-gray-900 placeholder-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 {{ $errors->has('name') ? 'dark:border-red-500 dark:text-red-100 dark:placeholder-red-400' : 'dark:focus:border-primary-500 dark:focus:ring-primary-500' }} transition-colors duration-200"
                                placeholder="Введите имя пользователя">
                            @if ($errors->has('name'))
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        @error('name')
                            <div class="mt-2 flex items-center text-sm text-red-600 dark:text-red-400 animate-fade-in">
                                <svg class="mr-1 h-4 w-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Минимум 3 символа, только буквы, цифры и подчеркивания
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Email адрес
                        </label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 {{ $errors->has('email') ? 'text-red-400' : '' }}"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M3 4a2 2 0 012-2h10a2 2 0 012 2v1.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 01-1.414 0L2.293 6.293A1 1 0 012 5.586V4z" />
                                    <path
                                        d="M2 7.414V16a2 2 0 002 2h12a2 2 0 002-2V7.414l-5.293 5.293a3 3 0 01-4.414 0L2 7.414z" />
                                </svg>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="email" required
                                value="{{ old('email') }}"
                                class="block w-full pl-10 pr-3 py-3 rounded-lg border {{ $errors->has('email') ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-primary-500 focus:ring-primary-500' }} bg-gray-50 text-gray-900 placeholder-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 {{ $errors->has('email') ? 'dark:border-red-500 dark:text-red-100 dark:placeholder-red-400' : 'dark:focus:border-primary-500 dark:focus:ring-primary-500' }} transition-colors duration-200"
                                placeholder="email@example.com">
                            @if ($errors->has('email'))
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        @error('email')
                            <div class="mt-2 flex items-center text-sm text-red-600 dark:text-red-400 animate-fade-in">
                                <svg class="mr-1 h-4 w-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Пароль -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Пароль
                        </label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 {{ $errors->has('password') ? 'text-red-400' : '' }}"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" autocomplete="new-password" required
                                class="block w-full pl-10 pr-12 py-3 rounded-lg border {{ $errors->has('password') ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-primary-500 focus:ring-primary-500' }} bg-gray-50 text-gray-900 placeholder-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 {{ $errors->has('password') ? 'dark:border-red-500 dark:text-red-100 dark:placeholder-red-400' : 'dark:focus:border-primary-500 dark:focus:ring-primary-500' }} transition-colors duration-200"
                                placeholder="Введите пароль">

                            <!-- Кнопка показать/скрыть пароль -->
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <button type="button" id="togglePassword"
                                    class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 focus:outline-none">
                                    <svg id="eyeOpen" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd"
                                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <svg id="eyeClosed" class="h-5 w-5 hidden" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z"
                                            clip-rule="evenodd" />
                                        <path
                                            d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                    </svg>
                                </button>
                            </div>

                            @if ($errors->has('password'))
                                <div class="absolute inset-y-0 right-10 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        @error('password')
                            <div class="mt-2 flex items-center text-sm text-red-600 dark:text-red-400 animate-fade-in">
                                <svg class="mr-1 h-4 w-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror

                        <!-- Индикатор силы пароля -->
                        <div class="mt-2">
                            <div class="flex items-center space-x-2">
                                <div class="flex-1">
                                    <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700">
                                        <div id="passwordStrength" class="h-2 rounded-full transition-all duration-300"
                                            style="width: 0%"></div>
                                    </div>
                                </div>
                                <span id="passwordStrengthText"
                                    class="text-xs text-gray-500 dark:text-gray-400 min-w-[60px]"></span>
                            </div>
                            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Минимум 8 символов, включая буквы и цифры
                            </div>
                        </div>
                    </div>

                    <!-- Подтверждение пароля -->
                    <div>
                        <label for="password_confirmation"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Подтвердите пароль
                        </label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 {{ $errors->has('password_confirmation') ? 'text-red-400' : '' }}"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input id="password_confirmation" name="password_confirmation" type="password"
                                autocomplete="new-password" required
                                class="block w-full pl-10 pr-12 py-3 rounded-lg border {{ $errors->has('password_confirmation') ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-primary-500 focus:ring-primary-500' }} bg-gray-50 text-gray-900 placeholder-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 {{ $errors->has('password_confirmation') ? 'dark:border-red-500 dark:text-red-100 dark:placeholder-red-400' : 'dark:focus:border-primary-500 dark:focus:ring-primary-500' }} transition-colors duration-200"
                                placeholder="Повторите пароль">

                            <!-- Кнопка показать/скрыть подтверждение пароля -->
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <button type="button" id="togglePasswordConfirmation"
                                    class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 focus:outline-none">
                                    <svg id="eyeOpenConfirm" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd"
                                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <svg id="eyeClosedConfirm" class="h-5 w-5 hidden" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z"
                                            clip-rule="evenodd" />
                                        <path
                                            d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                    </svg>
                                </button>
                            </div>

                            @if ($errors->has('password_confirmation'))
                                <div class="absolute inset-y-0 right-10 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif

                            <!-- Индикатор совпадения паролей -->
                            <div id="passwordMatch"
                                class="absolute inset-y-0 right-10 pr-3 flex items-center pointer-events-none hidden">
                                <svg id="passwordMatchIcon" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.236 4.53L7.53 10.53a.75.75 0 00-1.06 1.06l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        @error('password_confirmation')
                            <div class="mt-2 flex items-center text-sm text-red-600 dark:text-red-400 animate-fade-in">
                                <svg class="mr-1 h-4 w-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Соглашение с условиями -->
                    <div class="flex items-start">
                        <div class="flex h-5 items-center">
                            <input id="terms" name="terms" type="checkbox" required
                                class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600"
                                {{ old('terms') ? 'checked' : '' }}>
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="terms" class="text-gray-700 dark:text-gray-300">
                                Я согласен с
                                <a href="#"
                                    class="font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300">
                                    условиями использования
                                </a>
                                и
                                <a href="#"
                                    class="font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300">
                                    политикой конфиденциальности
                                </a>
                            </label>
                        </div>
                    </div>
                    @error('terms')
                        <div class="flex items-center text-sm text-red-600 dark:text-red-400 animate-fade-in">
                            <svg class="mr-1 h-4 w-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- Кнопка регистрации -->
                    <div>
                        <button type="submit" id="submitBtn"
                            class="group relative flex w-full justify-center rounded-lg bg-gradient-to-r from-primary-600 to-purple-600 px-4 py-3 text-sm font-medium text-white shadow-lg transition-all duration-200 hover:from-primary-700 hover:to-purple-700 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed dark:focus:ring-offset-gray-800">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg id="userIcon"
                                    class="h-5 w-5 text-primary-300 group-hover:text-primary-200 transition-colors duration-200"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                                </svg>
                                <svg id="loadingIcon" class="h-5 w-5 text-primary-300 animate-spin hidden"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </span>
                            <span id="submitText">Зарегистрироваться</span>
                        </button>
                    </div>
                </form>

                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="bg-white px-2 text-gray-500 dark:bg-gray-800 dark:text-gray-400">Или продолжить
                                с</span>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="#"
                            class="inline-flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-sm transition-all duration-200 hover:bg-gray-50 hover:shadow-md dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                            <svg class="mr-2 h-5 w-5" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.04883 9.80645H21.9512V14.1935H2.04883V9.80645Z" fill="#FC3F1D" />
                                <path d="M13.4464 2.04883V21.9512H10.5536V2.04883H13.4464Z" fill="#FC3F1D" />
                            </svg>
                            Войти через Яндекс
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Переключение видимости пароля
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClosed = document.getElementById('eyeClosed');

            if (togglePassword) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    eyeOpen.classList.toggle('hidden');
                    eyeClosed.classList.toggle('hidden');
                });
            }

            // Переключение видимости подтверждения пароля
            const togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation');
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const eyeOpenConfirm = document.getElementById('eyeOpenConfirm');
            const eyeClosedConfirm = document.getElementById('eyeClosedConfirm');

            if (togglePasswordConfirmation) {
                togglePasswordConfirmation.addEventListener('click', function() {
                    const type = passwordConfirmationInput.getAttribute('type') === 'password' ? 'text' :
                        'password';
                    passwordConfirmationInput.setAttribute('type', type);

                    eyeOpenConfirm.classList.toggle('hidden');
                    eyeClosedConfirm.classList.toggle('hidden');
                });
            }

            // Индикатор силы пароля
            const passwordStrength = document.getElementById('passwordStrength');
            const passwordStrengthText = document.getElementById('passwordStrengthText');

            function checkPasswordStrength(password) {
                let strength = 0;
                let text = '';
                let color = '';

                if (password.length >= 8) strength += 1;
                if (password.match(/[a-z]/)) strength += 1;
                if (password.match(/[A-Z]/)) strength += 1;
                if (password.match(/[0-9]/)) strength += 1;
                if (password.match(/[^a-zA-Z0-9]/)) strength += 1;

                switch (strength) {
                    case 0:
                    case 1:
                        text = 'Слабый';
                        color = 'bg-red-500';
                        break;
                    case 2:
                        text = 'Средний';
                        color = 'bg-yellow-500';
                        break;
                    case 3:
                        text = 'Хороший';
                        color = 'bg-blue-500';
                        break;
                    case 4:
                    case 5:
                        text = 'Сильный';
                        color = 'bg-green-500';
                        break;
                }

                const width = (strength / 5) * 100;
                passwordStrength.style.width = width + '%';
                passwordStrength.className = `h-2 rounded-full transition-all duration-300 ${color}`;
                passwordStrengthText.textContent = password.length > 0 ? text : '';
            }

            if (passwordInput) {
                passwordInput.addEventListener('input', function() {
                    checkPasswordStrength(this.value);
                });
            }

            // Проверка совпадения паролей
            const passwordMatch = document.getElementById('passwordMatch');
            const passwordMatchIcon = document.getElementById('passwordMatchIcon');

            function checkPasswordMatch() {
                const password = passwordInput.value;
                const confirmation = passwordConfirmationInput.value;

                if (confirmation.length > 0) {
                    passwordMatch.classList.remove('hidden');

                    if (password === confirmation) {
                        passwordMatchIcon.className = 'h-5 w-5 text-green-500';
                        passwordMatchIcon.innerHTML =
                            '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.236 4.53L7.53 10.53a.75.75 0 00-1.06 1.06l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />';
                    } else {
                        passwordMatchIcon.className = 'h-5 w-5 text-red-500';
                        passwordMatchIcon.innerHTML =
                            '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />';
                    }
                } else {
                    passwordMatch.classList.add('hidden');
                }
            }

            if (passwordConfirmationInput) {
                passwordConfirmationInput.addEventListener('input', checkPasswordMatch);
                passwordInput.addEventListener('input', checkPasswordMatch);
            }

            // Обработка отправки формы
            const form = document.getElementById('registerForm');
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const userIcon = document.getElementById('userIcon');
            const loadingIcon = document.getElementById('loadingIcon');

            if (form) {
                form.addEventListener('submit', function() {
                    // Показываем состояние загрузки
                    submitBtn.disabled = true;
                    submitText.textContent = 'Регистрация...';
                    userIcon.classList.add('hidden');
                    loadingIcon.classList.remove('hidden');
                });
            }

            // Очистка паролей при наличии ошибок
            @if ($errors->any())
                const passwordField = document.getElementById('password');
                const passwordConfirmationField = document.getElementById('password_confirmation');
                if (passwordField) passwordField.value = '';
                if (passwordConfirmationField) passwordConfirmationField.value = '';
            @endif

            // Фокус на поле с ошибкой
            @if ($errors->has('name'))
                document.getElementById('name').focus();
            @elseif ($errors->has('email'))
                document.getElementById('email').focus();
            @elseif ($errors->has('password'))
                document.getElementById('password').focus();
            @elseif ($errors->has('password_confirmation'))
                document.getElementById('password_confirmation').focus();
            @endif
        });
    </script>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }

        /* Улучшенные стили для полей с ошибками */
        .border-red-300:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        /* Плавные переходы для всех интерактивных элементов */
        input,
        button,
        a {
            transition: all 0.2s ease-in-out;
        }

        /* Стили для состояния загрузки */
        button:disabled {
            transform: scale(0.98);
        }
    </style>
@endsection
