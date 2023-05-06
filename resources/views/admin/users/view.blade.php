<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

@extends('layouts.admin', [
    'title' => "User: {$user->username}"
])

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Thumbnail</div>
                <div class="card-body text-center">
                    <img src="{{ $user->thumbnail() }}">
                    <a href="{{ route('users.profile', $user->id) }}" class="button blue small w-100 mt-3" target="_blank"><i class="fas fa-link"></i> View Profile</a>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Linked Accounts</div>
                <div class="card-body" style="max-height:250px;overflow-y:auto;">
                    @forelse ($user->accountsLinkedByIP() as $account)
                        <div class="row">
                            <div class="col-9 col-md-8 text-truncate"><a href="{{ route('admin.users.view', $account->id) }}">{{ $account->username }}</a></div>
                            <div class="col-3 col-md-4 text-right">{{ number_format($account->times_linked) }}x</div>
                        </div>
                    @empty
                        <p>None found.</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">Information</div>
                <div class="card-body">
                    <div class="row">
                        @if (staffUser()->staff('can_view_user_emails'))
                            <div class="col-4"><strong>Email</strong></div>
                            <div class="col-8 text-right">{{ $user->email }}</div>
                        @endif
                        <div class="col-4"><strong>Verified Email</strong></div>
                        <div class="col-8 text-right">{{ ($user->hasVerifiedEmail()) ? 'Yes' : 'No' }}</div>
                        <div class="col-3"><strong>Last IP</strong></div>
                        <div class="col-9 text-right">{{ ip_hash($user->lastIP()) }}</div>
                        <div class="col-4"><strong>Join Date</strong></div>
                        <div class="col-8 text-right">{{ $user->created_at->format('M d, Y') }}</div>
                        <div class="col-4"><strong>Last Seen</strong></div>
                        <div class="col-8 text-right">{{ $user->updated_at->format('M d, Y') }}</div>
                        <div class="col-6"><strong>Forum Posts</strong></div>
                        <div class="col-6 text-right">{{ number_format($user->forumPostCount()) }}</div>
                        <div class="col-4"><strong>Bits</strong></div>
                        <div class="col-8 text-right bits-text">
                            <span class="bits-icon"></span>
                            <span>{{ number_format($user->bits) }}</span>
                        </div>
                        <div class="col-4"><strong>Bucks</strong></div>
                        <div class="col-8 text-right bucks-text">
                            <span class="bucks-icon"></span>
                            <span>{{ number_format($user->bucks) }}</span>
                        </div>
                        @if (config('event.enabled'))
                            <div class="col-4"><strong>{{ config('event.currency_name') }}</strong></div>
                            <div class="col-8 text-right"><i class="{{ config('event.currency_class') }}"></i> {{ number_format($user->event_currency) }}</div>
                        @endif
                        <div class="col-6"><strong>Money Spent</strong></div>
                        <div class="col-6 text-right">${{ number_format($user->moneySpent()) }}</div>
                        @if ($user->hasMembership())
                            <div class="col-6"><strong>Membership Until</strong></div>
                            <div class="col-6 text-right">{{ $user->membership_until }}</div>
                        @endif
                        <div class="col-4"><strong>Is Online</strong></div>
                        <div class="col-8 text-right">{{ ($user->online()) ? 'Yes' : 'No' }}</div>
                        <div class="col-4"><strong>Is Staff</strong></div>
                        <div class="col-8 text-right">{{ ($user->isStaff()) ? 'Yes' : 'No' }}</div>
                        <div class="col-4"><strong>Status</strong></div>
                        <div class="col-8 text-right">
                            @if ($user->isBanned())
                                <span class="badge bg-danger text-white">BANNED</span>
                            @elseif (!$user->hasVerifiedEmail())
                                <span class="badge bg-warning">EMAIL NOT VERIFIED</span>
                            @else
                                <span class="badge bg-success text-white">OK</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Settings</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6"><strong>Theme</strong></div>
                        <div class="col-6 text-right">{{ ucwords(str_replace('_', ' ', $user->setting->theme)) }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <form action="{{ route('admin.users.update') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $user->id }}">

                @if (staffUser()->staff('can_ban_users') || staffUser()->staff('can_reset_passwords') || staffUser()->staff('can_edit_user_info'))
                    <div class="card">
                        <div class="card-header">Account Actions</div>
                        <div class="card-body">
                            @if (staffUser()->staff('can_ban_users') && !$user->isBanned())
                                <a href="{{ route('admin.users.ban.index', $user->id) }}" class="button red w-100 mb-2">
                                    <i class="fas fa-ban mr-1"></i>
                                    <span>Ban</span>
                                </a>
                            @endif

                            @if (staffUser()->staff('can_unban_users') && $user->isBanned())
                                <button class="green w-100 mb-2" name="action" value="unban">
                                    <i class="fa fa-ban mr-1"></i>
                                    <span>Unban</span>
                                </button>
                            @endif

                            @if (staffUser()->staff('can_ip_ban_users') && !$ipBanned)
                                <button class="red w-100 mb-2" name="action" value="ip_ban">
                                    <i class="fa fa-key mr-1"></i>
                                    <span>Ban IP</span>
                                </button>
                            @endif

                            @if (staffUser()->staff('can_ip_unban_users') && $ipBanned)
                                <button class="green w-100 mb-2" name="action" value="ip_ban">
                                    <i class="fa fa-key mr-1"></i>
                                    <span>Unban IP</span>
                                </button>
                            @endif

                            @if (staffUser()->staff('can_reset_user_passwords'))
                                <button class="red w-100 mb-2" name="action" value="password">
                                    <i class="fa fa-key mr-1"></i>
                                    <span>Reset Password</span>
                                </button>
                            @endif

                            @if (staffUser()->staff('can_edit_user_info'))
                                <button class="red w-100 mb-2" name="action" value="scrub_username">
                                    <i class="fa fa-trash mr-1"></i>
                                    <span>Scrub Username</span>
                                </button>
                                <button class="red w-100 mb-2" name="action" value="scrub_description">
                                    <i class="fa fa-trash mr-1"></i>
                                    <span>Scrub Description</span>
                                </button>
                                <button class="red w-100 mb-2" name="action" value="scrub_forum_signature">
                                    <i class="fa fa-trash mr-1"></i>
                                    <span>Scrub Forum Signature</span>
                                </button>
                                @if ($user->hasMembership())
                                    <button class="red w-100 mb-2" name="action" value="remove_membership">
                                        <i class="fa fa-trash mr-1"></i>
                                        <span>Remove Membership</span>
                                    </button>
                                @endif
                                <div class="mb-1"></div>
                                <label for="length">Membership</label>
                                <div class="input-group">
                                    <select class="form-control" name="membership_length">
                                        <option value="1_month" selected>1 Month</option>
                                        <option value="3_months">3 Months</option>
                                        <option value="6_months">6 Months</option>
                                        <option value="1_year">1 Year</option>
                                        <option value="forever">Forever</option>
                                    </select>
                                    <div class="input-group-append">
                                        <button class="green small" style="border-radius:0 5px 5px 0;" name="action" value="grant_membership">Grant</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                @if (staffUser()->staff('can_give_currency') || Auth::user('can_take_currency') || Auth::user('can_give_items') || Auth::user('can_take_items'))
                    <div class="card">
                        <div class="card-header">Economy Actions</div>
                        <div class="card-body">
                            @if (staffUser()->staff('can_give_currency') || Auth::user('can_take_currency'))
                                <a href="{{ route('admin.users.manage.index', ['currency', $user->id]) }}" class="button blue w-100 mb-2">
                                    <i class="fas fa-money-bill-alt mr-1"></i>
                                    <span>Manage Currency</span>
                                </a>
                            @endif

                            @if (staffUser()->staff('can_give_items') || Auth::user('can_take_items'))
                                <a href="{{ route('admin.users.manage.index', ['inventory', $user->id]) }}" class="button blue w-100 mb-2">
                                    <i class="fas fa-box mr-1"></i>
                                    <span>Manage Inventory</span>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                @if (staffUser()->staff('can_render_thumbnails'))
                    <div class="card">
                        <div class="card-header">Avatar Actions</div>
                        <div class="card-body">
                            <button class="orange w-100 mb-2" name="action" value="regen">
                                <i class="fas fa-sync mr-1"></i>
                                <span>Regen Avatar</span>
                            </button>
                            <button class="orange w-100 mb-2" name="action" value="reset">
                                <i class="fas fa-user mr-1"></i>
                                <span>Set Avatar to Default</span>
                            </button>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>
@endsection
