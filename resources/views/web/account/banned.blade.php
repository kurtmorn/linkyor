<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.default', [
    'title' => 'Banned'
])

@section('content')
    <div class="col-10-12 push-1-12">
        <div class="card">
            <div class="top red">Your account has been suspended</div>
            <div class="content">
                <span class="dark-gray-text sbold">We have deemed that your account has violated our Terms of Service, and as such a punishment has been applied to your account. Further incompetence or violations to our Terms of Service will result in a termination of your account.</span>
                <div style="padding-left:20px;margin-top:20px;">
                    <div class="block" style="margin-bottom:20px;">
                        <b class="dark-gray-text">Ban Length:</b>
                        <span class="light-gray-text">{{ $length }}</span>
                    </div>
                    <div class="block" style="margin-bottom:20px;">
                        <b class="dark-gray-text">Ban Reason:</b>
                        <span class="light-gray-text">{{ $category }}</span>
                    </div>
                </div>
                @if ($ban->note)
                    <div style="padding-left:20px;margin-top:20px;">
                        <div class="block" style="margin-bottom:20px;">
                            <b class="dark-gray-text">Moderator Note:</b>
                            <span class="light-gray-text">{{  $ban->note}}</span>
                        </div>
                    </div>
                @endif
                <span class="dark-gray-text" style="font-size:16px;">Please make sure that you have read our <a href="{{ route('info.index', 'terms') }}" class="darker-gray-text bold" target="_blank">Terms of Service</a> before returning to make sure you and others have the best experience on {{ config('site.name') }}.</span>
                <hr>
                <div style="margin-bottom:10px;">
                    @if ($ban->length != 'closed')
                        @if ($canReactivate)
                            <form action="{{ route('account.banned.reactivate') }}" method="POST">
                                @csrf
                                <button class="blue" type="submit">Reactivate Account</button>
                            </form>
                        @else
                            <span class="dark-gray-text">You can reactivate your account on or after {{ $ban->banned_until->format('M d, Y h:i A') }}.</span>
                        @endif
                        <div style="margin-bottom:10px;"></div>
                    @endif
                    <span class="dark-gray-text" style="font-size:16px;">If you wish to appeal, contact a staff member in our Discord server.</span>
                </div>
            </div>
        </div>
    </div>
@endsection
