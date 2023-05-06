<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.default', [
    'title' => 'Settings'
])

@section('js')
    <script src="{{ js_file('account/settings') }}"></script>
@endsection

@section('content')
    <div class="col-10-12 push-1-12">
        <div class="settings">
            <div class="card">
                <div class="top blue">Settings</div>
                <div class="content">
                    <span class="dark-gray-text very-bold block">Information</span>
                    <div class="block">
                        <span class="dark-gray-text" style="padding-right:5px;">Username:</span>
                        <span class="light-gray-text">{{ Auth::user()->username }}</span>
                        <i class="f-right light-gray-text far fa-edit" style="cursor:pointer;" data-modal-open="username"></i>
                    </div>
                    <div class="block">
                        <span class="dark-gray-text" style="padding-right:5px;">Password:</span>
                        <span class="light-gray-text">*********</span>
                        <i class="f-right light-gray-text far fa-edit" style="cursor:pointer;" data-modal-open="password"></i>
                    </div>
                    <div class="block">
                        <span class="dark-gray-text" style="padding-right:5px;">Email:</span>
                        <span class="light-gray-text">{{ $email }}</span>
                        <i class="f-right light-gray-text far fa-edit" style="cursor:pointer;" data-modal-open="email"></i>
                    </div>
                    <div class="block">
                        <form action="{{ route('account.settings.update') }}" style="display:inline;" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="theme">
                            <span class="dark-gray-text" style="padding-right:5px;">Theme:</span>
                            <div class="inline">
                                <select name="theme">
                                    @foreach ($themes as $key => $theme)
                                        <option value="{{ $key }}" {{ (Auth::user()->setting->theme == $key) ? 'selected' : '' }} {{ (!$theme['available']) ? 'disabled' : '' }}>{{ $theme['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="f-right blue button small" type="submit">Save</button>
                        </form>
                    </div>
                    <hr>
                    <form action="{{ route('account.settings.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="description">
                        <span class="dark-gray-text bold block" style="padding-bottom:5px;">Blurb</span>
                        <textarea name="description" placeholder="Hi, my name is {{ Auth::user()->username }}" class="width-100 block" style="height:80px;margin-bottom:6px;">{{ Auth::user()->description }}</textarea>
                        <button class="small blue" type="submit">Save</button>
                    </form>
                </div>
                <div class="modal" style="display:none;" data-modal="username">
                    <div class="modal-content">
                        <form action="{{ route('account.settings.update') }}" style="display:inline;" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="username">
                            <span class="close" data-modal-close="username">×</span>
                            <span>Change Username</span>
                            <hr>
                            <input type="text" name="username" placeholder="New Username">
                            <span style="color:red;font-size:11px;">WARNING: This will take {{ number_format(config('site.username_change_price')) }} bucks</span>
                            <div class="modal-buttons">
                                <button class="green" style="margin-right:10px;" type="submit">Buy</button>
                                <button type="button" class="cancel-button" data-modal-close="username">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal" style="display:none;" data-modal="password">
                    <div class="modal-content">
                        <form action="{{ route('account.settings.update') }}" style="display:inline;" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="password">
                            <span class="close" data-modal-close="password">×</span>
                            <span>Change Password</span>
                            <hr>
                            <input type="password" name="current_password" placeholder="Current Password">
                            <input type="password" name="new_password" placeholder="New Password">
                            <input type="password" name="new_password_confirmation" placeholder="Confirm New Password">
                            <div class="modal-buttons">
                                <button class="green" style="margin-right:10px;" type="submit">Save</button>
                                <button type="button" class="cancel-button" data-modal-close="password">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal" style="display:none;" data-modal="email">
                    <div class="modal-content">
                        <form action="{{ route('account.settings.update') }}" style="display:inline;" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="email">
                            <span class="close" data-modal-close="email">×</span>
                            <span>Change Email</span>
                            <hr>
                            <input type="text" name="current_email" placeholder="Current Email">
                            <input type="text" name="new_email" placeholder="New Email">
                            <input type="password" name="password" placeholder="Current Password">
                            <div class="modal-buttons">
                                <button class="green" style="margin-right:10px;" type="submit">Save</button>
                                <button type="button" class="cancel-button" data-modal-close="email">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
