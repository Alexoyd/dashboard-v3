<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-3xl font-bold">Gestion des Templates d'Emails</h1>
                        <a href="{{ route('admin.email-templates.create') }}" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                            Créer un nouveau template
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700">
                                    <th class="py-3 px-4 border-b text-left">ID</th>
                                    <th class="py-3 px-4 border-b text-left">Nom d'affichage</th>
                                    <th class="py-3 px-4 border-b text-left">Nom technique</th>
                                    <th class="py-3 px-4 border-b text-left">Sujet</th>
                                    <th class="py-3 px-4 border-b text-center">Statut</th>
                                    <th class="py-3 px-4 border-b text-left">Créé le</th>
                                    <th class="py-3 px-4 border-b text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($emailTemplates as $template)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="py-3 px-4 border-b">{{ $template->id }}</td>
                                        <td class="py-3 px-4 border-b font-semibold">{{ $template->display_name }}</td>
                                        <td class="py-3 px-4 border-b">
                                            <code class="bg-gray-100 dark:bg-gray-600 px-2 py-1 rounded text-sm">{{ $template->name }}</code>
                                        </td>
                                        <td class="py-3 px-4 border-b">{{ Str::limit($template->subject, 50) }}</td>
                                        <td class="py-3 px-4 border-b text-center">
                                            @if($template->is_active)
                                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">Actif</span>
                                            @else
                                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-semibold">Inactif</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 border-b">{{ $template->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="py-3 px-4 border-b text-center">
                                            <a href="{{ route('admin.email-templates.edit', $template) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-sm mr-2">
                                                Modifier
                                            </a>
                                            <form method="POST" action="{{ route('admin.email-templates.destroy', $template) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce template ?')" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-6 px-4 text-center text-gray-500">
                                            Aucun template d'email trouvé.
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