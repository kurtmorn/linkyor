<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.admin', [
    'title' => 'Login'
])

@section('content')
    <h3 class="text-center mb-3"><strong>Admin</strong></h3>
    <div class="card">
        <div class="card-header">Login</div>
        <div class="card-body">
            <form action="{{ route('admin.login.authenticate') }}" method="POST">
                @csrf

                @if ($returnLocation)
                    <input type="hidden" name="return_location" value="{{ $returnLocation }}">
                @endif

                <label for="username" style="font-weight:600;margin-bottom:5px;">Username</label>
                <input class="form-control mb-2" type="text" name="username" placeholder="Username" required>
                <label for="username" style="font-weight:600;margin-bottom:5px;">Password</label>
                <input class="form-control mb-2" type="password" name="password" placeholder="Password" required>

                @if (config('site.admin_panel_code'))
                    <label for="username" style="font-weight:600;margin-bottom:5px;">Secret Code</label>
                    <input class="form-control mb-2" type="password" name="code" placeholder="Code" required>
                @endif

                <div class="mb-3"></div>
                <button class="blue" type="submit">Login</button>
            </form>
        </div>
    </div>
@endsection
