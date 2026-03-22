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
            abort(404);
        }

        if (! app()->isLocal() && ! config('tilisho.allow_web_commands_in_production')) {
            abort(404);
        }

        return $next($request);
    }
}
