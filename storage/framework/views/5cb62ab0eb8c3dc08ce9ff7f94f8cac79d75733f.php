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
    <script src="<?php echo e(js_file('games/edit')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="col-10-12 push-1-12">
        <div class="card" style="margin-bottom:20px;">
            <div class="top green">Edit <?php echo e($game->name); ?></div>
            <div class="content">
                <div class="col-1-3 agray-text very-bold">
                    <form action="<?php echo e(route('games.update')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id" value="<?php echo e($game->id); ?>">
                        <div>Title:</div>
                        <input style="margin-bottom:10px;" type="text" name="name" placeholder="My Set" value="<?php echo e($game->name); ?>" required>
                        <div>Description</div>
                        <textarea class="width-100 block" style="height:80px;margin-bottom:10px;" name="description" placeholder="Have fun!"><?php echo e($game->description); ?></textarea>
                        <div style="margin-bottom:10px;">
                            <label for="thumbnail">Thumbnail</label><br>
                            <?php if(!$game->is_thumbnail_pending): ?>
                                <input style="background:transparent;border:0;padding:0;" name="thumbnail" type="file">
                            <?php else: ?>
                                <input class="width-100 block" style="background:transparent;border:0;padding:0;" type="text" value="Thumbnail is currently pending." readonly disabled>
                            <?php endif; ?>
                        </div>
                        <button class="green" type="submit">SAVE</button>
                        <a href="<?php echo e(route('games.view', $game->id)); ?>" class="button red" style="font-size:0.85rem;font-weight:500;">Cancel</a>
                    </form>
                </div>
                <div class="col-2-3 agray-text very-bold" style="padding-left:25px;">
                    <div>Host Key:</div>
                    <div style="font-size:13px;">This is used to host your set.</div>
                    <input class="width-100 block" style="margin-bottom:10px;" type="password" id="hostKey" value="<?php echo e($game->host_key); ?>" readonly disabled>
                    <button class="blue" id="showHostKey">Show Key</button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', [
    'title' => 'Edit Set'
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/web/games/edit.blade.php ENDPATH**/ ?>