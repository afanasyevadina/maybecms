<?php

namespace Altenic\MaybeCms\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HeadersMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');

        return $next($request);
    }
}
