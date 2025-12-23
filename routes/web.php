<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PdfUploadController;
use App\Http\Controllers\LegalPageController;

Route::get('/', function () {
    return view('auth.login');
});

//Route::get('/dashboard', function () {
//   return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard', function () {
   return redirect()->route('clients.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route pour afficher les pages légales (accessible à tous)
Route::get('/legal/{id}', [LegalPageController::class, 'show'])->name('legal.show');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index')->middleware('auth');
    // Route pour télécharger les fichiers PDF (authentification standard seulement)
    Route::get('/clients/download/{filename}', [PdfUploadController::class, 'download'])->name('clients.download');
	// Route pour télécharger les pièces jointes
    Route::get('/clients/download-attachment/{filename}', [PdfUploadController::class, 'downloadAttachment'])->name('clients.download.attachment');
});

// Routes Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('index');
        
    // Pages légales
    Route::get('/legal-pages', [App\Http\Controllers\AdminController::class, 'legalPagesIndex'])->name('legal-pages.index');
    Route::get('/legal-pages/create', [App\Http\Controllers\AdminController::class, 'legalPagesCreate'])->name('legal-pages.create');
    Route::post('/legal-pages', [App\Http\Controllers\AdminController::class, 'legalPagesStore'])->name('legal-pages.store');
    Route::get('/legal-pages/{legalPage}/edit', [App\Http\Controllers\AdminController::class, 'legalPagesEdit'])->name('legal-pages.edit');
    Route::patch('/legal-pages/{legalPage}', [App\Http\Controllers\AdminController::class, 'legalPagesUpdate'])->name('legal-pages.update');
    Route::delete('/legal-pages/{legalPage}', [App\Http\Controllers\AdminController::class, 'legalPagesDestroy'])->name('legal-pages.destroy');
        
    // Templates d'emails
    Route::get('/email-templates', [App\Http\Controllers\AdminController::class, 'emailTemplatesIndex'])->name('email-templates.index');
    Route::get('/email-templates/create', [App\Http\Controllers\AdminController::class, 'emailTemplatesCreate'])->name('email-templates.create');
    Route::post('/email-templates', [App\Http\Controllers\AdminController::class, 'emailTemplatesStore'])->name('email-templates.store');
    Route::get('/email-templates/{emailTemplate}/edit', [App\Http\Controllers\AdminController::class, 'emailTemplatesEdit'])->name('email-templates.edit');
    Route::patch('/email-templates/{emailTemplate}', [App\Http\Controllers\AdminController::class, 'emailTemplatesUpdate'])->name('email-templates.update');
    Route::delete('/email-templates/{emailTemplate}', [App\Http\Controllers\AdminController::class, 'emailTemplatesDestroy'])->name('email-templates.destroy');
    
    // Paramètres
    Route::get('/settings', [App\Http\Controllers\AdminController::class, 'settingsIndex'])->name('settings.index');
    Route::post('/settings', [App\Http\Controllers\AdminController::class, 'settingsUpdate'])->name('settings.update');
    
    // Clients
    Route::get('/clients', [App\Http\Controllers\AdminController::class, 'clientsList'])->name('clients.index');
    
    // Google Analytics ID
    Route::patch('/users/{user}/google-analytics-id', [App\Http\Controllers\AdminController::class, 'updateGoogleAnalyticsId'])->name('users.update-analytics-id');
});

// Routes pour définition de mot de passe
Route::get('/set-password/{token}', [App\Http\Controllers\Auth\SetPasswordController::class, 'show'])
    ->name('password.set.show');
Route::post('/set-password', [App\Http\Controllers\Auth\SetPasswordController::class, 'store'])
    ->name('password.set.store');


require __DIR__.'/auth.php';

