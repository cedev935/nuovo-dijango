<?php $__env->startSection('title', __('labels.backend.reasons.title').' | '.app_name()); ?>
<?php $__env->startPush('after-styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/colors/switch.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="card">
        <div class="card-header">

                <h3 class="page-title d-inline"><?php echo app('translator')->get('labels.backend.reasons.title'); ?></h3>
                <div class="float-right">
                    <a href="<?php echo e(route('admin.reasons.create')); ?>"
                       class="btn btn-success"><?php echo app('translator')->get('strings.backend.general.app_add_new'); ?></a>
                </div>

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        
                            
                                
                                    
                                       
                                
                                
                                
                                    
                                       
                                
                            
                        


                        <table id="myTable"
                               class="table table-bordered table-striped <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category_delete')): ?> <?php if( request('show_deleted') != 1 ): ?> dt-select <?php endif; ?> <?php endif; ?>">
                            <thead>
                            <tr>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category_delete')): ?>
                                    <?php if( request('show_deleted') != 1 ): ?>
                                        <th style="text-align:center;">
                                            <input type="checkbox" class="mass" id="select-all"/>
                                        </th>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <th><?php echo app('translator')->get('labels.general.sr_no'); ?></th>
                                <th><?php echo app('translator')->get('labels.general.id'); ?></th>
                                <th><?php echo app('translator')->get('labels.backend.reasons.fields.title'); ?></th>
                                <th><?php echo app('translator')->get('labels.backend.reasons.fields.icon'); ?></th>
                                <th><?php echo app('translator')->get('labels.backend.reasons.fields.content'); ?></th>
                                <th><?php echo app('translator')->get('labels.backend.reasons.fields.status'); ?></th>
                                <?php if( request('show_deleted') == 1 ): ?>
                                    <th>&nbsp; <?php echo app('translator')->get('strings.backend.general.actions'); ?></th>
                                <?php else: ?>
                                    <th>&nbsp; <?php echo app('translator')->get('strings.backend.general.actions'); ?></th>
                                <?php endif; ?>
                            </tr>
                            </thead>

                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
            <hr>
            <h4><?php echo app('translator')->get('labels.backend.reasons.note'); ?></h4>
            <img src="<?php echo e(asset('images/reasons.jpg')); ?>" width="100%"  >


        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('after-scripts'); ?>
    <script>

        $(document).ready(function () {
            var route = '<?php echo e(route('admin.reasons.get_data')); ?>';

            <?php if(request('show_deleted') == 1): ?>
                route = '<?php echo e(route('admin.reasons.get_data',['show_deleted' => 1])); ?>';
            <?php endif; ?>

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
                            columns: [ 1, 2, 3,5]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [ 1, 2, 3,5]
                        }
                    },
                    'colvis'
                ],
                ajax: route,
                columns: [
                        <?php if(request('show_deleted') != 1): ?>
                    {
                        "data": function (data) {
                            return '<input type="checkbox" class="single" name="id[]" value="' + data.id + '" />';
                        }, "orderable": false, "searchable": false, "name": "id"
                    },
                        <?php endif; ?>
                    {data: "DT_RowIndex", name: 'DT_RowIndex', searchable: false},
                    {data: "id", name: 'id'},
                    {data: "title", name: 'title'},
                    {data: "icon", name: 'icon'},
                    {data: "content", name: 'content'},
                    {data: "status", name: 'Status'},
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

        $(document).on('click', '.switch-input', function (e) {
            var id = $(this).data('id');
            $.ajax({
                type: "POST",
                url: "<?php echo e(route('admin.reasons.status')); ?>",
                data: {
                    _token:'<?php echo e(csrf_token()); ?>',
                    id: id,
                },
            }).done(function() {
                var table = $('#myTable').DataTable();
		        table.ajax.reload();
            });
        })

    </script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/reasons/index.blade.php ENDPATH**/ ?>