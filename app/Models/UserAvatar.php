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

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserAvatar extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'user_avatars';

    protected $fillable = [
        'user_id'
    ];

    public function hat($num)
    {
        return Item::where('id', '=', $this->{"hat_{$num}"})->first();
    }

    public function face()
    {
        return Item::where('id', '=', $this->face)->first();
    }

    public function tool()
    {
        return Item::where('id', '=', $this->tool)->first();
    }

    public function tshirt()
    {
        return Item::where('id', '=', $this->tshirt)->first();
    }

    public function shirt()
    {
        return Item::where('id', '=', $this->shirt)->first();
    }

    public function pants()
    {
        return Item::where('id', '=', $this->pants)->first();
    }

    public function head()
    {
        return Item::where('id', '=', $this->head)->first();
    }

    public function figure()
    {
        return Item::where('id', '=', $this->figure)->first();
    }

    public function reset()
    {
        $thumbnail = "thumbnails/{$this->image}.png";
        $headshot = "thumbnails/{$this->image}_headshot.png";

        $this->timestamps = false;
        $this->image = 'default';
        $this->hat_1 = null;
        $this->hat_2 = null;
        $this->hat_3 = null;
        $this->hat_4 = null;
        $this->hat_5 = null;
        $this->head = null;
        $this->face = null;
        $this->tool = null;
        $this->tshirt = null;
        $this->shirt = null;
        $this->pants = null;
        $this->angle = 'right';
        $this->color_head = '#f3b700';
        $this->color_torso = '#1c4399';
        $this->color_left_arm = '#f3b700';
        $this->color_right_arm = '#f3b700';
        $this->color_left_leg = '#85ad00';
        $this->color_right_leg = '#85ad00';
        $this->save();

        if (Storage::exists($thumbnail))
            Storage::delete($thumbnail);

        if (Storage::exists($headshot))
            Storage::delete($headshot);
    }
}
