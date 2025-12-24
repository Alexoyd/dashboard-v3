<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\LegalPage;
use App\Services\Ga4ServiceFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Ga4ServiceFactory::class, function () {
            return new Ga4ServiceFactory();
        });
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
