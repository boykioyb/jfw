<?php

namespace App\Shared\Infrastructure\Middleware;

use Closure;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Str;

class TraceMiddleware
{

    public function handle($request, Closure $next)
    {
        Context::add('trace_id', Str::uuid()->toString());

        // Logic middleware
        return $next($request);
    }
}
