<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.default', [
    'title' => $message->title
])

@section('js')
    <script src="{{ js_file('account/inbox/message') }}"></script>
@endsection

@section('content')
    <div class="col-10-12 push-1-12">
        <div class="card">
            <div class="top blue">{{ $message->title }}</div>
            <div class="content" style="position:relative;">
                <div class="user-info" style="width:250px;overflow:hidden;display:inline-block;float:left;">
                    <a href="{{ route('users.profile', $message->sender->id) }}">
                        <img src="{{ $message->sender->thumbnail() }}" style="width:200px;display:block;">
                        <span style="white-space:nowrap;">{{ $message->sender->username }}</span>
                    </a>
                </div>
                <div style="padding-left:250px;padding-bottom:10px;">{!! nl2br(e($message->body)) !!}</div>
                @if ($message->sender->id != Auth::user()->id && !$message->sender->isStaff() && $message->receiver->id == Auth::user()->id)
                    <div class="admin-forum-options" style="position:absolute;bottom:0;right:2px;padding-bottom:5px;">
                        <a href="{{ route('report.index', ['message', $message->id]) }}" class="dark-gray-text cap-text">Report</a>
                    </div>
                @endif
            </div>
        </div>
        @if ($message->sender->id != Auth::user()->id)
            <div class="card reply-card" id="replyCard" style="display:none;">
                <div class="content" style="padding:15px;">
                    <form action="{{ route('account.inbox.create') }}" method="POST"">
                        @csrf
                        <input type="hidden" name="id" value="{{ $message->id }}">
                        <input type="hidden" name="type" value="reply">
                        <textarea style="width:100%;height:250px;box-sizing:border-box;" name="body"></textarea>
                        <button class="forum-button blue" style="margin:10px auto 10px auto;display:block;" type="submit">SEND</button>
                    </form>
                </div>
            </div>
            <div class="center-text">
                <a class="button blue inline" id="replyButton" style="margin:10px auto 10px auto;">REPLY</a>
            </div>
        @endif
    </div>
@endsection
