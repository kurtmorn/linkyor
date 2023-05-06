<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.default', [
    'title' => 'Shop'
])

@section('js')
    <script src="{{ js_file('shop/index') }}"></script>
@endsection

@section('content')
    @include('web.shop._header')
    <div class="col-10-12 push-1-12" id="items"></div>
@endsection
