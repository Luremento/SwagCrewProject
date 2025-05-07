<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Redirect, Storage};
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{

    public function index($user = null)
    {
        if ($user) {
            $profileUser = User::where('id', $user)
                            ->orWhere('name', $user)
                            ->firstOrFail();
        } else {
            $profileUser = Auth::user();
        }

        return view('profile', [
            'user' => $profileUser
        ]);
    }

    /**
     * отображение страницы редактирования профиля
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $user = auth()->user();

        if ($user->avatar) {
            Storage::disk('public')->delete('avatars/' . $user->avatar);
        }

        $filename = uniqid() . '.' . $request->avatar->extension();
        $request->file('avatar')->storeAs('avatars', $filename, 'public');

        $user->avatar = $filename;
        $user->save();

        return redirect()->back()->with('success', 'Аватар успешно обновлен.');
    }
}
