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
    <div class="col-10-12 push-1-12">
        <div class="tabs">
            <a href="<?php echo e(route('account.currency.index', '')); ?>" class="tab <?php if($category == 'exchange'): ?> active <?php endif; ?> col-4-12">Exchange</a>
            <a href="<?php echo e(route('account.currency.index', 'purchases')); ?>" class="tab <?php if($category == 'purchases'): ?> active <?php endif; ?> col-4-12">Purchases</a>
            <a href="<?php echo e(route('account.currency.index', 'sales')); ?>" class="tab <?php if($category == 'sales'): ?> active <?php endif; ?> col-4-12">Sales</a>
            <div class="tab-holder" style="box-shadow:none;">
                <div class="tab-body active">
                    <div class="content">
                        <?php if(!$transactions): ?>
                            <form action="<?php echo e(route('account.currency.convert')); ?>" method="POST" style="text-align:center;">
                                <?php echo csrf_field(); ?>
                                <div class="block">
                                    <select name="type" class="select mb2">
                                        <option value="to-bits">To bits</option>
                                        <option value="to-bucks">To bucks</option>
                                    </select>
                                    <input type="number" style="margin-bottom:10px;" name="amount" placeholder="0" min="0">
                                </div>
                                <button class="blue smaller-text" type="submit">CONVERT</button>
                            </form>
                        <?php else: ?>
                            <?php if($transactions->count() == 0): ?>
                                <div style="text-align:center;padding:10px;">
                                    <span>You don't have any transactions!</span>
                                </div>
                            <?php else: ?>
                                <table style="width: 100%;">
                                    <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <th class="col-2-12" style="text-align:left;float:none;">
                                                <span class="agray-text block"><?php echo e($transaction->created_at->format('d/m/Y')); ?></span>
                                            </th>
                                            <th class="ellipsis col-4-12" style="text-align:left;float:none;">
                                                <a href="<?php echo e(route('users.profile', ($category == 'purchases') ? $transaction->seller->id : $transaction->buyer->id)); ?>" class="agray-text ellipsis">
                                                    <img src="<?php echo e(($category == 'purchases') ? $transaction->seller->thumbnail() : $transaction->buyer->thumbnail()); ?>" style="width:64px;">
                                                    <div><?php echo e(($category == 'purchases') ? $transaction->seller->username : $transaction->buyer->username); ?></div>
                                                </a>
                                            </th>
                                            <th class="col-4-12" style="text-align:left;float:none;">
                                                <a href="<?php echo e(route('shop.item', $transaction->item->id)); ?>" class="agray-text">
                                                    <img src="<?php echo e($transaction->item->thumbnail()); ?>" alt="<?php echo e($transaction->item->name); ?>" style="height:56px;">
                                                    <div><?php echo e($transaction->item->name); ?></div>
                                                </a>
                                            </th>
                                            <th class="col-2-12" style="text-align:left;float:none;">
                                                <?php if($transaction->currency_used == 'free'): ?>
                                                    <span style="color:#6fb6db;">FREE</span>
                                                <?php else: ?>
                                                    <span class="<?php echo e($transaction->currency_used); ?>-text"><?php echo e(number_format($transaction->price)); ?> <span class="<?php echo e($transaction->currency_used); ?>-icon"></span></span>
                                                <?php endif; ?>
                                            </th>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </table>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if($transactions): ?>
        <div class="col-10-12 push-1-12">
            <div class="pages"><?php echo e($transactions->onEachSide(1)); ?></div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', [
    'title' => 'Currency'
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/web/account/currency.blade.php ENDPATH**/ ?>