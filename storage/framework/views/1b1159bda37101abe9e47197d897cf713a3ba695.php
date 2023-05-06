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



<?php $__env->startSection('content'); ?>
    <div class="col-10-12 push-1-12">
        <div class="card">
            <div class="top blue">Search Users</div>
            <div class="content">
                <div class="col-1-1" style="text-align:center;margin-bottom:10px;padding-right:0;">
                    <form action="<?php echo e(route('users.index', $category)); ?>" method="GET">
                        <input class="input rigid" style="width:70%;margin-right:5px;" type="text" name="search" placeholder="Search users">
                        <button style="height:100%" class="blue shop-search-button" type="submit">SEARCH</button>
                        <a href="<?php echo e(route('users.index', 'online')); ?>" class="button green" style="font-size:14px;">ONLINE</a>
                    </form>
                </div>
                <div class="col-1-1" style="padding-right:0;">
                    <hr>
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <a href="<?php echo e(route('users.profile', $user->id)); ?>">
                            <div class="search-user-card ellipsis">
                                <img src="<?php echo e($user->thumbnail()); ?>">
                                <div class="data">
                                    <div class="ellipsis">
                                        <b><?php echo e($user->username); ?></b>
                                        <span style="float:right;" class="status-dot <?php echo e(($user->online()) ? 'online' : ''); ?>"></span>
                                    </div>
                                    <span class="ellipsis"><?php echo nl2br(e($user->description)); ?></span>
                                </div>
                            </div>
                        </a>
                        <hr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div style="text-align:center">
                            <span>No users found.</span>
                        </div>
                    <?php endif; ?>
                    <div class="pages"><?php echo e($users->onEachSide(1)); ?></div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', [
    'title' => 'Users'
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/web/users/index.blade.php ENDPATH**/ ?>