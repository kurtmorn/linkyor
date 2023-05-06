<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">Edit <?php echo e($topic->name); ?></div>
        <div class="card-body">
            <form action="<?php echo e(route('admin.manage.forum_topics.update')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo e($topic->id); ?>">
                <label for="name">Name</label>
                <input class="form-control mb-2" type="text" name="name" placeholder="Name" value="<?php echo e($topic->name); ?>" required>
                <label for="description">Description</label>
                <textarea class="form-control mb-2" name="description" placeholder="Write topic description here..." rows="5" required><?php echo e($topic->description); ?></textarea>
                <label for="home_page_priority">Home Page Priority</label>
                <input class="form-control mb-2" type="number" name="home_page_priority" placeholder="Home Page Priority" value="<?php echo e($topic->home_page_priority); ?>" min="1" max="255" required>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="is_staff_only_viewing" <?php if($topic->is_staff_only_viewing): ?> checked <?php endif; ?>>
                    <label class="form-check-label" for="staff_only_viewing">Staff Only Viewing</label>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_staff_only_posting" <?php if($topic->is_staff_only_posting): ?> checked <?php endif; ?>>
                    <label class="form-check-label" for="staff_only_posting">Staff Only Posting</label>
                </div>
                <button class="green w-100" type="submit">Edit</button>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', [
    'title' => "Edit {$topic->name}"
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/manage/forum_topics/edit.blade.php ENDPATH**/ ?>