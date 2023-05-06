<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.default', [
    'title' => 'Forgot Password'
])

@section('content')
    <div class="col-10-12 push-1-12">
        <div class="card">
            <div class="top red">Accounts</div>
            <div class="content">
                <div class="col-2-12" style="display:inline-block;">
                    <img src="{{ $user->thumbnail() }}" style="width:128px;">
                </div>
                <div class="col-10-12" style="padding-top:60px;">
                    <div style="min-width:200px;"><b>{{ $user->username }}</b></div>
                    <form action="{{ route('auth.forgot_password.finish') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $passwordReset->token }}">
                        <input type="password" name="password" placeholder="Password" required>
                        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                        <div style="float:right;margin-top:-25px;">
                            <button class="blue" type="submit">RESET</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
