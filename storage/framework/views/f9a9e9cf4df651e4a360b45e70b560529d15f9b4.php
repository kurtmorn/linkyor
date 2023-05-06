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
        <div class="col-md-8 offset-md-2">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-envelope text-primary mb-2" style="font-size:80px;"></i>
                    <h4>Verify your <?php echo e(config('site.name')); ?> Account</h4>
                    <?php if(empty(Auth::user()->email_verified_at)): ?>
                        <?php if($emailSent): ?>
                            <p>An email has been sent to your inbox. You can re-try again after 5 minutes.</p>
                            <p>Be sure to check your spam folder if you can't find the email.</p>
                        <?php else: ?>
                            <p>You are not verified! Click the "Send Email" button below to send an email to your account!</p>
                            <form action="<?php echo e(route('account.verify.send')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button class="btn btn-success" type="submit">Send Email</button>
                            </form>
                        <?php endif; ?>
                    <?php else: ?>
                        <p>Your account has been verified.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', [
    'title' => 'Verify'
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/web/account/verify.blade.php ENDPATH**/ ?>