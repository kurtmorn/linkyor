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



<?php $__env->startSection('meta'); ?>
    <meta
        name="user-info"
        data-id="<?php echo e($user->id); ?>"
    >
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(js_file('users/profile')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="col-10-12 push-1-12">
        <?php if($user->isBanned()): ?>
            <div class="alert error">User is banned</div>
        <?php endif; ?>
        <?php if($user->status()): ?>
            <div class="col-1-1" style="padding-right:0;">
                <div class="card">
                    <div class="content" style="border-radius:5px;position:relative;word-break:break-word">
                        <div class="small-text very-bold light-gray-text">What's on my mind:</div>
                        <span><?php echo e($user->status()); ?></span>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="col-6-12">
            <div class="card">
                <div class="content text-center bold medium-text relative ellipsis">
                    <span class="status-dot <?php echo e(($user->online()) ? 'online' : ''); ?>"></span>
                    <?php if($user->hasPrimaryClan()): ?>
                        <a href="<?php echo e(route('clans.view', $user->primaryClan->id)); ?>">
                            <span class="mr1" style="color:#999999;">[<?php echo e($user->primaryClan->tag); ?>]</span>
                        </a>
                    <?php endif; ?>
                    <span class="ellipsis"><?php echo e($user->username); ?></span>
                    <br>
                    <img src="<?php echo e($user->thumbnail()); ?>" style="height:350px;">
                    <div class="user-description-box closed">
                        <div class="toggle-user-desc gray-text">
                            <div class="user-desc p2 darker-grey-text" style="font-size:16px;line-height:17px;">
                                <?php echo nl2br(e($user->description)); ?>


                                <?php if($user->usernameHistory()->count() > 0): ?>
                                    <hr>
                                    <p></p>
                                    <span>Previously known as:</span>
                                    <i><?php echo e($user->usernameHistoryString()); ?></i>
                                <?php endif; ?>
                            </div>
                            <a class="darker-grey-text read-more-desc" style="font-size:16px;">Read More</a>
                        </div>
                    </div>
                    <?php if(auth()->guard()->check()): ?>
                        <?php if($user->id != Auth::user()->id): ?>
                            <div style="text-align:center;">
                                <a href="<?php echo e(route('account.inbox.new', $user->id)); ?>" class="button small blue inline" style="font-size:14px;">MESSAGE</a>

                                <?php if(site_setting('trading_enabled') && !$user->isBanned()): ?>
                                    <a href="<?php echo e(route('account.trades.send', $user->id)); ?>" class="button small blue inline" style="font-size:14px;">TRADE</a>
                                <?php endif; ?>

                                <?php if($areFriends): ?>
                                    <form action="<?php echo e(route('account.friends.update')); ?>" method="POST" style="display:inline;">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="id" value="<?php echo e($user->id); ?>">
                                        <input type="hidden" name="action" value="remove">
                                        <button class="button small red inline" style="font-size:14px;" type="submit">REMOVE</button>
                                    </form>
                                <?php elseif($isPending): ?>
                                    <a class="button small inline" style="font-size:14px;" disabled>FRIEND</a>
                                <?php else: ?>
                                    <form action="<?php echo e(route('account.friends.update')); ?>" method="POST" style="display:inline;">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="id" value="<?php echo e($user->id); ?>">
                                        <input type="hidden" name="action" value="send">
                                        <button class="button small blue inline" style="font-size:14px;" type="submit">FRIEND</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if(Auth::user()->isStaff() && (Auth::user()->staff('can_view_user_info') || Auth::user()->staff('can_ban_users'))): ?>
                            <div class="text-center">
                                <?php if(Auth::user()->staff('can_view_user_info')): ?>
                                    <a href="<?php echo e(route('admin.users.view', $user->id)); ?>" class="button small red inline" style="font-size:14px;" target="_blank">INFO</a>
                                <?php endif; ?>

                                <?php if($user->id != Auth::user()->id && !$user->isBanned() && Auth::user()->staff('can_ban_users')): ?>
                                    <a href="<?php echo e(route('admin.users.ban.index', $user->id)); ?>" class="button small red inline" style="font-size:14px;" target="_blank">BAN</a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php if(count($user->awards()) > 0): ?>
                <div class="card">
                    <div class="top green">Awards</div>
                    <div class="content" style="text-align:center;">
                        <?php $__currentLoopData = $user->awards(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $award): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('awards.index')); ?>">
                                <div class="profile-card award">
                                    <img src="<?php echo e(asset("images/awards/{$award->image}.png")); ?>">
                                    <span class="ellipsis"><?php echo e($award->name); ?></span>
                                </div>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-6-12" style="padding-right:0;">
            <div class="set-slider" id="games" style="position: relative;"></div>
        </div>
        <div class="col-1-1 tab-buttons">
            <button class="tab-button blue" data-tab="crate">CRATE</button>
            <button class="tab-button transparent" data-tab="social">SOCIAL</button>
            <button class="tab-button transparent" data-tab="stats">STATS</button>
        </div>
        <div class="col-1-1">
            <div class="col-1-1" data-tab-section="crate">
                <div class="card">
                    <div class="top red">Crate</div>
                    <div class="content">
                        <div class="col-2-12">
                            <ul class="crate-types">
                                <li class="active" data-category="all">All</li>
                                <li data-category="hats">Hats</li>
                                <li data-category="tools">Tools</li>
                                <li data-category="faces">Faces</li>
                                <li data-category="heads">Heads</li>
                                <li data-category="t-shirts">T-Shirts</li>
                                <li data-category="shirts">Shirts</li>
                                <li data-category="pants">Pants</li>
                                <li data-category="specials">Specials</li>
                            </ul>
                        </div>
                        <div>
                            <ul class="col-10-12" id="inventory" style="text-align:center;padding-right:0px;"></ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="padding-right:0.1px;display:none;" data-tab-section="social">
                <div class="col-6-12">
                    <div class="card">
                        <div class="top orange" style="position:relative;">
                            <span>Clans</span>
                            <a class="button orange" href="<?php echo e(route('users.clans', $user->id)); ?>" style="position:absolute;right:5px;top:4px;padding:5px;">SEE ALL</a>
                        </div>
                        <div class="content" style="text-align:center;min-height:330.86px;">
                            <?php if($clans->count() == 0): ?>
                                <div class="center-text">
                                    <span>This user is not in any clans</span>
                                </div>
                            <?php else: ?>
                                <?php $__currentLoopData = $clans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e(route('clans.view', $clan->id)); ?>" class="col-1-3" style="padding-right:5px;padding-left:5px;">
                                        <div class="profile-card">
                                            <img src="<?php echo e($clan->thumbnail()); ?>">
                                            <span class="ellipsis"><?php echo e($clan->name); ?></span>
                                        </div>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-6-12">
                    <div class="card">
                        <div class="top red" style="position:relative;">
                            <span>Friends</span>
                            <a class="button red" href="<?php echo e(route('users.friends', $user->id)); ?>" style="position:absolute;right:5px;top:4px;padding:5px;">SEE ALL</a>
                        </div>
                        <div class="content" style="text-align:center;min-height:330.86px;">
                            <?php if($friends->count() == 0): ?>
                                <div class="center-text">
                                    <span>This user does not have any friends :(</span>
                                </div>
                            <?php else: ?>
                                <?php $__currentLoopData = $friends; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $friend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e(route('users.profile', $friend->id)); ?>" class="col-1-3" style="padding-right:5px;padding-left:5px;">
                                        <div class="profile-card user">
                                            <img src="<?php echo e($friend->thumbnail()); ?>">
                                            <span class="ellipsis"><?php echo e($friend->username); ?></span>
                                        </div>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-1-1" style="display:none;" data-tab-section="stats">
                <div class="card">
                    <div class="top red">Statistics</div>
                    <div class="content" style="min-height:330.86px;">
                        <table class="stats-table">
                            <tbody>
                                <tr>
                                    <td><b>Join Date:</b></td>
                                    <td><?php echo e($user->created_at->format('d/m/Y')); ?></td>
                                </tr>
                                <tr>
                                    <td><b>Last Online:</b></td>
                                    <td><?php echo e(($user->online()) ? 'Now' : $user->updated_at->diffForHumans()); ?></td>
                                </tr>
                                <tr>
                                    <td><b>Game Visits:</b></td>
                                    <td><?php echo e(number_format($user->visitCount())); ?></td>
                                </tr>
                                <tr>
                                    <td><b>Forum Posts:</b></td>
                                    <td><?php echo e(number_format($user->forumPostCount())); ?></td>
                                </tr>
                                <tr>
                                    <td><b>Friends:</b></td>
                                    <td><?php echo e(number_format($user->friends()->count())); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', [
    'title' => "{$user->username}'s Profile",
    'image' => $user->thumbnail()
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/web/users/profile.blade.php ENDPATH**/ ?>