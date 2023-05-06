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



<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(js_file('account/inbox/message')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="col-10-12 push-1-12">
        <div class="card">
            <div class="top blue"><?php echo e($message->title); ?></div>
            <div class="content" style="position:relative;">
                <div class="user-info" style="width:250px;overflow:hidden;display:inline-block;float:left;">
                    <a href="<?php echo e(route('users.profile', $message->sender->id)); ?>">
                        <img src="<?php echo e($message->sender->thumbnail()); ?>" style="width:200px;display:block;">
                        <span style="white-space:nowrap;"><?php echo e($message->sender->username); ?></span>
                    </a>
                </div>
                <div style="padding-left:250px;padding-bottom:10px;"><?php echo nl2br(e($message->body)); ?></div>
                <?php if($message->sender->id != Auth::user()->id && !$message->sender->isStaff() && $message->receiver->id == Auth::user()->id): ?>
                    <div class="admin-forum-options" style="position:absolute;bottom:0;right:2px;padding-bottom:5px;">
                        <a href="<?php echo e(route('report.index', ['message', $message->id])); ?>" class="dark-gray-text cap-text">Report</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php if($message->sender->id != Auth::user()->id): ?>
            <div class="card reply-card" id="replyCard" style="display:none;">
                <div class="content" style="padding:15px;">
                    <form action="<?php echo e(route('account.inbox.create')); ?>" method="POST"">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id" value="<?php echo e($message->id); ?>">
                        <input type="hidden" name="type" value="reply">
                        <textarea style="width:100%;height:250px;box-sizing:border-box;" name="body"></textarea>
                        <button class="forum-button blue" style="margin:10px auto 10px auto;display:block;" type="submit">SEND</button>
                    </form>
                </div>
            </div>
            <div class="center-text">
                <a class="button blue inline" id="replyButton" style="margin:10px auto 10px auto;">REPLY</a>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', [
    'title' => $message->title
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/web/account/inbox/message.blade.php ENDPATH**/ ?>