<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ShopOrder;

class CheckPendingOrder
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if ($user) {
            $pendingOrder = ShopOrder::where('user_id', $user->id)
                ->where('order_status', 'pending')
                ->first();

            if ($pendingOrder) {
                $pendingOrder->delete();
            }
        }

        return $next($request);
    }
}
