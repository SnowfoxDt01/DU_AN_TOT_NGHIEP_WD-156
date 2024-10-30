<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdminRole
{
    public function handle($request, Closure $next)
    {
        if (!Auth::user() || !Auth::user()->hasRole('super-admin')) {
            return redirect()->route('client.index')->with('error', 'Bạn không có quyền truy cập trang này.');
        }
        return $next($request);
    }
}

