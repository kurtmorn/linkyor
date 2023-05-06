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
        <div class="tabs">
            <a href="<?php echo e(route('account.inbox.index', '')); ?>" class="tab <?php if($category == 'incoming'): ?> active <?php endif; ?> col-6-12">Inbox</a>
            <a href="<?php echo e(route('account.inbox.index', 'sent')); ?>" class="tab <?php if($category == 'sent'): ?> active <?php endif; ?> col-6-12">Outbox</a>
            <div class="tab-holder" style="box-shadow:none;">
                <div class="tab-body active">
                    <div class="content" style="padding:0px">
                        <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <a href="<?php echo e(route('account.inbox.message', $message->id)); ?>">
                                <div class="hover-card thread-card m0 <?php echo e((!$message->seen && $message->receiver_id == Auth::user()->id) ? 'viewed' : ''); ?>">
                                    <div class="col-7-12 topic">
                                        <span class="small-text label dark"><?php echo e($message->title); ?></span>
                                        <br>
                                        <?php if($message->receiver->id == Auth::user()->id): ?>
                                            <span class="label smaller-text">From <span class="darkest-gray-text"><?php echo e($message->sender->username); ?></span></span>
                                        <?php else: ?>
                                            <span class="label smaller-text">To <span class="darkest-gray-text"><?php echo e($message->receiver->username); ?></span></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="no-mobile overflow-auto topic">
                                        <div class="col-1-1 stat" style="text-align:right;">
                                            <span class="title" title="<?php echo e($message->created_at->format('D, M d Y h:i A')); ?>"><?php echo e($message->created_at->diffForHumans()); ?></span>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div style="text-align:center;padding:10px;">
                                <span>You don't have any messages!</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-10-12 push-1-12">
        <div class="pages"><?php echo e($messages->onEachSide(1)); ?></div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', [
    'title' => 'Inbox'
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/web/account/inbox/index.blade.php ENDPATH**/ ?>