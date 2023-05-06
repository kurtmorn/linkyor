<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.admin', [
    'title' => 'Info'
])

@section('content')
    <div class="card">
        <div class="card-header">Site Statistics</div>
        <div class="card-body text-center">
            <div class="row">
                @foreach ($siteData as $title => $value)
                    <div class="col-6 col-md-3">
                        <h4>{{ $value }}</h4>
                        <h5 class="text-muted">{{ $title }}</h5>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">Server Information</div>
        <div class="card-body text-center">
            <div class="row">
                @foreach ($serverData as $title => $value)
                    <div class="col-6 col-md-3">
                        <h4>{{ $value }}</h4>
                        <h5 class="text-muted">{{ $title }}</h5>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
