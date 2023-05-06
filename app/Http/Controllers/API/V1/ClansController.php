<?php
/**
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
 */

namespace App\Http\Controllers\API\V1;

use App\Models\Clan;
use App\Models\ClanMember;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClansController extends Controller
{
    public function members($id, $rank, Request $request)
    {
        $clan = Clan::where('id', '=', $id);

        if (!$clan->exists())
            return response()->json([
                'error' => [
                    'message' => 'Record not found',
                    'prettyMessage' => 'Sorry, something went wrong'
                ]
            ]);

        $clan = $clan->first();
        $json = [];
        $limit = (in_array((integer) $request->limit, [1, 10, 20, 25, 50, 100])) ? $request->limit : 10;
        $members = ClanMember::where([
            ['clan_id', '=', $clan->id],
            ['rank', '=', $rank]
        ])->orderBy('updated_at', 'DESC')->paginate($limit);

        foreach ($members as $member) {
            $image = $member->user->avatar()->image;

            $json[] = [
                'id' => $member->id,
                'clan_id' => $member->clan_id,
                'user_id' => $member->user_id,
                'rank' => $member->rank,
                'status' => 'accepted',
                'created_at' => $member->created_at,
                'updated_at' => $member->updated_at,
                'user' => [
                    'id' => $member->user->id,
                    'username' => $member->user->username,
                    'avatar_hash' => ($image == 'default') ? config('site.renderer.default_filename') : $image,
                    'thumbnail' => $member->user->thumbnail(),
                    'url' => route('users.profile', $member->user->id)
                ]
            ];
        }

        return response()->json([
            'data'         => $json,
            'current_page' => $members->currentPage(),
            'total_pages'  => $members->lastPage()
        ]);
    }
}
