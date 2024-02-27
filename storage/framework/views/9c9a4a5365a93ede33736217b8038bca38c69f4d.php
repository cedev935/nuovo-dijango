<?php 
    $report = (array) $testreport[0];
?>

<?php $__env->startSection('title', __('Test Report(Edit)').' | '.app_name()); ?>
<?php $__env->startPush('before-styles'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/metronic_assets/global/plugins/jquery-ui/jquery-ui.min.css')); ?>"/>   
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/metronic_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')); ?>"/>   
<?php $__env->stopPush(); ?>
<?php $__env->startPush('after-styles'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/admin/testreport.css')); ?>" />
    <script type="text/javascript" src="<?php echo e(asset('js/3.5.1/jquery.min.js')); ?>"></script>
    
    <script src="<?php echo e(asset('plugins/ckeditor4/ckeditor.js')); ?>"></script>
    
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

     
    <?php echo Form::hidden('model_id',0,['id'=>'lesson_id']); ?>


    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">Creation Of Test Reports</h3>
            <div class="float-right">
                <a href="<?php echo e(route('admin.testreports.index')); ?>"
                   class="btn btn-success"><?php echo app('translator')->get('labels.backend.reports.title'); ?></a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">         
                <div class="col-12 form-group">
                    <?php echo Form::label('course_id', trans('labels.backend.tests.fields.course'), ['class' => 'control-label']); ?>

                    <?php echo Form::select('course_id', $courses, request('course_id', old('course_id')), ['class' => 'form-control select2']); ?>

                </div>

                <div class="col-12 form-group">
                    <?php echo Form::label('tests_id', 'Test', ['class' => 'control-label']); ?>

                    <?php 
                        $i=0;
                    ?>                 
                    <select class="form-control select2 required" name="tests_id" id="tests_id" placeholder="Options" multiple>
                       <?php
                            $test_flag=array(); $t =0;  $tp=0;
                        ?>
                        <?php $__currentLoopData = $tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                         $test_flag[$tp] = 0;                   
                                    ?>
                             <?php $__currentLoopData = $current_tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $current_test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                
                                <?php if($test->id == $current_test->test_id): ?>
                                    <?php     
                                        $test_flag[$tp] = 1;             
                                    ?>                                   
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $tp ++; 
                                ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 

                        <?php $__currentLoopData = $tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($test_flag[$t] == 1): ?>
                                    <option value="<?php echo e($test->id); ?>" selected><?php echo e($test->title); ?></option>
                                <?php else: ?>
                                    <option value="<?php echo e($test->id); ?>" ><?php echo e($test->title); ?></option>
                                <?php endif; ?>
                                <?php
                                    $t ++; 
                                ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                    </select>
                    <?php
                        $preview_content = htmlspecialchars_decode(json_decode($testreport[0]->content));
                        $current_content = json_decode($testreport[0]->origin_content);
                    ?>
                    <input  id="id" name="id" type="hidden"  class="form-control" value="<?php echo e($testreport[0]->id); ?>">
                    <div class="form-group form-md-line-input has-info" style="margin-top:20px;">
                        <input  id="title" type="text"  class="form-control" value="<?php echo e($testreport[0]->title); ?>">
                        <label  class="control-label" >Input the title of Test Report</label>
                    </div>
                 
                </div>
            </div>

            <div class="row">
                <div class="col-12 form-group" id="editor">
                    <textarea class="form-control" id="content-ckeditor" name="content"><?php echo e($current_content); ?></textarea>
                </div>
            </div>

            <div class="row">

                <div class="col-12 col-lg-3 form-group">
                    <div class="checkbox">
                        <label for="published" class="checkbox control-label font-weight-bold">
                            <input id="published" name="published" type="checkbox" value="1" <?php if($testreport[0]->published): ?> checked <?php endif; ?>>
                            Published
                        </label>                        
                    </div>
                </div>
                <div class="col-12  text-left form-group">
                    
                    <button class="btn btn-danger" id="save_data">Save</button>
                </div>
            </div>
        </div>
    </div>

   

  
<div class="card">
    <div class="card-header">
        <h3 class="page-title float-left mb-0">Preview</h3>
    </div>
    <div class="card-body">                    
            <div id="preview"><?php echo $preview_content; ?></div>
    </div>
</div>   

<div class="modal fade" id="textGroup_sc_modal" tabindex="-1" role="dialog" aria-labelledby="textGroup_sc_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="textGroup_sc_modalLabel">Insert TextGroup Short Code</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="col-12">
            <?php echo Form::label('modal_tests_id', 'Test', ['class' => 'control-label']); ?>

            <?php 
                $i=0;
            ?>                 
            <select class="form-control select2 required" name="modal_tests_id" id="modal_tests_id" placeholder="Options" multiple>
                <?php
                    $test_flag=array(); $t =0;  $tp=0;
                ?>
                <?php $__currentLoopData = $tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                    $test_flag[$tp] = 0;                   
                            ?>
                        <?php $__currentLoopData = $current_tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $current_test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                
                        <?php if($test->id == $current_test->test_id): ?>
                            <?php     
                                $test_flag[$tp] = 1;             
                            ?>                                   
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $tp ++; 
                        ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 

                <?php $__currentLoopData = $tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($test_flag[$t] == 1): ?>
                            <option value="<?php echo e($test->id); ?>" selected><?php echo e($test->title); ?></option>
                        <?php else: ?>
                            <option value="<?php echo e($test->id); ?>" ><?php echo e($test->title); ?></option>
                        <?php endif; ?>
                        <?php
                            $t ++; 
                        ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
            </select>
            </div>
            <div class="col-12">
            <table id="myTable1" style="width:100%" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th><?php echo app('translator')->get('labels.general.id'); ?></th>
                    <th>Title</th>
                    <th>Short Code</th>
                    <th><?php echo app('translator')->get('strings.backend.general.actions'); ?></th>
                </tr>
                </thead>

                <tbody id="sortable-20">

                </tbody>
            </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>
        </div>
    </div>
</div>

  <div class="modal fade" id="chart_sc_modal" tabindex="-1" role="dialog" aria-labelledby="chart_sc_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="chart_sc_modalLabel">Insert chart Short Code</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="col-12">
            <?php echo Form::label('modal_tests_id', 'Test', ['class' => 'control-label']); ?>

            <?php 
                $i=0;
            ?>                 
            <select class="form-control select2 required" name="modal_tests_id" id="modal_tests_id" placeholder="Options" multiple>
               <?php
                    $test_flag=array(); $t =0;  $tp=0;
                ?>
                <?php $__currentLoopData = $tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                 $test_flag[$tp] = 0;                   
                            ?>
                     <?php $__currentLoopData = $current_tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $current_test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                
                        <?php if($test->id == $current_test->test_id): ?>
                            <?php     
                                $test_flag[$tp] = 1;             
                            ?>                                   
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $tp ++; 
                        ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 

                <?php $__currentLoopData = $tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($test_flag[$t] == 1): ?>
                            <option value="<?php echo e($test->id); ?>" selected><?php echo e($test->title); ?></option>
                        <?php else: ?>
                            <option value="<?php echo e($test->id); ?>" ><?php echo e($test->title); ?></option>
                        <?php endif; ?>
                        <?php
                            $t ++; 
                        ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
            </select>
          </div>
          <div class="col-12">
            <table id="myTable2" style="width:100%" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th><?php echo app('translator')->get('labels.general.id'); ?></th>
                    <th>Title</th>
                    <th>Short Code</th>
                    <th><?php echo app('translator')->get('strings.backend.general.actions'); ?></th>
                </tr>
                </thead>

                <tbody id="sortable-20">

                </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

  <?php $__env->stopSection(); ?>

<?php $__env->startPush('after-scripts'); ?>
    <script type="text/javascript" src="<?php echo e(asset('assets/metronic_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')); ?>"></script>
    
    <script src="<?php echo e(asset('/vendor/laravel-filemanager/js/lfm.js')); ?>"></script>
   
    <script src="<?php echo e(asset('/plugins/amcharts_4/core.js')); ?>"></script>
    <script src="<?php echo e(asset('/plugins/amcharts_4/charts.js')); ?>"></script>
    <script src="<?php echo e(asset('/plugins/amcharts_4/themes/material.js')); ?>"></script>
    <script src="<?php echo e(asset('/plugins/amcharts_4/themes/animated.js')); ?>"></script>
    <script src="<?php echo e(asset('/plugins/amcharts_4/themes/kelly.js')); ?>"></script>
    <script src="<?php echo e(asset('js/pie-chart.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bar-chart.js')); ?>"></script>
    <script src="<?php echo e(asset('js/d3bar-chart.js')); ?>"></script>
    <script src="<?php echo e(asset('js/donut-chart.js')); ?>"></script>    
    <script src="<?php echo e(asset('js/horizontal-bar.js')); ?>"></script>
    <script src="<?php echo e(asset('js/line-chart.js')); ?>"></script>
    <script src="<?php echo e(asset('js/radar-chart.js')); ?>"></script>
    <script src="<?php echo e(asset('js/polar-chart.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bubble-chart.js')); ?>"></script>
    <script src="<?php echo e(asset('js/radar1-chart.js')); ?>"></script>
    <script src="<?php echo e(asset('js/responsive-table.js')); ?>"></script>
    <script src="<?php echo e(asset('js/sortable-table.js')); ?>"></script>
    <script src="<?php echo e(asset('js/no-table-chart.js')); ?>"></script>
 
    <script src="<?php echo e(asset('js/report-create.js')); ?>"></script>

    <script>
        // CKEDITOR.plugins.addExternal( 'bootstraptable', '//localhost:8000/vendor/unisharp/laravel-ckeditor/plugins/table/dialogs/', 'table.js' );
        CKEDITOR.plugins.addExternal( 'shortcode', 'plugins/shortcode/');
        CKEDITOR.replace( 'content-ckeditor', {
            height : 300,
            filebrowserUploadUrl: `<?php echo e(route('admin.ckeditor_fileupload',['_token' => csrf_token() ])); ?>`,
            filebrowserUploadMethod: 'form',
            toolbarGroups : [
                { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
                // { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
                { name: 'links' },
                { name: 'insert' },
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                { name: 'shortcode',   groups: [ 'shortcode' ] },
                '/',
                // { name: 'forms' },
                // { name: 'tools' },
                // { name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
                // { name: 'others' },
                { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
                { name: 'styles' },
                { name: 'colors' },
                { name: 'about' },
            ],
            removeButtons : 'Underline,Subscript,Superscript',
            extraPlugins: 'font, widget, colorbutton, colordialog, justify, shortcode',
        });
jQuery(document).ready(function (e) {
    var route = "<?php echo e(route('admin.textgroups.get_data_editor')); ?>";

    <?php if(request('test_id') != ""): ?>
        route = '<?php echo e(route('admin.textgroups.get_data_editor',['test_id' => request('test_id')])); ?>';
    <?php else: ?>
        <?php if(request('course_id') != ""): ?>
            route = '<?php echo e(route('admin.textgroups.get_data_editor',['course_id' => request('course_id')])); ?>';
        <?php endif; ?>
    <?php endif; ?>

    var route2 = "<?php echo e(route('admin.charts.get_data_editor')); ?>";

    <?php if(request('test_id') != ""): ?>
        route2 = '<?php echo e(route('admin.charts.get_data_editor',['test_id' => request('test_id')])); ?>';
    <?php else: ?>
        <?php if(request('course_id') != ""): ?>
            route2 = '<?php echo e(route('admin.charts.get_data_editor',['course_id' => request('course_id')])); ?>';
        <?php endif; ?>
    <?php endif; ?>

    

    $('#myTable1').DataTable({
        processing: true,
        serverSide: true,
        iDisplayLength: 10,
        retrieve: true,
        ajax: route,
        buttons:[],
        columns: [
            {data: "id", name: 'id'},  
            {data: "title", name: 'title'},  
            {data: "short_code", name: 'short_code', searchable: false, orderable: false},                
            {data: "actions", name: "actions", searchable: false, orderable: false},
        ],
        language:{
            url : '<?php echo e(asset('plugins/jquery-datatable/lang/'.config('app.locale').'.json')); ?>'
        }
    });

    $('#myTable2').DataTable({
        processing: true,
        serverSide: true,
        iDisplayLength: 10,
        retrieve: true,
        ajax: route2,
        buttons:[],
        columns: [
            {data: "id", name: 'id'},  
            {data: "title", name: 'title'},  
            {data: "short_code", name: 'short_code', searchable: false, orderable: false},                
            {data: "actions", name: "actions", searchable: false, orderable: false},
        ],
        language:{
            url : '<?php echo e(asset('plugins/jquery-datatable/lang/'.config('app.locale').'.json')); ?>'
        }
    });

    $(document).on('change', '#modal_test_id', function (e) {
        var course_id = $('#course_id').val();
        var test_id = $(this).val();
        window.location.href = "<?php echo e(route('admin.textgroups.index')); ?>" + "?course_id=" + course_id + "&test_id=" + test_id;
    });
    
    $(document).on('change', '#course_id', function (e) {
        var course_id = $(this).val();
        window.location.href = "?course_id=" + course_id
    });

});


    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/testreports/edit.blade.php ENDPATH**/ ?>