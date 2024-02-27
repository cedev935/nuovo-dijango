<?php $request = app('Illuminate\Http\Request'); ?>

<?php $__env->startSection('title', __('labels.backend.questions.title').' | '.app_name()); ?>

<?php $__env->startPush('before-styles'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/metronic_assets/global/plugins/jquery-ui/jquery-ui.min.css')); ?>"/>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('after-styles'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/admin/questions.css')); ?>" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0"><?php echo app('translator')->get('labels.backend.questions.title'); ?></h3>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('question_create')): ?>
                <div class="float-right">
                   <a id="order_change" 
                       class="btn btn-primary" style="color:white">Order change</a>
                    <a 
                        href="<?php echo e(route('admin.questions.create', [
                            'course_id' => request('course_id', old('course_id')),
                            'test_id' => request('test_id', old('test_id')),
                        ])); ?>"
                       class="btn btn-success">Add New</a>

                </div>
            <?php endif; ?>
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
                    <li class="list-inline-item"><a href="<?php echo e(route('admin.questions.index')); ?>"
                                                    style="<?php echo e(request('show_deleted') == 1 ? '' : 'font-weight: 700'); ?>"><?php echo e(trans('labels.general.all')); ?></a>
                    </li>
                    |
                    <li class="list-inline-item"><a href="<?php echo e(route('admin.questions.index')); ?>?show_deleted=1"
                                                    style="<?php echo e(request('show_deleted') == 1 ? 'font-weight: 700' : ''); ?>"><?php echo e(trans('labels.general.trash')); ?></a>
                    </li>
                </ul>
            </div>
            <table id="myTable"
                   class="table table-bordered table-striped <?php if( request('show_deleted') != 1 ): ?> dt-select <?php endif; ?> ">
                <thead>
                <tr>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('question_delete')): ?>
                        <?php if( request('show_deleted') != 1 ): ?>
                            <th style="text-align:center;"><input type="checkbox" class="mass" id="select-all"/></th><?php endif; ?>
                    <?php endif; ?>
                        <th><?php echo app('translator')->get('labels.general.sr_no'); ?></th>
                        <th><?php echo app('translator')->get('labels.general.id'); ?></th>
                        <th>Question Order</th>
                        <?php if(request('test_id') != ""): ?>
                        <th> Page No</th>
                        <?php endif; ?>
                        <th> <?php echo app('translator')->get('labels.backend.questions.fields.question'); ?></th>
                        <th><?php echo app('translator')->get('labels.backend.questions.fields.question_image'); ?></th>
                        <?php if( request('show_deleted') == 1 ): ?>
                        <th><?php echo app('translator')->get('strings.backend.general.actions'); ?></th>
                        <?php else: ?>
                        <th><?php echo app('translator')->get('strings.backend.general.actions'); ?></th>
                        <?php endif; ?>
                        <th width="5%">condition logic</th>
                </tr>
                </thead>

                <tbody id="sortable-20">

                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('after-scripts'); ?>
<script type="text/javascript" src="<?php echo e(asset('assets/metronic_assets/global/plugins/jquery-ui/jquery-ui.min.js')); ?>"></script>
<script>
    jQuery(document).ready(function (e) {
        // QuestionEdit.init();
            $(function() {
            $('#sortable-20').sortable({
                update: function(event, ui) {
                }
            });
        });
        
        $("#order_change").on('click',function(e){
            var order_info=[], id_info=[];
            for (var i=1;i<=$("#sortable-20").children().length;i++)
            {
                id_info[i-1] =$("#sortable-20 tr:nth-child("+i+")").find("td:eq(2)").text(); //id value
                order_info[i-1] =$("#sortable-20 tr:nth-child("+i+")").find("td:eq(1)").text();// order value
            } 
            e.preventDefault();
            $.ajax({
                data: { "test_id":"<?php echo request('test_id') ?? '' ?>", "id_info":JSON.stringify(id_info)},
                url: '<?php echo e(route('user.questions.order-edit')); ?>',
                type: 'get',
                dataType: 'json',
                success: function(response){
                    swal("Success", response.success, "success")
                },
                error: function(response){
                    console.log("error");
                }
            });    
        });


        var route = '<?php echo e(route('admin.questions.get_data')); ?>';

        <?php if(request('show_deleted') == 1): ?>
            route = '<?php echo e(route('admin.questions.get_data',['show_deleted' => 1])); ?>';
        <?php endif; ?>

        <?php if(request('test_id') != ""): ?>
            route = '<?php echo e(route('admin.questions.get_data',['test_id' => request('test_id')])); ?>';
        <?php else: ?>
            <?php if(request('course_id') != ""): ?>
                route = '<?php echo e(route('admin.questions.get_data',['course_id' => request('course_id')])); ?>';
            <?php endif; ?>
        <?php endif; ?>

        $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            iDisplayLength: 25,
            lengthMenu: [ 25, 50, 75, 100 ],
            retrieve: true,
            dom: 'lfBrtip<"actions">',
            buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 1, 2, 3, 5,]
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [ 1, 2, 3, 5]
                    }
                },
                'colvis'
            ],
            ajax: route,
            columns: [
                    <?php if(request('show_deleted') != 1): ?>
                { "data": function(data){
                    return '<input type="checkbox" class="single" name="id[]" value="'+ data.id +'" />';
                }, "orderable": false, "searchable":false, "name":"id" },
                    <?php endif; ?>
                {data: "DT_RowIndex", name: 'DT_RowIndex', searchable: false, orderable: false},
                {data: "id", name: 'id'},
                {data: "questionorder", name: 'questionorder'},
                <?php if(request('test_id') != ""): ?>
                {data: "page_no", name: 'page_no'},
                <?php endif; ?>
                {data: "question", name: 'question'},
                {data: "questionimage", name: 'questionimage'},                    
                {data: "actions", name: "actions"},
                {data: function(data){ 
                    return '<p style="background-color:gold">'+ data.conditionlogic +'</p>'
                    }    
                }
            ],
            <?php if(request('show_deleted') != 1): ?>
            columnDefs: [
                {"width": "5%", "targets": 0},
                {"className": "text-center", "targets": [0]}
            ],
            <?php endif; ?>

            createdRow: function (row, data, dataIndex) {
                $(row).attr('data-entry-id', data.id);
            },
            initComplete: function(settings, json){
                $( ".page_no" ).blur(function() {
                    //console.log($(this).attr('id'));
                    //console.log($(this.val());
                    $.ajax({
                        data: { "test_id":"<?php echo request('test_id') ?? '' ?>", "question_id":$(this).attr('id'), "page_no":$(this).val(),"_token": "<?php echo e(csrf_token()); ?>"},
                        url: 'questions/page-update',
                        type: 'post',
                        dataType: 'json',
                        success: function(response){     
                            //alert("The Page Number is updated successfully.");
                        },
                        error: function(response){
                            console.log("error");
                        }
                    });
                });
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
            window.location.href = "<?php echo e(route('admin.questions.index')); ?>" + "?course_id=" + course_id + "&test_id=" + test_id;
        });
        $(document).on('change', '#course_id', function (e) {
            var course_id = $(this).val();
            window.location.href = "<?php echo e(route('admin.questions.index')); ?>" + "?course_id=" + course_id;
        });
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('question_delete')): ?>
        <?php if(request('show_deleted') != 1): ?>
        $('.actions').html('<a href="' + '<?php echo e(route('admin.questions.mass_destroy')); ?>' + '" class="btn btn-xs btn-danger js-delete-selected" style="margin-top:0.755em;margin-left: 20px;">Delete selected</a>');
        <?php endif; ?>
        <?php endif; ?>



    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/questions/index.blade.php ENDPATH**/ ?>