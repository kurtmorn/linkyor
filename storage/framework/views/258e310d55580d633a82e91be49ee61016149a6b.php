<?php $__env->startSection('header'); ?>
    <a href="<?php echo e(route('admin.manage.staff.new')); ?>" class="button green small"><i class="fas fa-plus"></i></a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if($users->count() == 0): ?>
        <p>No staff were found.</p>
    <?php else: ?>
        <div class="card" style="border:none;">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Since</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><a href="<?php echo e(route('admin.users.view', $user->user->id)); ?>"><?php echo e($user->id); ?></a></td>
                            <td><a href="<?php echo e(route('admin.users.view', $user->user->id)); ?>"><?php echo e($user->user->username); ?></a></td>
                            <td><?php echo e($user->created_at); ?></td>
                            <td><a href="<?php echo e(route('admin.manage.staff.edit', $user->user->id)); ?>" class="button blue small"><i class="fas fa-edit"></i></a></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="pages"><?php echo e($users->onEachSide(1)); ?></div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', [
    'title' => 'Manage Staff'
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/manage/staff/index.blade.php ENDPATH**/ ?>