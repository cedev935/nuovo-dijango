
<?php if(isset($allow_delete) && ($allow_delete == false)): ?>


<a href="#"  class="btn btn-xs btn-danger delete_warning text-white mb-1" style="cursor:pointer;">
    <i class="fa fa-trash"
       data-toggle="tooltip"
       data-placement="top" title=""
       data-original-title="Warning"></i>
</a>
<?php else: ?>

    <?php if(isset($class)): ?>
        <a data-method="delete" data-trans-button-cancel="<?php echo e(__('buttons.general.cancel')); ?>"
           data-trans-button-confirm="<?php echo e(__('buttons.general.crud.delete')); ?>" data-trans-title="<?php echo e(__('strings.backend.general.are_you_sure')); ?>"
           class="<?php echo e($class); ?>" style="cursor:pointer;"
           onclick="$(this).find('form').submit();">
            <?php echo e(__('buttons.general.crud.delete')); ?>

            <form action="<?php echo e($route); ?>"
                  method="POST" name="delete_item" style="display:none">
                <?php echo csrf_field(); ?>
                <?php echo e(method_field('DELETE')); ?>

            </form>
        </a>
    <?php else: ?>
        <a data-method="delete" data-trans-button-cancel="<?php echo e(__('buttons.general.cancel')); ?>"
           data-trans-button-confirm="<?php echo e(__('buttons.general.crud.delete')); ?>" data-trans-title="<?php echo e(__('strings.backend.general.are_you_sure')); ?>"
           class="btn btn-xs btn-danger text-white mb-1" style="cursor:pointer;"
           onclick="$(this).find('form').submit();">
            <i class="fa fa-trash"
               data-toggle="tooltip"
               data-placement="top" title=""
               data-original-title="<?php echo e(__('buttons.general.crud.delete')); ?>"></i>
            <form action="<?php echo e($route); ?>"
                  method="POST" name="delete_item" style="display:none">
                <?php echo csrf_field(); ?>
                <?php echo e(method_field('DELETE')); ?>

            </form>
        </a>
    <?php endif; ?>


<?php endif; ?>
<?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/datatable/action-delete.blade.php ENDPATH**/ ?>