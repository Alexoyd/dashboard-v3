<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Services\Ga4ServiceFactory;

class ClientController extends Controller
{
    public function index(Request $request, Ga4ServiceFactory $factory)
    {
        // Vérifie qu'il y a un utilisateur connecté
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->withErrors('Vous devez être connecté pour accéder à cette page.');
        }

        // Récupérer le type d'onglet actuel (par défaut : dashboard)
        $currentTab = $request->get('tab', 'dashboard');
        
        // Si c'est l'onglet dashboard, pas besoin de récupérer les clients
        if ($currentTab === 'dashboard') {
            $clients = collect(); // Collection vide

            if ($user->google_analytics_id) {

              $ga4 = $factory->make(auth()->user()->google_analytics_id);
              $response = $ga4->getAllEventNames();
              
              try {
                  $stats = collect($response->getRows())->map(function ($row) {
                      return [
                          'event' => $row->getDimensionValues()[0]->getValue(),
                          'count' => (int) $row->getMetricValues()[0]->getValue(),
                      ];
                  });

                  $pageViews = $stats->firstWhere('event', 'page_view');
                  $uniquePageViews = $stats->firstWhere('event', 'first_visit');
                  $sessions = $stats->firstWhere('event', 'session_start');
                  $contactEvent = $stats->firstWhere('event', 'Click_RDV_pour_mon_projet');

              } catch (\Google\Service\Exception $e) {
                  if ($e->getCode() === 403) {
                      // property inaccessible, notify admin, show user message 
                  }
              }
              
            }

            return view('clients.index', compact('clients', 'currentTab', 'stats', 'pageViews', 'uniquePageViews', 'sessions', 'contactEvent'));
        }
        
        // Filtrer les clients liés à cet utilisateur et au type sélectionné
        $clients = Client::where('user_id', $user->id)
                        ->where('type', $currentTab)
                        ->orderBy('form_sent_at', 'desc')
                        ->paginate(10);
                        
        return view('clients.index', compact('clients', 'currentTab'));
    }
}
