<?php $__env->startSection('content'); ?>
    <?php if($type == 'currency'): ?>
        <div class="row">
            <?php if(staffUser()->staff('can_give_currency')): ?>
                <div class="col-md">
                    <div class="card">
                        <div class="card-header">Give Bits</div>
                        <div class="card-body">
                            <form action="<?php echo e(route('admin.users.manage.update')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="id" value="<?php echo e($user->id); ?>">
                                <input type="hidden" name="action" value="give_currency">
                                <input type="hidden" name="currency" value="bits">
                                <input class="form-control mb-3" name="amount" type="number" min="1" placeholder="Amount" required>
                                <button class="bits" type="submit">Give</button>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">Give Bucks</div>
                        <div class="card-body">
                            <form action="<?php echo e(route('admin.users.manage.update')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="id" value="<?php echo e($user->id); ?>">
                                <input type="hidden" name="action" value="give_currency">
                                <input type="hidden" name="currency" value="bucks">
                                <input class="form-control mb-3" name="amount" type="number" min="1" placeholder="Amount" required>
                                <button class="bucks" type="submit">Give</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(staffUser()->staff('can_take_currency')): ?>
                <div class="col-md">
                    <div class="card">
                        <div class="card-header">Take Bits</div>
                        <div class="card-body">
                            <form action="<?php echo e(route('admin.users.manage.update')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="id" value="<?php echo e($user->id); ?>">
                                <input type="hidden" name="action" value="take_currency">
                                <input type="hidden" name="currency" value="bits">
                                <input class="form-control mb-3" name="amount" type="number" min="1" placeholder="Amount" required>
                                <button class="red" type="submit">Take</button>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">Take Bucks</div>
                        <div class="card-body">
                            <form action="<?php echo e(route('admin.users.manage.update')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="id" value="<?php echo e($user->id); ?>">
                                <input type="hidden" name="action" value="take_currency">
                                <input type="hidden" name="currency" value="bucks">
                                <input class="form-control mb-3" name="amount" type="number" min="1" placeholder="Amount" required>
                                <button class="red" type="submit">Take</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php elseif($type == 'inventory'): ?>
        <div class="row">
            <?php if(staffUser()->staff('can_give_items')): ?>
                <div class="col-md">
                    <div class="card">
                        <div class="card-header">Give Item</div>
                        <div class="card-body">
                            <form action="<?php echo e(route('admin.users.manage.update')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="id" value="<?php echo e($user->id); ?>">
                                <input type="hidden" name="action" value="give_items">
                                <input class="form-control mb-3" name="item_id" type="number" min="1" placeholder="Item ID" required>
                                <button class="green" type="submit">Give</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(staffUser()->staff('can_take_items')): ?>
                <div class="col-md">
                    <div class="card">
                        <div class="card-header">Take Item</div>
                        <div class="card-body">
                            <form action="<?php echo e(route('admin.users.manage.update')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="id" value="<?php echo e($user->id); ?>">
                                <input type="hidden" name="action" value="take_items">
                                <input class="form-control mb-3" name="item_id" type="number" min="1" placeholder="Item ID" required>
                                <button class="red" type="submit">Take</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', [
    'title' => $title
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/users/manage.blade.php ENDPATH**/ ?>