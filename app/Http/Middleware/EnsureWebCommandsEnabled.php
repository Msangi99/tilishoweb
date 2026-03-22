<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureWebCommandsEnabled
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! config('tilisho.allow_web_commands')) {
            abort(403, 'Web /command is disabled. Set ALLOW_WEB_COMMANDS=true in .env, then run php artisan config:clear (or config:cache after deploy).');
        }

        if (! app()->isLocal() && ! config('tilisho.allow_web_commands_in_production')) {
            abort(403, 'Web /command is not allowed in non-local environments. Set ALLOW_WEB_COMMANDS_IN_PRODUCTION=true in .env on the server, then php artisan config:clear — or use php artisan over SSH instead.');
        }

        return $next($request);
    }
}
