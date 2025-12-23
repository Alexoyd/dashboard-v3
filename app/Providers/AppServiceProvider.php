<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\LegalPage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Partager les pages légales avec toutes les vues
        View::composer('*', function ($view) {
            $legalPages = LegalPage::all();
            $view->with('legalPages', $legalPages);
        });
    }
}
