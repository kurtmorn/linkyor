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
use Illuminate\Support\Str;

class FloodCheck
{
    public const FLOOD_ROUTES = [
        'home.status',
        'account.inbox.create',
        'account.settings.update',
        'account.trades.process',
        'account.currency.convert',
        'report.submit',
        'shop.update',
        'shop.create',
        'shop.purchase',
        // 'shop.favorite',
        'shop.comment',
        'forum.create',
        'clans.update'
    ];

    public const API_FLOOD_URLS = [];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $route = $request->route()->getName();
        $url = str_replace("{$request->root()}/api/", '', $request->url());

        if (Auth::check() && $request->isMethod('post') && (in_array($url, $this::API_FLOOD_URLS) || in_array($route, $this::FLOOD_ROUTES))) {
            $seconds = strtotime(Auth::user()->flood) - time();
            $word = ($seconds == 1) ? 'second' : 'seconds';
            $message = "You are trying to do things too quickly! Please wait {$seconds} {$word} before trying again.";

            if (time() < strtotime(Auth::user()->flood)) {
                if ($route == 'account.trades.process') {
                    if ($request->action == 'send')
                        return response()->json(['error' => $message]);
                } else if ($route == 'shop.favorite') {
                    return response()->json(['success' => false, 'error' => $message]);
                } else if ($request->is('api/*')) {
                    return response()->json(['error' => $message]);
                } else {
                    return back()->withErrors([$message]);
                }
            }

            $user = Auth::user();
            $user->flood = Carbon::createFromTimestamp(time() + config('site.flood_time'))->toDateTimeString();
            $user->save();
        }

        return $next($request);
    }
}
