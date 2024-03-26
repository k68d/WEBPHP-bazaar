<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Advertentie;

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

    public function generateApiToken(Request $request)
    {
        $user = $request->user();

        // Aanname: hasRole() is een methode die controleert of de gebruiker de gegeven rol heeft
        if (!$user->hasRole('Business')) {
            return response()->json(['message' => 'Alleen bedrijven mogen een API-token genereren.'], 403);
        }

        // Verwijder eventueel bestaande tokens voor deze gebruiker voor veiligheid
        $user->tokens()->delete();
        // Genereer een nieuw token
        $tokenResult = $user->createToken('Personal Access Token');
        $user->api_access = true;
        $user->save();
        // Retourneer het nieuwe token
        return redirect()->back()->with('token', "$tokenResult->plainTextToken");

    }
}
