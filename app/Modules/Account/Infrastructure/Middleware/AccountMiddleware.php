<?php

namespace App\Modules\Account\Infrastructure\Middleware;

use Closure;

class AccountMiddleware
{
    public function handle($request, Closure $next)
    {
        // Logic middleware
        return $next($request);
    }
}
