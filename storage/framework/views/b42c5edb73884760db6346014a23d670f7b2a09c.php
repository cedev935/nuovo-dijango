<?php $request = app('Illuminate\Http\Request'); ?>

<?php $__env->startSection('title', __('labels.backend.courses.title').' | '.app_name()); ?>

<?php $__env->startSection('content'); ?>


    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0"><?php echo app('translator')->get('labels.backend.courses.title'); ?></h3>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('course_create')): ?>
                <div class="float-right">
                <a id="order_change" 
                       class="btn btn-primary" style="color:white">Order change</a>
                    <a href="<?php echo e(route('admin.courses.create')); ?>"
                       class="btn btn-success"><?php echo app('translator')->get('strings.backend.general.app_add_new'); ?></a>

                </div>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="d-block">
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a href="<?php echo e(route('admin.courses.index')); ?>"
                               style="<?php echo e(request('show_deleted') == 1 ? '' : 'font-weight: 700'); ?>"><?php echo e(trans('labels.general.all')); ?></a>
                        </li>
                        |
                        <li class="list-inline-item">
                            <a href="<?php echo e(route('admin.courses.index')); ?>?show_deleted=1"
                               style="<?php echo e(request('show_deleted') == 1 ? 'font-weight: 700' : ''); ?>"><?php echo e(trans('labels.general.trash')); ?></a>
                        </li>
                    </ul>
                </div>


                <table id="myTable" class="table table-bordered table-striped <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('course_delete')): ?> <?php if( request('show_deleted') != 1 ): ?> dt-select <?php endif; ?> <?php endif; ?>">
                    <thead>
                    <tr>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('course_delete')): ?>
                            <?php if( request('show_deleted') != 1 ): ?>
                                <th style="text-align:center;"><input type="checkbox" class="mass" id="select-all"/></th><?php endif; ?>
                        <?php endif; ?>


                        <?php if(Auth::user()->isAdmin()): ?>
                                <th><?php echo app('translator')->get('labels.general.sr_no'); ?></th>
                                <th><?php echo app('translator')->get('labels.general.id'); ?>
                                <th><?php echo app('translator')->get('labels.backend.courses.fields.teachers'); ?></th>
                        <?php else: ?>
                                <th><?php echo app('translator')->get('labels.general.sr_no'); ?></th>
                                <th><?php echo app('translator')->get('labels.general.id'); ?>

                            <?php endif; ?>

                        <th><?php echo app('translator')->get('labels.backend.courses.fields.title'); ?></th>
                        <th><?php echo app('translator')->get('labels.backend.courses.fields.category'); ?></th>
                        <th><?php echo app('translator')->get('labels.backend.courses.fields.price'); ?> <br><small>(in <?php echo e($appCurrency['symbol']); ?>)</small></th>
                            <th><?php echo app('translator')->get('labels.backend.courses.fields.status'); ?></th>
                            <th><?php echo app('translator')->get('labels.backend.lessons.title'); ?></th>
                        <?php if( request('show_deleted') == 1 ): ?>
                            <th>&nbsp; <?php echo app('translator')->get('strings.backend.general.actions'); ?></th>
                        <?php else: ?>
                            <th>&nbsp; <?php echo app('translator')->get('strings.backend.general.actions'); ?></th>
                        <?php endif; ?>
                    </tr>
                    </thead>

                    <tbody id="sortable-20">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('after-scripts'); ?>
    <script>

        $(document).ready(function () {
            $(function() {
                $('#sortable-20').sortable({
                    update: function(event, ui) {
                    }
                });
            });

            $("#order_change").on('click',function(e){
                // alert(e);
                var order_info=[], id_info=[];
                for (var i=1;i<=$("#sortable-20").children().length;i++)
                {
                    id_info[i-1] =$("#sortable-20 tr:nth-child("+i+")").find("td:eq(2)").text(); //id value
                    order_info[i-1] =$("#sortable-20 tr:nth-child("+i+")").find("td:eq(1)").text();// order value
                } 

                // alert(order_info);
                e.preventDefault();
                    $.ajax({
                        data: {"id_info":JSON.stringify(id_info)},
                        url: '<?php echo e(route('admin.courses.position-reorder')); ?>',
                        type: 'get',
                        dataType: 'json',
                        success: function(response){
                            // alert(response.success);
                            swal("Success", response.success, "success")
                        },
                        error: function(response){
                            console.log("error");
                        }
                    });    
            });


            var route = '<?php echo e(route('admin.courses.get_data')); ?>';

            <?php if(request('show_deleted') == 1): ?>
                route = '<?php echo e(route('admin.courses.get_data',['show_deleted' => 1])); ?>';
            <?php endif; ?>

            <?php if(request('teacher_id') != ""): ?>
                route = '<?php echo e(route('admin.courses.get_data',['teacher_id' => request('teacher_id')])); ?>';
            <?php endif; ?>

            <?php if(request('cat_id') != ""): ?>
                route = '<?php echo e(route('admin.courses.get_data',['cat_id' => request('cat_id')])); ?>';
            <?php endif; ?>

            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: 100,
                retrieve: true,
                dom: 'lfBrtip<"actions">',
                buttons: [
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [ 1, 2, 3, 4,5,6 ]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [ 1, 2, 3, 4,5,6 ]
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
                        <?php if(Auth::user()->isAdmin()): ?>
                    {data: "DT_RowIndex", name: 'DT_RowIndex', searchable: false, orderable:false},
                    {data: "id", name: 'id'},
                    {data: "teachers", name: 'teachers'},

                    <?php else: ?>
                    {data: "DT_RowIndex", name: 'DT_RowIndex', searchable: false},
                    {data: "id", name: 'id'},

                    <?php endif; ?>
                    {data: "title", name: 'title'},
                    {data: "category", name: 'category'},
                    {data: "price", name: "price"},
                    {data: "status", name: "status"},
                    {data: "lessons", name: "lessons"},
                    {data: "actions", name: "actions"}
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
                language:{
                    url : '<?php echo e(asset('plugins/jquery-datatable/lang/'.config('app.locale').'.json')); ?>',
                    buttons :{
                        colvis : '<?php echo e(trans("datatable.colvis")); ?>',
                        pdf : '<?php echo e(trans("datatable.pdf")); ?>',
                        csv : '<?php echo e(trans("datatable.csv")); ?>',
                    }
                }
            });
            
            
            
            
            
        });

    </script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/courses/index.blade.php ENDPATH**/ ?>