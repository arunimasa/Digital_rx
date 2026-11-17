<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->user()?->preferred_language ?? config('app.locale');

        App::setLocale(in_array($locale, ['bn', 'en'], true) ? $locale : 'bn');

        return $next($request);
    }
}