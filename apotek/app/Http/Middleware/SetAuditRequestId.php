<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SetAuditRequestId
{
    public function handle(Request $request, Closure $next)
    {
        $request->attributes->set(
            'audit_request_id',
            (string) Str::uuid()
        );

        return $next($request);
    }
}
