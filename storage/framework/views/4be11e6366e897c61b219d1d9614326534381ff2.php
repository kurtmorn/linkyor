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

<div class="col-1-1" style="padding-right:0;">
    <?php $__empty_1 = true; $__currentLoopData = $staffUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staffUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <a href="<?php echo e(route('users.profile', $staffUser->user->id)); ?>">
            <div class="search-user-card ellipsis">
                <img src="<?php echo e($staffUser->user->thumbnail()); ?>">
                <div class="data">
                    <div class="ellipsis">
                        <b><?php echo e($staffUser->user->username); ?></b>
                        <span style="float:right;" class="status-dot <?php echo e(($staffUser->user->online()) ? 'online' : ''); ?>"></span>
                    </div>
                    <span class="ellipsis"><?php echo nl2br(e($staffUser->user->description)); ?></span>
                </div>
            </div>
        </a>
        <hr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <span>There are currently no staff.</span>
    <?php endif; ?>
    <div class="pages"><?php echo e($staffUsers->onEachSide(1)); ?></div>
</div>
<?php /**PATH /var/www/html/resources/views/web/info/_staff.blade.php ENDPATH**/ ?>