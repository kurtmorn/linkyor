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
            <div class="top blue">Friends</div>
            <div class="content text-center">
                <?php if($friendRequests->count() == 0): ?>
                    <span>You don't have any friend requests</span>
                <?php else: ?>
                    <ul class="friends-list">
                        <?php $__currentLoopData = $friendRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $friendRequest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="col-1-5 mobile-col-1-1">
                                <div class="friend-card">
                                    <a href="<?php echo e(route('users.profile', $friendRequest->sender->id)); ?>">
                                        <img src="<?php echo e($friendRequest->sender->thumbnail()); ?>">
                                        <div class="ellipsis"><?php echo e($friendRequest->sender->username); ?></div>
                                    </a>
                                    <form action="<?php echo e(route('account.friends.update')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="id" value="<?php echo e($friendRequest->sender->id); ?>">
                                        <button class="button small green inline" style="left:10px;font-size:10px;" name="action" value="accept">ACCEPT</button>
                                        <button class="button small red inline" style="left:10px;font-size:10px;" name="action" value="decline">DECLINE</button>
                                    </form>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
        <div class="pages"><?php echo e($friendRequests->onEachSide(1)); ?></div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', [
    'title' => 'Friends'
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/web/account/friends.blade.php ENDPATH**/ ?>