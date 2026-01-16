<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();
        if (! $user) {
            return redirect()->route('login');
        }

        $allowed = array_map('trim', explode(',', $role));
        if (! in_array((string) ($user->role ?? ''), $allowed, true)) {
            abort(403);
        }

        return $next($request);
    }
}
