<!--
MIT License
Copyright (c) 2022 FoxxoSnoot
Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:
The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
-->

<!DOCTYPE html>
<html lang="en" class="theme-<?php echo e(Auth::user()->setting->theme ?? 'default'); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo e(isset($title) ? "{$title} - " . config('site.name') : config('site.name')); ?></title>

    <!-- Preconnect -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">

    <!-- Meta -->
    <meta name="theme-color" content="<?php echo e(config('site.theme_color')); ?>">
    <link rel="shortcut icon" href="<?php echo e(config('site.icon')); ?>">
    <meta name="author" content="<?php echo e(config('site.name')); ?>">
    <meta name="description" content="Brick building, brick build together part piece construct make create set.">
    <meta name="keywords" content="<?php echo e(strtolower(config('site.name'))); ?>, <?php echo e(strtolower(str_replace(' ', '', config('site.name')))); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php echo $__env->yieldContent('meta'); ?>

    <!-- OpenGraph -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?php echo e(config('site.name')); ?>">
    <meta property="og:title" content="<?php echo e($title ?? config('site.name')); ?>">
    <meta property="og:description" content="Brick building, brick build together part piece construct make create set.">
    <meta property="og:image" content="<?php echo e(!isset($image) ? config('site.icon') : $image); ?>">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.3/css/all.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,500;0,600;0,700;1,500;1,600;1,700&display=swap">
    <?php echo $__env->yieldContent('fonts'); ?>

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo e(theme_file()); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/newtheme.css')); ?>">
    <style>#globalError:empty, .dropdown-content:not(.active) { display: none; }</style>
    <?php echo $__env->yieldContent('css'); ?>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1047015416294545"
     crossorigin="anonymous"></script>
</head>
<body>
    <nav>
        <div class="primary">
            <div class="grid">
                <div class="push-left">
                    <ul>
                        <?php if(request()->isMaintenancePage): ?>
                            <li><a style="cursor:pointer;border-color:transparent!important;"><?php echo e(config('site.name')); ?></a></li>
                        <?php else: ?>
                            <li><a href="<?php echo e(route('games.index')); ?>">Play</a></li>
                            <li><a href="<?php echo e(route('shop.index')); ?>">Shop</a></li>
                            <li><a href="<?php echo e(route('clans.index')); ?>">Clans</a></li>
                            <li><a href="<?php echo e(route('users.index', '')); ?>">Users</a></li>
                            <li><a href="<?php echo e(route('forum.index')); ?>">Forum</a></li>
                            <li><a href="<?php echo e(route('account.billing.index')); ?>">Membership</a></li>
                            <?php if(Auth::check() && Auth::user()->isStaff()): ?>
                                <li>
                                    <a href="<?php echo e(route('admin.index')); ?>" target="_blank">
                                        Admin
                                        <?php if(pendingAssetsCount() > 0 || pendingReportsCount() > 0): ?>
                                            <span class="nav-notif">
                                                <?php if(pendingAssetsCount() > 0): ?>
                                                    <span>(A: <?php echo e(number_format(pendingAssetsCount())); ?>)</span>
                                                <?php endif; ?>

                                                <?php if(pendingReportsCount() > 0): ?>
                                                    <span>(R: <?php echo e(number_format(pendingReportsCount())); ?>)</span>
                                                <?php endif; ?>
                                            </span>
                                        <?php endif; ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="nav-user push-right" id="info">
                    <?php if(auth()->guard()->guest()): ?>
                        <div class="username login-buttons">
                            <a href="<?php echo e(route('auth.login.index')); ?>" class="login-button">Login</a>
                            <a href="<?php echo e(route('auth.register.index')); ?>" class="register-button">Register</a>
                        </div>
                    <?php else: ?>
                        <?php if(!request()->isMaintenancePage): ?>
                            <div class="info">
                                <a href="<?php echo e(route('account.currency.index', '')); ?>" class="header-data" title="<?php echo e(number_format(Auth::user()->currency_bucks)); ?>">
                                    <span class="bucks-icon img-white"></span> <?php echo e(shorten_number(Auth::user()->currency_bucks)); ?>

                                </a>
                                <a href="<?php echo e(route('account.currency.index', '')); ?>" class="header-data" title="<?php echo e(number_format(Auth::user()->currency_bits)); ?>">
                                    <span class="bits-icon img-white"></span> <?php echo e(shorten_number(Auth::user()->currency_bits)); ?>

                                </a>
                                <a href="<?php echo e(route('account.inbox.index', '')); ?>" class="header-data">
                                    <span class="messages-icon img-white"></span> <?php echo e(number_format(Auth::user()->messageCount())); ?>

                                </a>
                                <a href="<?php echo e(route('account.friends.index')); ?>" class="header-data">
                                    <span class="friends-icon img-white"></span> <?php echo e(number_format(Auth::user()->friendRequestCount())); ?>

                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="username ellipsis" data-dropdown-open="logout">
                            <div class="username-holder ellipsis inline unselectable"><?php echo e(Auth::user()->username); ?></div>
                            <i class="arrow-down img-white"></i>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if(auth()->guard()->check()): ?>
            <?php if(!request()->isMaintenancePage): ?>
                <div class="secondary">
                    <div class="grid">
                        <div class="bottom-bar">
                            <ul>
                                <li><a href="<?php echo e(route('home.dashboard')); ?>" id="pHome">Home</a></li>
                                <li><a href="<?php echo e(route('account.settings.index')); ?>" id="pSettings">Settings</a></li>
                                <li><a href="<?php echo e(route('account.character.index')); ?>" id="pAvatar">Avatar</a></li>
                                <li><a href="<?php echo e(route('users.profile', Auth::user()->id)); ?>" id="pProfile">Profile</a></li>
                                <li><a href="<?php echo e(route('games.download')); ?>" id="pDownload">Download</a></li>
                                <li>
                                    <a href="<?php echo e(route('account.trades.index')); ?>" id="pTrades">
                                        <span>Trades</span>
                                        <?php if(Auth::user()->tradeCount() > 0): ?>
                                            <span class="nav-notif"><?php echo e(number_format(Auth::user()->tradeCount())); ?></span>
                                        <?php endif; ?>
                                    </a>
                                </li>
                                <li><a href="<?php echo e(route('games.creations')); ?>" id="pSets">Sets</a></li>
                                <li><a href="<?php echo e(route('account.currency.index', '')); ?>" id="pCurrency">Currency</a></li>
                                <li><a id="pBlog" style="cursor:not-allowed;opacity:.6;border-color:transparent!important;">Blog</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </nav>

    <?php echo $__env->yieldContent('before_content'); ?>

    <div class="main-holder grid">
        <?php if(!request()->isMaintenancePage && site_setting('alert_enabled') && site_setting('alert_message')): ?>
            <div class="col-10-12 push-1-12">
                <div class="alert" style="background:<?php echo e(site_setting('alert_background_color')); ?>;color:<?php echo e(site_setting('alert_text_color')); ?>;">
                    <?php echo site_setting('alert_message'); ?>

                </div>
            </div>
        <?php endif; ?>

        <?php if(request()->isMaintenanceEnabled && session()->has('maintenance_password')): ?>
            <div class="col-10-12 push-1-12">
                <div class="alert warning">
                    You are currently in maintenance mode. <a href="<?php echo e(route('maintenance.exit')); ?>"><b>[Exit]</b></a>
                </div>
            </div>
        <?php endif; ?>

        <?php if(!site_setting('item_purchases_enabled') && Str::startsWith(request()->route()->getName(), 'shop.')): ?>
            <div class="col-10-12 push-1-12">
                <div class="alert warning">
                    Item purchases are temporarily unavailable. Items may be browsed but are unable to be purchased.
                </div>
            </div>
        <?php endif; ?>

        <?php if(session()->has('success_message')): ?>
            <div class="col-10-12 push-1-12">
                <div class="alert success">
                    <?php echo session()->get('success_message'); ?>

                </div>
            </div>
        <?php endif; ?>

        <?php if(count($errors) > 0): ?>
            <div class="col-10-12 push-1-12">
                <div class="alert error">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div><?php echo $error; ?></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="col-10-12 push-1-12">
            <div class="alert error" id="globalError"></div>
        </div>

        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <footer>
        <div>© <?php echo e(date('Y')); ?> <?php echo e(config('site.name')); ?>. All rights reserved.</div>
        <a href="<?php echo e(route('info.index', 'terms')); ?>">Terms</a>
        <span>|</span>
        <a href="<?php echo e(route('info.index', 'privacy')); ?>">Privacy Policy</a>
        <span>|</span>
        <a href="<?php echo e(route('info.index', 'staff')); ?>">Staff</a>
    </footer>

    <?php if(auth()->guard()->check()): ?>
        <div class="dropdown-content logout-dropdown" data-dropdown="logout">
            <div class="dropdown-arrow"></div>
            <ul>
                <li>
                    <a onclick="$('#logoutForm').submit()">Logout</a>
                </li>
            </ul>
            <form method="POST" action="<?php echo e(route('auth.logout')); ?>" id="logoutForm"><?php echo csrf_field(); ?></form>
        </div>
    <?php endif; ?>

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
    <?php echo $__env->yieldContent('js'); ?>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/layouts/default.blade.php ENDPATH**/ ?>