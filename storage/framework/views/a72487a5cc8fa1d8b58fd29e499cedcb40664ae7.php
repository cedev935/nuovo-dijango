<?php echo e(html()->form('PATCH', route('admin.account.post',$user->email))->class('form-horizontal')->open()); ?>


<?php if(!Route::is('admin.auth.user.change-password', $user) && Route::is('admin.account')): ?>
<div class="row">
        <div class="col">
            <div class="form-group">
                <?php echo e(html()->label(__('validation.attributes.frontend.old_password'))->for('old_password')); ?>


                <?php echo e(html()->password('old_password')
                    ->class('form-control')
                    ->placeholder(__('validation.attributes.frontend.old_password'))
                    ->autofocus()
                    ->required()); ?>

            </div><!--form-group-->
        </div><!--col-->
    </div><!--row-->
<?php endif; ?>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <?php echo e(html()->label(__('validation.attributes.frontend.new_password'))->for('password')); ?>


                <?php echo e(html()->password('password')
                    ->class('form-control')
                    ->placeholder(__('validation.attributes.frontend.new_password'))
                    ->required()); ?>

            </div><!--form-group-->
        </div><!--col-->
    </div><!--row-->

    <div class="row">
        <div class="col">
            <div class="form-group">
                <?php echo e(html()->label(__('validation.attributes.frontend.password_confirmation'))->for('password_confirmation')); ?>


                <?php echo e(html()->password('password_confirmation')
                    ->class('form-control')
                    ->placeholder(__('validation.attributes.frontend.password_confirmation'))
                    ->required()); ?>

            </div><!--form-group-->
        </div><!--col-->
    </div><!--row-->

    <div class="row">
        <div class="col">
            <div class="form-group mb-0 clearfix">
                <?php echo e(form_submit(__('labels.general.buttons.update') . ' ' . __('validation.attributes.frontend.password'))); ?>

            </div><!--form-group-->
        </div><!--col-->
    </div><!--row-->
<?php echo e(html()->form()->close()); ?>

<?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/account/tabs/change-password.blade.php ENDPATH**/ ?>