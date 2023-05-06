<?php
/**
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
 */

namespace App\Http\Controllers\Web;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    public function index()
    {
        if (session()->has('maintenance_password'))
            return redirect()->route('home.index');

        return view('web.maintenance.index');
    }

    public function authenticate(Request $request)
    {
        $maintenancePasswords = config('site.maintenance_passwords');

        if (session()->has('maintenance_password'))
            return back()->withErrors(['Already authenticated.']);

        if (!$request->key)
            return back()->withErrors(['Please provide a key.']);

        if (!in_array($request->key, $maintenancePasswords))
            return back()->withErrors(['Invalid key.']);

        session()->put('maintenance_password', $request->key);
        session()->save();

        return redirect()->route('home.index');
    }

    public function exit()
    {
        session()->forget('maintenance_password');

        return redirect()->route('maintenance.index');
    }
}
