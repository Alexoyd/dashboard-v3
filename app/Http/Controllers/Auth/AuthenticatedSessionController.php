<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

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

        return redirect()->intended(route('clients.index', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
   public function destroy(Request $request): RedirectResponse
    {
        // Récupérer l'utilisateur authentifié avant de le déconnecter
        $userId = Auth::id();

        Auth::guard('web')->logout();

        // Supprimer toutes les sessions associées à cet utilisateur
        DB::table('sessions')->where('user_id', $userId)->delete();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');

    }
}
