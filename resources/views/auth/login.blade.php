@extends('layouts.auth')

@section('title', 'Вход')

@section('content')

    <div class="w-full max-w-md">
        <div class="mb-8 text-center">
            <a href="/" class="inline-flex items-center">
                <svg class="h-10 w-10 text-primary-600 dark:text-primary-400" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="ml-3 text-2xl font-bold text-gray-900 dark:text-white">MusicHub</span>
            </a>
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900 dark:text-white">Войдите в аккаунт</h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Или
                <a href="{{ route('register') }}"
                    class="font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300">
                    зарегистрируйтесь
                </a>
            </p>
        </div>

        <div class="overflow-hidden rounded-2xl bg-white shadow-xl dark:bg-gray-800/80 dark:backdrop-blur-sm">
            <div class="px-6 py-8 sm:px-10">
                <form class="space-y-6" action="{{ route('login') }}" method="POST">
                    @csrf
                    @if ($errors->has('blocked'))
                        <div class="mb-4 rounded-lg bg-red-50 p-4 text-red-700 dark:bg-red-900/50 dark:text-red-200">
                            <div class="flex">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium">Аккаунт заблокирован</h3>
                                    <div class="mt-2 text-sm">
                                        {{ $errors->first('blocked') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Email
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input id="email" name="email" type="email" autocomplete="email" required
                                value="{{ old('email') }}"
                                class="block w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 placeholder-gray-500 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500 @error('email') border-red-500 dark:border-red-500 @enderror"
                                placeholder="email@example.com">
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Пароль -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Пароль
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                class="block w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 placeholder-gray-500 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500 @error('password') border-red-500 dark:border-red-500 @enderror"
                                placeholder="Введите пароль">
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Кнопка входа -->
                    <div>
                        <button type="submit"
                            class="group relative flex w-full justify-center rounded-lg bg-primary-600 px-4 py-3 text-sm font-medium text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:bg-primary-700 dark:hover:bg-primary-800">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-primary-500 group-hover:text-primary-400 dark:text-primary-400 dark:group-hover:text-primary-300"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                            Войти
                        </button>
                    </div>
                </form>

                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="bg-white px-2 text-gray-500 dark:bg-gray-800 dark:text-gray-400">Или войти
                                через</span>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('yandex') }}"
                            class="inline-flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                            <svg class="mr-2 h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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
@endsection
