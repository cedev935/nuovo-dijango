<?php $request = app('Illuminate\Http\Request'); ?>

<?php $__env->startSection('title', __('Text Groups').' | '.app_name()); ?>

<?php $__env->startPush('before-styles'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/metronic_assets/global/plugins/jquery-ui/jquery-ui.min.css')); ?>"/>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">Text Groups</h3>
            <div class="float-right">
                <a id="order_change" 
                    class="btn btn-primary" style="color:white">Order change</a>
                <a href="<?php echo e(route('admin.textgroups.create', [
                    'course_id' => request('course_id'),
                    'test_id' => request('test_id'),
                ])); ?>"
                    class="btn btn-success">Add New</a>

            </div>
        </div>
        <div class="card-body table-responsive">
            <div class="row">
                <div class="col-12 col-lg-6 form-group">
                    <?php echo Form::label('course_id', trans('labels.backend.questions.fields.course'), ['class' => 'control-label']); ?>

                    <?php echo Form::select('course_id', $courses,  (request('course_id')) ? request('course_id') : old('course_id'), ['class' => 'form-control select2', 'id' => 'course_id']); ?>

                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-6 form-group">
                    <?php echo Form::label('test_id', trans('labels.backend.questions.test'), ['class' => 'control-label']); ?>

                    <?php echo Form::select('test_id', $tests,  (request('test_id')) ? request('test_id') : old('test_id'), ['class' => 'form-control select2', 'id' => 'test_id']); ?>

                </div>
            </div>
            <div class="d-block">
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="<?php echo e(route('admin.textgroups.index')); ?>"
                                                    style="<?php echo e(request('show_deleted') == 1 ? '' : 'font-weight: 700'); ?>"><?php echo e(trans('labels.general.all')); ?></a>
                    </li>
                    |
                    <li class="list-inline-item"><a href="<?php echo e(route('admin.textgroups.index')); ?>?show_deleted=1"
                                                    style="<?php echo e(request('show_deleted') == 1 ? 'font-weight: 700' : ''); ?>"><?php echo e(trans('labels.general.trash')); ?></a>
                    </li>
                </ul>
            </div>
            <table id="myTable2"
                   class="table table-bordered table-striped <?php if( request('show_deleted') != 1 ): ?> dt-select <?php endif; ?> ">
                <thead>
                <tr>
                    
                        <th><?php echo app('translator')->get('labels.general.sr_no'); ?></th>
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('after-scripts'); ?>
<script>
jQuery(document).ready(function (e) {
    var route = "<?php echo e(route('admin.textgroups.get_data')); ?>";

    

    <?php if(request('test_id') != ""): ?>
        route = '<?php echo e(route('admin.textgroups.get_data',['test_id' => request('test_id')])); ?>';
    <?php else: ?>
        <?php if(request('course_id') != ""): ?>
            route = '<?php echo e(route('admin.textgroups.get_data',['course_id' => request('course_id')])); ?>';
        <?php endif; ?>
    <?php endif; ?>

    $('#myTable2').DataTable({
        processing: true,
        serverSide: true,
        iDisplayLength: 10,
        retrieve: true,
        dom: 'lfBrtip<"actions">',
        buttons: [
            {
                extend: 'csv',
                exportOptions: {
                    columns: [ 1, 2]
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [ 1, 2]
                }
            },
            'colvis'
        ],
        ajax: route,
        columns: [
                //   
            {data: "DT_RowIndex", name: 'DT_RowIndex', searchable: false, orderable: false},
            {data: "id", name: 'id'},  
            {data: "title", name: 'title'},  
            {data: "short_code", name: 'short_code'},                
            {data: "actions", name: "actions"},
            
        ],
        <?php if(request('show_deleted') != 1): ?>
        columnDefs: [
            {"width": "5%", "targets": 0},
            {"className": "text-center", "targets": [0]}
        ],
        <?php endif; ?>

        columnDefs: [
            {"width": "5%", "targets": 0},
            {"className": "text-center", "targets": [0]}
        ],

        createdRow: function (row, data, dataIndex) {
            $(row).attr('data-entry-id', data.id);
        },
        language:{
            url : '<?php echo e(asset('plugins/jquery-datatable/lang/'.config('app.locale').'.json')); ?>',
            buttons :{
                colvis : '<?php echo e(trans("datatable.colvis")); ?>',
                pdf : '<?php echo e(trans("datatable.pdf")); ?>',
                csv : '<?php echo e(trans("datatable.csv")); ?>',
            }
        }
    });

    $(document).on('change', '#test_id', function (e) {
        var course_id = $('#course_id').val();
        var test_id = $(this).val();
        window.location.href = "<?php echo e(route('admin.textgroups.index')); ?>" + "?course_id=" + course_id + "&test_id=" + test_id;
    });
    $(document).on('change', '#course_id', function (e) {
        var course_id = $(this).val();
        window.location.href = "<?php echo e(route('admin.textgroups.index')); ?>" + "?course_id=" + course_id;
    });

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('textgroup_delete')): ?>
    <?php if(request('show_deleted') != 1): ?>
    $('.actions').html('<a href="' + '<?php echo e(route('admin.textgroups.mass_destroy')); ?>' + '" class="btn btn-xs btn-danger js-delete-selected" style="margin-top:0.755em;margin-left: 20px;">Delete selected</a>');
    <?php endif; ?>
    <?php endif; ?>


    // $(function() {
    //      $('#sortable-20').sortable({
    //          update: function(event, ui) {
    //         }
    //      });
    //  });

    $("#order_change").on('click',function(e){
        var order_info=[], id_info=[];
        for (var i=1;i<=$("#sortable-20").children().length;i++)
        {
        
            id_info[i-1] =$("#sortable-20 tr:nth-child("+i+")").find("td:eq(2)").text(); //id value
            order_info[i-1] =$("#sortable-20 tr:nth-child("+i+")").find("td:eq(1)").text();// order value
        } 

        e.preventDefault();
            $.ajax({
                data: { "id_info":JSON.stringify(id_info)},
                url: 'textgroups/order-edit',
                type: 'get',
                dataType: 'json',
                complete: function(response){     
                    alert("The order is updated successfully.");
                },
                error: function(response){
                    console.log("error");
                }
            });    
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/textgroups/index.blade.php ENDPATH**/ ?>