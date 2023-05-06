<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <i class="fa fa-home"></i>
                    <strong>Welcome</strong>
                </div>
                <div class="card-body">
                    <p>This is a semi-private project. If you're not sure what this is, <a href="<?php echo e(config('site.discord_url')); ?>" class="text-success">join our Discord server</a> to learn more.</p>
                    <h4 class="mb-1">How do I get access?</h4>
                    <p class="mb-0">To get access, <a href="<?php echo e(config('site.discord_url')); ?>" class="text-success">join our discord server</a>, then copy and pase the url in the "#access" channel into your web browser. We do this to help prevent malicious bots, indexing, and other actions that may harm the progress of this website.</p>
                </div>
            </div>
        </div>
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <i class="fa fa-info-circle"></i>
                    <strong>Frequently Asked Questions</strong>
                </div>
                <div class="card-body">
                    <h4 class="mb-1">After pasting the URL, I just get brought back to this page!</h4>
                    <p>Make sure your web browser has cookies enabled. If you use Firefox Containers, make sure to paste the authorization URL into the URL bar of the container you want to access this website with.</p>
                    <h4 class="mb-1">I already pasted the URL recently. Why am I being asked to do it again?</h4>
                    <p class="mb-0">In an ongoing effort to prevent abuse, we may have to update the authorization URL every so often. Each time it is updated, you will have to paste the new URL into your web browser again.</p>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.faker', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/faker/index.blade.php ENDPATH**/ ?>