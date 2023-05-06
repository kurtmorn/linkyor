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



<?php $__env->startSection('header'); ?>
    <a href="<?php echo e(config('site.storage_url')); ?>/default/<?php echo e(($item->type != 'face') ? 'avatar.blend' : 'face.png'); ?>" class="button green small" download>
        <i class="fas fa-share"></i>
        <span>Download <?php echo e(($item->type != 'face') ? 'Avatar' : 'Face'); ?></span>
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Information</div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.edit_item.update')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id" value="<?php echo e($item->id); ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name">Name</label>
                                <input class="form-control mb-2" type="text" name="name" placeholder="Item Name" value="<?php echo e($item->name); ?>">
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col">
                                        <label for="price_bucks">
                                            <span class="bucks-icon"></span>
                                            <span>Bucks</span>
                                        </label>
                                        <input class="form-control mb-2" type="number" name="price_bucks" placeholder="Bucks" min="0" max="1000000" value="<?php echo e($item->price_bucks); ?>">
                                    </div>
                                    <div class="col">
                                        <label for="price_bits">
                                            <span class="bits-icon"></span>
                                            <span>Bits</span>
                                        </label>
                                        <input class="form-control mb-2" type="number" name="price_bits" placeholder="Bits" min="0" max="1000000" value="<?php echo e($item->price_bits); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <label for="description">Description</label>
                        <textarea class="form-control mb-2" name="description" placeholder="Item Description" rows="5"><?php echo e($item->description); ?></textarea>
                        <label for="stock">Special Stock</label>
                        <input class="form-control mb-2" type="number" name="stock" placeholder="Special Stock" min="0" max="500" value="<?php echo e($item->stock); ?>">
                        <label for="onsale_for">
                            <span>Onsale For</span>
                            <?php if($item->isTimed()): ?>
                                <span class="text-danger">(Onsale Until: <?php echo e($item->onsale_until); ?>)</span>
                            <?php endif; ?>
                        </label>
                        <select class="form-control mb-2" name="onsale_for">
                            <option selected disabled hidden>--</option>
                            <option value="forever">Forever</option>
                            <option value="1_hour">1 Hour</option>
                            <option value="12_hours">12 Hours</option>
                            <option value="1_day">1 Day</option>
                            <option value="3_days">3 Days</option>
                            <option value="7_days">7 Days</option>
                            <option value="14_days">14 Days</option>
                            <option value="21_days">21 Days</option>
                            <option value="1_month">1 Month</option>
                        </select>
                        <div class="row">
                            <?php if($item->type != 'head'): ?>
                                <div class="col-12 mb-2">
                                    <label for="image">Image</label><br>
                                    <input name="image" type="file" accept=".png,.jpg,.jpeg">
                                </div>
                            <?php endif; ?>

                            <?php if($item->type != 'face'): ?>
                                <div class="col-12 mb-2">
                                    <label for="model">Model</label><br>
                                    <input name="model" type="file" accept=".obj">
                                </div>
                            <?php endif; ?>
                        </div>
                        <label>Options</label>
                        <div class="row mb-1">
                            <div class="col-md-4">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="onsale" <?php if($item->onsale()): ?> checked <?php endif; ?>>
                                    <label class="form-check-label" for="onsale">For Sale</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="special" <?php if($item->special_type): ?> checked <?php endif; ?>>
                                    <label class="form-check-label" for="special">Special</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="public" <?php if($item->public_view): ?> checked <?php endif; ?>>
                                    <label class="form-check-label" for="public_view">Public</label>
                                </div>
                            </div>
                        </div>
                        <button class="green w-100" type="submit">Update</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-header">Thumbnail</div>
            <div class="card">
                <div class="card-body text-center">
                    <img src="<?php echo e($item->thumbnail()); ?>">
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', [
    'title' => "Edit {$item->name}"
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/edit_item.blade.php ENDPATH**/ ?>