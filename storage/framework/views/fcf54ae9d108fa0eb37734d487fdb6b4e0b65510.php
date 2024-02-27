<?php $request = app('Illuminate\Http\Request'); ?>

<?php $__env->startSection('title', __('labels.backend.tests.title').' | '.app_name()); ?>

<?php $__env->startSection('content'); ?>


    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline"><?php echo app('translator')->get('labels.backend.tests.title'); ?></h3>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('test_create')): ?>
                <div class="float-right">
                    <a 
                        href="<?php echo e(route('admin.tests.create', ['course_id' => request('course_id', old('course_id'))])); ?>"
                        class="btn btn-success add-new"
                    >
                       <?php echo app('translator')->get('strings.backend.general.app_add_new'); ?>
                    </a>

                </div>
            <?php endif; ?>
        </div>
        <div class="card-body table-responsive">
            <div class="row">
                <div class="col-12 col-lg-6 form-group">
                    <input type="hidden" name="hdnseq" id='hdnseq'>
                    <?php echo Form::label('course_id', trans('labels.backend.lessons.fields.course'), ['class' => 'control-label']); ?>

                    <?php echo Form::select('course_id', $courses,  request('course_id', old('course_id')), ['class' => 'form-control js-example-placeholder-single select2 ', 'id' => 'course_id']); ?>

                </div>
            </div>
            <div class="d-block">
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a href="<?php echo e(route('admin.tests.index',['course_id'=>request('course_id')])); ?>"
                           style="<?php echo e(request('show_deleted') == 1 ? '' : 'font-weight: 700'); ?>"><?php echo e(trans('labels.general.all')); ?></a>
                    </li>
                    |
                    <li class="list-inline-item">
                        <a href="<?php echo e(trashUrl(request())); ?>"
                           style="<?php echo e(request('show_deleted') == 1 ? 'font-weight: 700' : ''); ?>"><?php echo e(trans('labels.general.trash')); ?></a>
                    </li>
                </ul>
            </div>

            <?php if(request('course_id') != "" || request('show_deleted') == 1): ?>


            <table id="myTable"
                   class="table table-bordered table-striped <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('test_delete')): ?> <?php if( request('show_deleted') != 1 ): ?> dt-select <?php endif; ?> <?php endif; ?>">
                <thead>
                <tr>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('test_delete')): ?>
                        <?php if( request('show_deleted') != 1 ): ?>
                            <th style="text-align:center;"><input type="checkbox" class="mass" id="select-all"/>
                            </th><?php endif; ?>
                    <?php endif; ?>
                    <th><?php echo app('translator')->get('labels.general.sr_no'); ?></th>
                    <th><?php echo app('translator')->get('labels.general.id'); ?></th>
                    <th><?php echo app('translator')->get('labels.backend.tests.fields.course'); ?></th>
                    <th><?php echo app('translator')->get('labels.backend.tests.fields.title'); ?></th>
                    <th><?php echo app('translator')->get('labels.backend.tests.fields.questions'); ?></th>
                    <th><?php echo app('translator')->get('labels.backend.tests.fields.published'); ?></th>
                    <?php if( request('show_deleted') == 1 ): ?>
                        <th><?php echo app('translator')->get('labels.general.actions'); ?></th>

                    <?php else: ?>
                        <th><?php echo app('translator')->get('labels.general.actions'); ?></th>
                    <?php endif; ?>
                </tr>
                </thead>

                <tbody id='shotingTest'>

                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('after-scripts'); ?>
    <script>

        $(document).ready(function () {
            
            $(function() {
                $('#shotingTest').sortable({
                    update: function(event, ui) {
                    }
                });
            });
           
            $("#order_change").on('click',function(e){
                var course_id = $("#course_id").val();
                var sequenceValues = [];
                $('.sequence').each(function() {
                  var value = $(this).val();
                  sequenceValues.push(value);
                });
                var seq = JSON.stringify(sequenceValues)
                var order_info=[], id_info=[];
                for (var i=1;i<=$("#shotingTest").children().length;i++)
                {
                    id_info[i-1] =$("#shotingTest tr:nth-child("+i+")").find("td:eq(2)").text(); //id value
                    order_info[i-1] =$("#shotingTest tr:nth-child("+i+")").find("td:eq(1)").text();// order value
                } 

                // alert(id_info);
                e.preventDefault();
                    $.ajax({
                        data: { "test_id":"<?php echo request('test_id') ?? '' ?>", "id_info":JSON.stringify(id_info),"courseid":course_id,'sequence':seq},
                        url: '<?php echo e(route('admin.tests.order-edit')); ?>',
                        type: 'get',
                        dataType: 'json',
                        success: function(response){
                            alert(response.success);
                        },
                        error: function(response){
                            console.log("error");
                        }
                    });    
            });

            var route = '<?php echo e(route('admin.tests.get_data')); ?>';


        <?php
            $show_deleted = (request('show_deleted') == 1) ? 1 : 0;
            $course_id = (request('course_id') != "") ? request('course_id') : 0;
            $route = route('admin.tests.get_data',['show_deleted' => $show_deleted,'course_id' => $course_id]);
        ?>

            route = '<?php echo e($route); ?>';
            route = route.replace(/&amp;/g, '&');

            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: 10,
                retrieve: true,
                dom: 'lfBrtip<"actions">',
                buttons: [
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [ 1, 2, 3, 4,5,6]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [ 1, 2, 3, 4,5,6]
                        }
                    },
                    'colvis'
                ],
                ajax: route,
                columns: [
                    <?php if($show_deleted != 1): ?>
                    {
                        "data": function (data) {
                            return '<input type="checkbox" class="single" name="id[]" value="' + data.id + '" />';
                        }, "orderable": false, "searchable": false, "name": "id"
                    },
                    <?php endif; ?>
                    {data: "DT_RowIndex", name: 'DT_RowIndex', searchable: false, orderable: false},
                    {data: "id", name: 'id'},
                    {data: "course", name: 'course'},
                    {data: "title", name: 'title'},
                    {data: "questions", name: "questions"},
                    {data: "published", name: "published"},
                    {data: "actions", name: "actions"}
                ],
                <?php if($show_deleted != 1): ?>
                    columnDefs: [
                        {"width": "5%", "targets": 0},
                        {"className": "text-center", "targets": [0]}
                    ],
                <?php endif; ?>

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

            $(document).on('change', '#course_id', function (e) {
                var course_id = $(this).val();
                window.location.href = "<?php echo e(route('admin.tests.index')); ?>" + "?course_id=" + course_id
            });
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('test_delete')): ?>
                <?php if(request('show_deleted') != 1): ?>
                    $('.actions').html('<a href="' + '<?php echo e(route('admin.tests.mass_destroy')); ?>' + '" class="btn btn-xs btn-danger js-delete-selected" style="margin-top:0.755em;margin-left: 20px;">Delete selected</a>');
                <?php endif; ?>
            <?php endif; ?>

            $(".js-example-placeholder-single").select2({
                placeholder: "<?php echo e(trans('labels.backend.lessons.select_course')); ?>",
            });

        });
    </script>

    <?php if(session()->has('flash_success')): ?> 
        <script>templateAlert("Success", "<?php echo e(session()->get('flash_success')); ?>", "success");</script>
    <?php endif; ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/tests/index.blade.php ENDPATH**/ ?>