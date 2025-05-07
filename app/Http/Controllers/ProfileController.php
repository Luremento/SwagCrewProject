<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Redirect, Storage};
use Illuminate\View\View;
use App\Models\User;
use App\Models\Contact;
use App\Models\SocialLink;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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
     * Update the authenticated user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'bio' => ['nullable', 'string'],
        ]);

        $user->update($validated);

        return redirect()->route('profile.edit')->with('status', 'Профиль успешно обновлен!');
    }

    /**
     * Update the authenticated user's password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.edit')->with('status', 'Пароль успешно изменен!');
    }

    /**
     * Upload and update the authenticated user's avatar.
     */
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'max:2048'], // 2MB Max
        ]);

        $user = Auth::user();

        // Delete old avatar if exists
        if ($user->avatar) {
            Storage::disk('public')->delete('avatars/' . $user->avatar);
        }

        // Store the new avatar
        $avatarName = $user->id . '_' . time() . '.' . $request->avatar->extension();
        $request->avatar->storeAs('avatars', $avatarName, 'public');

        // Update user record
        $user->avatar = $avatarName;
        $user->save();

        return redirect()->route('profile.edit')->with('status', 'Аватар успешно обновлен!');
    }

    /**
     * Update or create a contact for the authenticated user.
     */
    public function updateContact(Request $request, $type)
    {
        $request->validate([
            'value' => ['required', 'string', 'max:100'],
            'is_public' => ['sometimes', 'boolean'],
        ]);

        $isPublic = $request->has('is_public');
        $userId = Auth::id();

        Contact::updateOrCreate(
            ['user_id' => $userId, 'type' => $type],
            ['value' => $request->value, 'is_public' => $isPublic]
        );

        return redirect()->route('profile.edit')->with('status', 'Контактная информация обновлена!');
    }

    /**
     * Update or create a social link for the authenticated user.
     */
    public function updateSocialLink(Request $request, $platform)
    {
        $request->validate([
            'url' => ['required', 'string', 'max:100'],
        ]);

        $userId = Auth::id();

        SocialLink::updateOrCreate(
            ['user_id' => $userId, 'platform' => $platform],
            ['url' => $request->url]
        );

        return redirect()->route('profile.edit')->with('status', 'Ссылка на социальную сеть обновлена!');
    }
}
