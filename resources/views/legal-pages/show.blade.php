<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $legalPage->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <!-- Header simple -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-gray-900">{{ $legalPage->title }}</h1>
            </div>
        </header>

        <!-- Contenu -->
        <main class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 prose max-w-none">
                        {!! nl2br(e($legalPage->content)) !!}
                    </div>
                </div>
                
                <!-- Bouton de retour -->
                <div class="mt-6 text-center">
                    <a href="javascript:history.back()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Retour
                    </a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>