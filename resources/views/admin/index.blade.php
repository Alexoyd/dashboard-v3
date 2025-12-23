<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-3xl font-bold mb-6">Interface d'Administration</h1>
                    
                    <!-- Statistiques -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                        <div class="bg-blue-100 dark:bg-blue-900 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200">Utilisateurs</h3>
                            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $totalUsers }}</p>
                        </div>
                        <div class="bg-green-100 dark:bg-green-900 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-green-800 dark:text-green-200">Nombre PDF</h3>
                            <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $totalClients }}</p>
                        </div>
                        <div class="bg-purple-100 dark:bg-purple-900 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-purple-800 dark:text-purple-200">Pages Légales</h3>
                            <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $totalLegalPages }}</p>
                        </div>
                        <div class="bg-orange-100 dark:bg-orange-900 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-orange-800 dark:text-orange-200">Templates Emails</h3>
                            <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">{{ $totalEmailTemplates }}</p>
                        </div>
                    </div>

                     <!-- Menu d'actions -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                            <h3 class="text-xl font-semibold mb-4">Templates d'Emails</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">Gérer les templates d'emails envoyés automatiquement.</p>
                            <a href="{{ route('admin.email-templates.index') }}" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                                Gérer les Templates
                            </a>
                        </div>

						<div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                            <h3 class="text-xl font-semibold mb-4">Paramètres SMTP</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">Configurer l'envoi d'emails et les paramètres SMTP.</p>
                            <a href="{{ route('admin.settings.index') }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Paramètres Email
                            </a>
                        </div>
                        
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                            <h3 class="text-xl font-semibold mb-4">Gestion des Pages Légales</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">Créer et modifier les mentions légales et pages de contenu.</p>
                            <a href="{{ route('admin.legal-pages.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Gérer les Pages Légales
                            </a>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                            <h3 class="text-xl font-semibold mb-4">Liste des Utilisateurs</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">Voir tous les utilisateurs avec leurs informations et clés API.</p>
                            <a href="{{ route('admin.clients.index') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Voir les Clients
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>