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
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills nav-justified" role="tablist">
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.asset_approval.index', 'items')); ?>" class="nav-link <?php if($category == 'items'): ?> active <?php endif; ?>">Items (<?php echo e(number_format($totalItems)); ?>)</a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.asset_approval.index', 'logos')); ?>" class="nav-link <?php if($category == 'logos'): ?> active <?php endif; ?>">Logos (<?php echo e(number_format($totalLogos)); ?>)</a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.asset_approval.index', 'thumbnails')); ?>" class="nav-link <?php if($category == 'thumbnails'): ?> active <?php endif; ?>">Thumbnails (<?php echo e(number_format($totalThumbnails)); ?>)</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="row mb-2">
        <?php $__empty_1 = true; $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <a href="<?php echo e($asset->image); ?>" class="mb-2" target="_blank">
                            <img src="<?php echo e($asset->image); ?>">
                        </a>
                        <div class="text-truncate">
                            <a href="<?php echo e($asset->url); ?>" style="font-weight:600;" target="_blank"><?php echo e($asset->name); ?></a>
                            <div style="margin-top:-5px;">
                                <strong><?php echo e(($category == 'items') ? 'Creator' : 'Owner'); ?>:</strong>
                                <a href="<?php echo e($asset->creator_url); ?>" target="_blank"><?php echo e($asset->creator_name); ?></a>
                            </div>
                        </div>
                        <?php if($category == 'items'): ?>
                            <div style="margin-top:-5px;">
                                <strong>Type:</strong>
                                <span><?php echo e(itemType($asset->type)); ?></span>
                            </div>
                        <?php endif; ?>
                        <hr>
                        <form action="<?php echo e(route('admin.asset_approval.update')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="id" value="<?php echo e($asset->id); ?>">
                            <input type="hidden" name="type" value="<?php echo e($type); ?>">
                            <div class="row">
                                <div class="col">
                                    <button class="green w-100" name="action" value="approve"><i class="fas fa-check"></i></button>
                                </div>
                                <div class="col">
                                    <button class="red w-100" name="action" value="deny"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col">There are currently no pending <?php echo e($category); ?>.</div>
        <?php endif; ?>
    </div>
    <div class="pages"><?php echo e($assets->onEachSide(1)); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', [
    'title' => 'Asset Approval'
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/asset_approval.blade.php ENDPATH**/ ?>