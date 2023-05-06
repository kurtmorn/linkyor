<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.default', [
    'title' => 'Maintenance'
])

@section('content')
    <div style="text-align:center;padding-top:50px;">
        <span style="font-weight:600;font-size:3rem;display:block;">Welcome to {{ config('site.name') }}</span>
        <span style="font-weight:500;font-size:2rem;">We are currently under maintenance.</span>
        <form action="{{ route('maintenance.authenticate') }}" method="POST" style="margin-top:20px;">
            @csrf
            <input type="password" name="key" placeholder="Maintenance Key">
            <div style="padding:2.5px;"></div>
            <button class="blue" type="submit">SUBMIT</button>
        </form>
    </div>
@endsection
