<?php $__env->startSection('content'); ?>
    <div class="text-center">
        <h4 class="mb-1"><?php echo e($title); ?></h4>
        <p><?php echo e($description); ?></p>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.faker', [
    'title' => $title
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/faker/error.blade.php ENDPATH**/ ?>