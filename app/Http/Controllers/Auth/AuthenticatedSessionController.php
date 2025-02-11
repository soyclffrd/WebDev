<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
{
    return Inertia::render('Auth/Login');
}

public function store(LoginRequest $request)
{
    $request->authenticate();
    $request->session()->regenerate();
    
    // Return a JSON response for API requests
    if ($request->wantsJson()) {
        return response()->json([
            'success' => true,
            'redirect' => route('admin.teacher.index')
        ]);
    }
    
    return redirect()->intended(route('admin.teacher.index'));
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
}
