<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('profile.index', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function yandex(): RedirectResponse
    {
        return Socialite::driver('yandex')->redirect();
    }

    public function yandexRedirect()
    {
        try {
            $user = Socialite::driver('yandex')->user();

            $existingUser = User::where('email', $user->email)->first();

            if (!$existingUser) {
                $newUser = User::create([
                    'name' => $user->name ?? $user->nickname,
                    'email' => $user->email,
                ]);
                Auth::login($newUser, true);
                return redirect()->intended(route('profile.index'));
            } else {
                Auth::login($existingUser, true);
                return redirect()->intended(route('profile.index'));
            }
        } catch (\Exception $e) {
            logger()->error('Yandex auth error: ' . $e->getMessage());
            return redirect(route('login'))->with('error', 'Ошибка входа через Yandex');
        }
    }
}
