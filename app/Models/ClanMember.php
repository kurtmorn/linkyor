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

use App\Models\ClanRank;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClanMember extends Model
{
    use HasFactory;

    protected $table = 'clan_members';

    protected $fillable = [
        'user_id',
        'clan_id',
        'rank'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function clan()
    {
        return $this->belongsTo('App\Models\Clan', 'clan_id');
    }

    public function rank()
    {
        return ClanRank::where([
            ['clan_id', '=', $this->clan_id],
            ['rank', '=', $this->rank]
        ])->first();
    }
}
