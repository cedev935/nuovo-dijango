<a data-method="restore" data-trans-button-cancel="Cancel"
   data-trans-button-confirm="Restore" data-trans-title="Are you sure?"
   class="btn btn-xs mb-1 btn-success text-white" style="cursor:pointer;"
   onclick="$(this).find('form').submit();">
    <?php echo e(trans('strings.backend.general.app_restore')); ?>

    <form action="<?php echo e(route($route_label.'.restore',[$label=> $value])); ?>"
          method="POST" name="restore_item" style="display:none">
        <?php echo csrf_field(); ?>
    </form>
</a>

<a data-method="delete" data-trans-button-cancel="Cancel"
   data-trans-button-confirm="Delete" data-trans-title="Are you sure?"
   class="btn btn-xs mb-1 btn-danger text-white" style="cursor:pointer;"
   onclick="$(this).find('form').submit();">
    <?php echo e(trans('strings.backend.general.app_permadel')); ?>

    <form action="<?php echo e(route($route_label.'.perma_del',[$label=>$value])); ?>"
          method="POST" name="delete_item" style="display:none">
        <?php echo csrf_field(); ?>
        <?php echo e(method_field('DELETE')); ?>

    </form>
</a>
<?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/datatable/action-trashed.blade.php ENDPATH**/ ?>