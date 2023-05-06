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



<?php $__env->startSection('css'); ?>
    <style>.post_css_overwrite img{max-width:100%;}</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if($thread->is_deleted): ?>
        <div class="col-10-12 push-1-12">
            <div class="alert error">
                This thread is deleted.
            </div>
        </div>
    <?php endif; ?>
    <div class="col-10-12 push-1-12">
        <div class="col-8-12">
            <?php echo $__env->make('web.forum._header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
    <div class="col-10-12 push-1-12">
        <div class="forum-bar mb2 ellipsis">
            <div class="inline mt2">
                <a href="<?php echo e(route('forum.index')); ?>">Forum</a>
                <i class="fa fa-angle-double-right" style="font-size:1rem;" aria-hidden="true"></i>
                <a href="<?php echo e(route('forum.topic', $thread->topic->id)); ?>"><?php echo e($thread->topic->name); ?></a>
                <i class="fa fa-angle-double-right" style="font-size:1rem;" aria-hidden="true"></i>
                <a href="<?php echo e(route('forum.thread', $thread->id)); ?>">
                    <span class="weight700 bold"><?php echo e($thread->title); ?></span>
                </a>
            </div>
            <div class="push-right">
                <a href="<?php echo e(route('forum.new', ['thread', $thread->topic->id])); ?>" class="button small <?php echo e($thread->topic->color()); ?>">CREATE</a>
            </div>
        </div>
        <div class="card">
            <div class="top <?php echo e($thread->topic->color()); ?>">
                <?php if($thread->is_pinned): ?>
                    <span class="thread-label <?php echo e($thread->topic->color()); ?>">Pinned</span>
                <?php endif; ?>

                <?php if($thread->is_locked): ?>
                    <span class="thread-label <?php echo e($thread->topic->color()); ?>">Locked</span>
                <?php endif; ?>

                <?php echo e($thread->title); ?>

                <div style="float:right">
                    <form method="POST" action="#" id="bookmark-submit">
                        <?php echo csrf_field(); ?>
                        <input type="submit" id="bookmarkSubmit" style="display:none;">
                    </form>
                </div>
            </div>
            <div class="content">
                <?php if($thread->replies()->currentPage() == 1): ?>
                    <?php echo $__env->make('web.forum._reply', ['post' => $thread, 'isReply' => false], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>

                <?php $__currentLoopData = $thread->replies(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('web.forum._reply', ['post' => $reply, 'isReply' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <div class="center-text">
            <div class="pages mb2"><?php echo e($thread->replies()->onEachSide(1)); ?></div>
            <?php if(!Auth::check() || (!Auth::user()->isStaff() && $thread->is_locked)): ?>
                <a class="button no-click">REPLY</a>
            <?php else: ?>
                <a href="<?php echo e(route('forum.new', ['reply', $thread->id])); ?>" class="button <?php echo e($thread->topic->color()); ?>">REPLY</a>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', [
    'title' => $thread->title,
    'image' => $thread->creator->thumbnail()
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/web/forum/thread.blade.php ENDPATH**/ ?>