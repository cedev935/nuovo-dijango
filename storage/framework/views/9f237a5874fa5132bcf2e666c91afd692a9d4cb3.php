<div class="table-responsive">
    <table class="table table-striped table-hover table-bordered">
        <tr>
            <th><?php echo app('translator')->get('labels.frontend.user.profile.avatar'); ?></th>
            <td><img src="<?php echo e($user->picture); ?>" height="100px" class="user-profile-image" /></td>
        </tr>
        <tr>
            <th><?php echo app('translator')->get('labels.frontend.user.profile.name'); ?></th>
            <td><?php echo e($user->name); ?></td>
        </tr>
        <tr>
            <th><?php echo app('translator')->get('labels.frontend.user.profile.email'); ?></th>
            <td><?php echo e($user->email); ?></td>
        </tr>
        <?php if($logged_in_user->hasRole('teacher')): ?>
            <tr>
                <th><?php echo app('translator')->get('labels.backend.access.users.tabs.content.overview.status'); ?></th>
                <td><?php echo $logged_in_user->status_label; ?></td>
            </tr>
            <tr>
                <th><?php echo app('translator')->get('labels.backend.general_settings.user_registration_settings.fields.gender'); ?></th>
                <td><?php echo $logged_in_user->gender; ?></td>
            </tr>
            <?php
                $teacherProfile = $logged_in_user->teacherProfile?:'';
                $payment_details = $logged_in_user->teacherProfile?json_decode($logged_in_user->teacherProfile->payment_details):new stdClass();
            ?>
            <tr>
                <th><?php echo app('translator')->get('labels.teacher.facebook_link'); ?></th>
                <td><?php echo $teacherProfile->facebook_link; ?></td>
            </tr>
            <tr>
                <th><?php echo app('translator')->get('labels.teacher.twitter_link'); ?></th>
                <td><?php echo $teacherProfile->twitter_link; ?></td>
            </tr>
            <tr>
                <th><?php echo app('translator')->get('labels.teacher.linkedin_link'); ?></th>
                <td><?php echo $teacherProfile->linkedin_link; ?></td>
            </tr>
            <tr>
                <th><?php echo app('translator')->get('labels.teacher.payment_details'); ?></th>
                <td><?php echo $teacherProfile->payment_method; ?></td>
            </tr>
            <?php if($payment_details): ?>
                <?php if($teacherProfile->payment_method == 'bank'): ?>
                <tr>
                    <th><?php echo app('translator')->get('labels.teacher.bank_details.name'); ?></th>
                    <td><?php echo $payment_details->bank_name; ?></td>
                </tr>
                <tr>
                    <th><?php echo app('translator')->get('labels.teacher.bank_details.bank_code'); ?></th>
                    <td><?php echo $payment_details->ifsc_code; ?></td>
                </tr>
                <tr>
                    <th><?php echo app('translator')->get('labels.teacher.bank_details.account'); ?></th>
                    <td><?php echo $payment_details->account_number; ?></td>
                </tr>
                <tr>
                    <th><?php echo app('translator')->get('labels.teacher.bank_details.holder_name'); ?></th>
                    <td><?php echo $payment_details->account_name; ?></td>
                </tr>
                <?php else: ?>
                <tr>
                    <th><?php echo app('translator')->get('labels.teacher.paypal_email'); ?></th>
                    <td><?php echo $payment_details->paypal_email; ?></td>
                </tr>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>

        <tr>
            <th><?php echo app('translator')->get('labels.frontend.user.profile.created_at'); ?></th>
            <td><?php echo e(timezone()->convertToLocal($user->created_at)); ?> (<?php echo e($user->created_at->diffForHumans()); ?>)</td>
        </tr>
        <tr>
            <th><?php echo app('translator')->get('labels.frontend.user.profile.last_updated'); ?></th>
            <td><?php echo e(timezone()->convertToLocal($user->updated_at)); ?> (<?php echo e($user->updated_at->diffForHumans()); ?>)</td>
        </tr>
        <?php if(config('registration_fields') != NULL): ?>
            <?php
                $fields = json_decode(config('registration_fields'));
            ?>
            <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <th><?php echo e(__('labels.backend.general_settings.user_registration_settings.fields.'.$item->name)); ?></th>
                    <td><?php echo e($user[$item->name]); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </table>
</div>
<?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/account/tabs/profile.blade.php ENDPATH**/ ?>