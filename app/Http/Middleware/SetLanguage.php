<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $expectLanguage = $request->header('X-Expect-Language');

        if ($expectLanguage) {
            App::setLocale($expectLanguage);
        }

        return $next($request);
    }
}
