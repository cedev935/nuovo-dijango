<?php $__env->startSection('title', __('labels.backend.coupons.title').' | '.app_name()); ?>

<?php $__env->startSection('content'); ?>

    <div class="card">

        <div class="card-header">
            <h3 class="page-title mb-0 float-left"><?php echo app('translator')->get('labels.backend.coupons.title'); ?></h3>
            <div class="float-right">
                <a href="<?php echo e(route('admin.coupons.index')); ?>"
                   class="btn btn-success"><?php echo app('translator')->get('labels.backend.coupons.view'); ?></a>

            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered table-striped">
                       <tr>
                           <th width="20%"><?php echo app('translator')->get('labels.backend.coupons.fields.name'); ?></th>
                           <td>
                             <?php echo e($coupon->name); ?>

                           </td>
                       </tr>
                        <tr>
                            <th width="20%"><?php echo app('translator')->get('labels.backend.coupons.fields.description'); ?></th>
                            <td>
                                <?php echo e($coupon->description); ?>

                            </td>
                        </tr>
                        <tr>
                            <th><?php echo app('translator')->get('labels.backend.coupons.fields.code'); ?></th>
                            <td>
                                <?php echo e($coupon->code); ?>

                            </td>
                        </tr>

                        <tr>
                            <th><?php echo app('translator')->get('labels.backend.coupons.fields.type'); ?></th>
                            <td>
                                <?php if($coupon->type == 1): ?>
                                    <?php echo app('translator')->get('labels.backend.coupons.discount_rate'); ?> (in %)
                                <?php else: ?>
                                    <?php echo app('translator')->get('labels.backend.coupons.flat_rate'); ?> ( in <?php echo e(config('app.currency')); ?>)
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th><?php echo app('translator')->get('labels.backend.coupons.fields.amount'); ?></th>
                            <td><?php echo e($coupon->amount); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo app('translator')->get('labels.backend.coupons.fields.expires_at'); ?></th>
                            <td>
                                <?php if($coupon->expires_at): ?>
                                    <?php echo e(\Illuminate\Support\Carbon::parse($coupon->expires_at)->format('d M Y')); ?>

                                <?php else: ?>
                                    <?php echo app('translator')->get('labels.backend.coupons.unlimited'); ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th><?php echo app('translator')->get('labels.backend.coupons.fields.status'); ?></th>
                            <td>
                                <?php if($coupon->status == 1): ?>
                                    <?php echo app('translator')->get('labels.backend.coupons.on'); ?>
                                <?php else: ?>
                                    <?php echo app('translator')->get('labels.backend.coupons.off'); ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th><?php echo app('translator')->get('labels.backend.coupons.fields.min_price'); ?></th>
                            <td>
                                <?php echo e($coupon->min_price); ?>

                            </td>
                        </tr>
                        <tr>
                            <th><?php echo app('translator')->get('labels.backend.coupons.fields.per_user_limit'); ?></th>
                            <td>
                                <?php echo e($coupon->per_user_limit); ?>

                            </td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->

            <a href="<?php echo e(route('admin.coupons.index')); ?>" class="btn btn-default border"><?php echo app('translator')->get('strings.backend.general.app_back_to_list'); ?></a>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/coupons/show.blade.php ENDPATH**/ ?>