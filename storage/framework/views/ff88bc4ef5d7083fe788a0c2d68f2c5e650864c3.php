<?php if(auth()->check() && (auth()->user()->hasRole('student'))): ?>
<div class="text-center mt-3">
    <form name="wishlist-form" action="<?php echo e(route('add-to-wishlist')); ?>" method="POST">
    <?php echo csrf_field(); ?>
        <input type="hidden" name="course_id" value="<?php echo e($course); ?>">
        <input type="hidden" name="price" value="<?php echo e($price); ?>">
    <button type="submit" class="btn gradient-bg text-white font-weight-bold wishlist-btn">
        <i class="far fa-heart"></i>
        <?php echo app('translator')->get('strings.frontend.general.add_to_wishlist'); ?>
    </button>
    </form>
</div>
<?php endif; ?>
<?php if(!auth()->check()): ?>
<div class="text-center mt-3">
    <a id="openLoginModal" data-target="#myModal" href="#" class="btn gradient-bg text-white font-weight-bold">
        <i class="far fa-heart"></i>
        <?php echo app('translator')->get('strings.frontend.general.add_to_wishlist'); ?>
    </a>
</div>
<?php endif; ?>

<?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/frontend/layouts/partials/wishlist.blade.php ENDPATH**/ ?>