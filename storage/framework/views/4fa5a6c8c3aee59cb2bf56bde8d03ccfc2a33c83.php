       
        <div class="modal fade" id="exampleModalLong<?php echo e($question->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document" style="padding-right: 17px; display: block;">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header backgroud-style p-0">
    
                        <div class="gradient-bg"></div>
                        <div class="popup-logo">
                            <img src="http://www.diagnosiaziendale.it/storage/logos/popup-logo.png" alt="">
                        </div>
                        <div class="popup-text text-center">
                            <h2>Guida</h2>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    
                    </div>
    
                    <!-- Modal body -->
                    <div class="modal-body">
                        <?php echo $question->help_info; ?>

                        <div class="nws-button text-right white text-capitalize">
                            <button type="button" class="p-3" style="height:unset;width:unset;font-size:1.2rem;background:<?php echo e($question->color1 == NULL ? $question->color1 : $question->color1); ?>;;" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
            
            
            <?php if($question->questiontype==0): ?>
                <?php echo $__env->make('frontend.components.questions.single_input', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            
            <?php elseif($question->questiontype==1): ?>
                <?php echo $__env->make('frontend.components.questions.checkbox', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            
            <?php elseif($question->questiontype==2): ?>
                <?php echo $__env->make('frontend.components.questions.radiogroup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            
            <?php elseif($question->questiontype==3): ?>
                <?php echo $__env->make('frontend.components.questions.image', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            
            <?php elseif($question->questiontype==4): ?>
                <?php echo $__env->make('frontend.components.questions.matrix', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            
            <?php elseif($question->questiontype==5): ?>
                <?php echo $__env->make('frontend.components.questions.rating', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            
            <?php elseif($question->questiontype==6): ?>
                <?php echo $__env->make('frontend.components.questions.dropdown', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            
            <?php elseif($question->questiontype==7): ?>
                <?php echo $__env->make('frontend.components.questions.file', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            
            <?php elseif($question->questiontype==8): ?>
                <?php echo $__env->make('frontend.components.questions.stars', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            
            <?php elseif($question->questiontype==9): ?>
                <?php echo $__env->make('frontend.components.questions.rangs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            
            <?php elseif($question->questiontype==10): ?>
                <?php echo $__env->make('frontend.components.questions.euro', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/frontend/components/questions/inputs.blade.php ENDPATH**/ ?>