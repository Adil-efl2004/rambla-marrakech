<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $allowedRoles = explode(',', $roles);

        if (! in_array($request->user()?->role, $allowedRoles, true)) {
            abort(403);
        }

        return $next($request);
    }
}
