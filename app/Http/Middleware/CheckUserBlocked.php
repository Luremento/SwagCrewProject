<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserBlocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Проверяем, авторизован ли пользователь
        if (Auth::check()) {
            $user = Auth::user();

            // Если пользователь заблокирован
            if ($user->is_blocked) {
                // Выходим из системы
                Auth::logout();

                // Очищаем сессию
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // Перенаправляем на страницу входа с сообщением об ошибке
                return redirect()->route('login')
                    ->withErrors(['blocked' => 'Ваш аккаунт заблокирован. Обратитесь к администратору.']);
            }
        }

        return $next($request);
    }
}
