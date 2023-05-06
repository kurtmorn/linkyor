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
        <div class="card">
            <div class="top blue">{{ $title }}</div>
            <div class="content">
                @include("web.info._{$view}", $variables)
            </div>
        </div>
    </div>
@endsection
