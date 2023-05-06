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



<?php $__env->startSection('meta'); ?>
    <meta
        name="routes"
        data-index="<?php echo e(route('shop.index')); ?>"
        data-index-title="Shop - <?php echo e(config('site.name')); ?>"
        data-upload="<?php echo e(route('shop.upload')); ?>"
    >
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(js_file('shop/create')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('web.shop._header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="col-10-12 push-1-12 item-holder" id="items">
        <div class="card">
            <div class="top green">Upload</div>
            <div class="content">
                <div id="types" style="text-align:center;">
                    <div style="display:inline-block;padding-bottom:20px;">
                        <div style="cursor:pointer;" data-type="shirt">
                            <img src="<?php echo e(asset('images/shop/shirt.png')); ?>">
                        </div>
                        <div>Shirt</div>
                    </div>
                    <div style="display:inline-block;padding-bottom:20px;">
                        <div style="cursor:pointer;" data-type="pants">
                            <img src="<?php echo e(asset('images/shop/pants.png')); ?>">
                        </div>
                        <div>Pants</div>
                    </div>
                </div>
                <form id="upload" style="display:none;">
                    <div class="col-1-3 agray-text very-bold">
                        <div>Title:</div>
                        <input class="mb2" type="text" name="title" placeholder="My Item" required>
                        <a href="<?php echo e(asset('images/shop/template.png')); ?>" class="mb2 button width-100 blue" style="font-size:10px;">DOWNLOAD TEMPLATE</a>
                        <button class="green" type="submit">UPLOAD</button>
                    </div>
                    <div class="col-1-3" style="text-align:center;">
                        <div class="agray-text very-bold" id="textureChosen" style="margin-bottom:5px;">No Texture Chosen</div>
                        <div class="file-img-box">
                            <img id="texture">
                        </div>
                        <label class="button orange small unselectable no-cap" for="upload-file-img">Choose Texture</label>
                        <input style="display:none;" type="file" name="img" id="upload-file-img" accept="image/jpeg, image/png">
                    </div>
                    <div class="col-1-3">
                        <div class="upload-preview-box">
                            <img id="preview">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', [
    'title' => 'Create'
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/web/shop/create.blade.php ENDPATH**/ ?>