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
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Thumbnail</div>
                <div class="card-body text-center">
                    <img src="<?php echo e($item->thumbnail()); ?>">
                    <a href="<?php echo e(route('shop.item', $item->id)); ?>" class="button blue small w-100 mt-3" target="_blank"><i class="fas fa-link"></i> View in Shop</a>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">Information</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6"><strong>Creation Date</strong></div>
                        <div class="col-6 text-right"><?php echo e($item->created_at->format('M d, Y')); ?></div>
                        <div class="col-6"><strong>Last Updated</strong></div>
                        <div class="col-6 text-right"><?php echo e($item->updated_at->format('M d, Y')); ?></div>
                        <div class="col-6"><strong>Owners</strong></div>
                        <div class="col-6 text-right"><?php echo e(number_format($item->owners()->count())); ?></div>
                        <div class="col-4"><strong>Bits</strong></div>
                        <div class="col-8 text-right bits-text">
                            <span class="bits-icon"></span>
                            <span><?php echo e(number_format($item->price_bits)); ?></span>
                        </div>
                        <div class="col-4"><strong>Bucks</strong></div>
                        <div class="col-8 text-right bucks-text">
                            <span class="bucks-icon"></span>
                            <span><?php echo e(number_format($item->price_bucks)); ?></span>
                        </div>
                        <div class="col-6"><strong>Is Off Sale</strong></div>
                        <div class="col-6 text-right"><?php echo e((!$item->onsale) ? 'Yes' : 'No'); ?></div>
                        <div class="col-6"><strong>Is Public</strong></div>
                        <div class="col-6 text-right"><?php echo e(($item->public_view) ? 'Yes' : 'No'); ?></div>
                        <div class="col-6"><strong>Status</strong></div>
                        <div class="col-6 text-right"><?php echo e(ucfirst($item->status)); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <form action="<?php echo e(route('admin.items.update')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo e($item->id); ?>">
                <div class="card">
                    <div class="card-header">Actions</div>
                    <div class="card-body">
                        <?php if(staffUser()->staff('can_review_pending_assets')): ?>
                            <button class="<?php echo e(($item->status != 'approved') ? 'green' : 'red'); ?> w-100 mb-2" name="action" value="status">
                                <?php if($item->status != 'approved'): ?>
                                    <i class="fas fa-check mr-1"></i>
                                    <span>Approve</span>
                                <?php else: ?>
                                    <i class="fas fa-times mr-1"></i>
                                    <span>Deny</span>
                                <?php endif; ?>
                            </button>
                        <?php endif; ?>

                        <?php if(staffUser()->staff('can_scrub_item_info')): ?>
                            <button class="red w-100 mb-2" name="action" value="scrub">
                                <i class="fas fa-trash mr-1"></i>
                                <span>Scrub</span>
                            </button>
                        <?php endif; ?>

                        <?php if((staffUser()->staff('can_edit_item_info') || $item->creator->id == staffUser()->id) && !in_array($item->type, ['tshirt', 'shirt', 'pants'])): ?>
                            <a href="<?php echo e(route('admin.edit_item.index', $item->id)); ?>" class="button blue w-100 mb-2">
                                <i class="fas fa-edit mr-1"></i>
                                <span>Edit</span>
                            </a>
                        <?php endif; ?>

                        <?php if(staffUser()->staff('can_render_thumbnails')): ?>
                            <button class="orange w-100 mb-2" name="action" value="regen">
                                <i class="fas fa-sync mr-1"></i>
                                <span>Regen Thumbnail</span>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', [
    'title' => "Item: {$item->name}"
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/items/view.blade.php ENDPATH**/ ?>