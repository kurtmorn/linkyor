<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.default', [
    'title' => 'Edit Item'
])

@section('meta')
    <meta
        name="routes"
        data-index="{{ route('shop.index') }}"
        data-index-title="Shop - {{ config('site.name') }}"
    >
@endsection

@section('js')
    <script src="{{ js_file('shop/edit') }}"></script>
@endsection

@section('content')
    @include('web.shop._header')
    <div class="col-10-12 push-1-12 item-holder" id="items">
        <div class="card" style="margin-bottom:20px;">
            <div class="top green">Edit {{ $item->name }}</div>
            <div class="content">
                <div class="col-1-3 agray-text very-bold">
                    <form action="{{ route('shop.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <div>Title:</div>
                        <input style="margin-bottom:10px;" type="text" name="name" placeholder="My Item" value="{{ $item->name }}" required>
                        <div>Description</div>
                        <textarea class="width-100 block" style="height:80px;margin-bottom:10px;" name="description" placeholder="Brand new design!">{{ $item->description }}</textarea>
                        <div class="mb3">
                            <span>For Sale:</span>
                            <input style="vertical-align:middle;" type="checkbox" name="onsale" @if ($item->onsale()) checked @endif>
                        </div>
                        <div class="block" style="margin-bottom:10px;">
                            <div>Price:</div>
                            <span class="bucks-icon" style="vertical-align:middle;padding-right:0px;"></span>
                            <input style="width:100px;" type="number" name="price_bucks" placeholder="0 bucks" value="{{ $item->price_bucks }}" min="0" max="1000000">
                            <span class="bits-icon" style="vertical-align:middle;padding-right:0px;"></span>
                            <input style="width:100px;" type="number" name="price_bits" placeholder="0 bits" value="{{ $item->price_bits }}" min="0" max="1000000">
                        </div>
                        <button class="green" type="submit">SAVE</button>
                        <a href="{{ route('shop.item', $item->id) }}" class="button red" style="font-size:0.85rem;font-weight:500;">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
