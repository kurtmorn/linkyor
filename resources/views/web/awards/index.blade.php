<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.default', [
    'title' => 'Awards'
])

@section('content')
    <div class="col-10-12 push-1-12">
        @forelse ($categories as $category)
            <div class="card">
                <div class="top {{ $category['color'] }}">{{ $category['name'] }}</div>
                <div class="content">
                    @forelse ($awards[$category['name']] as $key => $award)
                        <div class="award-card">
                            <img src="{{ asset("images/awards/{$award['image']}.png") }}">
                            <div class="data">
                                <div class="very-bold">{{ $award['name'] }}</div>
                                <div style="padding:1px;"></div>
                                <span>{{ $award['description'] }}</span>
                            </div>
                        </div>

                        @if ($key != count($awards[$category['name']]) - 1)
                            <hr>
                        @endif
                    @empty
                        <span>This category has no awards.</span>
                    @endforelse
                </div>
            </div>
        @empty
            <span>There are currently no award categories.</span>
        @endforelse
    </div>
@endsection
