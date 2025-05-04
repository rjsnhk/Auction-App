<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile edit form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the user's profile.
     */
    public function view(string $id): View
    {
        $user = User::findorfail($id);
        return view('users', compact('user'));
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

        return Redirect::route('profile.view', $request->user()->id)->with('status', 'profile-updated');
    }

    /**
     * Update the user's fund information.
     */
    public function fund(Request $request): RedirectResponse
    {
        $request->validate([
            'amount' => ['required', 'integer'],
            'card_no' => ['required', 'integer'],
        ]);

        $fund = $request->amount + $request->user()->asset;

        $request->user()->update([
            'asset' => $fund,
            'card_no' => $request->card_no,
        ]);

        return Redirect::route('profile.view', $request->user()->id)->with('status', 'Fund added to profile');
    }

    /**
     * Update the user's contact information.
     */
    public function contact(Request $request): RedirectResponse
    {
        $request->validate([
            'mobile' => ['required', 'unique:'.User::class],
            'address' => ['required', 'string', 'max:200'],
            'photo' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:5120'],
        ]);

        $picName = $request->user()->id.time().'.'.$request->photo->extension();
        $path = $request->photo->move('storage', $picName);

        $request->user()->update([
            'mobile' => $request->mobile,
            'address' => $request->address,
            'avatar' => $path,
        ]);

        return Redirect::route('profile.view', $request->user()->id)->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
