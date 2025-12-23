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
                                            {{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-6 px-4 text-center text-gray-500">
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