<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect('login'); // Redirect to login if not authenticated
        }

        // Check if the user's role matches the required role
        $user = Auth::user();
        if ($user->role !== $role) {
            abort(403, 'Unauthorized'); // Abort with a 403 error if the role doesn't match
        }

        // Allow the request to continue if the role is correct
        return $next($request);
    }
}
