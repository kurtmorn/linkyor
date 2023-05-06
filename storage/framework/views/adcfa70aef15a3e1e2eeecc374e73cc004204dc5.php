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
        data-favorite="<?php echo e(route('shop.favorite')); ?>"
    >
    <meta
        name="item-info"
        data-id="<?php echo e($item->id); ?>"
        <?php if($item->isTimed()): ?>
            data-onsale-until="<?php echo e($item->onsale_until->format('Y-m-d H:i')); ?>"
        <?php endif; ?>
    >
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <?php if($item->isTimed()): ?>
        <script src="<?php echo e(asset('js/vendor/jquery.countdown.min.js')); ?>"></script>
        <script src="<?php echo e(asset('js/vendor/moment.min.js')); ?>"></script>
        <script src="<?php echo e(asset('js/vendor/moment.timezone.min.js')); ?>"></script>
    <?php endif; ?>

    <script src="<?php echo e(js_file('shop/item')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(!$item->public_view): ?>
        <div class="col-10-12 push-1-12">
            <div class="alert error">
                This item is not public.
            </div>
        </div>
    <?php endif; ?>
    <?php echo $__env->make('web.shop._header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="col-10-12 push-1-12 item-holder" id="items">
        <div class="card mb4">
            <div class="content item-page">
                <div class="col-5-12" style="padding-right:10px;">
                    <div class="box relative shaded item-img  <?php echo e((!$item->special_type && Auth::check() && Auth::user()->ownsItem($item->id)) ? 'owns' : ''); ?> <?php echo e(($item->special_type) ? 'special' : ''); ?>">
                        <img src="<?php echo e($item->thumbnail()); ?>" alt="<?php echo e($item->name); ?>">
                        <?php if(Auth::check() && Auth::user()->ownsItem($item->id)): ?>
                            <div class="owned-check-tri <?php echo e(($item->special_type) ? 'special' : 'owns'); ?>">
                                <i class="fas fa-check owned-check"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-7-12 item-data">
                    <div class="padding-bottom">
                        <div class="ellipsis">
                            <span class="medium-text bold ablack-text"><?php echo e($item->name); ?></span>
                            <span><?php echo e(itemType($item->type)); ?></span>
                        </div>
                        <div class="item-creator">By <a href="<?php echo e(route('users.profile', $item->creator->id)); ?>"><?php echo e($item->creator->username); ?></a></div>
                    </div>
                    <div class="item-purchase-buttons mt2 mb2">
                        <?php if($item->isTimed()): ?>
                            <span id="timer" style="display:block;padding-bottom:5px;color:red;"></span>
                        <?php endif; ?>

                        <?php if($item->special_type && $item->stock > 0): ?>
                            <span style="display:block;padding-bottom:5px;color:red;"><?php echo e($item->stock); ?> out of <?php echo e($item->owners()->count() + $item->stock); ?> remaining</span>
                        <?php endif; ?>

                        <?php if(site_setting('item_purchases_enabled') && $item->status == 'approved' && $item->onsale()): ?>
                            <?php if($item->price_bits == 0 && $item->price_bucks == 0): ?>
                                <button class="purchase free flat no-cap" data-modal-open="purchase_free">
                                    <span>FREE</span>
                                </button>
                                <div class="modal" style="display:none;" data-modal="purchase_free">
                                    <div class="modal-content">
                                        <span class="close" data-modal-close="purchase_free">×</span>
                                        <?php if(auth()->guard()->guest()): ?>
                                            <span>You are not logged in</span>
                                            <hr>
                                            <span>You must login to purchase an item</span>
                                            <div class="modal-buttons">
                                                <a href="<?php echo e(route('auth.login.index')); ?>" class="button bucks" style="margin-right:10px;">Login</a>
                                                <button class="cancel-button" type="button" data-modal-close="purchase_free">Cancel</button>
                                            </div>
                                        <?php else: ?>
                                            <?php if(Auth::user()->ownsItem($item->id)): ?>
                                                <span>You already own this item</span>
                                                <hr>
                                                <span>You can't purchase an item you already own</span>
                                                <div class="modal-buttons">
                                                    <button class="cancel-button" type="button" data-modal-close="purchase_free">Cancel</button>
                                                </div>
                                            <?php else: ?>
                                                <span>Buy Item</span>
                                                <hr>
                                                <span>Are you sure you want to buy <b><?php echo e($item->name); ?></b> for free?</span>
                                                <div class="modal-buttons">
                                                    <form action="<?php echo e(route('shop.purchase')); ?>" style="display:inline;" method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <input type="hidden" name="id" value="<?php echo e($item->id); ?>">
                                                        <input type="hidden" name="currency" value="free">
                                                        <button class="free" style="margin-right:10px;" type="submit">Buy Now</button>
                                                    </form>
                                                    <button type="button" class="cancel-button" data-modal-close="purchase_free">Cancel</button>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <?php if($item->price_bucks > 0): ?>
                                    <button class="purchase bucks flat no-cap" data-modal-open="purchase_bucks">
                                        <span class="bucks-icon img-white"></span>
                                        <span><?php echo e($item->price_bucks); ?> Bucks</span>
                                    </button>
                                    <div class="modal" style="display:none;" data-modal="purchase_bucks">
                                        <div class="modal-content">
                                            <span class="close" data-modal-close="purchase_bucks">×</span>
                                            <?php if(auth()->guard()->guest()): ?>
                                                <span>You are not logged in</span>
                                                <hr>
                                                <span>You must login to purchase an item</span>
                                                <div class="modal-buttons">
                                                    <a href="<?php echo e(route('auth.login.index')); ?>" class="button bucks" style="margin-right:10px;">Login</a>
                                                    <button class="cancel-button" type="button" data-modal-close="purchase_bucks">Cancel</button>
                                                </div>
                                            <?php else: ?>
                                                <?php if(Auth::user()->ownsItem($item->id)): ?>
                                                    <span>You already own this item</span>
                                                    <hr>
                                                    <span>You can't purchase an item you already own</span>
                                                    <div class="modal-buttons">
                                                        <button class="cancel-button" type="button" data-modal-close="purchase_bucks">Cancel</button>
                                                    </div>
                                                <?php else: ?>
                                                    <?php if(Auth::user()->currency_bucks < $item->price_bucks): ?>
                                                        <span>You do not have enough</span>
                                                        <hr>
                                                        <div style="text-align:center;padding-top:25px;padding-bottom:25px;">
                                                            <svg class="bucks-icon" style="transform:scale(5);padding:0px;margin-top:10px;"></svg>
                                                        </div>
                                                        <div class="modal-buttons">
                                                            <a href="<?php echo e(route('account.billing.index')); ?>" class="button bucks" style="margin-right:10px;">Buy More</a>
                                                            <button class="cancel-button" type="button" data-modal-close="purchase_bucks">Cancel</button>
                                                        </div>
                                                    <?php else: ?>
                                                        <span>Buy Item</span>
                                                        <hr>
                                                        <span>Are you sure you want to buy <b><?php echo e($item->name); ?></b> for <span class="bucks-icon" style="margin-left:2px;"></span> <?php echo e($item->price_bucks); ?>?</span>
                                                        <div class="modal-buttons">
                                                            <form action="<?php echo e(route('shop.purchase')); ?>" style="display:inline;" method="POST">
                                                                <?php echo csrf_field(); ?>
                                                                <input type="hidden" name="id" value="<?php echo e($item->id); ?>">
                                                                <input type="hidden" name="currency" value="bucks">
                                                                <button class="bucks" style="margin-right:10px;" type="submit">Buy Now</button>
                                                            </form>
                                                            <button type="button" class="cancel-button" data-modal-close="purchase_bucks">Cancel</button>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if($item->price_bits > 0): ?>
                                    <button class="purchase bits flat no-cap" data-modal-open="purchase_bits">
                                        <span class="bits-icon img-white"></span>
                                        <span><?php echo e($item->price_bits); ?> Bits</span>
                                    </button>
                                    <div class="modal" style="display:none;" data-modal="purchase_bits">
                                        <div class="modal-content">
                                            <span class="close" data-modal-close="purchase_bits">×</span>
                                            <?php if(auth()->guard()->guest()): ?>
                                                <span>You are not logged in</span>
                                                <hr>
                                                <span>You must login to purchase an item</span>
                                                <div class="modal-buttons">
                                                    <a href="<?php echo e(route('auth.login.index')); ?>" class="button bucks" style="margin-right:10px;">Login</a>
                                                    <button class="cancel-button" type="button" data-modal-close="purchase_bits">Cancel</button>
                                                </div>
                                            <?php else: ?>
                                                <?php if(Auth::user()->ownsItem($item->id)): ?>
                                                    <span>You already own this item</span>
                                                    <hr>
                                                    <span>You can't purchase an item you already own</span>
                                                    <div class="modal-buttons">
                                                        <button class="cancel-button" type="button" data-modal-close="purchase_bits">Cancel</button>
                                                    </div>
                                                <?php else: ?>
                                                    <?php if(Auth::user()->currency_bits < $item->price_bits): ?>
                                                        <span>You do not have enough</span>
                                                        <hr>
                                                        <div style="text-align:center;padding-top:25px;padding-bottom:25px;">
                                                            <svg class="bits-icon" style="transform:scale(5);padding:0px;margin-top:10px;"></svg>
                                                        </div>
                                                        <div class="modal-buttons">
                                                            <a href="<?php echo e(route('account.billing.index')); ?>" class="button bucks" style="margin-right:10px;">Buy More</a>
                                                            <button class="cancel-button" type="button" data-modal-close="purchase_bits">Cancel</button>
                                                        </div>
                                                    <?php else: ?>
                                                        <span>Buy Item</span>
                                                        <hr>
                                                        <span>Are you sure you want to buy <b><?php echo e($item->name); ?></b> for <span class="bits-icon" style="margin-left:2px;"></span> <?php echo e($item->price_bits); ?>?</span>
                                                        <div class="modal-buttons">
                                                            <form action="<?php echo e(route('shop.purchase')); ?>" style="display:inline;" method="POST">
                                                                <?php echo csrf_field(); ?>
                                                                <input type="hidden" name="id" value="<?php echo e($item->id); ?>">
                                                                <input type="hidden" name="currency" value="bits">
                                                                <button class="bits" style="margin-right:10px;" type="submit">Buy Now</button>
                                                            </form>
                                                            <button type="button" class="cancel-button" data-modal-close="purchase_bits">Cancel</button>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if(auth()->guard()->check()): ?>
                            <?php if($item->creator->id == Auth::user()->id && in_array($item->type, ['tshirt', 'shirt', 'pants'])): ?>
                                <a href="<?php echo e(route('shop.edit', $item->id)); ?>" class="button purchase green flat no-cap">EDIT</a>
                            <?php endif; ?>

                            <?php if(Auth::user()->isStaff()): ?>
                                <?php if(Auth::user()->staff('can_edit_item_info') && !in_array($item->type, ['tshirt', 'shirt', 'pants'])): ?>
                                    <a href="<?php echo e(route('admin.edit_item.index', $item->id)); ?>" class="button purchase red flat no-cap" target="_blank">EDIT</a>
                                <?php endif; ?>

                                <?php if(Auth::user()->staff('can_view_item_info')): ?>
                                    <a href="<?php echo e(route('admin.items.view', $item->id)); ?>" class="button purchase red flat no-cap" target="_blank">INFO</a>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <div class="agray-text bold"><?php echo nl2br(e($item->description)); ?></div>
                    <div class="padding-30"></div>
                    <div class="small-text mt6 mb2">
                        <div class="item-stats">
                            <span class="agray-text">Created:</span>
                            <span class="darkest-gray-text" title="<?php echo e($item->created_at->format('D, M d Y h:i A')); ?>"><?php echo e($item->created_at->format('Y/m/d')); ?></span>
                        </div>
                        <div class="item-stats">
                            <span class="agray-text">Updated:</span>
                            <span class="darkest-gray-text" title="<?php echo e($item->updated_at->format('D, M d Y h:i A')); ?>"><?php echo e($item->updated_at->diffForHumans()); ?></span>
                        </div>
                        <div class="item-stats">
                            <span class="agray-text">Sold:</span>
                            <span class="darkest-gray-text"><?php echo e($item->owners()->count()); ?></span>
                        </div>
                    </div>
                    <span class="hover-cursor favorite-text" id="favorite">
                        <i class="<?php echo e((Auth::check() && Auth::user()->hasFavoritedItem($item->id)) ? 'fas' : 'far'); ?> fa-star" <?php echo (Auth::check()) ? 'id="favoriteIcon"' : ''; ?>></i>
                        <span style="font-size: 0.9rem;" id="favoriteCount"><?php echo e($item->favorites()->count()); ?></span>
                    </span>
                    <?php if(Auth::check() && $item->creator->id != Auth::user()->id && !$item->creator->isStaff()): ?>
                        <a href="<?php echo e(route('report.index', ['item', $item->id])); ?>" class="red-text" style="margin-left:15px;">
                            <i class="far fa-flag"></i>
                            <span style="font-size: 0.9rem;">Report</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if($item->special_type && $item->stock <= 0): ?>
            <div class="card" style="margin-bottom:20px;">
                <div class="content item-page">
                    <span class="item-name" style="font-size:1.1rem;">Private Sellers</span>
                    <?php if(Auth::check() && Auth::user()->ownsItem($item->id) && !empty(Auth::user()->resellableCopiesOfItem($item->id))): ?>
                        <a class="button small blue" style="float:right;margin-top:-5px;" data-modal-open="sell">SELL</a>
                        <div class="modal" style="display:none;" data-modal="sell">
                            <div class="modal-content">
                                <form action="<?php echo e(route('shop.resell')); ?>" style="display:inline;" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <span class="close" data-modal-close="sell">×</span>
                                    <span>Sell <?php echo e($item->name); ?></span>
                                    <hr>
                                    <select class="select" style="width:100%;" name="id">
                                        <?php $__currentLoopData = Auth::user()->resellableCopiesOfItem($item->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $copy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($copy->id); ?>">#<?php echo e($copy->serial); ?> of <?php echo e($item->owners()->count() + $item->stock); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div style="width:100%;padding-top:15px;">
                                        <span style="color:#7f817f;">Price (min 1)</span>
                                        <input style="width:100%;box-sizing:border-box;" type="number" name="price" min="1" max="1000000">
                                    </div>
                                    <div class="modal-buttons">
                                        <button class="bucks" style="margin-right:10px;" type="submit">Sell Now</button>
                                        <button type="button" class="cancel-button" data-modal-close="sell">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                    <hr>
                    <div class="sellers">
                        <?php $__empty_1 = true; $__currentLoopData = $item->resellers(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $listing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="seller">
                                <div class="owner">
                                    <a href="<?php echo e(route('users.profile', $listing->seller->id)); ?>">
                                        <img src="<?php echo e($listing->seller->thumbnail()); ?>">
                                        <br>
                                        <span class="dark-gray-text"><?php echo e($listing->seller->username); ?></span>
                                    </a>
                                </div>
                                <div class="price">
                                    <div class="push-right">
                                        <div class="serial">#<?php echo e($listing->inventory->serial()); ?> of <?php echo e($item->owners()->count() + $item->stock); ?></div>
                                        <?php if(!Auth::check() || (Auth::check() && $listing->seller->id != Auth::user()->id)): ?>
                                            <a class="button bucks small flat" data-modal-open="purchase_<?php echo e($listing->id); ?>">Buy for <span class="bucks-icon img-white"></span> <?php echo e($listing->price); ?></a>
                                        <?php else: ?>
                                            <form action="<?php echo e(route('shop.take_off_sale')); ?>" method="POST" style="display:inline;">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="id" value="<?php echo e($listing->id); ?>">
                                                <button class="small flat" style="background:#999;" type="submit">TAKE OFFSALE (<span class="bucks-icon img-white"></span> <?php echo e($listing->price); ?>)</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="modal" style="display:none;" data-modal="purchase_<?php echo e($listing->id); ?>">
                                <div class="modal-content">
                                    <span class="close" data-modal-close="purchase_<?php echo e($listing->id); ?>">×</span>
                                    <?php if(auth()->guard()->guest()): ?>
                                        <span>You are not logged in</span>
                                        <hr>
                                        <span>You must login to purchase an item</span>
                                        <div class="modal-buttons">
                                            <a href="<?php echo e(route('auth.login.index')); ?>" class="button bucks" style="margin-right:10px;">Login</a>
                                            <button class="cancel-button" type="button" data-modal-close="purchase_<?php echo e($listing->id); ?>">Cancel</button>
                                        </div>
                                    <?php else: ?>
                                        <?php if(Auth::user()->currency_bucks < $listing->price): ?>
                                            <span>You do not have enough</span>
                                            <hr>
                                            <div style="text-align:center;padding-top:25px;padding-bottom:25px;">
                                                <svg class="bucks-icon" style="transform:scale(5);padding:0px;margin-top:10px;"></svg>
                                            </div>
                                            <div class="modal-buttons">
                                                <a href="<?php echo e(route('account.billing.index')); ?>" class="button bucks" style="margin-right:10px;">Buy More</a>
                                                <button class="cancel-button" type="button" data-modal-close="purchase_<?php echo e($listing->id); ?>">Cancel</button>
                                            </div>
                                        <?php else: ?>
                                            <span>Buy Item</span>
                                            <hr>
                                            <span>Are you sure you want to buy <b><?php echo e($item->name); ?></b> for <span class="bucks-icon" style="margin-left:2px;"></span> <?php echo e($listing->price); ?>?</span>
                                            <div class="modal-buttons">
                                                <form action="<?php echo e(route('shop.purchase')); ?>" style="display:inline;" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="id" value="<?php echo e($item->id); ?>">
                                                    <input type="hidden" name="currency" value="bucks">
                                                    <input type="hidden" name="reseller_id" value="<?php echo e($listing->id); ?>">
                                                    <button class="bucks" style="margin-right:10px;" type="submit">Buy Now</button>
                                                </form>
                                                <button type="button" class="cancel-button" data-modal-close="purchase_<?php echo e($listing->id); ?>">Cancel</button>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <span>No one is currently selling this item.</span>
                        <?php endif; ?>
                    </div>
                    <div class="pages"><?php echo e($item->resellers()->onEachSide(1)); ?></div>
                </div>
            </div>
        <?php endif; ?>
        <div class="tabs">
            <div class="tab col-1-2 active" data-tab="comments">Comments</div>
            <div class="tab col-1-2" data-tab="recommended">Recommended</div>
            <div class="tab-holder">
                <div class="tab-body active" data-tab-section="comments">
                    <div class="comments-holder">
                        <form action="<?php echo e(route('shop.comment')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="id" value="<?php echo e($item->id); ?>">
                            <span class="smedium-text bold">Comment</span>
                            <textarea class="width-100 mb2" style="height:80px;" name="comment" placeholder="Enter Comment"></textarea>
                            <button class="blue" type="submit">Post</button>
                        </form>
                        <hr>
                        <div id="comments"></div>
                    </div>
                </div>
                <div class="tab-body" data-tab-section="recommended">
                    <div id="recommendations"></div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', [
    'title' => $item->name,
    'image' => $item->thumbnail()
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/web/shop/item.blade.php ENDPATH**/ ?>