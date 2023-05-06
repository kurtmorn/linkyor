<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(route('admin.items.index')); ?>" method="GET">
        <input class="form-control mb-3" type="text" name="search" placeholder="Search..." value="<?php echo e(request()->search); ?>">
    </form>
    <?php if($items->count() == 0): ?>
        <p>No items were found.</p>
    <?php else: ?>
        <div class="card" style="border:none;">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Created</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><a href="<?php echo e(route('admin.items.view', $item->id)); ?>"><?php echo e($item->id); ?></a></td>
                            <td><a href="<?php echo e(route('admin.items.view', $item->id)); ?>"><?php echo e($item->name); ?></a></td>
                            <td><?php echo e($item->created_at); ?></td>
                            <td><?php echo e(ucfirst($item->status)); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="pages"><?php echo e($items->onEachSide(1)); ?></div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', [
    'title' => 'Items'
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/items/index.blade.php ENDPATH**/ ?>