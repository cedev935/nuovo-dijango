
<?php echo e(html()->modelForm($user, 'PATCH', route('admin.profile.update'))->class('form-horizontal')->attribute('enctype', 'multipart/form-data')->open()); ?>

<div class="row">
    <div class="col">
        <div class="form-group">
            <?php echo e(html()->label(__('validation.attributes.frontend.avatar'))->for('avatar')); ?>


            <div>
                <input type="radio" name="avatar_type"
                       value="gravatar" <?php echo e($user->avatar_type == 'gravatar' ? 'checked' : ''); ?> /> <?php echo e(__('validation.attributes.frontend.gravatar')); ?>

                &nbsp;&nbsp;
                <input type="radio" name="avatar_type"
                       value="storage" <?php echo e($user->avatar_type == 'storage' ? 'checked' : ''); ?> /> <?php echo e(__('validation.attributes.frontend.upload')); ?>


                <?php $__currentLoopData = $user->providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(strlen($provider->avatar)): ?>
                        <input type="radio" name="avatar_type"
                               value="<?php echo e($provider->provider); ?>" <?php echo e($logged_in_user->avatar_type == $provider->provider ? 'checked' : ''); ?> /> <?php echo e(ucfirst($provider->provider)); ?>

                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div><!--form-group-->

        <div class="form-group hidden" id="avatar_location">
            <?php echo e(html()->file('avatar_location')->class('form-control')); ?>

        </div><!--form-group-->

    </div><!--col-->
</div><!--row-->

<div class="row">
    <div class="col">
        <div class="form-group">
            <?php echo e(html()->label(__('validation.attributes.frontend.first_name'))->for('first_name')); ?>


            <?php echo e(html()->text('first_name')
                ->class('form-control')
                ->placeholder(__('validation.attributes.frontend.first_name'))
                ->attribute('maxlength', 191)
                ->required()
                ->autofocus()); ?>

        </div><!--form-group-->
    </div><!--col-->
</div><!--row-->

<div class="row">
    <div class="col">
        <div class="form-group">
            <?php echo e(html()->label(__('validation.attributes.frontend.last_name'))->for('last_name')); ?>


            <?php echo e(html()->text('last_name')
                ->class('form-control')
                ->placeholder(__('validation.attributes.frontend.last_name'))
                ->attribute('maxlength', 191)
                ->required()); ?>

        </div><!--form-group-->
    </div><!--col-->
</div><!--row-->
<?php if($logged_in_user->hasRole('teacher')): ?>
    <?php
        $teacherProfile = $logged_in_user->teacherProfile?:'';
        $payment_details = $logged_in_user->teacherProfile?json_decode($logged_in_user->teacherProfile->payment_details):optional();
    ?>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <?php echo e(html()->label(__('labels.backend.general_settings.user_registration_settings.fields.gender'))->for('gender')); ?>

                <div class="">
                    <label class="radio-inline mr-3 mb-0">
                        <input type="radio" name="gender" value="male" <?php echo e($logged_in_user->gender == 'male'?'checked':''); ?>> <?php echo e(__('validation.attributes.frontend.male')); ?>

                    </label>
                    <label class="radio-inline mr-3 mb-0">
                        <input type="radio" name="gender" value="female" <?php echo e($logged_in_user->gender == 'female'?'checked':''); ?>> <?php echo e(__('validation.attributes.frontend.female')); ?>

                    </label>
                    <label class="radio-inline mr-3 mb-0">
                        <input type="radio" name="gender" value="other" <?php echo e($logged_in_user->gender == 'other'?'checked':''); ?>> <?php echo e(__('validation.attributes.frontend.other')); ?>

                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <?php echo e(html()->label(__('labels.teacher.facebook_link'))->for('facebook_link')); ?>


                <?php echo e(html()->text('facebook_link')
                    ->class('form-control')
                    ->value($teacherProfile->facebook_link)
                    ->placeholder(__('labels.teacher.facebook_link'))); ?>

            </div><!--form-group-->
        </div><!--col-->
    </div><!--row-->

    <div class="row">
        <div class="col">
            <div class="form-group">
                <?php echo e(html()->label(__('labels.teacher.twitter_link'))->for('twitter_link')); ?>


                <?php echo e(html()->text('twitter_link')
                    ->class('form-control')
                    ->value($teacherProfile->twitter_link)
                    ->placeholder(__('labels.teacher.twitter_link'))); ?>

            </div><!--form-group-->
        </div><!--col-->
    </div><!--row-->

    <div class="row">
        <div class="col">
            <div class="form-group">
                <?php echo e(html()->label(__('labels.teacher.twitter_link'))->for('linkedin_link')); ?>


                <?php echo e(html()->text('linkedin_link')
                    ->class('form-control')
                    ->value($teacherProfile->linkedin_link)
                    ->placeholder(__('labels.teacher.linkedin_link'))); ?>

            </div><!--form-group-->
        </div><!--col-->
    </div><!--row-->

    <div class="row">
        <div class="col">
            <div class="form-group">
                <?php echo e(html()->label(__('labels.teacher.payment_details'))->for('payment_details')); ?>

                <select class="form-control" name="payment_method" id="payment_method" required>
                    <option value="bank" <?php echo e($teacherProfile->payment_method == 'bank'?'selected':''); ?>><?php echo e(trans('labels.teacher.bank')); ?></option>
                    <option value="paypal" <?php echo e($teacherProfile->payment_method == 'paypal'?'selected':''); ?>><?php echo e(trans('labels.teacher.paypal')); ?></option>
                </select>
            </div><!--form-group-->
        </div><!--col-->
    </div><!--row-->
    <div class="bank_details" style="display:<?php echo e($logged_in_user->teacherProfile->payment_method == 'bank'?'':'none'); ?>">

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <?php echo e(html()->label(__('labels.teacher.bank_details.name'))->for('bank_name')); ?>


                    <?php echo e(html()->text('bank_name')
                        ->class('form-control')
                        ->value($payment_details?$payment_details->bank_name:'')
                        ->placeholder(__('labels.teacher.bank_details.name'))); ?>

                </div><!--form-group-->
            </div><!--col-->
        </div><!--row-->

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <?php echo e(html()->label(__('labels.teacher.bank_details.bank_code'))->for('ifsc_code')); ?>


                    <?php echo e(html()->text('ifsc_code')
                        ->class('form-control')
                        ->value($payment_details?$payment_details->ifsc_code:'')
                        ->placeholder(__('labels.teacher.bank_details.bank_code'))); ?>

                </div><!--form-group-->
            </div><!--col-->
        </div><!--row-->

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <?php echo e(html()->label(__('labels.teacher.bank_details.account'))->for('account_number')); ?>


                    <?php echo e(html()->text('account_number')
                        ->class('form-control')
                        ->value($payment_details?$payment_details->account_number:'')
                        ->placeholder(__('labels.teacher.bank_details.account'))); ?>

                </div><!--form-group-->
            </div><!--col-->
        </div><!--row-->

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <?php echo e(html()->label(__('labels.teacher.bank_details.holder_name'))->for('account_name')); ?>


                    <?php echo e(html()->text('account_name')
                        ->class('form-control')
                        ->value($payment_details?$payment_details->account_name:'')
                        ->placeholder(__('labels.teacher.bank_details.holder_name'))); ?>

                </div><!--form-group-->
            </div><!--col-->
        </div><!--row-->

    </div>

    <div class="paypal_details" style="display:<?php echo e($logged_in_user->teacherProfile->payment_method == 'paypal'?'':'none'); ?>">

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <?php echo e(html()->label(__('labels.teacher.paypal_email'))->for('paypal_email')); ?>


                    <?php echo e(html()->text('paypal_email')
                        ->class('form-control')
                        ->value($payment_details?$payment_details->paypal_email:'')
                        ->placeholder(__('labels.teacher.paypal_email'))); ?>

                </div><!--form-group-->
            </div><!--col-->
        </div><!--row-->

    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <?php echo e(html()->label(__('labels.teacher.description'))->for('description')); ?>


                <?php echo e(html()->textarea('description')
                    ->class('form-control')
                    ->value($teacherProfile->description)
                    ->placeholder(__('labels.teacher.description'))); ?>

            </div><!--form-group-->
        </div><!--col-->
    </div><!--row-->

<?php endif; ?>
<?php if($logged_in_user->canChangeEmail()): ?>
    <div class="row">
        <div class="col">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> <?php echo app('translator')->get('strings.frontend.user.change_email_notice'); ?>
            </div>

            <div class="form-group">
                <?php echo e(html()->label(__('validation.attributes.frontend.email'))->for('email')); ?>


                <?php echo e(html()->email('email')
                    ->class('form-control')
                    ->placeholder(__('validation.attributes.frontend.email'))
                    ->attribute('maxlength', 191)
                    ->required()); ?>

            </div><!--form-group-->
        </div><!--col-->
    </div><!--row-->
<?php endif; ?>
<?php if(config('registration_fields') != NULL): ?>
    <?php
        $fields = json_decode(config('registration_fields'));
        $inputs = ['text','number','date'];
    ?>


    <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <?php if(in_array($item->type,$inputs)): ?>
                        <?php echo e(html()->label(__('labels.backend.general_settings.user_registration_settings.fields.'.$item->name))->for('last_name')); ?>


                        <input type="<?php echo e($item->type); ?>" class="form-control mb-0" value="<?php echo e($logged_in_user[$item->name]); ?>"
                               name="<?php echo e($item->name); ?>"
                               placeholder="<?php echo e(__('labels.backend.general_settings.user_registration_settings.fields.'.$item->name)); ?>">
                    <?php elseif($item->type == 'gender'): ?>
                        <label class="radio-inline mr-3 mb-0">
                            <input type="radio" <?php if($logged_in_user[$item->name] == 'male'): ?> checked
                                   <?php endif; ?> name="<?php echo e($item->name); ?>"
                                   value="male"> <?php echo e(__('validation.attributes.frontend.male')); ?>

                        </label>
                        <label class="radio-inline mr-3 mb-0">
                            <input type="radio" <?php if($logged_in_user[$item->name] == 'female'): ?> checked
                                   <?php endif; ?>  name="<?php echo e($item->name); ?>"
                                   value="female"> <?php echo e(__('validation.attributes.frontend.female')); ?>

                        </label>
                        <label class="radio-inline mr-3 mb-0">
                            <input type="radio" <?php if($logged_in_user[$item->name] == 'other'): ?> checked
                                   <?php endif; ?>  name="<?php echo e($item->name); ?>"
                                   value="other"> <?php echo e(__('validation.attributes.frontend.other')); ?>

                        </label>
                    <?php elseif($item->type == 'textarea'): ?>
                        <textarea name="<?php echo e($item->name); ?>"
                                  placeholder="<?php echo e(__('labels.backend.general_settings.user_registration_settings.fields.'.$item->name)); ?>"
                                  class="form-control mb-0"><?php echo e($logged_in_user[$item->name]); ?></textarea>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php endif; ?>
<div class="row">
    <div class="col">
        <div class="form-group mb-0 clearfix">
            <?php echo e(form_submit(__('labels.general.buttons.update'))); ?>

        </div><!--form-group-->
    </div><!--col-->
</div><!--row-->
<?php echo e(html()->closeModelForm()); ?>


<?php $__env->startPush('after-scripts'); ?>
    <script>
        $(function () {
            var avatar_location = $("#avatar_location");

            if ($('input[name=avatar_type]:checked').val() === 'storage') {
                avatar_location.show();
            } else {
                avatar_location.hide();
            }

            $('input[name=avatar_type]').change(function () {
                if ($(this).val() === 'storage') {
                    avatar_location.show();
                } else {
                    avatar_location.hide();
                }
            });
        });
        $(document).on('change', '#payment_method', function(){
            if($(this).val() === 'bank'){
                $('.paypal_details').hide();
                $('.bank_details').show();
            }else{
                $('.paypal_details').show();
                $('.bank_details').hide();
            }
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/account/tabs/edit.blade.php ENDPATH**/ ?>