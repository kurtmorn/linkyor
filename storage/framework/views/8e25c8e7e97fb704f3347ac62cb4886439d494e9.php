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



<?php $__env->startSection('meta'); ?>
    <meta
        name="routes"
        data-index="<?php echo e(route('shop.index')); ?>"
        data-index-title="Shop - <?php echo e(config('site.name')); ?>"
    >
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(js_file('shop/edit')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('web.shop._header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="col-10-12 push-1-12 item-holder" id="items">
        <div class="card" style="margin-bottom:20px;">
            <div class="top green">Edit <?php echo e($item->name); ?></div>
            <div class="content">
                <div class="col-1-3 agray-text very-bold">
                    <form action="<?php echo e(route('shop.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id" value="<?php echo e($item->id); ?>">
                        <div>Title:</div>
                        <input style="margin-bottom:10px;" type="text" name="name" placeholder="My Item" value="<?php echo e($item->name); ?>" required>
                        <div>Description</div>
                        <textarea class="width-100 block" style="height:80px;margin-bottom:10px;" name="description" placeholder="Brand new design!"><?php echo e($item->description); ?></textarea>
                        <div class="mb3">
                            <span>For Sale:</span>
                            <input style="vertical-align:middle;" type="checkbox" name="onsale" <?php if($item->onsale()): ?> checked <?php endif; ?>>
                        </div>
                        <div class="block" style="margin-bottom:10px;">
                            <div>Price:</div>
                            <span class="bucks-icon" style="vertical-align:middle;padding-right:0px;"></span>
                            <input style="width:100px;" type="number" name="price_bucks" placeholder="0 bucks" value="<?php echo e($item->price_bucks); ?>" min="0" max="1000000">
                            <span class="bits-icon" style="vertical-align:middle;padding-right:0px;"></span>
                            <input style="width:100px;" type="number" name="price_bits" placeholder="0 bits" value="<?php echo e($item->price_bits); ?>" min="0" max="1000000">
                        </div>
                        <button class="green" type="submit">SAVE</button>
                        <a href="<?php echo e(route('shop.item', $item->id)); ?>" class="button red" style="font-size:0.85rem;font-weight:500;">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', [
    'title' => 'Edit Item'
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/web/shop/edit.blade.php ENDPATH**/ ?>