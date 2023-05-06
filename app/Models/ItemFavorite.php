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

class ItemFavorite extends Model
{
    use HasFactory;

    protected $table = 'item_favorites';

    protected $fillable = [
        'item_id',
        'user_id'
    ];

    public function item()
    {
        return $this->belongsTo('App\Models\Item', 'item_id');
    }
}
