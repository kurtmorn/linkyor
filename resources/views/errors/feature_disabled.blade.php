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
    <div class="col-8-12 push-2-12">
        <div class="card">
            <div class="content rounded center-text" style="padding:25px;">
                <i class="fas fa-exclamation-triangle text-warning mb-3" style="color:orange;font-size:80px;"></i>
                <h3>{{ $title }}</h3>
                <span>This feature is currently disabled.</span>
            </div>
        </div>
    </div>
@endsection
