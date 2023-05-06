<?php
/**
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
 */

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\IPBan;
use App\Models\Inventory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request, $next) {
            if (!staffUser()->staff('can_view_user_info')) abort(404);

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $search = (isset($request->search)) ? trim($request->search) : '';
        $users = User::where('username', 'LIKE', "%{$search}%")->orderBy('created_at', 'ASC')->paginate(25);

        return view('admin.users.index')->with([
            'search' => $search,
            'users' => $users ?? null
        ]);
    }

    public function view($id)
    {
        $user = User::where('id', '=', $id)->firstOrFail();
        $ipBans = IPBan::where('unbanner_id', '=', null)->whereIn('ip', $user->ips())->get();
        $ipBanned = $ipBans->count() > 0;

        return view('admin.users.view')->with([
            'user' => $user,
            'ipBanned' => $ipBanned
        ]);
    }

    public function update(Request $request)
    {
        $user = User::where('id', '=', $request->id)->firstOrFail();
        $user->timestamps = false;

        switch ($request->action) {
            case 'unban':
                if (!staffUser()->staff('can_unban_users')) abort(404);

                $ban = $user->ban();
                $ban->unbanner_id = staffUser()->id;
                $ban->active = false;
                $ban->save();

                return back()->with('success_message', 'User has been unbanned.');
            case 'password':
                if (!staffUser()->staff('can_reset_user_passwords')) abort(404);

                $password = Str::random(25);

                $user->password = bcrypt($password);
                $user->save();

                return back()->with('success_message', "User password has been changed to <strong>{$password}</strong>.");
            case 'ip_ban':
                $ipBans = IPBan::where('unbanner_id', '=', null)->whereIn('ip', $user->ips())->get();
                $ipBanned = $ipBans->count() > 0;
                $message = 'User has been IP banned.';

                if ($ipBanned) {
                    $message = 'User is no longer IP banned.';

                    if (!staffUser()->staff('can_ip_unban_users')) abort(404);

                    foreach ($ipBans as $ipBan) {
                        $ipBan->unbanner_id = staffUser()->id;
                        $ipBan->save();
                    }
                } else {
                    if (!staffUser()->staff('can_ip_ban_users')) abort(404);

                    foreach ($user->ips() as $ip) {
                        $ipBan = new IPBan;
                        $ipBan->banner_id = staffUser()->id;
                        $ipBan->ip = $ip;
                        $ipBan->save();
                    }
                }

                return back()->with('success_message', $message);
            case 'scrub_username':
            case 'scrub_description':
            case 'scrub_forum_signature':
                if (!staffUser()->staff('can_edit_user_info')) abort(404);

                $column = str_replace('scrub_', '', $request->action);
                $word = ucfirst(str_replace('_', ' ', $column));

                $user->scrub($column);

                return back()->with('success_message', "{$word} has been scrubbed.");
            case 'remove_membership':
                if (!staffUser()->staff('can_edit_user_info')) abort(404);

                if (!$user->hasMembership())
                    return back()->withErrors(['This user does not have a membership.']);

                $user->membership_until = null;
                $user->save();

                return back()->with('success_message', 'User membership has been removed.');
            case 'grant_membership':
                if (!staffUser()->staff('can_edit_user_info')) abort(404);

                switch ($request->membership_length) {
                    case '1_month':
                        $months = 1;
                        break;
                    case '3_months':
                        $months = 3;
                        break;
                    case '6_months':
                        $months = 6;
                        break;
                    case '1_year':
                        $months = 12;
                        break;
                    case 'forever':
                        $months = 150;
                        break;
                    default:
                        abort(404);
                }

                $time = ($request->membership_length == 'forever') ? 'a lifetime' : str_replace('_', ' ', $request->membership_length);

                $user->membership_until = Carbon::now()->addMonths($months)->toDateTimeString();
                $user->save();

                return back()->with('success_message', "User has been granted {$time} worth of membership.");
            case 'regen':
                if (!staffUser()->staff('can_render_thumbnails')) abort(404);

                render($user->id, 'user');

                return back()->with('success_message', 'User thumbnail has been regenerated.');
            case 'reset':
                if (!staffUser()->staff('can_render_thumbnails')) abort(404);

                $user->avatar()->reset();

                return back()->with('success_message', 'User avatar has been reset.');
            default:
                abort(404);
        }
    }
}
