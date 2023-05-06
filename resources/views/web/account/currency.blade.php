<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.default', [
    'title' => 'Currency'
])

@section('content')
    <div class="col-10-12 push-1-12">
        <div class="tabs">
            <a href="{{ route('account.currency.index', '') }}" class="tab @if ($category == 'exchange') active @endif col-4-12">Exchange</a>
            <a href="{{ route('account.currency.index', 'purchases') }}" class="tab @if ($category == 'purchases') active @endif col-4-12">Purchases</a>
            <a href="{{ route('account.currency.index', 'sales') }}" class="tab @if ($category == 'sales') active @endif col-4-12">Sales</a>
            <div class="tab-holder" style="box-shadow:none;">
                <div class="tab-body active">
                    <div class="content">
                        @if (!$transactions)
                            <form action="{{ route('account.currency.convert') }}" method="POST" style="text-align:center;">
                                @csrf
                                <div class="block">
                                    <select name="type" class="select mb2">
                                        <option value="to-bits">To bits</option>
                                        <option value="to-bucks">To bucks</option>
                                    </select>
                                    <input type="number" style="margin-bottom:10px;" name="amount" placeholder="0" min="0">
                                </div>
                                <button class="blue smaller-text" type="submit">CONVERT</button>
                            </form>
                        @else
                            @if ($transactions->count() == 0)
                                <div style="text-align:center;padding:10px;">
                                    <span>You don't have any transactions!</span>
                                </div>
                            @else
                                <table style="width: 100%;">
                                    @foreach ($transactions as $transaction)
                                        <tr>
                                            <th class="col-2-12" style="text-align:left;float:none;">
                                                <span class="agray-text block">{{ $transaction->created_at->format('d/m/Y') }}</span>
                                            </th>
                                            <th class="ellipsis col-4-12" style="text-align:left;float:none;">
                                                <a href="{{ route('users.profile', ($category == 'purchases') ? $transaction->seller->id : $transaction->buyer->id) }}" class="agray-text ellipsis">
                                                    <img src="{{ ($category == 'purchases') ? $transaction->seller->thumbnail() : $transaction->buyer->thumbnail() }}" style="width:64px;">
                                                    <div>{{ ($category == 'purchases') ? $transaction->seller->username : $transaction->buyer->username }}</div>
                                                </a>
                                            </th>
                                            <th class="col-4-12" style="text-align:left;float:none;">
                                                <a href="{{ route('shop.item', $transaction->item->id) }}" class="agray-text">
                                                    <img src="{{ $transaction->item->thumbnail() }}" alt="{{ $transaction->item->name }}" style="height:56px;">
                                                    <div>{{ $transaction->item->name }}</div>
                                                </a>
                                            </th>
                                            <th class="col-2-12" style="text-align:left;float:none;">
                                                @if ($transaction->currency_used == 'free')
                                                    <span style="color:#6fb6db;">FREE</span>
                                                @else
                                                    <span class="{{ $transaction->currency_used }}-text">{{ number_format($transaction->price) }} <span class="{{ $transaction->currency_used }}-icon"></span></span>
                                                @endif
                                            </th>
                                        </tr>
                                    @endforeach
                                </table>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($transactions)
        <div class="col-10-12 push-1-12">
            <div class="pages">{{ $transactions->onEachSide(1) }}</div>
        </div>
    @endif
@endsection
