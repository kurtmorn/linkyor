<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.default', [
    'title' => 'Create Clan'
])

@section('content')
    <div class="col-10-12 push-1-12">
        <div class="card" style="margin-bottom:20px;">
            <div class="top green">Create Clan</div>
            <div class="content">
                <div style="width:100%;">
                    <form action="{{ route('clans.purchase') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input class="upload-input" style="width:50px;margin-right:5px;display:inline-block;" type="text" name="tag" placeholder="Tag" required>
                        <input class="upload-input" style="display:inline-block;" type="text" name="name" placeholder="Title" required>
                        <input class="upload-input" style="border:0;" type="file" name="image" required>
                        <textarea class="upload-input" style="width:320px;height:100px;" name="description" placeholder="Description"></textarea>
                        <span style="color:green;display:block;">This will cost <span class="bucks-icon"></span>{{ config('site.clan_creation_price') }}</span>
                        <button class="green" type="submit">PURCHASE CLAN</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
