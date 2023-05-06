<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.default', [
    'title' => 'Report'
])

@section('content')
    <div class="col-10-12 push-1-12">
        <div class="card">
            <div class="top blue">Report</div>
            <div class="content">
                <span class="darker-grey-text bold block">Tell us how you think this {{ $type }} is breaking the {{ config('site.name') }} rules.</span>
                <form action="{{ route('report.submit') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $id }}">
                    <input type="hidden" name="type" value="{{ $type }}">
                    <select name="category">
                        @foreach ($categories as $name => $value)
                            <option value="{{ $value }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    <textarea style="width:100%;box-sizing:border-box;margin-top:10px;height:100px;" name="comment" placeholder="Explain more (optional)"></textarea>
                    <button class="blue" type="submit">SUBMIT</button>
                </form>
            </div>
        </div>
    </div>
@endsection
