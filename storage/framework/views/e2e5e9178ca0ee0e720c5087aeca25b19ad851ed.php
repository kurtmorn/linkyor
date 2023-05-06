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
        <div class="col-8-12">
            <?php echo $__env->make('web.forum._header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
    <div class="col-10-12 push-1-12">
        <div class="forum-bar weight600" style="padding:10px 5px 10px 0;">
            <a href="<?php echo e(route('forum.index')); ?>">Forum</a>
            <i class="fa fa-angle-double-right" style="font-size:1rem;" aria-hidden="true"></i>
            <a href="<?php echo e(route('forum.topic', ($type == 'thread') ? $post->topic->id : $post->thread->topic->id)); ?>"><?php echo e(($type == 'thread') ? $post->topic->name : $post->thread->topic->name); ?></a>
            <i class="fa fa-angle-double-right" style="font-size:1rem;" aria-hidden="true"></i>
            <a href="<?php echo e(route('forum.thread', ($type == 'thread') ? $post->id : $post->thread->id)); ?>">
                <span class="weight700 bold"><?php echo e(($type == 'thread') ? $post->title : $post->thread->title); ?></span>
            </a>
        </div>
        <div class="card">
            <div class="top <?php echo e(($type == 'thread') ? $post->topic->color() : $post->thread->topic->color()); ?>"><?php echo e($title); ?></div>
            <div class="content">
                <form action="<?php echo e(route('forum.update')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id" value="<?php echo e($id); ?>">
                    <input type="hidden" name="type" value="<?php echo e($type); ?>">

                    <?php if($post->quote): ?>
                        <blockquote class="<?php echo e(($type == 'thread') ? $post->topic->color() : $post->thread->topic->color()); ?>">
                            <em>Quote from <a href="<?php echo e(route('users.profile', $post->quote->creator->id)); ?>" style="color:#444"><?php echo e($post->quote->creator->username); ?></a>, <?php echo e($post->quote->created_at->format('h:i A d/m/Y')); ?></em>
                            <br>
                            <?php echo nl2br(e($post->quote->body)); ?>

                        </blockquote>
                    <?php endif; ?>

                    <?php if($type == 'thread'): ?>
                        <input style="width:100%;font-size:16px;box-sizing:border-box;" type="text" name="title" placeholder="Title (max 60 characters)" value="<?php echo e($post->title); ?>" required>
                    <?php endif; ?>

                    <textarea style="width:100%;min-height:200px;font-size:16px;box-sizing:border-box;margin-top:10px;" name="body" placeholder="Body (max 3,000 characters)" required><?php echo e($post->body); ?></textarea>
                    <div style="text-align:center;">
                        <button type="submit" class="button smaller-text <?php echo e(($type == 'thread') ? $post->topic->color() : $post->thread->topic->color()); ?>">Edit <?php echo e(ucfirst($type)); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', [
    'title' => $title
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/web/forum/edit.blade.php ENDPATH**/ ?>