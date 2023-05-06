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
            <div class="content">
                <?php if($friends->count() == 0): ?>
                    <div style="text-align:center">
                        <span>This user does not have any friends :(</span>
                    </div>
                <?php else: ?>
                    <ul class="friends-list">
                        <?php $__currentLoopData = $friends; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $friend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="col-1-5 mobile-col-1-1">
                                <a href="<?php echo e(route('users.profile', $friend->id)); ?>">
                                    <div class="profile-card">
                                        <img src="<?php echo e($friend->thumbnail()); ?>" style="height:150px;width:150px;">
                                        <div class="ellipsis"><?php echo e($friend->username); ?></div>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
        <div class="pages"><?php echo e($friends->onEachSide(1)); ?></div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', [
    'title' => 'Friends'
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/web/users/friends.blade.php ENDPATH**/ ?>