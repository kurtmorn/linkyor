<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.default', [
    'title' => 'Clans'
])

@section('content')
    <div class="col-10-12 push-1-12">
        <div class="card">
            <div class="top orange">Clans</div>
            <div class="content">
                @if ($clans->count() == 0)
                    <div style="text-align:center">
                        <span>This user is not in any clans</span>
                    </div>
                @else
                    @foreach ($clans as $clan)
                        <a href="{{ route('clans.view', $clan->id) }}">
                            <div class="profile-card not-padded" style="width:calc(100% / 6 - 8px)">
                                <img src="{{ $clan->thumbnail() }}">
                                <span class="ellipsis">{{ $clan->name }}</span>
                            </div>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="pages">{{ $clans->onEachSide(1) }}</div>
    </div>
@endsection
