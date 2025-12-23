<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PasswordCreationToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class SetPasswordController extends Controller
{
    /**
     * Afficher le formulaire de définition de mot de passe
     */
    public function show(string $token)
    {
        $passwordToken = PasswordCreationToken::findValidToken($token);
        
        if (!$passwordToken) {
            return redirect()->route('login')
                           ->withErrors(['token' => 'Ce lien de création de mot de passe est invalide ou a expiré.']);
        }

        return view('auth.set-password', [
            'token' => $token,
            'email' => $passwordToken->email
        ]);
    }

    /**
     * Traiter la définition du mot de passe
     */
    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $passwordToken = PasswordCreationToken::findValidToken($request->token);
        
        if (!$passwordToken) {
            return back()->withErrors(['token' => 'Ce lien de création de mot de passe est invalide ou a expiré.']);
        }

        // Trouver l'utilisateur
        $user = User::where('email', $passwordToken->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'Aucun utilisateur trouvé avec cette adresse email.']);
        }

        // Mettre à jour le mot de passe
        $user->update([
            'password' => Hash::make($request->password),
            'email_verified_at' => now() // Marquer comme vérifié
        ]);

        // Marquer le token comme utilisé
        $passwordToken->markAsUsed();

        // Connecter l'utilisateur
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Votre mot de passe a été défini avec succès !');
    }
}