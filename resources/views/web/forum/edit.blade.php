<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.default', [
    'title' => $title
])

@section('content')
    <div class="col-10-12 push-1-12">
        <div class="col-8-12">
            @include('web.forum._header')
        </div>
    </div>
    <div class="col-10-12 push-1-12">
        <div class="forum-bar weight600" style="padding:10px 5px 10px 0;">
            <a href="{{ route('forum.index') }}">Forum</a>
            <i class="fa fa-angle-double-right" style="font-size:1rem;" aria-hidden="true"></i>
            <a href="{{ route('forum.topic', ($type == 'thread') ? $post->topic->id : $post->thread->topic->id) }}">{{ ($type == 'thread') ? $post->topic->name : $post->thread->topic->name }}</a>
            <i class="fa fa-angle-double-right" style="font-size:1rem;" aria-hidden="true"></i>
            <a href="{{ route('forum.thread', ($type == 'thread') ? $post->id : $post->thread->id) }}">
                <span class="weight700 bold">{{ ($type == 'thread') ? $post->title : $post->thread->title }}</span>
            </a>
        </div>
        <div class="card">
            <div class="top {{ ($type == 'thread') ? $post->topic->color() : $post->thread->topic->color() }}">{{ $title }}</div>
            <div class="content">
                <form action="{{ route('forum.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $id }}">
                    <input type="hidden" name="type" value="{{ $type }}">

                    @if ($post->quote)
                        <blockquote class="{{ ($type == 'thread') ? $post->topic->color() : $post->thread->topic->color() }}">
                            <em>Quote from <a href="{{ route('users.profile', $post->quote->creator->id) }}" style="color:#444">{{ $post->quote->creator->username }}</a>, {{ $post->quote->created_at->format('h:i A d/m/Y') }}</em>
                            <br>
                            {!! nl2br(e($post->quote->body)) !!}
                        </blockquote>
                    @endif

                    @if ($type == 'thread')
                        <input style="width:100%;font-size:16px;box-sizing:border-box;" type="text" name="title" placeholder="Title (max 60 characters)" value="{{ $post->title }}" required>
                    @endif

                    <textarea style="width:100%;min-height:200px;font-size:16px;box-sizing:border-box;margin-top:10px;" name="body" placeholder="Body (max 3,000 characters)" required>{{ $post->body }}</textarea>
                    <div style="text-align:center;">
                        <button type="submit" class="button smaller-text {{ ($type == 'thread') ? $post->topic->color() : $post->thread->topic->color() }}">Edit {{ ucfirst($type) }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
