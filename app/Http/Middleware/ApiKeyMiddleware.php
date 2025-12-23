<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\ApiKey;
use Illuminate\Support\Facades\Log;

class ApiKeyMiddleware
{
public function handle($request, Closure $next)
{
	Log::info('ApiKeyMiddleware exécuté');

    // Récupère la clé API depuis l'en-tête Authorization
    $apiKey = $request->header('Authorization');
    Log::info('Clé API reçue: ' . $request->header('Authorization'));

    // Si la clé API n'est pas présente ou invalide, retourne une erreur
    if (!$apiKey || !$keyRecord = ApiKey::where('key', $apiKey)->first()) {
        Log::warning('Clé API non valide ou absente', ['apiKey' => $apiKey]);
        return response()->json(['error' => 'Unauthorized'], 401); // Erreur si la clé est invalide
    }

    // Associe l'utilisateur lié à la requête
    $request->user = $keyRecord->user;
    
    // // Authentifie l'utilisateur correspondant
    //     Auth::login($keyRecord->user);
    //     Log::info('Utilisateur identifié', ['user_id' => Auth::id()]);

    return $next($request);
    }
}
