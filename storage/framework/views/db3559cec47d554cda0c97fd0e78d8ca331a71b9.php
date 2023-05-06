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
        data-regen="<?php echo e(route('account.character.regenerate')); ?>"
        data-inventory="<?php echo e(route('account.character.inventory')); ?>"
        data-wearing="<?php echo e(route('account.character.wearing')); ?>"
        data-update="<?php echo e(route('account.character.update')); ?>"
    >
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <style>
        .avatar-body-colors {
            max-width: 370px;
        }

        .avatar-body-color {
            width: 40px;
            height: 40px;
            cursor: pointer;
            display: inline-block;
            margin-bottom: 5px;
        }

        .avatar-body-part {
            cursor: pointer;
        }

        .palette {
            background: #fff;
            border: 1px solid #eee;
            position: absolute;
            margin-left: 300px;
            margin-top: 308px;
            padding: 15px;
            z-index: 1337;
        }

        @media  only screen and (max-width: 768px) {
            .avatar-body-colors {
                max-width: 320px;
            }

            .palette {
                margin-top: 200px;
                margin-left: 20px;
            }
        }

        .character-btn {
            padding: 2.5px 5px;
            position: absolute;
            top: 0;
            right: 0;
            margin-top: 5px;
            margin-right: 5px;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(js_file('account/character')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="palette" id="colors" style="display:none;">
        <div id="colorsTitle" style="color:#333;font-weight:600;margin-bottom:5px;"></div>
        <div class="avatar-body-colors">
            <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hex): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button class="avatar-body-color" style="background:<?php echo e($hex); ?>;" data-color="<?php echo e($hex); ?>"></button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <div class="col-10-12 push-1-12">
        <div class="col-5-12">
            <div class="card">
                <div class="top blue">Avatar</div>
                <div class="content customize-content" style="position:relative;min-height:405.5px;">
                    <img id="avatar" src="<?php echo e(Auth::user()->thumbnail()); ?>" style="width:100%;">
                    <div class="loader" id="loader" style="display:none;"></div>
                </div>
            </div>
            <div class="card">
                <div class="top blue">Color Pallete</div>
                <div class="content center-text">
                    <div style="margin-bottom:2.5px;">
                        <button class="avatar-body-part" style="background-color:<?php echo e(Auth::user()->avatar()->color_head); ?>;padding:25px;margin-top:-1px;" data-part="head"></button>
                    </div>
                    <div style="margin-bottom:2.5px;">
                        <button class="avatar-body-part" style="background-color:<?php echo e(Auth::user()->avatar()->color_left_arm); ?>;padding:50px;padding-right:0px;" data-part="left_arm"></button>
                        <button class="avatar-body-part" style="background-color:<?php echo e(Auth::user()->avatar()->color_torso); ?>;padding:50px;" data-part="torso"></button>
                        <button class="avatar-body-part" style="background-color:<?php echo e(Auth::user()->avatar()->color_right_arm); ?>;padding:50px;padding-right:0px;" data-part="right_arm"></button>
                    </div>
                    <div>
                        <button class="avatar-body-part" style="background-color:<?php echo e(Auth::user()->avatar()->color_left_leg); ?>;padding:50px;padding-right:0px;padding-left:47px;" data-part="left_leg"></button>
                        <button class="avatar-body-part" style="background-color:<?php echo e(Auth::user()->avatar()->color_right_leg); ?>;padding:50px;padding-right:0px;padding-left:47px;" data-part="right_leg"></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-7-12" style="padding-right:0;">
            <div class="card">
                <div class="top blue">Crate</div>
                <div class="content">
                    <div class="search-bar">
                        <input class="search rigid width-100" id="search" style="margin-right:-30px;padding:7px;margin-bottom:5px;" type="text" placeholder="Search crate">
                    </div>
                    <div class="item-types">
                        <a class="active" data-tab="hats">Hats</a>
                        <span>|</span>
                        <a data-tab="faces">Faces</a>
                        <span>|</span>
                        <a data-tab="tools">Tools</a>
                        <span>|</span>
                        <a data-tab="heads">Heads</a>
                        <span>|</span>
                        <a data-tab="figures">Figures</a>
                        <span>|</span>
                        <a data-tab="shirts">Shirts</a>
                        <span>|</span>
                        <a data-tab="t-shirts">T-Shirts</a>
                        <span>|</span>
                        <a data-tab="pants">Pants</a>
                    </div>
                    <div id="inventory"></div>
                </div>
            </div>
            <div class="card" style="position:relative;">
                <div class="top blue">Wearing</div>
                <div class="content">
                    <div id="wearing"></div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', [
    'title' => 'Customize'
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/web/account/character.blade.php ENDPATH**/ ?>