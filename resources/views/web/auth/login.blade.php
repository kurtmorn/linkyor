<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.default', [
    'title' => 'Login'
])

@section('content')
    <div class="col-1-3 push-1-3">
        <div class="card">
            <div class="top green">Login</div>
            <div class="content">
                <form action="{{ route('auth.login.authenticate') }}" method="POST">
                    @csrf
                    <input type="text" name="username" placeholder="Username" required>
                    <div style="height:5px;"></div>
                    <input style="display:block;" type="password" name="password" placeholder="Password" required>
                    <a href="{{ route('auth.forgot_password.index') }}" style="font-size:15px;">Forgot password?</a>
                    <div style="padding-top:5px;"></div>
                    <button class="green" type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>
@endsection
