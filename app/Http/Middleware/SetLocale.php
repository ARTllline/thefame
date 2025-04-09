<?php
// app/Http/Middleware/SetLocale.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        // Берем язык из сессии, если его нет — используем язык по умолчанию из конфигурации
        $locale = session('locale', config('app.locale'));
        App::setLocale($locale);

        return $next($request);
    }
}
