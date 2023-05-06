<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.admin', [
    'title' => "Edit {$item->name}"
])

@section('header')
    <a href="{{ config('site.storage_url') }}/default/{{ ($item->type != 'face') ? 'avatar.blend' : 'face.png' }}" class="button green small" download>
        <i class="fas fa-share"></i>
        <span>Download {{ ($item->type != 'face') ? 'Avatar' : 'Face' }}</span>
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Information</div>
                <div class="card-body">
                    <form action="{{ route('admin.edit_item.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name">Name</label>
                                <input class="form-control mb-2" type="text" name="name" placeholder="Item Name" value="{{ $item->name }}">
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col">
                                        <label for="price_bucks">
                                            <span class="bucks-icon"></span>
                                            <span>Bucks</span>
                                        </label>
                                        <input class="form-control mb-2" type="number" name="price_bucks" placeholder="Bucks" min="0" max="1000000" value="{{ $item->price_bucks }}">
                                    </div>
                                    <div class="col">
                                        <label for="price_bits">
                                            <span class="bits-icon"></span>
                                            <span>Bits</span>
                                        </label>
                                        <input class="form-control mb-2" type="number" name="price_bits" placeholder="Bits" min="0" max="1000000" value="{{ $item->price_bits }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <label for="description">Description</label>
                        <textarea class="form-control mb-2" name="description" placeholder="Item Description" rows="5">{{ $item->description }}</textarea>
                        <label for="stock">Special Stock</label>
                        <input class="form-control mb-2" type="number" name="stock" placeholder="Special Stock" min="0" max="500" value="{{ $item->stock }}">
                        <label for="onsale_for">
                            <span>Onsale For</span>
                            @if ($item->isTimed())
                                <span class="text-danger">(Onsale Until: {{ $item->onsale_until }})</span>
                            @endif
                        </label>
                        <select class="form-control mb-2" name="onsale_for">
                            <option selected disabled hidden>--</option>
                            <option value="forever">Forever</option>
                            <option value="1_hour">1 Hour</option>
                            <option value="12_hours">12 Hours</option>
                            <option value="1_day">1 Day</option>
                            <option value="3_days">3 Days</option>
                            <option value="7_days">7 Days</option>
                            <option value="14_days">14 Days</option>
                            <option value="21_days">21 Days</option>
                            <option value="1_month">1 Month</option>
                        </select>
                        <div class="row">
                            @if ($item->type != 'head')
                                <div class="col-12 mb-2">
                                    <label for="image">Image</label><br>
                                    <input name="image" type="file" accept=".png,.jpg,.jpeg">
                                </div>
                            @endif

                            @if ($item->type != 'face')
                                <div class="col-12 mb-2">
                                    <label for="model">Model</label><br>
                                    <input name="model" type="file" accept=".obj">
                                </div>
                            @endif
                        </div>
                        <label>Options</label>
                        <div class="row mb-1">
                            <div class="col-md-4">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="onsale" @if ($item->onsale()) checked @endif>
                                    <label class="form-check-label" for="onsale">For Sale</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="special" @if ($item->special_type) checked @endif>
                                    <label class="form-check-label" for="special">Special</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="public" @if ($item->public_view) checked @endif>
                                    <label class="form-check-label" for="public_view">Public</label>
                                </div>
                            </div>
                        </div>
                        <button class="green w-100" type="submit">Update</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-header">Thumbnail</div>
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ $item->thumbnail() }}">
                </div>
            </div>
        </div>
    </div>
@endsection
