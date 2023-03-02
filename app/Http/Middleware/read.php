<?php

namespace App\Http\Middleware;

use App\Models\UserOrder;
use Closure;
use Illuminate\Http\Request;

class read
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        UserOrder::where('read',false)->update([
            'read'=>true
        ]);
        return $next($request);
    }
}
