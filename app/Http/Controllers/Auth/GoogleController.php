<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the Google callback.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {
            // Get the user from Google
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Check if the Google response is null
            if (!$googleUser || !$googleUser->getEmail()) {
                // Handle the case where Google didn't return user data
                return redirect('/login')->with('error', 'Failed to retrieve user information from Google.');
            }

            // Try to find or create the user in your system
            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'password' => bcrypt('random-password'), // Optional for social login, you can customize as needed
                ]
            );

            // Log the user in
            Auth::login($user);

            // Redirect to the dashboard after successful login
            return redirect('/admin-dashboard'); // Redirect to your desired dashboard page
        } catch (\Exception $e) {
            // Handle any errors that occur during the login process
            return redirect('/login')->with('error', 'Something went wrong. Please try again.');
        }
    }
}
