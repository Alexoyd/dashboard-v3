<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\MailConfigHelper;

class ApplyMailConfig
{
    public function handle($request, Closure $next)
    {
        // Appliquer la configuration SMTP dynamique à chaque requête
        MailConfigHelper::apply();
        return $next($request);
    }
}
