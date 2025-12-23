<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        // Vérifie qu'il y a un utilisateur connecté
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->withErrors('Vous devez être connecté pour accéder à cette page.');
        }

        // Récupérer le type d'onglet actuel (par défaut : questionnaire_medical)
        $currentTab = $request->get('tab', 'questionnaire_medical');
        
        // Filtrer les clients liés à cet utilisateur et au type sélectionné
        $clients = Client::where('user_id', $user->id)
                        ->where('type', $currentTab)
                        ->orderBy('form_sent_at', 'desc')
                        ->paginate(10);
                        
        return view('clients.index', compact('clients', 'currentTab'));
    }
}
