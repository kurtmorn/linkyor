<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.admin', [
    'title' => "Edit {$user->user->username}'s Staff Permissions"
])

@section('js')
    <script>
        var toggled = false;

        $(() => {
            $('#toggle').click(function() {
                toggled = !toggled;

                $('#toggle').removeClass('green red');
                $('#toggle i').removeClass('fa-toggle-on fa-toggle-off');

                if (!toggled) {
                    $('#toggle').addClass('red');
                    $('#toggle i').addClass('fa-toggle-off');
                    $('input:checkbox').prop('checked', false);
                } else {
                    $('#toggle').addClass('green');
                    $('#toggle i').addClass('fa-toggle-on');
                    $('input:checkbox').prop('checked', true);
                }
            });
        });
    </script>
@endsection

@section('header')
    <button class="red small" id="toggle"><i class="fas fa-toggle-off"></i> Toggle All</button>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">Edit {{ $user->user->username }}'s Staff Permissions</div>
        <div class="card-body">
            <form action="{{ route('admin.manage.staff.update') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $user->user->id }}">
                <div class="row">
                    @foreach ($permissions as $title => $options)
                        <div class="col-md-3">
                            <label style="margin-bottom:0;">{{ $title }}</label>
                            @foreach ($options as $title => $option)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="{{ $option }}" {{ ($user->$option) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ $option }}">{{ $title }}</label>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
                <div class="row mt-1">
                    <div class="col">
                        <button class="green w-100" type="submit">Update</button>
                    </div>
                    <div class="col">
                        <button class="orange w-100" name="password">Reset Password</button>
                    </div>
                    @if ($user->user->id != staffUser()->id)
                        <div class="col">
                            <button class="red w-100" name="delete">Delete</button>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
