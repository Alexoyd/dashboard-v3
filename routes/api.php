<?php
use App\Http\Controllers\PdfUploadController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

// Route pour afficher les clients (authentification standard requise)
Route::get('/clients', [ClientController::class, 'index'])->middleware('auth'); //Middleware auth pour protéger la route

// // Route pour télécharger les fichiers PDF (authentification standard seulement)
// Route::get('/clients/download/{filename}', [PdfUploadController::class, 'download'])->name('clients.download');

Log::info('Middleware auth.apikey associé à la route /upload-pdf');
//  Route pour l'upload PDF (nécessite une clé API). Route API protégée avec le middleware 'auth.apikey' pour sécuriser via clé API
Route::middleware('auth.apikey')->group(function () {
    Route::post('/upload-pdf', [PdfUploadController::class, 'store']);

});