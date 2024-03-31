<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Advertentie;
use App\Models\Advertisement;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
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

    public function history(Request $request): View
    {
        $advertenties = $request->user()->purchasedAdvertisements()->get();

        return view('profile.history', compact('advertenties'));
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

    public function favorites(Request $request)
    {
        $user = $request->user();
        $favorites = $user->favorites()->paginate(10);

        return view('profile.favorites', compact('favorites'));
    }

    public function addFavorite(Request $request, $advertisementId)
    {
        $user = $request->user();
        $user->favorites()->syncWithoutDetaching([$advertisementId]);

        return back()->with('success', 'Advertentie toegevoegd aan favorieten.');
    }

    public function removeFavorite(Request $request, $advertisementId)
    {
        $user = $request->user();
        $user->favorites()->detach($advertisementId);

        return back()->with('success', 'Advertentie verwijderd van favorieten.');
    }


    public function generateApiToken(Request $request)
    {
        $user = $request->user();

        if (!$user->hasRole('Business')) {
            return response()->json(['message' => 'Alleen bedrijven mogen een API-token genereren.'], 403);
        }

        $user->tokens()->delete();
        $tokenResult = $user->createToken('Personal Access Token');
        $user->api_access = true;
        $user->save();
        return redirect()->back()->with('token', "$tokenResult->plainTextToken");

    }
}
