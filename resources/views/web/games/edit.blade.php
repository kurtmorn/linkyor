<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.default', [
    'title' => 'Edit Set'
])

@section('js')
    <script src="{{ js_file('games/edit') }}"></script>
@endsection

@section('content')
    <div class="col-10-12 push-1-12">
        <div class="card" style="margin-bottom:20px;">
            <div class="top green">Edit {{ $game->name }}</div>
            <div class="content">
                <div class="col-1-3 agray-text very-bold">
                    <form action="{{ route('games.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $game->id }}">
                        <div>Title:</div>
                        <input style="margin-bottom:10px;" type="text" name="name" placeholder="My Set" value="{{ $game->name }}" required>
                        <div>Description</div>
                        <textarea class="width-100 block" style="height:80px;margin-bottom:10px;" name="description" placeholder="Have fun!">{{ $game->description }}</textarea>
                        <div style="margin-bottom:10px;">
                            <label for="thumbnail">Thumbnail</label><br>
                            @if (!$game->is_thumbnail_pending)
                                <input style="background:transparent;border:0;padding:0;" name="thumbnail" type="file">
                            @else
                                <input class="width-100 block" style="background:transparent;border:0;padding:0;" type="text" value="Thumbnail is currently pending." readonly disabled>
                            @endif
                        </div>
                        <button class="green" type="submit">SAVE</button>
                        <a href="{{ route('games.view', $game->id) }}" class="button red" style="font-size:0.85rem;font-weight:500;">Cancel</a>
                    </form>
                </div>
                <div class="col-2-3 agray-text very-bold" style="padding-left:25px;">
                    <div>Host Key:</div>
                    <div style="font-size:13px;">This is used to host your set.</div>
                    <input class="width-100 block" style="margin-bottom:10px;" type="password" id="hostKey" value="{{ $game->host_key }}" readonly disabled>
                    <button class="blue" id="showHostKey">Show Key</button>
                </div>
            </div>
        </div>
    </div>
@endsection
