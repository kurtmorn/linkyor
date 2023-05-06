<?php
/**
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
 */

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GiveDailyCurrency
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && strtotime(Auth::user()->next_currency_payout) < time()) {
            $user = Auth::user();

            $user->currency_bits += 10;
            $user->next_currency_payout = Carbon::now()->addHours(24)->toDateTimeString();
            $user->save();
        }

        return $next($request);
    }
}
