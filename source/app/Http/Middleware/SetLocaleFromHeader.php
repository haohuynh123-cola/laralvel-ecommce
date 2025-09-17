<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleFromHeader
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->header('X-Locale', config('app.locale'));
        if (is_string($locale) && $locale !== '') {
            app()->setLocale($locale);
        }
        return $next($request);
    }
}
