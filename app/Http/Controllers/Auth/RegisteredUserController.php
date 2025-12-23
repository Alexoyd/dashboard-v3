<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiKeyController; // Import correct
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Models\PasswordCreationToken;
use App\Notifications\SetPasswordNotification;
use Illuminate\Support\Facades\Notification;
use App\Helpers\MailConfigHelper;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        ]);

        // Créer l'utilisateur SANS mot de passe
        $user = User::create([
            'name'       => $request->name,
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => Hash::make(Str::random(32)) // Mot de passe temporaire impossible à deviner
        ]);

        // Générer la clé API
        $apiKeyController = new ApiKeyController();
        $apiKey = $apiKeyController->generateApiKey($user);
    
     if (!$apiKey) {
        Log::warning('La clé API n\'a pas pu être générée', ['user_id' => $user->id]);
    } else {
        Log::info('Clé API générée avec succès', ['api_key' => $apiKey, 'user_id' => $user->id]);
    }

        // Créer le token de création de mot de passe
        $passwordToken = PasswordCreationToken::createForEmail($user->email, 24);

        // Envoyer l'email de création de mot de passe
       	// Notification::route('mail', $user->email)->notify(new SetPasswordNotification($passwordToken));
    	MailConfigHelper::apply();
    	$user->notify(new SetPasswordNotification($passwordToken));

        event(new Registered($user));
		
    	return redirect()->route('admin.clients.index')
    	->with('success', 'Utilisateur créé et invitation envoyée.');
        //Auth::login($user);

       // return redirect(route('clients', absolute: false));
         //return redirect()->route('clients.index');
    }
}
