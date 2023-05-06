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

use App\Models\ForumThread;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class ForumTopic extends Model
{
    use HasFactory;

    protected $table = 'forum_topics';

    protected $fillable = [
        'name',
        'description',
        'home_page_priority',
        'is_staff_only_viewing',
        'is_staff_only_posting'
    ];

    public function threads($hasPagination = true)
    {
        if (Auth::check() && Auth::user()->isStaff())
            $threads = ForumThread::where('topic_id', '=', $this->id)->orderBy('is_pinned', 'DESC')->orderBy('updated_at', 'DESC');
        else
            $threads = ForumThread::where([
                ['topic_id', '=', $this->id],
                ['is_deleted', '=', false]
            ])->orderBy('is_pinned', 'DESC')->orderBy('updated_at', 'DESC');

        return ($hasPagination) ? $threads->paginate(15) : $threads->get();
    }

    public function lastPost()
    {
        return ForumThread::where([
            ['topic_id', '=', $this->id],
            ['is_deleted', '=', false]
        ])->orderBy('updated_at', 'DESC')->first();
    }

    public function color()
    {
        return (!$this->is_staff_only_viewing) ? 'blue' : 'red';
    }
}
