<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-3xl font-bold mb-6">Modifier le template d'email</h1>

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.email-templates.update', $emailTemplate) }}">
                        @csrf
                        @method('PATCH')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="display_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nom d'affichage *
                                </label>
                                <input type="text" name="display_name" id="display_name" value="{{ old('display_name', $emailTemplate->display_name) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white"
                                       placeholder="Ex: Nouveau questionnaire médical reçu" required>
                            </div>

                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nom technique * <small>(identifiant unique)</small>
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name', $emailTemplate->name) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white"
                                       placeholder="Ex: nouveau_questionnaire_medical" required>
                                <small class="text-gray-500">Utilisé dans le code (sans espaces, tirets ou underscores uniquement)</small>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Sujet de l'email *
                            </label>
                            <input type="text" name="subject" id="subject" value="{{ old('subject', $emailTemplate->subject) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="Ex: Nouveau questionnaire médical reçu - {nom} {prenom}" required>
                        </div>

                        <div class="mb-6">
                            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Contenu de l'email *
                            </label>
                            <textarea name="content" id="content" rows="15" 
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white"
                                      required>{{ old('content', $emailTemplate->content) }}</textarea>
                        </div>

                        <div class="mb-6">
                            <label for="available_variables" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Variables disponibles <small>(séparées par des virgules)</small>
                            </label>
                            <input type="text" name="available_variables" id="available_variables" value="{{ old('available_variables', is_array($emailTemplate->available_variables) ? implode(', ', $emailTemplate->available_variables) : '') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="Ex: nom, prenom, type, date">
                            <small class="text-gray-500">Variables utilisables dans le sujet et contenu avec {nom_variable}</small>
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Description <small>(optionnelle)</small>
                            </label>
                            <textarea name="description" id="description" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white">{{ old('description', $emailTemplate->description) }}</textarea>
                        </div>

                        <div class="mb-6">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_active" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-orange-600 shadow-sm focus:ring-orange-500 dark:focus:ring-orange-600 dark:focus:ring-offset-gray-800" {{ old('is_active', $emailTemplate->is_active) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Template actif</span>
                            </label>
                        </div>

                        <div class="flex justify-between">
                            <a href="{{ route('admin.email-templates.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Annuler
                            </a>
                            <button type="submit" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                                Mettre à jour le template
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>