<?php $__env->startSection('title', __('labels.backend.subscription.title').' | '.app_name()); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong><?php echo app('translator')->get('strings.backend.dashboard.welcome'); ?> <?php echo e($logged_in_user->name); ?>!</strong>
                </div><!--card-header-->
                <div class="card-body">
                    <div class="row">
                        <?php if(auth()->user()->subscription('default')): ?>
                        <?php if(!auth()->user()->subscription('default')->cancelled()): ?>
                        <div class="col-md-4 col-12">
                            <div class="card text-white bg-dark text-center py-3">
                                <div class="card-body">
                                    <h1 class="text-uppercase"><?php echo e($activePlan->name); ?></h1>
                                    <h3><?php echo app('translator')->get('labels.backend.subscription.active_plan'); ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="card text-white bg-dark text-center py-3">
                                <div class="card-body">
                                    <h1 class=""><?php echo e(trans_choice('labels.backend.subscription.quantity', $activePlan->bundle, ['quantity' => $activePlan->bundle])); ?></h1>
                                    <h3><?php echo app('translator')->get('labels.backend.subscription.bundle'); ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="card text-white bg-dark text-center py-3">
                                <div class="card-body">
                                    <h1 class=""><?php echo e(trans_choice('labels.backend.subscription.quantity', $activePlan->course, ['quantity' => $activePlan->course])); ?></h1>
                                    <h3><?php echo app('translator')->get('labels.backend.subscription.course'); ?></h3>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php if(auth()->user()->subscription('default')): ?>
                        <div class="col-md-12">
                            <div class="d-inline-block form-group w-100">
                                <h4 class="mb-0">
                                    <?php if(auth()->user()->subscription()->cancelled()): ?>
                                    <?php echo app('translator')->get('labels.backend.subscription.subscribe_plan'); ?>
                                    <a href="<?php echo e(route('subscription.plans')); ?>"
                                       class="btn btn-primary">
                                        <?php echo app('translator')->get('labels.backend.subscription.click_here'); ?>
                                    </a>
                                    <?php else: ?>
                                    <?php echo app('translator')->get('labels.backend.subscription.cancel_title'); ?>
                                    <a href="<?php echo e(route('admin.subscriptions.delete')); ?>"
                                       class="btn btn-primary">
                                        <?php echo app('translator')->get('labels.backend.subscription.click_here'); ?>
                                    </a>
                                    <?php endif; ?>
                                </h4>
                            </div>

                        </div>
                        <?php endif; ?>


                        <div class="col-md-12 col-12">
                            <div class="d-inline-block form-group w-100">
                                <h4 class="mb-0"><?php echo app('translator')->get('labels.backend.subscription.invoice_list'); ?> </h4>
                            </div>
                            <table class="table table-responsive-sm table-striped">
                                <thead>
                                <tr>
                                    <td><?php echo app('translator')->get('labels.backend.subscription.date'); ?></td>
                                    <td><?php echo app('translator')->get('labels.backend.subscription.sub_total'); ?></td>
                                    <td><?php echo app('translator')->get('labels.backend.subscription.total'); ?></td>
                                    <td><?php echo app('translator')->get('labels.backend.subscription.download'); ?></td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($invoice->date()->toFormattedDateString()); ?></td>
                                        <td><?php echo e($invoice->subtotal()); ?></td>
                                        <td><?php echo e($invoice->total()); ?></td>
                                        <td>
                                            <a href="<?php echo e(route('admin.subscriptions.download_invoice', ['invoice' => $invoice->id])); ?>"
                                                class="btn btn-primary">
                                                <?php echo app('translator')->get('labels.backend.subscription.download'); ?>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr><td colspan="4"> <h4> <?php echo app('translator')->get('labels.backend.subscription.no_invoice'); ?></h4></td></tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/subscription.blade.php ENDPATH**/ ?>