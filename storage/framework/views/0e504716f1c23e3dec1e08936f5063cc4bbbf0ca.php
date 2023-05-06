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



<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(js_file('account/settings')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="col-10-12 push-1-12">
        <div class="settings">
            <div class="card">
                <div class="top blue">Settings</div>
                <div class="content">
                    <span class="dark-gray-text very-bold block">Information</span>
                    <div class="block">
                        <span class="dark-gray-text" style="padding-right:5px;">Username:</span>
                        <span class="light-gray-text"><?php echo e(Auth::user()->username); ?></span>
                        <i class="f-right light-gray-text far fa-edit" style="cursor:pointer;" data-modal-open="username"></i>
                    </div>
                    <div class="block">
                        <span class="dark-gray-text" style="padding-right:5px;">Password:</span>
                        <span class="light-gray-text">*********</span>
                        <i class="f-right light-gray-text far fa-edit" style="cursor:pointer;" data-modal-open="password"></i>
                    </div>
                    <div class="block">
                        <span class="dark-gray-text" style="padding-right:5px;">Email:</span>
                        <span class="light-gray-text"><?php echo e($email); ?></span>
                        <i class="f-right light-gray-text far fa-edit" style="cursor:pointer;" data-modal-open="email"></i>
                    </div>
                    <div class="block">
                        <form action="<?php echo e(route('account.settings.update')); ?>" style="display:inline;" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="type" value="theme">
                            <span class="dark-gray-text" style="padding-right:5px;">Theme:</span>
                            <div class="inline">
                                <select name="theme">
                                    <?php $__currentLoopData = $themes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $theme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key); ?>" <?php echo e((Auth::user()->setting->theme == $key) ? 'selected' : ''); ?> <?php echo e((!$theme['available']) ? 'disabled' : ''); ?>><?php echo e($theme['name']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <button class="f-right blue button small" type="submit">Save</button>
                        </form>
                    </div>
                    <hr>
                    <form action="<?php echo e(route('account.settings.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="type" value="description">
                        <span class="dark-gray-text bold block" style="padding-bottom:5px;">Blurb</span>
                        <textarea name="description" placeholder="Hi, my name is <?php echo e(Auth::user()->username); ?>" class="width-100 block" style="height:80px;margin-bottom:6px;"><?php echo e(Auth::user()->description); ?></textarea>
                        <button class="small blue" type="submit">Save</button>
                    </form>
                </div>
                <div class="modal" style="display:none;" data-modal="username">
                    <div class="modal-content">
                        <form action="<?php echo e(route('account.settings.update')); ?>" style="display:inline;" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="type" value="username">
                            <span class="close" data-modal-close="username">×</span>
                            <span>Change Username</span>
                            <hr>
                            <input type="text" name="username" placeholder="New Username">
                            <span style="color:red;font-size:11px;">WARNING: This will take <?php echo e(number_format(config('site.username_change_price'))); ?> bucks</span>
                            <div class="modal-buttons">
                                <button class="green" style="margin-right:10px;" type="submit">Buy</button>
                                <button type="button" class="cancel-button" data-modal-close="username">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal" style="display:none;" data-modal="password">
                    <div class="modal-content">
                        <form action="<?php echo e(route('account.settings.update')); ?>" style="display:inline;" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="type" value="password">
                            <span class="close" data-modal-close="password">×</span>
                            <span>Change Password</span>
                            <hr>
                            <input type="password" name="current_password" placeholder="Current Password">
                            <input type="password" name="new_password" placeholder="New Password">
                            <input type="password" name="new_password_confirmation" placeholder="Confirm New Password">
                            <div class="modal-buttons">
                                <button class="green" style="margin-right:10px;" type="submit">Save</button>
                                <button type="button" class="cancel-button" data-modal-close="password">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal" style="display:none;" data-modal="email">
                    <div class="modal-content">
                        <form action="<?php echo e(route('account.settings.update')); ?>" style="display:inline;" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="type" value="email">
                            <span class="close" data-modal-close="email">×</span>
                            <span>Change Email</span>
                            <hr>
                            <input type="text" name="current_email" placeholder="Current Email">
                            <input type="text" name="new_email" placeholder="New Email">
                            <input type="password" name="password" placeholder="Current Password">
                            <div class="modal-buttons">
                                <button class="green" style="margin-right:10px;" type="submit">Save</button>
                                <button type="button" class="cancel-button" data-modal-close="email">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', [
    'title' => 'Settings'
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/web/account/settings.blade.php ENDPATH**/ ?>