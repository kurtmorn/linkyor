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

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Game extends Model
{
    use HasFactory;

    protected $table = 'games';

    protected $fillable = [
        'creator_id',
        'host_key',
        'name',
        'image'
    ];

    public function creator()
    {
        return $this->belongsTo('App\Models\User', 'creator_id');
    }

    public function thumbnail()
    {
        $url = config('site.storage_url');
        $filename = "{$url}/games/{$this->thumbnail}.png";

        if ($this->is_thumbnail_pending)
            return "{$url}/default/pendingset.png";
        else if ($this->thumbnail_url == 'declined')
            return "{$url}/default/declinedset.png";

        if (Str::startsWith($this->thumbnail, 'default_')) {
            $default = str_replace('default_', '', $this->thumbnail);
            $filename = "{$url}/default/games/{$default}.png";
        }

        return $filename;
    }
}
