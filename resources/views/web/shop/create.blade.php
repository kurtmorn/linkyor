<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.default', [
    'title' => 'Create'
])

@section('meta')
    <meta
        name="routes"
        data-index="{{ route('shop.index') }}"
        data-index-title="Shop - {{ config('site.name') }}"
        data-upload="{{ route('shop.upload') }}"
    >
@endsection

@section('js')
    <script src="{{ js_file('shop/create') }}"></script>
@endsection

@section('content')
    @include('web.shop._header')
    <div class="col-10-12 push-1-12 item-holder" id="items">
        <div class="card">
            <div class="top green">Upload</div>
            <div class="content">
                <div id="types" style="text-align:center;">
                    <div style="display:inline-block;padding-bottom:20px;">
                        <div style="cursor:pointer;" data-type="shirt">
                            <img src="{{ asset('images/shop/shirt.png') }}">
                        </div>
                        <div>Shirt</div>
                    </div>
                    <div style="display:inline-block;padding-bottom:20px;">
                        <div style="cursor:pointer;" data-type="pants">
                            <img src="{{ asset('images/shop/pants.png') }}">
                        </div>
                        <div>Pants</div>
                    </div>
                </div>
                <form id="upload" style="display:none;">
                    <div class="col-1-3 agray-text very-bold">
                        <div>Title:</div>
                        <input class="mb2" type="text" name="title" placeholder="My Item" required>
                        <a href="{{ asset('images/shop/template.png') }}" class="mb2 button width-100 blue" style="font-size:10px;">DOWNLOAD TEMPLATE</a>
                        <button class="green" type="submit">UPLOAD</button>
                    </div>
                    <div class="col-1-3" style="text-align:center;">
                        <div class="agray-text very-bold" id="textureChosen" style="margin-bottom:5px;">No Texture Chosen</div>
                        <div class="file-img-box">
                            <img id="texture">
                        </div>
                        <label class="button orange small unselectable no-cap" for="upload-file-img">Choose Texture</label>
                        <input style="display:none;" type="file" name="img" id="upload-file-img" accept="image/jpeg, image/png">
                    </div>
                    <div class="col-1-3">
                        <div class="upload-preview-box">
                            <img id="preview">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
