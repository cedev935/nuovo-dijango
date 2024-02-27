<?php $__env->startComponent('mail::message'); ?>
#Hello <?php echo e(auth()->user()->name); ?>


We have successfully received your request for following:<br>
Order Reference No. <?php echo e($content['reference_no']); ?>

<?php $__currentLoopData = $content['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
#<?php echo e($item['number']); ?>. <?php echo e($item['name']); ?> <?php echo e($appCurrency['symbol'].$item['price']); ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

#Total Amount : <?php echo e($appCurrency['symbol']); ?> <?php echo e($content['total']); ?>


Our representatives will contact you soon regarding order payments.
Happy Shopping.


Thanks,<br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/emails/offlineOrderMail.blade.php ENDPATH**/ ?>