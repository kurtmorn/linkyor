<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.default', [
    'title' => 'Inbox'
])

@section('content')
    <div class="col-10-12 push-1-12">
        <div class="tabs">
            <a href="{{ route('account.inbox.index', '') }}" class="tab @if ($category == 'incoming') active @endif col-6-12">Inbox</a>
            <a href="{{ route('account.inbox.index', 'sent') }}" class="tab @if ($category == 'sent') active @endif col-6-12">Outbox</a>
            <div class="tab-holder" style="box-shadow:none;">
                <div class="tab-body active">
                    <div class="content" style="padding:0px">
                        @forelse ($messages as $message)
                            <a href="{{ route('account.inbox.message', $message->id) }}">
                                <div class="hover-card thread-card m0 {{ (!$message->seen && $message->receiver_id == Auth::user()->id) ? 'viewed' : '' }}">
                                    <div class="col-7-12 topic">
                                        <span class="small-text label dark">{{ $message->title }}</span>
                                        <br>
                                        @if ($message->receiver->id == Auth::user()->id)
                                            <span class="label smaller-text">From <span class="darkest-gray-text">{{ $message->sender->username }}</span></span>
                                        @else
                                            <span class="label smaller-text">To <span class="darkest-gray-text">{{ $message->receiver->username }}</span></span>
                                        @endif
                                    </div>
                                    <div class="no-mobile overflow-auto topic">
                                        <div class="col-1-1 stat" style="text-align:right;">
                                            <span class="title" title="{{ $message->created_at->format('D, M d Y h:i A') }}">{{ $message->created_at->diffForHumans() }}</span>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div style="text-align:center;padding:10px;">
                                <span>You don't have any messages!</span>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-10-12 push-1-12">
        <div class="pages">{{ $messages->onEachSide(1) }}</div>
    </div>
@endsection
