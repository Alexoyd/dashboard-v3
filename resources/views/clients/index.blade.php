<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des questionnaires médicaux et RDV en ligne</title>
    <style>
        .red-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            background-color: #ef4444;
            border-radius: 50%;
            margin-right: 8px;
        }
        .downloaded-row {
            opacity: 0.8;
        }
        .undownloaded-row .client-name,
        .undownloaded-row .sent-date {
            font-weight: bold;
        }
        /* Masquer le curseur clignotant sur les en-têtes */
        th {
            cursor: default !important;
            user-select: none;
        }
        th:focus {
            outline: none;
        }
        
        /* Nouveaux styles d'onglets modernes */
        .tabs-container {
            border-bottom: 2px solid #e5e7eb;
            margin-bottom: 2rem;
        }
        .tabs-wrapper {
            display: flex;
            space-x: 0;
        }
        .tab-button {
            position: relative;
            padding: 1rem 2rem 0.75rem 2rem;
            font-weight: 600;
            font-size: 0.95rem;
            color: #6b7280;
            background: transparent;
            border: none;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
            text-decoration: none;
            cursor: pointer;
            border-radius: 0.5rem 0.5rem 0 0;
            margin-right: 0.25rem;
        }
        .tab-button:hover {
            color: #374151;
            background-color: #f9fafb;
            border-bottom-color: #d1d5db;
        }
        .tab-button.active {
            color: #1f2937;
            background-color: #ffffff;
            border-bottom-color: #3b82f6;
            box-shadow: 0 -2px 8px rgba(0, 0, 0, 0.1);
        }
        /* Mode sombre pour les onglets */
        .dark .tabs-container {
            border-bottom-color: #374151;
        }
        .dark .tab-button {
            color: #9ca3af;
        }
        .dark .tab-button:hover {
            color: #d1d5db;
            background-color: #374151;
            border-bottom-color: #6b7280;
        }
        .dark .tab-button.active {
            color: #f9fafb;
            background-color: #1f2937;
            border-bottom-color: #60a5fa;
        }
        
        /* Layout pour footer fixe */
        .page-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .content-wrapper {
            flex: 1;
        }
        .footer-wrapper {
            margin-top: auto;
        }

        /* Styles pour les cartes du tableau de bord */
        .dashboard-card {
            background: linear-gradient(135deg, #1e3a4c 0%, #0f2027 100%);
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 1rem;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }
        .dashboard-card:hover {
            border-color: rgba(59, 130, 246, 0.6);
            transform: translateY(-2px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }
        .dashboard-card .stat-number {
            font-size: 3rem;
            font-weight: 300;
            color: #ffffff;
            line-height: 1;
            margin-bottom: 0.75rem;
        }
        .dashboard-card .stat-label {
            color: #94a3b8;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .dashboard-card .stat-icon {
            color: #38bdf8;
            width: 1.25rem;
            height: 1.25rem;
        }
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
        @media (max-width: 768px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body class="page-wrapper">
    <x-app-layout>
        <div class="content-wrapper">
            <div class="py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div class="overflow-x-auto">
                            <!-- Onglets modernes -->
                            <div class="tabs-container">
                                <div class="tabs-wrapper">
                                    <a href="{{ route('clients.index', ['tab' => 'dashboard']) }}" 
                                       class="tab-button {{ $currentTab == 'dashboard' ? 'active' : '' }}">
                                        📊 Tableau de bord
                                    </a>
                                    <a href="{{ route('clients.index', ['tab' => 'questionnaire_medical']) }}" 
                                       class="tab-button {{ $currentTab == 'questionnaire_medical' ? 'active' : '' }}">
                                        📋 Questionnaires médicaux
                                    </a>
                                    {{-- Masqué pour v1 --}}
                                    {{-- <a href="{{ route('clients.index', ['tab' => 'rdv_en_ligne']) }}" 
                                       class="tab-button {{ $currentTab == 'rdv_en_ligne' ? 'active' : '' }}">
                                        🩺 RDV En ligne
                                    </a> --}}
                                </div>
                            </div>

                            <!-- Contenu de l'onglet -->
                            <div class="tab-content">
                                @if($currentTab == 'dashboard')
                                    <!-- ========== ONGLET TABLEAU DE BORD ========== -->
                                    <div class="mb-6 text-center">
                                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                            Tableau de bord
                                        </h1>
                                        {{-- Sélecteur de dates - à activer par votre collègue --}}
                                        {{-- <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">
                                            Les 28 derniers jours 28 nov. - 10 déc. 2025
                                        </p> --}}
                                    </div>

                                    <!-- Grille des 6 cartes statistiques -->
                                    <div class="dashboard-grid">
                                        <!-- Carte 1 : Emails envoyés par le formulaire de contact -->
                                        <div class="dashboard-card" data-stat="emails_contact">
                                            <div class="stat-number" data-value="emails_contact">0</div>
                                            <div class="stat-label">
                                                <!-- Icône message/email -->
                                                <svg class="stat-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                </svg>
                                                <span data-label="emails_contact">Emails envoyé par le formulaire de contact</span>
                                            </div>
                                        </div>

                                        <!-- Carte 2 : Emails envoyés ce mois -->
                                        <div class="dashboard-card" data-stat="emails_mois">
                                            <div class="stat-number" data-value="emails_mois">0</div>
                                            <div class="stat-label">
                                                <!-- Icône avion/envoi -->
                                                <svg class="stat-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                                </svg>
                                                <span data-label="emails_mois">Emails envoyé ce mois</span>
                                            </div>
                                        </div>

                                        <!-- Carte 3 : Pages vues -->
                                        <div class="dashboard-card" data-stat="pages_vues">
                                            <div class="stat-number" data-value="pages_vues">0</div>
                                            <div class="stat-label">
                                                <!-- Icône calendrier/pages -->
                                                <svg class="stat-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <span data-label="pages_vues">Pages vues</span>
                                            </div>
                                        </div>

                                        <!-- Carte 4 : Clicks pour prendre RDV -->
                                        <div class="dashboard-card" data-stat="clicks_rdv">
                                            <div class="stat-number" data-value="clicks_rdv">0</div>
                                            <div class="stat-label">
                                                <!-- Icône curseur/click -->
                                                <svg class="stat-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                                                </svg>
                                                <span data-label="clicks_rdv">Clicks pour prendre RDV</span>
                                            </div>
                                        </div>

                                        <!-- Carte 5 : Statistique personnalisable 5 -->
                                        <div class="dashboard-card" data-stat="stat_5">
                                            <div class="stat-number" data-value="stat_5">0</div>
                                            <div class="stat-label">
                                                <!-- Icône utilisateurs -->
                                                <svg class="stat-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                                <span data-label="stat_5">Statistique 5</span>
                                            </div>
                                        </div>

                                        <!-- Carte 6 : Statistique personnalisable 6 -->
                                        <div class="dashboard-card" data-stat="stat_6">
                                            <div class="stat-number" data-value="stat_6">0</div>
                                            <div class="stat-label">
                                                <!-- Icône graphique -->
                                                <svg class="stat-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                                </svg>
                                                <span data-label="stat_6">Statistique 6</span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- 
                                    ============================================================
                                    INSTRUCTIONS POUR VOTRE COLLÈGUE - PERSONNALISATION
                                    ============================================================
                                    
                                    Pour modifier les TITRES des cartes :
                                    - Cherchez les balises <span data-label="...">
                                    - Modifiez le texte entre les balises
                                    
                                    Pour modifier les VALEURS des cartes :
                                    - Cherchez les balises <div class="stat-number" data-value="...">
                                    - Remplacez le "0" par la valeur souhaitée ou injectez via JavaScript
                                    
                                    Pour modifier les ICÔNES :
                                    - Chaque carte a une icône SVG dans <svg class="stat-icon">
                                    - Vous pouvez remplacer le SVG par n'importe quelle icône
                                    
                                    Identifiants des cartes (data-stat) :
                                    - emails_contact : Emails formulaire contact
                                    - emails_mois : Emails ce mois
                                    - pages_vues : Pages vues
                                    - clicks_rdv : Clicks RDV
                                    - stat_5 : Personnalisable
                                    - stat_6 : Personnalisable
                                    
                                    Exemple JavaScript pour mettre à jour dynamiquement :
                                    
                                    document.querySelector('[data-value="emails_contact"]').textContent = '150';
                                    document.querySelector('[data-label="stat_5"]').textContent = 'Nouveaux patients';
                                    
                                    ============================================================
                                    --}}

                                @else
                                    <!-- ========== ONGLET QUESTIONNAIRES MÉDICAUX ========== -->
                                    <div class="mb-6">
                                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                                             @if($currentTab == 'questionnaire_medical')
                                                📋 <span class="ml-2">Questionnaires médicaux</span>
                                            @else
                                               🩺 <span class="ml-2">RDV En ligne</span>
                                            @endif
                                        </h1>
                                        <p class="text-gray-600 dark:text-gray-400 mt-1">
                                            {{ $currentTab == 'questionnaire_medical' ? 'Gérez vos questionnaires de santé' : 'Gérez vos rendez-vous en ligne' }}
                                        </p>
                                    </div>
                                    
                                    <div class="bg-white dark:bg-gray-900 rounded-lg shadow">
                                        <table class="min-w-full">
                                            <thead>
                                                <tr class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                                                    <th class="py-4 px-6 text-center text-sm font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wider">
                                                        Patients
                                                    </th>
                                                    <th class="py-4 px-6 text-center text-sm font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wider">
                                                        Date d'envoi
                                                    </th>
                                                    <th class="py-4 px-6 text-center text-sm font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wider">
                                                        Questionnaire médical
                                                    </th>
                                                    <th class="py-4 px-6 text-center text-sm font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wider">
                                                        Pièces jointes
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                                @forelse ($clients as $client)
                                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-150 {{ $client->isDownloaded() ? 'downloaded-row' : 'undownloaded-row' }}">
                                                        <td class="py-4 px-6 text-center client-name">
                                                            <div class="flex items-center justify-center">
                                                                @if(!$client->isDownloaded())
                                                                    <span class="red-dot"></span>
                                                                @endif
                                                                <span class="text-gray-900 dark:text-gray-100">
                                                                    {{ $client->first_name }} {{ $client->last_name }}
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td class="py-4 px-6 text-center sent-date">
                                                            <span class="text-gray-700 dark:text-gray-300">
                                                                {{ \Carbon\Carbon::parse($client->form_sent_at)->format('d/m/Y H:i:s') }}
                                                            </span>
                                                        </td>
                                                        <td class="py-4 px-6 text-center">
                                                            <a href="{{ route('clients.download', ['filename' => basename($client->pdf_path)]) }}" 
                                                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-lg transition duration-150 ease-in-out shadow-sm hover:shadow-md">
                                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                                </svg>
                                                                Télécharger
                                                            </a>
                                                        </td>
                                                        <td class="py-4 px-6 text-center">
                                                            @if($client->attachments && count($client->attachments) > 0)
                                                                <div class="flex flex-col gap-2 items-center">
                                                                    @foreach($client->attachments as $index => $attachment)
                                                                        <a href="{{ route('clients.download.attachment', ['filename' => basename($attachment['path'])]) }}" 
                                                                           class="inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white font-medium text-xs rounded-lg transition duration-150 ease-in-out shadow-sm hover:shadow-md"
                                                                           title="{{ $attachment['original_name'] }}">
                                                                            <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                                                            </svg>
                                                                            PJ {{ $index + 1 }}
                                                                        </a>
                                                                    @endforeach
                                                                </div>
                                                            @else
                                                                <span class="text-gray-400 dark:text-gray-500 text-sm italic">Aucune</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="py-12 px-6 text-center">
                                                            <div class="flex flex-col items-center">
                                                                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                                </svg>
                                                                <p class="text-gray-500 dark:text-gray-400 text-lg">
                                                                    Aucun {{ $currentTab == 'questionnaire_medical' ? 'questionnaire médical' : 'RDV en ligne' }} trouvé.
                                                                </p>
                                                                <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">
                                                                    Les nouveaux éléments apparaîtront ici automatiquement.
                                                                </p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Pagination -->
                                    @if ($clients instanceof \Illuminate\Contracts\Pagination\Paginator)
                                        <div class="mt-6 flex justify-center">
                                            {{ $clients->appends(['tab' => $currentTab])->links() }}
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer avec mentions légales (maintenant en bas de page) -->
        <footer class="footer-wrapper bg-gray-800 text-white py-8 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <div class="border-t border-gray-700 pt-6">
                        <p class="text-sm mb-4">
                            @if(isset($legalPages) && $legalPages->count() > 0)
                                @foreach($legalPages as $index => $page)
                                    <a href="{{ route('legal.show', $page->id) }}" class="text-blue-400 hover:text-blue-300 transition duration-150 ease-in-out">{{ $page->title }}</a>
                                    @if(!$loop->last) | @endif
                                @endforeach
                            @else
                                <a href="#" class="text-blue-400 hover:text-blue-300">Mentions légales</a> |
                                <a href="#" class="text-blue-400 hover:text-blue-300">Politique de confidentialité</a>
                            @endif
                        </p>
                        <p class="text-xs text-gray-400">
                            © {{ date('Y') }} Tous droits réservés. | Dashboard sécurisé
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </x-app-layout>
</body>
</html>
