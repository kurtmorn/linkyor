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
    <div class="col-8-12">
        <?php echo $__env->make('web.forum._header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <div class="col-8-12">
        <div class="card">
            <?php if($topics->count() == 0): ?>
                <span>There are currently no forum topics.</span>
            <?php else: ?>
                <div class="top blue">
                    <div class="col-7-12"><?php echo e(config('site.name')); ?></div>
                    <div class="no-mobile overflow-auto topic text-center">
                        <div class="col-3-12 stat">Threads</div>
                        <div class="col-3-12 stat">Replies</div>
                        <div class="col-6-12"></div>
                    </div>
                </div>
                <div class="content">
                    <?php $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="board-info mb1">
                            <div class="col-7-12 board">
                                <div><a href="<?php echo e(route('forum.topic', $topic->id)); ?>" class="label dark"><?php echo e($topic->name); ?></a></div>
                                <span class="label small"><?php echo e($topic->description); ?></span>
                            </div>
                            <div class="no-mobile overflow-auto board ellipsis" style="overflow:hidden;">
                                <div class="col-3-12 stat">
                                    <span class="title"><?php echo e(number_format($topic->threads(false)->count())); ?></span>
                                </div>
                                <div class="col-3-12 stat">
                                    <span class="title"><?php echo e(number_format(0)); ?></span>
                                </div>
                                <div class="col-6-12 text-right ellipsis pt2" style="max-width:180px;">
                                    <?php if($topic->lastPost()): ?>
                                        <a href="<?php echo e(route('forum.thread', $topic->lastPost()->id)); ?>" class="label dark"><?php echo e($topic->lastPost()->title); ?></a>
                                        <br>
                                        <span class="label small"><?php echo e($topic->lastPost()->updated_at->diffForHumans()); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-4-12">
        <div class="card">
            <div class="top">Recent Topics</div>
            <div class="content">
                <?php $__empty_1 = true; $__currentLoopData = $recentThreads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $thread): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="thread">
                        <div class="col-10-12 ellipsis">
                            <div class="ellipsis mb1">
                                <a href="<?php echo e(route('forum.thread', $thread->id)); ?>" class="label dark"><?php echo e($thread->title); ?></a>
                            </div>
                            <div class="label small ellipsis">
                                by <a href="<?php echo e(route('users.profile', $thread->creator->id)); ?>" class="dark-gray-text"><?php echo e($thread->creator->username); ?></a> in <a href="<?php echo e(route('forum.topic', $thread->topic->id)); ?>" class="dark-gray-text"><?php echo e($thread->topic->name); ?></a>
                            </div>
                        </div>
                        <div class="col-2-12">
                            <div class="forum-tag"><?php echo e(number_format($thread->replies(false)->count())); ?></div>
                        </div>
                    </div>

                    <?php if($key != $recentThreads->count() - 1): ?>
                        <hr>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <span>No topics found.</span>
                <?php endif; ?>
            </div>
        </div>
        <div class="card">
            <div class="top">Popular Topics</div>
            <div class="content">
                <span>Coming soon.</span>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', [
    'title' => 'Forum'
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/web/forum/index.blade.php ENDPATH**/ ?>