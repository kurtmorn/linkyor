<?php $__env->startSection('header'); ?>
    <a href="<?php echo e(route('admin.manage.forum_topics.new')); ?>" class="button green small"><i class="fas fa-plus"></i></a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if($topics->count() == 0): ?>
        <p>No forum topics were found.</p>
    <?php else: ?>
        <div class="card" style="border:0;">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Created</th>
                        <th>Posts</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><a href="<?php echo e(route('admin.manage.forum_topics.edit', $topic->id)); ?>"><?php echo e($topic->id); ?></a></td>
                            <td><a href="<?php echo e(route('admin.manage.forum_topics.edit', $topic->id)); ?>"><?php echo e($topic->name); ?></a></td>
                            <td><?php echo e($topic->created_at); ?></td>
                            <td><?php echo e(number_format($topic->threads()->count())); ?></td>
                            <td><a href="<?php echo e(route('admin.manage.forum_topics.confirm_delete', $topic->id)); ?>" class="button red small"><i class="fas fa-trash"></i></a></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="pages"><?php echo e($topics->onEachSide(1)); ?></div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', [
    'title' => 'Manage Forum Topics'
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/manage/forum_topics/index.blade.php ENDPATH**/ ?>