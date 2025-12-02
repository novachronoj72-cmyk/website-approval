<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles (bisa satu atau lebih role)
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return $this->unauthenticatedResponse();
        }

        foreach ($roles as $role) {
            // Kita gunakan $user->role->value karena kita cast di Model
            if ($user->role->value === $role) {
                return $next($request);
            }
        }

        // Jika user ada tapi role tidak sesuai
        return $this->unauthorizedResponse();
    }

    /**
     * Respon jika tidak terautentikasi.
     */
    protected function unauthenticatedResponse()
    {
        if (request()->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        return redirect()->route('login');
    }

    /**
     * Respon jika role tidak sesuai.
     */
    protected function unauthorizedResponse()
    {
        if (request()->expectsJson()) {
            return response()->json(['message' => 'This action is unauthorized.'], 403);
        }
        // Redirect ke halaman yang sesuai atau 403
        abort(403, 'THIS ACTION IS UNAUTHORIZED.');
    }
}