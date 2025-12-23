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
                                    <a href="{{ route('clients.index', ['tab' => 'questionnaire_medical']) }}" 
                                       class="tab-button {{ $currentTab == 'questionnaire_medical' ? 'active' : '' }}">
                                        📋 Questionnaires médicaux
                                    </a>
                                    {{-- Masqu� pour v1 --}}
                                    {{-- <a href="{{ route('clients.index', ['tab' => 'rdv_en_ligne']) }}" 
                                       class="tab-button {{ $currentTab == 'rdv_en_ligne' ? 'active' : '' }}">
                                        ? RDV En ligne
                                    </a> --}}
                                </div>
                            </div>

                            <!-- Contenu de l'onglet -->
                            <div class="tab-content">
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
                                                                Les nouveaux �l�ments appara�tront ici automatiquement.
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer avec mentions l�gales (maintenant en bas de page) -->
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
