<a class="btn btn-xs mb-1 mr-1 btn-success text-white" style="cursor:pointer;"
   onclick="$(this).find('form').submit();">
    <?php echo e(trans('labels.backend.orders.complete')); ?>

    <form action="<?php echo e($route); ?>"
          method="POST" name="complete" style="display:none">
        <?php echo csrf_field(); ?>
    </form>
</a><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/datatable/action-complete-order.blade.php ENDPATH**/ ?>