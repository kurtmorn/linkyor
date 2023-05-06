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
            <a href="{{ route('forum.topic', $topic->id) }}">{{ $topic->name }}</a>
            @if ($thread)
                <i class="fa fa-angle-double-right" style="font-size:1rem;" aria-hidden="true"></i>
                <a href="{{ route('forum.thread', $thread->id) }}">
                    <span class="weight700 bold">{{ $thread->title }}</span>
                </a>
            @endif
        </div>
        <div class="card">
            <div class="top {{ $topic->color() }}">{{ $title }}</div>
            <div class="content">
                <form action="{{ route('forum.create') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $id }}">
                    <input type="hidden" name="type" value="{{ $type }}">

                    @if ($quote)
                        <blockquote class="{{ $topic->color() }}">
                            <em>Quote from <a href="{{ route('users.profile', $quote->creator->id) }}" style="color:#444">{{ $quote->creator->username }}</a>, {{ $quote->created_at->format('h:i A d/m/Y') }}</em>
                            <br>
                            {!! nl2br(e($quote->body)) !!}
                        </blockquote>
                    @endif

                    @if ($type == 'thread')
                        <input style="width:100%;font-size:16px;box-sizing:border-box;" type="text" name="title" placeholder="Title (max 60 characters)" required>
                    @endif

                    <textarea style="width:100%;min-height:200px;font-size:16px;box-sizing:border-box;margin-top:10px;" name="body" placeholder="Body (max 3,000 characters)" required></textarea>
                    <div style="text-align:center;">
                        <button type="submit" class="button smaller-text {{ $topic->color() }}">Create {{ ucfirst($type) }}</button>
                        {{-- <button type="button" id="draft" class="button smaller-text {{ $topic->color() }}">Save as Draft</button> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
