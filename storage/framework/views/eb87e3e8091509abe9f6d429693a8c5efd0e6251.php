<?php $__env->startSection('title', __('labels.backend.textgroups.title').' | '.app_name()); ?>
<?php $__env->startPush('after-styles'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/admin/textgroup.css')); ?>" />
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">Textgroup Create</h3>
            <div class="float-right">
                <a 
                    href="<?php echo e(route('admin.textgroups.index', ['course_id' => request('course_id'), 'test_id'=>request('test_id')])); ?>" 
                    class="btn btn-success"
                >
                    <i class="fa fa-list-ul"></i> <?php echo app('translator')->get('labels.backend.textgroups.view'); ?>
                </a>
            </div>         
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="row form-group">
                        <?php echo Form::label('course_id', trans('labels.backend.tests.fields.course'), ['class' => 'col-md-2 form-control-label']); ?>

                        <div class="col-md-10">
                            <?php echo Form::select('course_id', $courses, request('course_id', old('course_id')), ['class' => 'form-control select2']); ?>

                        </div>
                    </div>    
                    <div class="row form-group">
                        <?php echo Form::label('tests_id', 'Test List *', ['class' => 'col-md-2 form-control-label']); ?>

                        <div class="col-md-10">
                            <select class="form-control select2 required" name="tests_id" id="tests_id" placeholder="Options" multiple>
                                <?php $__currentLoopData = $tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($test->id); ?>"><?php echo e(strip_tags($test->title)); ?></option>                             
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                            </select> 
                        </div>
                    </div>
                    <div class="row form-group has-info">
                        <?php echo Form::label('title', 'Title *', ['class' => 'col-md-2 form-control-label']); ?>

                        <div class="col-md-10">
                            <input id="title" type="text" class="form-control required" value="" />
                        </div>
                    </div>                 
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="page-title mb-0">Textgroup</h3>           
        </div>
        <div class="card-body row">
            <div class="col-12 text-box">
            </div>   
            <div class="col-12">
                <div class="row text m-3">
                    <a class="btn add-text-btn" href="javascript:add_text()">
                        <i class="fa fa-2 fa-plus-square"></i> New Text
                    </a>  
                </div>
            </div>
        </div> 
    </div>
    <div class="float-right">
        <a class="btn btn-danger" href="javascript:save_data();"><i class="fa fa-save"></i> Save TextGroup</a>  
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('after-scripts'); ?>
    <script type="text/javascript" src="<?php echo e(asset('js/textgroup-create.js')); ?>"></script>
    <script>
        jQuery(document).ready(function(e) {   
            let testId = <?php echo e(request('test_id') ?? '0'); ?>;
            if(testId) $('#tests_id').val(testId).trigger('change');
        });

        $(document).on('change', '#course_id', function (e) {
            var course_id = $(this).val();
            window.location.href = "?course_id=" + course_id
        });
    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/textgroups/create.blade.php ENDPATH**/ ?>