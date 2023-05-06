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
use App\Models\ClanMember;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Clan extends Model
{
    use HasFactory;

    protected $table = 'clans';

    protected $fillable = [
        'owner_id',
        'tag',
        'name',
        'description',
        'thumbnail'
    ];

    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'owner_id');
    }

    public function thumbnail()
    {
        $url = config('site.storage_url');

        if ($this->is_thumbnail_pending)
            return "{$url}/default/pending.png";
        else if ($this->thumbnail == 'declined')
            return "{$url}/default/declined.png";

        return "{$url}/thumbnails/{$this->thumbnail}.png";
    }

    public function slug()
    {
        $name = str_replace('-', ' ', $this->name);

        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    }

    public function members()
    {
        return ClanMember::where('clan_id', '=', $this->id)->get();
    }

    public function ranks()
    {
        return ClanRank::where('clan_id', '=', $this->id)->orderBy('rank', 'ASC')->get();
    }
}
