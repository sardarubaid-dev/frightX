<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAccountStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return $next($request);
        }

        $user = auth()->user();

        // SuperAdmin bypasses all checks
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // Skip auth routes to prevent redirect loops
        if ($request->routeIs('login', 'logout', 'register', 'password.*', 'verification.*')) {
            return $next($request);
        }

        // Check user status
        if (!$user->isActive()) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->withErrors([
                'email' => 'Your account has been deactivated. Please contact your administrator.',
            ]);
        }

        // Check company status
        if ($user->company_id && $user->company && $user->company->status !== 'active') {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->withErrors([
                'email' => 'Your company account has been deactivated. Please contact the system administrator.',
            ]);
        }

        return $next($request);
    }
}
