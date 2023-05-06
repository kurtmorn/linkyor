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

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventories';

    protected $fillable = [
        'user_id',
        'item_id',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function item()
    {
        return $this->belongsTo('App\Models\Item', 'item_id');
    }

    public function serial()
    {
        $items = $this->where('item_id', '=', $this->item_id)->get();
        $list = [];

        foreach ($items as $item)
            $list[] = $item->id;

        return array_search($this->id, $list) + 1;
    }
}
