<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="overflow-x-auto">
                        <div class="flex justify-between items-center mb-4">
                            <h1 class="text-3xl font-bold">Liste de tous les utilisateurs</h1>
                            <a href="{{ url('/register') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Créer un utilisateur
                            </a>
                        </div>
                        <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700">
                                    <th class="py-3 px-4 border-b text-left">Nom du compte</th>
                                    <th class="py-3 px-4 border-b text-left">E-mail</th>
                                    <th class="py-3 px-4 border-b text-center">Nombre de PDF</th>
                                    <th class="py-3 px-4 border-b text-center">Clé API</th>
                                    <th class="py-3 px-4 border-b text-center">Google Analytics ID</th>
                                    <th class="py-3 px-4 border-b text-center">Créé le</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="py-3 px-4 border-b">
                                            <div>
                                                <div class="font-semibold">{{ $user->name }}</div>
                                                @if($user->first_name && $user->last_name)
                                                    <div class="text-sm text-gray-500">{{ $user->first_name }} {{ $user->last_name }}</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-3 px-4 border-b">{{ $user->email }}</td>
                                        <td class="py-3 px-4 border-b text-center">
                                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                                {{ $user->clients->count() }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 border-b text-center">
                                            @if($user->apiKeys->count() > 0)
                                                @foreach($user->apiKeys as $apiKey)
                                                    <div class="text-xs font-mono bg-gray-100 dark:bg-gray-700 p-1 rounded mb-1">
                                                        {{ $apiKey->key }}
                                                    </div>
                                                @endforeach
                                            @else
                                                <span class="text-gray-500">Aucune clé</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 border-b text-center">
                                            <div class="flex items-center justify-center gap-2" x-data="{ 
                                                editing: false, 
                                                analyticsId: '{{ $user->google_analytics_id ?? '' }}',
                                                originalId: '{{ $user->google_analytics_id ?? '' }}',
                                                saving: false,
                                                message: '',
                                                messageType: ''
                                            }">
                                                <!-- Mode affichage -->
                                                <template x-if="!editing">
                                                    <div class="flex items-center gap-2">
                                                        <span x-text="analyticsId || 'Non défini'" 
                                                              :class="analyticsId ? 'text-xs font-mono bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 p-1 rounded' : 'text-gray-500 italic'">
                                                        </span>
                                                        <button @click="editing = true" 
                                                                class="text-blue-500 hover:text-blue-700 p-1" 
                                                                title="Modifier">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </template>
                                                
                                                <!-- Mode édition -->
                                                <template x-if="editing">
                                                    <div class="flex flex-col items-center gap-2">
                                                        <div class="flex items-center gap-2">
                                                            <input type="text" 
                                                                   x-model="analyticsId" 
                                                                   placeholder="G-XXXXXXXXXX"
                                                                   class="text-xs font-mono w-32 px-2 py-1 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                                   @keydown.enter="
                                                                       saving = true;
                                                                       fetch('{{ route('admin.users.update-analytics-id', $user->id) }}', {
                                                                           method: 'PATCH',
                                                                           headers: {
                                                                               'Content-Type': 'application/json',
                                                                               'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                                           },
                                                                           body: JSON.stringify({ google_analytics_id: analyticsId })
                                                                       })
                                                                       .then(response => response.json())
                                                                       .then(data => {
                                                                           saving = false;
                                                                           if(data.success) {
                                                                               originalId = analyticsId;
                                                                               editing = false;
                                                                               message = 'Sauvegardé !';
                                                                               messageType = 'success';
                                                                               setTimeout(() => message = '', 2000);
                                                                           } else {
                                                                               message = 'Erreur';
                                                                               messageType = 'error';
                                                                           }
                                                                       })
                                                                       .catch(err => {
                                                                           saving = false;
                                                                           message = 'Erreur';
                                                                           messageType = 'error';
                                                                       });
                                                                   "
                                                                   @keydown.escape="analyticsId = originalId; editing = false;">
                                                            
                                                            <!-- Bouton Sauvegarder -->
                                                            <button @click="
                                                                       saving = true;
                                                                       fetch('{{ route('admin.users.update-analytics-id', $user->id) }}', {
                                                                           method: 'PATCH',
                                                                           headers: {
                                                                               'Content-Type': 'application/json',
                                                                               'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                                           },
                                                                           body: JSON.stringify({ google_analytics_id: analyticsId })
                                                                       })
                                                                       .then(response => response.json())
                                                                       .then(data => {
                                                                           saving = false;
                                                                           if(data.success) {
                                                                               originalId = analyticsId;
                                                                               editing = false;
                                                                               message = 'Sauvegardé !';
                                                                               messageType = 'success';
                                                                               setTimeout(() => message = '', 2000);
                                                                           } else {
                                                                               message = 'Erreur';
                                                                               messageType = 'error';
                                                                           }
                                                                       })
                                                                       .catch(err => {
                                                                           saving = false;
                                                                           message = 'Erreur';
                                                                           messageType = 'error';
                                                                       });
                                                                   " 
                                                                    :disabled="saving"
                                                                    class="text-green-500 hover:text-green-700 p-1 disabled:opacity-50" 
                                                                    title="Sauvegarder">
                                                                <svg x-show="!saving" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                                </svg>
                                                                <svg x-show="saving" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                                </svg>
                                                            </button>
                                                            
                                                            <!-- Bouton Annuler -->
                                                            <button @click="analyticsId = originalId; editing = false;" 
                                                                    class="text-red-500 hover:text-red-700 p-1" 
                                                                    title="Annuler">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <span class="text-xs text-gray-400">Entrée pour sauvegarder, Échap pour annuler</span>
                                                    </div>
                                                </template>
                                                
                                                <!-- Message de feedback -->
                                                <span x-show="message" 
                                                      x-text="message"
                                                      :class="messageType === 'success' ? 'text-green-500' : 'text-red-500'"
                                                      class="text-xs ml-2">
                                                </span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4 border-b text-center">
                                            {{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-6 px-4 text-center text-gray-500">
                                            Aucun utilisateur trouvé.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('admin.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Retour au tableau de bord
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
