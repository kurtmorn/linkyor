<?php
/**
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
 */

namespace App\Models;

use Carbon\Carbon;
use App\Models\Clan;
use App\Models\Game;
use App\Models\Trade;
use App\Models\Friend;
use App\Models\Status;
use App\Models\Message;
use App\Models\UserBan;
use App\Models\Purchase;
use App\Models\ForumView;
use App\Models\Inventory;
use App\Models\StaffUser;
use App\Models\UserAward;
use App\Models\UserLogin;
use App\Models\ClanMember;
use App\Models\ForumReply;
use App\Models\UserAvatar;
use App\Models\ForumThread;
use App\Models\ItemFavorite;
use App\Models\ItemReseller;
use App\Models\UserSettings;
use App\Models\UsernameHistory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'username',
        'email',
        'email_verified_at',
        'password',
        'description',
        'forum_signature',
        'currency_bits',
        'next_currency_payout',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'next_currency_payout' => 'datetime',
        'flood' => 'datetime'
    ];

    public function avatar()
    {
        return UserAvatar::where('user_id', '=', $this->id)->first();
    }

    public function setting()
    {
        return $this->belongsTo('App\Models\UserSettings', 'id');
    }

    public function thumbnail()
    {
        $url = config('site.storage_url');
        $time = time();
        $image = ($this->avatar()->image == 'default') ? config('site.renderer.default_filename') : $this->avatar()->image;
        $filename = "{$url}/thumbnails/{$image}.png";

        if ($image == $this->id)
            $filename .= "?cb={$time}";

        return $filename;
    }

    public function online()
    {
        return (strtotime($this->updated_at) + 300) > time();
    }

    public function updateFlood()
    {
        $this->flood = Carbon::createFromTimestamp(time() + 15)->toDateTimeString();
        $this->save();
    }

    public function usernameHistory()
    {
        return UsernameHistory::where('user_id', '=', $this->id)->orderBy('created_at', 'ASC')->get();
    }

    public function usernameHistoryString()
    {
        $i = 0;
        $string = '';

        $usernameHistory = $this->usernameHistory();
        $length = $usernameHistory->count();

        foreach ($usernameHistory as $usernameHistoryItem) {
            $i++;
            $string .= $usernameHistoryItem->username;

            if ($i < $length)
                $string .= ', ';
        }

        return $string;
    }

    public function hasMembership()
    {
        return !empty($this->membership_until);
    }

    public function hasVerifiedEmail()
    {
        return !empty($this->email_verified_at);
    }

    public function isWearingItem($id)
    {
        $avatar = $this->avatar();
        $avatar->timestamps = false;

        if ($avatar->hat_1 == $id)
            $column = 'hat_1';
        else if ($avatar->hat_2 == $id)
            $column = 'hat_2';
        else if ($avatar->hat_3 == $id)
            $column = 'hat_3';
        else if ($avatar->hat_4 == $id)
            $column = 'hat_4';
        else if ($avatar->hat_5 == $id)
            $column = 'hat_5';
        else if ($avatar->head == $id)
            $column = 'head';
        else if ($avatar->face == $id)
            $column = 'face';
        else if ($avatar->tool == $id)
            $column = 'tool';
        else if ($avatar->tshirt == $id)
            $column = 'tshirt';
        else if ($avatar->shirt == $id)
            $column = 'shirt';
        else if ($avatar->pants == $id)
            $column = 'pants';
        else if ($avatar->figure == $id)
            $column = 'figure';
        else
            return false;

        return $avatar->$column == $id;
    }

    public function takeOffItem($id)
    {
        $avatar = $this->avatar();
        $avatar->timestamps = false;

        if ($avatar->hat_1 == $id)
            $column = 'hat_1';
        else if ($avatar->hat_2 == $id)
            $column = 'hat_2';
        else if ($avatar->hat_3 == $id)
            $column = 'hat_3';
        else if ($avatar->head == $id)
            $column = 'head';
        else if ($avatar->face == $id)
            $column = 'face';
        else if ($avatar->tool == $id)
            $column = 'tool';
        else if ($avatar->tshirt == $id)
            $column = 'tshirt';
        else if ($avatar->shirt == $id)
            $column = 'shirt';
        else if ($avatar->pants == $id)
            $column = 'pants';
        else if ($avatar->figure == $id)
            $column = 'figure';
        else
            return false;

        $avatar->$column = null;
        $avatar->save();
    }

    public function moneySpent()
    {
        $purchases = Purchase::where('user_id', '=', $this->id)->get();
        $total = 0.00;

        foreach ($purchases as $purchase)
            $total += (int) $purchase->cost;

        return $total;
    }

    public function status()
    {
        $status = Status::where('creator_id', '=', $this->id)->orderBy('created_at', 'DESC')->first();

        return $status->message ?? null;
    }

    public function hasSeenForumThread($id)
    {
        return ForumView::where([
            ['user_id', '=', $this->id],
            ['thread_id', '=', $id]
        ])->exists();
    }

    /**
     * Staff
     */

    public function isStaff()
    {
        $permissions = StaffUser::where('user_id', '=', $this->id);

        if (!$permissions->exists())
            return false;

        foreach ($permissions->get() as $name => $permission) {
            if ($name != 'id' && $name != 'user_id' && $name != 'created_at' && $name != 'updated_at') {
                if (!$permission)
                    return false;
            }
        }

        return true;
    }

    public function staff($permission)
    {
        $permissions = StaffUser::where('user_id', '=', $this->id)->first();

        return $permissions->$permission ?? false;
    }

    /**
     * Bans
     */

    public function isBanned()
    {
        return UserBan::where([
            ['user_id', '=', $this->id],
            ['active', '=', true]
        ])->exists();
    }

    public function ban()
    {
        return UserBan::where([
            ['user_id', '=', $this->id],
            ['active', '=', true]
        ])->orderBy('created_at', 'ASC')->first();
    }

    public function bans()
    {
        return UserBan::where('user_id', '=', $this->id)->orderBy('updated_at', 'DESC')->paginate(25);
    }

    /**
     * IPs
     */

    public function ips()
    {
        $log = UserLogin::where('user_id', '=', $this->id)->get();
        $ips = [];

        foreach ($log as $l) {
            if (!in_array($l->ip, $ips))
                $ips[] = $l->ip;
        }

        return $ips;
    }

    public function registerIP()
    {
        $log = UserLogin::where('user_id', '=', $this->id)->orderBy('created_at', 'ASC')->first();

        return $log->ip;
    }

    public function lastIP()
    {
        $log = UserLogin::where('user_id', '=', $this->id)->orderBy('created_at', 'DESC')->first();

        return $log->ip;
    }

    public function accountsLinkedByIP()
    {
        $log = UserLogin::where('user_id', '!=', $this->id)->whereIn('ip', $this->ips())->get();
        $users = [];
        $times = [];

        foreach ($log as $l) {
            if (!isset($times[$l->user_id]))
                $times[$l->user_id] = 0;

            $times[$l->user_id]++;

            if (!in_array($l->user_id, $users))
                $users[] = $l->user_id;
        }

        $accounts = User::whereIn('id', $users)->get();

        foreach ($accounts as $account)
            $account->times_linked = $times[$account->id];

        return $accounts;
    }

    /**
     * Forum
     */

    public function forumLevelMaxExp()
    {
        return 1000 * pow(1.50, $this->forum_level - 1);
    }

    public function forumLevelUp($exp)
    {
        $levelMaxExp = $this->forumLevelMaxExp();

        if ($exp >= $levelMaxExp) {
            $remainingExp = $exp - $levelMaxExp;

            $this->forum_exp = $remainingExp;
            $this->forum_level += 1;
        } else {
            $this->forum_exp = $exp;
        }

        $this->save();
    }

    /**
     * Items
     */

    public function ownsItem($id)
    {
        return Inventory::where([
            ['user_id', '=', $this->id],
            ['item_id', '=', $id]
        ])->exists();
    }

    public function hasFavoritedItem($id)
    {
        return ItemFavorite::where([
            ['item_id', '=', $id],
            ['user_id', '=', $this->id]
        ])->exists();
    }

    public function resellableCopiesOfItem($id)
    {
        $resellableCopies = [];
        $copies = Inventory::where([
            ['user_id', '=', $this->id],
            ['item_id', '=', $id]
        ])->get();

        foreach ($copies as $copy) {
            $isReselling = ItemReseller::where('inventory_id', '=', $copy->id)->exists();

            if (!$isReselling) {
                $copy->serial = $copy->serial();
                $resellableCopies[] = $copy;
            }
        }

        return $resellableCopies;
    }

    /**
     * Games
     */

    public function games()
    {
        $games = Game::where('creator_id', '=', $this->id)->get();

        return $games;
    }

    public function gameLaunch($id, $type, $withProtocol = true)
    {
        $protocol = ($withProtocol) ? 'bldn:' : '';

        return $protocol . game_launch("{$this->id}hahaboop-{$id}-{$type}");
    }

    /**
     * Clans
     */

    public function clans()
    {
        $members = ClanMember::where('user_id', '=', $this->id)->get();
        $clans = [];

        foreach ($members as $member)
            $clans[] = $member->clan->id;

        return Clan::whereIn('id', $clans)->get();
    }

    public function hasPrimaryClan()
    {
        return !empty($this->primary_clan_id) && $this->isInClan($this->primary_clan_id);
    }

    public function primaryClan()
    {
        return $this->belongsTo('App\Models\Clan', 'primary_clan_id');
    }

    public function isInClan($id)
    {
        return ClanMember::where([
            ['user_id', '=', $this->id],
            ['clan_id', '=', $id]
        ])->exists();
    }

    public function rankInClan($id)
    {
        return ClanMember::where([
            ['user_id', '=', $this->id],
            ['clan_id', '=', $id]
        ])->first()->rank();
    }

    public function reachedClanLimit()
    {
        $count = ClanMember::where('user_id', '=', $this->id)->count();

        return $count >= 10;
    }

    /**
     * Awards
     */

    public function awards()
    {
        $awards = UserAward::where('user_id', '=', $this->id)->get();
        $array = [];

        foreach ($awards as $award) {
            $data = config('awards')[$award->award_id];

            $award = new \stdClass;
            $award->name = $data['name'];
            $award->description = $data['description'];
            $award->image = $data['image'];

            $array[] = $award;
        }

        return $array;
    }

    public function ownsAward($id)
    {
        return UserAward::where([
            ['user_id', '=', $this->id],
            ['award_id', '=', $id]
        ])->exists();
    }

    public function giveAward($id, $granter = null)
    {
        $badge = new UserAward;
        $badge->user_id = $this->id;
        $badge->granter_id = $granter;
        $badge->award_id = $id;
        $badge->save();
    }

    public function removeAward($id)
    {
        return UserAward::where([
            ['user_id', '=', $this->id],
            ['award_id', '=', $id]
        ])->delete();
    }

    /**
     * Friends
     */

    public function friendRequestCount()
    {
        return Friend::where([
            ['receiver_id', '=', $this->id],
            ['is_pending', '=', true]
        ])->count();
    }

    public function friendsOfMine()
    {
        return $this->belongsToMany($this, 'friends', 'sender_id', 'receiver_id');
    }

    public function friendOf()
    {
        return $this->belongsToMany($this, 'friends', 'receiver_id', 'sender_id');
    }

    public function friends()
    {
        return $this->friendsOfMine()->wherePivot('is_pending', '=', false)->orderBy('created_at', 'DESC')->get()->merge($this->friendOf()->wherePivot('is_pending', '=', false)->orderBy('created_at', 'DESC')->get());
    }

    /**
     * Counts
     */

    public function forumPostCount()
    {
        return ForumThread::where([
            ['creator_id', '=', $this->id],
            ['is_deleted', '=', false]
        ])->count() + ForumReply::where([
            ['creator_id', '=', $this->id],
            ['is_deleted', '=', false]
        ])->count();
    }

    public function messageCount()
    {
        return Message::where([
            ['receiver_id', '=', $this->id],
            ['seen', '=', false]
        ])->count();
    }

    public function tradeCount()
    {
        return Trade::where([
            ['receiver_id', '=', $this->id],
            ['status', '=', 'pending']
        ])->count();
    }

    public function visitCount()
    {
        $visits = 0;
        $games = $this->games();

        foreach ($games as $game)
            $visits += $game->visits;

        return $visits;
    }

    /**
     * Moderation
     */

    public function scrub($column)
    {
        $this->timestamps = false;

        switch ($column) {
            case 'username':
                $this->username = "[Deleted{$this->id}]";
                $this->save();
                break;
            case 'description':
            case 'forum_signature':
                $this->$column = '[ Content Removed ]';
                $this->save();
                break;
        }
    }
}
