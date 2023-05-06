<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.admin', [
    'title' => 'Manage Forum Topics'
])

@section('header')
    <a href="{{ route('admin.manage.forum_topics.new') }}" class="button green small"><i class="fas fa-plus"></i></a>
@endsection

@section('content')
    @if ($topics->count() == 0)
        <p>No forum topics were found.</p>
    @else
        <div class="card" style="border:0;">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Created</th>
                        <th>Posts</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($topics as $topic)
                        <tr>
                            <td><a href="{{ route('admin.manage.forum_topics.edit', $topic->id) }}">{{ $topic->id }}</a></td>
                            <td><a href="{{ route('admin.manage.forum_topics.edit', $topic->id) }}">{{ $topic->name }}</a></td>
                            <td>{{ $topic->created_at }}</td>
                            <td>{{ number_format($topic->threads()->count()) }}</td>
                            <td><a href="{{ route('admin.manage.forum_topics.confirm_delete', $topic->id) }}" class="button red small"><i class="fas fa-trash"></i></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pages">{{ $topics->onEachSide(1) }}</div>
    @endif
@endsection
