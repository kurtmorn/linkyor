<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.admin', [
    'title' => 'Create New Staff User'
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
        <div class="card-header">Create New Staff User</div>
        <div class="card-body">
            <form action="{{ route('admin.manage.staff.create') }}" method="POST">
                @csrf
                <label for="username">Username</label>
                <input class="form-control mb-2" type="text" name="username" placeholder="Username" required>
                <div class="row">
                    @foreach ($permissions as $title => $options)
                        <div class="col-md-3">
                            <label style="margin-bottom:0;">{{ $title }}</label>
                            @foreach ($options as $title => $option)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="{{ $option }}">
                                    <label class="form-check-label" for="{{ $option }}">{{ $title }}</label>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
                <button class="green w-100 mt-1" type="submit">Create</button>
            </form>
        </div>
    </div>
@endsection
