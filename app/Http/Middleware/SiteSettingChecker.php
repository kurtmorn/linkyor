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
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class SiteSettingChecker
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
        $route = $request->route()->getName();
        $middleware = $request->route()->middleware();
        $api = $request->is('api/*');
        $isPOST = $request->isMethod('post');
        $maintenancePasswords = config('site.maintenance_passwords');
        $isMaintenanceEnabled = site_setting('maintenance_enabled');
        $isMaintenancePage = (!Auth::check()) ? Str::startsWith($route, ['maintenance.', 'auth.']) && !Auth::check() : Str::startsWith($route, ['maintenance.', 'auth.']);

        if (!$isMaintenanceEnabled)
            $isMaintenancePage = false;

        if (($isMaintenanceEnabled && !in_array(session('maintenance_password'), $maintenancePasswords)) || !$isMaintenanceEnabled && session()->has('maintenance_password'))
            session()->forget('maintenance_code');

        if ($isMaintenanceEnabled && !session()->has('maintenance_password') && $api)
            return response()->json([
                'error' => [
                    'message' => 'Maintenance is currently enabled',
                    'prettyMessage' => 'Maintenance is currently enabled'
                ]
            ]);

        if ($isMaintenanceEnabled && !session()->has('maintenance_password') && !Str::startsWith($route, ['maintenance.', 'auth.']))
            return redirect()->route('maintenance.index');

        if (!$isMaintenanceEnabled && Str::startsWith($route, 'maintenance.'))
            return $this->disabled('Maintenance', $middleware, $isPOST);

        if (!site_setting('item_purchases_enabled') && $route == 'shop.purchase')
            return $this->disabled('Shop', $middleware, $isPOST);

        if (!site_setting('forum_enabled') && Str::startsWith($route, 'forum.'))
            return $this->disabled('Forum', $middleware, $isPOST);

        if (!site_setting('item_creation_enabled') && Str::startsWith($route, 'shop.create.'))
            return $this->disabled('Create', $middleware, $isPOST);

        if (!site_setting('avatar_editor_enabled') && Str::startsWith($route, 'account.character.'))
            return $this->disabled('Customize', $middleware, $isPOST);

        if (!site_setting('trading_enabled') && Str::startsWith($route, 'account.trades.'))
            return $this->disabled('Trades', $middleware, $isPOST);

        if (!site_setting('clans_enabled') && (Str::startsWith($route, 'clans.')))
            return $this->disabled('Clans', $middleware, $isPOST);

        if (!site_setting('settings_enabled') && Str::startsWith($route, 'account.settings.'))
            return $this->disabled('Settings', $middleware, $isPOST);

        if (!site_setting('registration_enabled') && $route == 'auth.register.authenticate')
            return $this->disabled('Register', $middleware, $isPOST);

        $request->merge(compact('isMaintenanceEnabled', 'isMaintenancePage'));

        return $next($request);
    }

    public function disabled($feature, $middleware, $isPOST)
    {
        if ($feature == 'Maintenance')
            abort(403);
        else if (!Auth::check() && in_array('auth', $middleware))
            return redirect()->route('auth.login.index');
        else if (Auth::check() && in_array('guest', $middleware))
            return redirect()->route('home.dashboard');
        else if ($isPOST || ((!Auth::check() || (Auth::check() && !Auth::user()->isStaff())) && in_array('staff', $middleware)))
            return abort(404);

        return response()->view('errors.feature_disabled', [
            'title' => $feature
        ]);
    }
}
