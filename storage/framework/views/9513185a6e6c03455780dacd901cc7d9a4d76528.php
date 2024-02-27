<?php $__env->startSection('title', __('labels.backend.categories.title').' | '.app_name()); ?>

<?php $__env->startSection('content'); ?>

    <div class="card">
        <div class="card-header">

            <h3 class="page-title d-inline"><?php echo app('translator')->get('labels.backend.categories.title'); ?></h3>
            <div class="float-right">
                <a href="<?php echo e(route('admin.categories.create')); ?>"
                   class="btn btn-success"><?php echo app('translator')->get('strings.backend.general.app_add_new'); ?></a>
            </div>

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <div class="d-block">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="<?php echo e(route('admin.categories.index')); ?>"
                                       style="<?php echo e(request('show_deleted') == 1 ? '' : 'font-weight: 700'); ?>"><?php echo e(trans('labels.general.all')); ?></a>
                                </li>
                                |
                                <li class="list-inline-item">
                                    <a href="<?php echo e(route('admin.categories.index')); ?>?show_deleted=1"
                                       style="<?php echo e(request('show_deleted') == 1 ? 'font-weight: 700' : ''); ?>"><?php echo e(trans('labels.general.trash')); ?></a>
                                </li>
                            </ul>
                        </div>


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
                                <th><?php echo app('translator')->get('labels.backend.categories.fields.name'); ?></th>
                                <th><?php echo app('translator')->get('labels.backend.categories.fields.slug'); ?></th>
                                <th><?php echo app('translator')->get('labels.backend.categories.fields.icon'); ?></th>
                                <th><?php echo app('translator')->get('labels.backend.categories.fields.courses'); ?></th>
                                <th><?php echo app('translator')->get('labels.backend.categories.fields.blog'); ?></th>
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
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('after-scripts'); ?>
    <script>
        $(document).ready(function () {
            var route = '<?php echo e(route('admin.categories.get_data')); ?>';

            <?php if(request('show_deleted') == 1): ?>
                route = '<?php echo e(route('admin.categories.get_data',['show_deleted' => 1])); ?>';
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
                            columns: [1, 2, 3, 4,6,7]

                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [1, 2, 3, 4,6,7]
                        }
                    },
                    'colvis'
                ],
                ajax: route,
                columns: [
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category_delete')): ?>
                        <?php if(request('show_deleted') != 1): ?>
                    {
                        "data": function (data) {
                            return '<input type="checkbox" class="single" name="id[]" value="' + data.id + '" />';
                        }, "orderable": false, "searchable": false, "name": "id"
                    },
                        <?php endif; ?>
                        <?php endif; ?>
                    {data: "DT_RowIndex", name: 'DT_RowIndex',searchable: false, orderable: false},
                    {data: "id", name: 'id'},
                    {data: "name", name: 'name'},
                    {data: "slug", name: 'slug'},
                    {data: "icon", name: 'icon'},
                    {data: "courses", name: "courses"},
                    {data: "blogs", name: "blogs"},
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
                language: {
                    url: '<?php echo e(asset('plugins/jquery-datatable/lang/'.config('app.locale').'.json')); ?>',
                    buttons: {
                        colvis: '<?php echo e(trans("datatable.colvis")); ?>',
                        pdf: '<?php echo e(trans("datatable.pdf")); ?>',
                        csv: '<?php echo e(trans("datatable.csv")); ?>',
                    }
                }
            });
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category_access')): ?>
            <?php if(request('show_deleted') != 1): ?>
            $('.actions').html('<a href="' + '<?php echo e(route('admin.categories.mass_destroy')); ?>' + '" class="btn btn-xs btn-danger js-delete-selected" style="margin-top:0.755em;margin-left: 20px;">Delete selected</a>');
            <?php endif; ?>
            <?php endif; ?>


            $(document).on('click', '.delete_warning', function () {
                const link = $(this);
                const cancel = (link.attr('data-trans-button-cancel')) ? link.attr('data-trans-button-cancel') : 'Cancel';

                const title = (link.attr('data-trans-title')) ? link.attr('data-trans-title') : "<?php echo e(trans('labels.backend.categories.not_allowed')); ?>";

                swal({
                    title: title,
                    icon: 'error',
                    showCancelButton: true,
                    cancelButtonText: cancel,
                    type: 'info'
                })
            });


        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/categories/index.blade.php ENDPATH**/ ?>