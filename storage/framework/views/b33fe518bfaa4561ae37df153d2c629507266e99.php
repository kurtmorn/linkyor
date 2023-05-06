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
            <div class="top blue">Popular Clans</div>
            <div class="content">
                <div class="mb2 overflow-auto">
                    <form action="<?php echo e(route('clans.index')); ?>" method="GET">
                        <div class="col-9-12">
                            <input class="width-100 rigid" style="height:41px;" type="text" name="search" placeholder="Search">
                        </div>
                        <div class="col-3-12">
                            <div class="acc-1-2 np">
                                <button class="blue width-100" type="submit">Search</button>
                            </div>
                            <?php if(auth()->guard()->check()): ?>
                                <div class="acc-1-2 np">
                                    <a href="<?php echo e(route('clans.create')); ?>" class="button green width-100">Create</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
                <div class="col-1-1" style="padding-right:0;">
                    <?php $__empty_1 = true; $__currentLoopData = $clans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <a href="<?php echo e(route('clans.view', $clan->id)); ?>">
                            <div class="hover-card clan">
                                <div class="clan-logo">
                                    <img class="width-100" src="<?php echo e($clan->thumbnail()); ?>">
                                </div>
                                <div class="data ellipsis">
                                    <span class="clan-name bold mobile-col-1-2 ellipsis"><?php echo e($clan->name); ?></span>
                                    <span class="push-right"><?php echo e(number_format($clan->member_count)); ?> <?php echo e(($clan->member_count == 1) ? 'Member' : 'Members'); ?></span>
                                </div>
                                <div class="clan-description"><?php echo nl2br(e($clan->description)); ?></div>
                            </div>
                        </a>
                        <hr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div style="text-align:center">
                            <span>No clans found</span>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="pages"><?php echo e($clans->onEachSide(1)); ?></div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', [
    'title' => 'Clans'
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/web/clans/index.blade.php ENDPATH**/ ?>