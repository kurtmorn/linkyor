<!--
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
-->

<!DOCTYPE html>
<html lang="en" class="theme-{{ Auth::user()->setting->theme ?? 'default' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ isset($title) ? "{$title} - " . config('site.name') : config('site.name') }}</title>

    <!-- Preconnect -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">

    <!-- Meta -->
    <meta name="theme-color" content="{{ config('site.theme_color') }}">
    <link rel="shortcut icon" href="{{ config('site.icon') }}">
    <meta name="author" content="{{ config('site.name') }}">
    <meta name="description" content="Brick building, brick build together part piece construct make create set.">
    <meta name="keywords" content="{{ strtolower(config('site.name')) }}, {{ strtolower(str_replace(' ', '', config('site.name'))) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')

    <!-- OpenGraph -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('site.name') }}">
    <meta property="og:title" content="{{ $title ?? config('site.name') }}">
    <meta property="og:description" content="Brick building, brick build together part piece construct make create set.">
    <meta property="og:image" content="{{ !isset($image) ? config('site.icon') : $image }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.3/css/all.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,500;0,600;0,700;1,500;1,600;1,700&display=swap">
    @yield('fonts')

    <!-- CSS -->
    <link rel="stylesheet" href="{{ theme_file() }}">
    <link rel="stylesheet" href="{{ asset('css/newtheme.css') }}">
    <style>#globalError:empty, .dropdown-content:not(.active) { display: none; }</style>
    @yield('css')
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1047015416294545"
     crossorigin="anonymous"></script>
</head>
<body>
    <nav>
        <div class="primary">
            <div class="grid">
                <div class="push-left">
                    <ul>
                        @if (request()->isMaintenancePage)
                            <li><a style="cursor:pointer;border-color:transparent!important;">{{ config('site.name') }}</a></li>
                        @else
                            <li><a href="{{ route('games.index') }}">Play</a></li>
                            <li><a href="{{ route('shop.index') }}">Shop</a></li>
                            <li><a href="{{ route('clans.index') }}">Clans</a></li>
                            <li><a href="{{ route('users.index', '') }}">Users</a></li>
                            <li><a href="{{ route('forum.index') }}">Forum</a></li>
                            <li><a href="{{ route('account.billing.index') }}">Membership</a></li>
                            @if (Auth::check() && Auth::user()->isStaff())
                                <li>
                                    <a href="{{ route('admin.index') }}" target="_blank">
                                        Admin
                                        @if (pendingAssetsCount() > 0 || pendingReportsCount() > 0)
                                            <span class="nav-notif">
                                                @if (pendingAssetsCount() > 0)
                                                    <span>(A: {{ number_format(pendingAssetsCount()) }})</span>
                                                @endif

                                                @if (pendingReportsCount() > 0)
                                                    <span>(R: {{ number_format(pendingReportsCount()) }})</span>
                                                @endif
                                            </span>
                                        @endif
                                    </a>
                                </li>
                            @endif
                        @endif
                    </ul>
                </div>
                <div class="nav-user push-right" id="info">
                    @guest
                        <div class="username login-buttons">
                            <a href="{{ route('auth.login.index') }}" class="login-button">Login</a>
                            <a href="{{ route('auth.register.index') }}" class="register-button">Register</a>
                        </div>
                    @else
                        @if (!request()->isMaintenancePage)
                            <div class="info">
                                <a href="{{ route('account.currency.index', '') }}" class="header-data" title="{{ number_format(Auth::user()->currency_bucks) }}">
                                    <span class="bucks-icon img-white"></span> {{ shorten_number(Auth::user()->currency_bucks) }}
                                </a>
                                <a href="{{ route('account.currency.index', '') }}" class="header-data" title="{{ number_format(Auth::user()->currency_bits) }}">
                                    <span class="bits-icon img-white"></span> {{ shorten_number(Auth::user()->currency_bits) }}
                                </a>
                                <a href="{{ route('account.inbox.index', '') }}" class="header-data">
                                    <span class="messages-icon img-white"></span> {{ number_format(Auth::user()->messageCount()) }}
                                </a>
                                <a href="{{ route('account.friends.index') }}" class="header-data">
                                    <span class="friends-icon img-white"></span> {{ number_format(Auth::user()->friendRequestCount()) }}
                                </a>
                            </div>
                        @endif
                        <div class="username ellipsis" data-dropdown-open="logout">
                            <div class="username-holder ellipsis inline unselectable">{{ Auth::user()->username }}</div>
                            <i class="arrow-down img-white"></i>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
        @auth
            @if (!request()->isMaintenancePage)
                <div class="secondary">
                    <div class="grid">
                        <div class="bottom-bar">
                            <ul>
                                <li><a href="{{ route('home.dashboard') }}" id="pHome">Home</a></li>
                                <li><a href="{{ route('account.settings.index') }}" id="pSettings">Settings</a></li>
                                <li><a href="{{ route('account.character.index') }}" id="pAvatar">Avatar</a></li>
                                <li><a href="{{ route('users.profile', Auth::user()->id) }}" id="pProfile">Profile</a></li>
                                <li><a href="{{ route('games.download') }}" id="pDownload">Download</a></li>
                                <li>
                                    <a href="{{ route('account.trades.index') }}" id="pTrades">
                                        <span>Trades</span>
                                        @if (Auth::user()->tradeCount() > 0)
                                            <span class="nav-notif">{{ number_format(Auth::user()->tradeCount()) }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li><a href="{{ route('games.creations') }}" id="pSets">Sets</a></li>
                                <li><a href="{{ route('account.currency.index', '') }}" id="pCurrency">Currency</a></li>
                                <li><a id="pBlog" style="cursor:not-allowed;opacity:.6;border-color:transparent!important;">Blog</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        @endauth
    </nav>

    @yield('before_content')

    <div class="main-holder grid">
        @if (!request()->isMaintenancePage && site_setting('alert_enabled') && site_setting('alert_message'))
            <div class="col-10-12 push-1-12">
                <div class="alert" style="background:{{ site_setting('alert_background_color') }};color:{{ site_setting('alert_text_color') }};">
                    {!! site_setting('alert_message') !!}
                </div>
            </div>
        @endif

        @if (request()->isMaintenanceEnabled && session()->has('maintenance_password'))
            <div class="col-10-12 push-1-12">
                <div class="alert warning">
                    You are currently in maintenance mode. <a href="{{ route('maintenance.exit') }}"><b>[Exit]</b></a>
                </div>
            </div>
        @endif

        @if (!site_setting('item_purchases_enabled') && Str::startsWith(request()->route()->getName(), 'shop.'))
            <div class="col-10-12 push-1-12">
                <div class="alert warning">
                    Item purchases are temporarily unavailable. Items may be browsed but are unable to be purchased.
                </div>
            </div>
        @endif

        @if (session()->has('success_message'))
            <div class="col-10-12 push-1-12">
                <div class="alert success">
                    {!! session()->get('success_message') !!}
                </div>
            </div>
        @endif

        @if (count($errors) > 0)
            <div class="col-10-12 push-1-12">
                <div class="alert error">
                    @foreach ($errors->all() as $error)
                        <div>{!! $error !!}</div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="col-10-12 push-1-12">
            <div class="alert error" id="globalError"></div>
        </div>

        @yield('content')
    </div>

    <footer>
        <div>© {{ date('Y') }} {{ config('site.name') }}. All rights reserved.</div>
        <a href="{{ route('info.index', 'terms') }}">Terms</a>
        <span>|</span>
        <a href="{{ route('info.index', 'privacy') }}">Privacy Policy</a>
        <span>|</span>
        <a href="{{ route('info.index', 'staff') }}">Staff</a>
    </footer>

    @auth
        <div class="dropdown-content logout-dropdown" data-dropdown="logout">
            <div class="dropdown-arrow"></div>
            <ul>
                <li>
                    <a onclick="$('#logoutForm').submit()">Logout</a>
                </li>
            </ul>
            <form method="POST" action="{{ route('auth.logout') }}" id="logoutForm">@csrf</form>
        </div>
    @endauth

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
        var _token;

        $(() => _token = $('meta[name="csrf-token"]').attr('content'));
        $('[data-dropdown-open]').click(function(event) {
            var dropdown = $(this).attr('data-dropdown-open');
            var object = `[data-dropdown="${dropdown}"]`;
            var opened = $(object).hasClass('active');

            if (!opened) {
                if (targetMatches(true, event.target, `[data-dropdown-open="${dropdown}"], [data-dropdown-open="${dropdown}"] *`)) {
                    const self = this;

                    $(object).addClass('active').css({
                        top: ($(self).height() + 30) + 'px',
                        left: $(self).offset().left + 'px'
                    });

                    window.onresize = function() {
                        $(object).css({
                            top: ($(self).height() + 30) + 'px',
                            left: $(self).offset().left + 'px'
                        });
                    };
                }
            } else {
                if (targetMatches(false, event.target, `${dropdown}, ${dropdown} *`)) {
                    $(object).removeClass('active');

                    window.onresize = null;
                }
            }
        });


        function targetMatches(does, eventTarget, target)
        {
            if (does)
                return (eventTarget.matches) ? eventTarget.matches(target) : eventTarget.msMatchesSelector(target);

            return (eventTarget.matches) ? !eventTarget.matches(target) : !eventTarget.msMatchesSelector(target);
        }
    </script>
    @yield('js')
</body>
</html>
