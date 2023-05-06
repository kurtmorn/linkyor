<?php
/**
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
 */

namespace App\Http\Controllers\Web\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Invite;
use App\Models\StaffUser;
use App\Models\UserLogin;
use App\Models\RegisterIP;
use App\Models\UserAvatar;
use Illuminate\Support\Str;
use App\Models\UserSettings;
use Illuminate\Http\Request;
use App\Models\UsernameHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\Manage\StaffController;

class RegisterController extends Controller
{
    public function index(Request $request)
    {
        return view('web.auth.register');
    }

    public function authenticate(Request $request)
    {
        $emailDomain = substr(strrchr($_POST['email'], '@'), 1);
        $isInUsernameHistory = UsernameHistory::where('username', '=', $request->username)->exists();
        $accountsWithSameIP = RegisterIP::where('ip', '=', $request->ip())->count();
        $validate = [
            'username' => ['required', 'min:3', 'max:26', 'regex:/\\A[a-z\\d]+(?:[.-][a-z\\d]+)*\\z/i', 'unique:users'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:6', 'max:255']
        ];

        if (config('app.env') == 'production')
            $validate['g-recaptcha-response'] = ['required', 'captcha'];

        $this->validate($request, $validate, [
            'username.unique' => 'Username has already been taken.',
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'g-recaptcha-response.captcha' => 'Captcha error. Try again.'
        ]);

        if ($isInUsernameHistory)
            return back()->withErrors(['Username has already been taken.']);

        if (config('app.env') == 'production' && $accountsWithSameIP >= 4)
            return back()->withErrors(['You have reached the limit of 4 accounts.']);

        if (!in_array($emailDomain, config('email_whitelist')))
            return back()->withErrors(['Sorry, this email cannot be used. Please try another.']);

        $user = new User;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->currency_bits = 100; // Remove later, ok?
        $user->next_currency_payout = Carbon::now()->addHours(24)->toDateTimeString();
        $user->save();

        $login = new UserLogin;
        $login->user_id = $user->id;
        $login->ip = $request->ip();
        $login->save();

        $avatar = new UserAvatar;
        $avatar->user_id = $user->id;
        $avatar->save();

        $settings = new UserSettings;
        $settings->user_id = $user->id;
        $settings->save();

        if ($user->id == 1) {
            $user->giveAward(3);

            $permissions = StaffController::STAFF_PERMISSIONS;

            $staffUser = new StaffUser;
            $staffUser->user_id = $user->id;
            $staffUser->password = bcrypt('password');

            foreach ($permissions as $options)
                foreach ($options as $option)
                    $staffUser->$option = true;

            $staffUser->save();
        }

        $registerIP = new RegisterIP;
        $registerIP->ip = $request->ip();
        $registerIP->save();

        Auth::login($user);

        return redirect()->route('home.dashboard')->with('success_message', 'You have successfully created your account!');
    }
}
