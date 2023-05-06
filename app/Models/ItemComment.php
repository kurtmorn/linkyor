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

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemComment extends Model
{
    use HasFactory;

    protected $table = 'item_comments';

    protected $fillable = [
        'item_id',
        'creator_id',
        'body'
    ];

    public function item()
    {
        return $this->belongsTo('App\Models\Item', 'item_id');
    }

    public function creator()
    {
        return $this->belongsTo('App\Models\User', 'creator_id');
    }

    public function scrub()
    {
        $this->timestamps = false;
        $this->body = '[ Content Removed ]';
        $this->save();
    }
}
