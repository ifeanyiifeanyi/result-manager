<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, String $role): Response
    {
        $user = Auth::user();
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        if ($user->role->name != $role) {
            return redirect()->route('login');
        }

        request()->user()->update([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip()
        ]);



        if ($user->is_blacklisted) {
            Auth::logout();
            return redirect()->route('login')->withErrors('Please contact support.');
        }

        // Get the current route name
        $currentRoute = $request->route()->getName();

        // Get the user's designated dashboard route
        $dashboardRoute = request()->user()->getDashboardRoute();

        // Check if user is already on their correct dashboard
        if ($currentRoute === $dashboardRoute) {
            return $next($request);
        }

        // If trying to access a dashboard route that's not theirs, redirect to their proper dashboard
        if (str_contains($currentRoute, '.dashboard')) {
            return redirect()->route($dashboardRoute)
                ->with('error', 'Unauthorized access attempt.');
        }

        // For non-dashboard routes, check if user has required role
        $requiredRole = $this->getRequiredRoleFromRoute($currentRoute);
        if ($requiredRole && !$this->hasRequiredRole($user, $requiredRole)) {
            return redirect()->route($dashboardRoute)
                ->with('error', 'Access restricted.');
        }

        return $next($request);
    }

      /**
     * Extract required role from route name
     */
    protected function getRequiredRoleFromRoute($route): ?string
    {
        $routeParts = explode('.', $route);
        return count($routeParts) > 0 ? $routeParts[0] : null;
    }

    /**
     * Determine if user has required role
     */
    protected function hasRequiredRole($user, $requiredRole): bool
    {
        return $user->hasRole($requiredRole);
    }

}
