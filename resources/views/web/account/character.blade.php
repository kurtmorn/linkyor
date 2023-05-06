<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.default', [
    'title' => 'Customize'
])

@section('meta')
    <meta
        name="routes"
        data-regen="{{ route('account.character.regenerate') }}"
        data-inventory="{{ route('account.character.inventory') }}"
        data-wearing="{{ route('account.character.wearing') }}"
        data-update="{{ route('account.character.update') }}"
    >
@endsection

@section('css')
    <style>
        .avatar-body-colors {
            max-width: 370px;
        }

        .avatar-body-color {
            width: 40px;
            height: 40px;
            cursor: pointer;
            display: inline-block;
            margin-bottom: 5px;
        }

        .avatar-body-part {
            cursor: pointer;
        }

        .palette {
            background: #fff;
            border: 1px solid #eee;
            position: absolute;
            margin-left: 300px;
            margin-top: 308px;
            padding: 15px;
            z-index: 1337;
        }

        @media only screen and (max-width: 768px) {
            .avatar-body-colors {
                max-width: 320px;
            }

            .palette {
                margin-top: 200px;
                margin-left: 20px;
            }
        }

        .character-btn {
            padding: 2.5px 5px;
            position: absolute;
            top: 0;
            right: 0;
            margin-top: 5px;
            margin-right: 5px;
        }
    </style>
@endsection

@section('js')
    <script src="{{ js_file('account/character') }}"></script>
@endsection

@section('content')
    <div class="palette" id="colors" style="display:none;">
        <div id="colorsTitle" style="color:#333;font-weight:600;margin-bottom:5px;"></div>
        <div class="avatar-body-colors">
            @foreach ($colors as $hex)
                <button class="avatar-body-color" style="background:{{ $hex }};" data-color="{{ $hex }}"></button>
            @endforeach
        </div>
    </div>
    <div class="col-10-12 push-1-12">
        <div class="col-5-12">
            <div class="card">
                <div class="top blue">Avatar</div>
                <div class="content customize-content" style="position:relative;min-height:405.5px;">
                    <img id="avatar" src="{{ Auth::user()->thumbnail() }}" style="width:100%;">
                    <div class="loader" id="loader" style="display:none;"></div>
                </div>
            </div>
            <div class="card">
                <div class="top blue">Color Pallete</div>
                <div class="content center-text">
                    <div style="margin-bottom:2.5px;">
                        <button class="avatar-body-part" style="background-color:{{ Auth::user()->avatar()->color_head }};padding:25px;margin-top:-1px;" data-part="head"></button>
                    </div>
                    <div style="margin-bottom:2.5px;">
                        <button class="avatar-body-part" style="background-color:{{ Auth::user()->avatar()->color_left_arm }};padding:50px;padding-right:0px;" data-part="left_arm"></button>
                        <button class="avatar-body-part" style="background-color:{{ Auth::user()->avatar()->color_torso }};padding:50px;" data-part="torso"></button>
                        <button class="avatar-body-part" style="background-color:{{ Auth::user()->avatar()->color_right_arm }};padding:50px;padding-right:0px;" data-part="right_arm"></button>
                    </div>
                    <div>
                        <button class="avatar-body-part" style="background-color:{{ Auth::user()->avatar()->color_left_leg }};padding:50px;padding-right:0px;padding-left:47px;" data-part="left_leg"></button>
                        <button class="avatar-body-part" style="background-color:{{ Auth::user()->avatar()->color_right_leg }};padding:50px;padding-right:0px;padding-left:47px;" data-part="right_leg"></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-7-12" style="padding-right:0;">
            <div class="card">
                <div class="top blue">Crate</div>
                <div class="content">
                    <div class="search-bar">
                        <input class="search rigid width-100" id="search" style="margin-right:-30px;padding:7px;margin-bottom:5px;" type="text" placeholder="Search crate">
                    </div>
                    <div class="item-types">
                        <a class="active" data-tab="hats">Hats</a>
                        <span>|</span>
                        <a data-tab="faces">Faces</a>
                        <span>|</span>
                        <a data-tab="tools">Tools</a>
                        <span>|</span>
                        <a data-tab="heads">Heads</a>
                        <span>|</span>
                        <a data-tab="figures">Figures</a>
                        <span>|</span>
                        <a data-tab="shirts">Shirts</a>
                        <span>|</span>
                        <a data-tab="t-shirts">T-Shirts</a>
                        <span>|</span>
                        <a data-tab="pants">Pants</a>
                    </div>
                    <div id="inventory"></div>
                </div>
            </div>
            <div class="card" style="position:relative;">
                <div class="top blue">Wearing</div>
                <div class="content">
                    <div id="wearing"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
