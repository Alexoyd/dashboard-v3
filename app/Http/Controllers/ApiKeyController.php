<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\ApiKey;
use Illuminate\Support\Facades\Log;

class ApiKeyController extends Controller // Nom de la classe, modifie-le selon ton besoin
{
    public function generateApiKey(User $user)
    {
        try {
        Log::info('Début de génération de clé API pour l\'utilisateur', ['user_id' => $user->id]);
            do {
                // Génère une clé API aléatoire de 40 caractères utilisant un cryptographie secure method
                $apiKeyValue = bin2hex(random_bytes(20));
            } while (ApiKey::where('key', $apiKeyValue)->exists());

        Log::info('Clé API générée', ['api_key' => $apiKeyValue, 'user_id' => $user->id]);
        
            // Création de l'API Key
            $apiKey = ApiKey::create([
                'user_id' => $user->id,
                'key' => $apiKeyValue,
            ]);
        
 Log::info('Clé API sauvegardée avec succès', ['api_key_id' => $apiKey->id, 'user_id' => $user->id]);
        
            return $apiKey->key; // Retourne la clé générée

        } catch (\Exception $e) {
            // Enregistre l'erreur dans les logs
            Log::error('Erreur lors de la génération de la clé API: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de la génération de la clé API.'], 500);
        }
    }
}
