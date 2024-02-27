<?php echo app('translator')->get('strings.emails.contact.email_body_title'); ?>

<?php echo app('translator')->get('validation.attributes.frontend.name'); ?>: <?php echo e($request->name); ?>

<?php echo app('translator')->get('validation.attributes.frontend.email'); ?>: <?php echo e($request->email); ?>

<?php echo app('translator')->get('validation.attributes.frontend.phone'); ?>: <?php echo e(($request->phone == "") ? "N/A" : $request->phone); ?>

<?php echo app('translator')->get('validation.attributes.frontend.message'); ?>: <?php echo e($request->message); ?>

<?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/frontend/mail/contact-text.blade.php ENDPATH**/ ?>