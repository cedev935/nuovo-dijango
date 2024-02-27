<div class="questions-container-<?php echo e($question->id); ?>">
    <?php if($question->titlelocation !== 'default'): ?>
        <div 
            class="title"
            style="
                padding-top: <?php echo e(data_get($settings, 'description.top', 40)); ?>px;
                padding-bottom: <?php echo e(data_get($settings, 'description.down', 0)); ?>px;
                padding-left: <?php echo e(data_get($settings, 'description.left', 20)); ?>px;
                padding-right: <?php echo e(data_get($settings, 'description.right', 0)); ?>px;
                justify-content: <?php echo e(data_get($settings, 'description.align', 'left')); ?>;
                align-items: baseline;
                display: flex;
            "
        >
            <div id="dynamic_chart<?php echo e($question->id); ?>">
                <?php echo $question->question; ?>

            </div>
        </div>
    <?php endif; ?>

    <?php if(filled($question->questionimage)): ?>
        <div 
            class="image"
            
            style="
                padding-top: <?php echo e(data_get($settings, 'image.top', 30)); ?>px;
                padding-bottom: <?php echo e(data_get($settings, 'image.down', 0)); ?>px;
                padding-left: <?php echo e(data_get($settings, 'image.left', 10)); ?>px;
                padding-right: <?php echo e(data_get($settings, 'image.right', 0)); ?>px;
                justify-content: <?php echo e(data_get($question, 'image_aligment', 'left')); ?>;
                align-items: baseline;
                display: flex;
            "
        >
            <img 
                src="<?php echo e(asset('uploads/image/'.$question->questionimage[0])); ?>" 
                style="object-fit: <?php echo e($question->imagefit); ?>"
                width="<?php echo e($question->imagewidth); ?>"
                height="<?php echo e($question->imageheight); ?>"
            />
        </div>
    <?php endif; ?>

    <div 
        class="answers"
        style="
            padding-top: <?php echo e(data_get($settings, 'answer.top', 20)); ?>px;
            padding-bottom: <?php echo e(data_get($settings, 'answer.down', 0)); ?>px;
            padding-left: <?php echo e(data_get($settings, 'answer.left', 20)); ?>px;
            padding-right: <?php echo e(data_get($settings, 'answer.right', 0)); ?>px;
            justify-content: <?php echo e(data_get($question, 'answer_aligment', 'left')); ?>;
            align-items: baseline;
            display: flex;
        "
    >
        <div 
            class="w-100"
            style="
                <?php if(filled($question->min_width)): ?>
                    min-width: <?php echo e($question->min_width); ?>px !important;
                <?php endif; ?>

                <?php if(filled($question->max_width)): ?>
                    max-width: <?php echo e($question->max_width); ?>px !important;
                <?php endif; ?>

                <?php if(filled($question->width)): ?>
                    width: <?php echo e($question->width); ?>px !important;
                <?php endif; ?>

                justify-content: <?php echo e(data_get($question, 'answer_aligment', 'left')); ?>;
                align-items: baseline;
                display: flex;
            "
        >
            <?php echo $__env->make('frontend.components.questions.inputs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</div>

<?php $__currentLoopData = collect($question->questionimage)->except(0); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <img 
        src="<?php echo e(asset('uploads/image/'.$image)); ?>" 
        style="object-fit: <?php echo e($question->imagefit); ?>"
        width="<?php echo e($question->imagewidth); ?>"
        height="<?php echo e($question->imageheight); ?>"
    />
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<style>
    .questions-container-<?php echo e($question->id); ?> {
        display: grid;
        grid-template-columns: <?php echo e($template['column']); ?>;
        grid-template-rows: minmax(5px, auto);
        grid-template-areas: <?php echo $template['template']; ?>;
    }

    .image {
        grid-area: image;
    }

    .title {
        grid-area: title;
    }

    .answers {
        grid-area: answer;
    }
</style><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/components/fontend/questions.blade.php ENDPATH**/ ?>