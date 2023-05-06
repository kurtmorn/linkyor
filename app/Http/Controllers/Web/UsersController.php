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

use Carbon\Carbon;
use App\Models\User;
use App\Models\Clan;
use App\Models\Friend;
use Illuminate\Http\Request;
use App\Models\UsernameHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $search = (isset($request->search)) ? trim($request->search) : '';
        $where = [
            ['username', 'LIKE', "%{$search}%"]
        ];

        switch ($request->category) {
            case '':
            case 'all':
                $category = 'all';
                break;
            case 'online':
                $category = 'online';
                $where[] = ['updated_at', '>=', Carbon::now()->subMinutes(3)];
                break;
            default:
                abort(404);
        }

        $users = User::where($where)->orderBy('created_at', 'ASC')->paginate(25);

        return view('web.users.index')->with([
            'category' => $category,
            'users' => $users
        ]);
    }

    public function profile($id)
    {
        $user = User::where('id', '=', $id)->firstOrFail();
        $friends = $user->friends()->take(6);
        $clans = $user->clans()->take(6);

        if (Auth::check()) {
            $friendsArray = [];

            foreach ($user->friends() as $friend)
                $friendsArray[] = $friend->id;

            $areFriends = in_array(Auth::user()->id, $friendsArray);
            $isPending = Friend::where('is_pending', '=', true)->where(function($query) use($user) {
                $query->where([
                    ['receiver_id', '=', $user->id],
                    ['sender_id', '=', Auth::user()->id]
                ])->orWhere([
                    ['receiver_id', '=', Auth::user()->id],
                    ['sender_id', '=', $user->id]
                ]);
            })->first();
        }

        return view('web.users.profile')->with([
            'user' => $user,
            'friends' => $friends,
            'clans' => $clans,
            'areFriends' => $areFriends ?? false,
            'isPending' => $isPending ?? false
        ]);
    }

    public function friends($id)
    {
        $user = User::where('id', '=', $id)->firstOrFail();
        $friendsArray = [];

        foreach ($user->friends() as $friend)
            $friendsArray[] = $friend->id;

        $friends = User::whereIn('id', $friendsArray)->paginate(25);

        return view('web.users.friends')->with([
            'user' => $user,
            'friends' => $friends
        ]);
    }

    public function clans($id)
    {
        $user = User::where('id', '=', $id)->firstOrFail();
        $array = [];

        foreach ($user->clans() as $clan)
            $array[] = $clan->id;

        $clans = Clan::whereIn('id', $array)->paginate(25);

        return view('web.users.clans')->with([
            'user' => $user,
            'clans' => $clans
        ]);
    }
}
