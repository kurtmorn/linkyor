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
        <div class="col-4-12">
            <div class="card">
                <div class="content rounded center-text">
                    <img src="<?php echo e(Auth::user()->thumbnail()); ?>" style="width:100%;">
                    <span class="bold gray-text"><?php echo e(Auth::user()->username); ?></span>
                    <hr>
                    <div class="col-4-12 p0">
                        <div class="very-bold red-text smedium-text"><?php echo e(number_format(Auth::user()->friends()->count())); ?></div>
                        <div class="gray-text cap-text bold small-text">Friends</div>
                    </div>
                    <div class="col-4-12 p0">
                        <div class="very-bold blue-text smedium-text"><?php echo e(number_format(Auth::user()->forumPostCount())); ?></div>
                        <div class="gray-text cap-text bold small-text">Posts</div>
                    </div>
                    <div class="col-4-12 p0">
                        <div class="very-bold green-text smedium-text"><?php echo e(number_format(Auth::user()->visitCount())); ?></div>
                        <div class="gray-text cap-text bold small-text">Visits</div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="top red">News</div>
                <div class="content">
                    <?php $__empty_1 = true; $__currentLoopData = $updates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $update): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="block">
                            <a href="<?php echo e(route('forum.thread', $update->id)); ?>" class="very-bold dark-gray-text block ellipsis"><?php echo e($update->title); ?></a>
                            <div class="gray-text block status-block">by <b><?php echo e($update->creator->username); ?></b></div>
                            <span class="bold light-gray-text status-time" title="<?php echo e($update->created_at->diffForHumans()); ?>"><?php echo e($update->created_at->format('d/m/Y h:i A')); ?></span>
                        </div>
                        <hr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <span>No news found.</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-8-12">
            <div class="card">
                <div class="top blue">About Me</div>
                <div class="content">
                    <span class="gray-text very-hold">Status:</span>
                    <form style="width:75%;" class="pb3" method="POST" action="<?php echo e(route('home.status')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="input-group fill">
                            <input name="message" placeholder="Right now I'm..." type="text">
                            <button class="input-button" type="submit">Post</button>
                        </div>
                    </form>
                    <span class="gray-text very-bold">Blurb:</span>
                    <form method="POST" action="<?php echo e(route('account.settings.update')); ?>">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="type" value="description">
                        <textarea class="width-100 mb1" style="height:80px;" name="description" placeholder="Hi, my name is <?php echo e(Auth::user()->username); ?>"><?php echo e(Auth::user()->description); ?></textarea>
                        <button class="button small smaller-text blue" type="submit">Submit</button>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="top orange">My Feed</div>
                <div class="content">
                    <?php $__empty_1 = true; $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="status">
                            <a href="<?php echo e(route('users.profile', $status->creator->id)); ?>">
                                <img src="<?php echo e($status->creator->thumbnail()); ?>">
                            </a>
                            <div class="status-text ellipsis">
                                <a href="<?php echo e(route('users.profile', $status->creator->id)); ?>" class="very-bold dark-gray-text block"><?php echo e($status->creator->username); ?></a>
                                <div class="status-body gray-text"><?php echo e($status->message); ?></div>
                                <span class="bold dark-gray-text status-time absolute bottom" title="<?php echo e($status->created_at->diffForHumans()); ?>"><?php echo e($status->created_at->format('d/m/Y h:i A')); ?></span>
                            </div>
                        </div>
                        <hr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <span>Your feed is empty.</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', [
    'title' => 'Dashboard'
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/web/home/dashboard.blade.php ENDPATH**/ ?>