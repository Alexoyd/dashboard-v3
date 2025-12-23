<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-3xl font-bold">Paramètres Email / SMTP</h1>
                        <a href="{{ route('admin.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Retour au tableau de bord
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.settings.update') }}">
                        @csrf
                        
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        <strong>Information :</strong> Ces paramètres remplacent ceux du fichier .env. Laissez vide pour utiliser les valeurs par défaut du .env.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Configuration générale -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-semibold border-b pb-2">Configuration générale</h3>
                                
                                <div>
                                    <label for="mail_mailer" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Driver Email *
                                    </label>
                                    <select name="mail_mailer" id="mail_mailer" 
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white" 
                                            required>
                                        <option value="log" {{ $smtpSettings['mail_mailer'] == 'log' ? 'selected' : '' }}>Log (pas d'envoi réel)</option>
                                        <option value="smtp" {{ $smtpSettings['mail_mailer'] == 'smtp' ? 'selected' : '' }}>SMTP</option>
                                        <option value="sendmail" {{ $smtpSettings['mail_mailer'] == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                                        <option value="array" {{ $smtpSettings['mail_mailer'] == 'array' ? 'selected' : '' }}>Array (test)</option>
                                    </select>
                                    <small class="text-gray-500">Mode 'log' = emails dans les logs, 'smtp' = envoi réel</small>
                                </div>

                                <div>
                                    <label for="mail_from_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Adresse expéditeur *
                                    </label>
                                    <input type="email" name="mail_from_address" id="mail_from_address" 
                                           value="{{ $smtpSettings['mail_from_address'] }}" 
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white"
                                           placeholder="noreply@mediweb.fr" required>
                                </div>

                                <div>
                                    <label for="mail_from_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Nom expéditeur *
                                    </label>
                                    <input type="text" name="mail_from_name" id="mail_from_name" 
                                           value="{{ $smtpSettings['mail_from_name'] }}" 
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white"
                                           placeholder="Mediweb" required>
                                </div>
                            </div>

                            <!-- Configuration SMTP -->
                            <div class="space-y-6" id="smtp-settings">
                                <h3 class="text-lg font-semibold border-b pb-2">Configuration SMTP</h3>
                                
                                <div>
                                    <label for="mail_host" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Serveur SMTP
                                    </label>
                                    <input type="text" name="mail_host" id="mail_host" 
                                           value="{{ $smtpSettings['mail_host'] }}" 
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white"
                                           placeholder="smtp.gmail.com">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="mail_port" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Port
                                        </label>
                                        <input type="number" name="mail_port" id="mail_port" 
                                               value="{{ $smtpSettings['mail_port'] }}" 
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white"
                                               placeholder="587">
                                    </div>

                                    <div>
                                        <label for="mail_encryption" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Encryption
                                        </label>
                                        <select name="mail_encryption" id="mail_encryption" 
                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white">
                                            <option value="">Aucune</option>
                                            <option value="tls" {{ $smtpSettings['mail_encryption'] == 'tls' ? 'selected' : '' }}>TLS</option>
                                            <option value="ssl" {{ $smtpSettings['mail_encryption'] == 'ssl' ? 'selected' : '' }}>SSL</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label for="mail_username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Nom d'utilisateur SMTP
                                    </label>
                                    <input type="text" name="mail_username" id="mail_username" 
                                           value="{{ $smtpSettings['mail_username'] }}" 
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white"
                                           placeholder="votre@email.com">
                                </div>

                                <div>
                                    <label for="mail_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Mot de passe SMTP
                                    </label>
                                    <input type="password" name="mail_password" id="mail_password" 
                                           value="{{ $smtpSettings['mail_password'] }}" 
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white"
                                           placeholder="Laissez vide pour garder l'actuel">
                                </div>
                            </div>
                        </div>

                        <!-- Providers recommandés -->
                        <div class="mt-8 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <h4 class="font-semibold mb-3">Providers SMTP recommandés :</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
                                <div>
                                    <strong>Gmail :</strong><br>
                                    Host: smtp.gmail.com<br>
                                    Port: 587 (TLS)
                                </div>
                                <div>
                                    <strong>Mailtrap (dev) :</strong><br>
                                    Host: sandbox.smtp.mailtrap.io<br>
                                    Port: 587 (TLS)
                                </div>
                                <div>
                                    <strong>SendGrid :</strong><br>
                                    Host: smtp.sendgrid.net<br>
                                    Port: 587 (TLS)
                                </div>
                                <div>
                                    <strong>Mailgun :</strong><br>
                                    Host: smtp.eu.mailgun.org<br>
                                    Port: 587 (TLS)
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded">
                                Sauvegarder les paramètres
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Afficher/masquer les paramètres SMTP selon le driver sélectionné
        document.getElementById('mail_mailer').addEventListener('change', function() {
            const smtpSettings = document.getElementById('smtp-settings');
            const isSmtp = this.value === 'smtp';
            smtpSettings.style.opacity = isSmtp ? '1' : '0.5';
            smtpSettings.querySelectorAll('input, select').forEach(input => {
                input.disabled = !isSmtp;
            });
        });

        // Initialiser l'état au chargement
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('mail_mailer').dispatchEvent(new Event('change'));
        });
    </script>
</x-app-layout>