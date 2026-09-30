<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckCustomerAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isCustomer() || !auth()->user()->trade_partner_id) {
            abort(403, 'Unauthorized access to Customer Portal.');
        }

        return $next($request);
    }
}
