<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $module, string $action): Response
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        $user = auth()->user();

        // Admin has full access
        if ($user->isAdmin()) {
            return $next($request);
        }

        if (!$user->hasModuleAction($module, $action)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized access to this module.'], 403);
            }
            
            return abort(403, "Access Denied. You do not have '{$action}' permission for the '{$module}' module.");
        }

        return $next($request);
    }
}
