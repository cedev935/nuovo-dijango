<?php $__env->startSection('title', app_name() . ' | ' . __('labels.backend.access.users.management')); ?>

<?php $__env->startSection('breadcrumb-links'); ?>
    <?php echo $__env->make('backend.auth.user.includes.breadcrumb-links', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-7">
                    <h4 class="card-title mb-0">
                        <?php echo e(__('labels.backend.access.users.management')); ?>

                        <small class="text-muted"><?php echo e(__('labels.backend.access.users.active')); ?></small>
                    </h4>
                </div><!--col-->

                <div class="col-sm-5">
                    <select name="roles" id="roles" class="form-control d-inline w-75">

                        <option value=""><?php echo e(__('labels.backend.access.users.select_role')); ?></option>

                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <option value="<?php echo e($role->id); ?>"><?php echo e($role->name); ?></option>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </select>
                    <?php echo $__env->make('backend.auth.user.includes.header-buttons', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div><!--col-->
            </div><!--row-->

            <div class="row mt-4">
                <div class="col">

                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th><?php echo app('translator')->get('labels.general.sr_no'); ?></th>
                                <th><?php echo app('translator')->get('labels.general.id'); ?></th>
                                <th><?php echo app('translator')->get('labels.backend.access.users.table.first_name'); ?></th>
                                <th><?php echo app('translator')->get('labels.backend.access.users.table.last_name'); ?></th>
                                <th><?php echo app('translator')->get('labels.backend.access.users.table.email'); ?></th>
                                <th><?php echo app('translator')->get('labels.backend.access.users.table.confirmed'); ?></th>
                                <th><?php echo app('translator')->get('labels.backend.access.users.table.roles'); ?></th>
                                <th><?php echo app('translator')->get('labels.backend.access.users.table.other_permissions'); ?></th>
                                <th><?php echo app('translator')->get('labels.backend.access.users.table.social'); ?></th>
                                <th><?php echo app('translator')->get('labels.backend.access.users.table.last_updated'); ?></th>
                                <th><?php echo app('translator')->get('labels.general.actions'); ?></th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div><!--col-->
            </div><!--row-->

        </div><!--card-body-->
    </div><!--card-->
<?php $__env->stopSection(); ?>


<?php $__env->startPush('after-scripts'); ?>
    <script>

        $(document).ready(function () {
            var route = '<?php echo e(route('admin.auth.user.getData')); ?>';

            var myTable = $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: 10,
                retrieve: true,
                dom: 'lfBrtip<"actions">',
                buttons: [
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8]
                        }
                    },
                    'colvis'
                ],
                ajax: {
                    url: route,
                    data: function (d) {
                        d.role = $('#roles').val();
                    }
                },
                columns: [
                    {data: "DT_RowIndex", name: 'DT_RowIndex', "orderable": false, "searchable": false},
                    {data: "id", name: 'id', "orderable": false},
                    {data: "first_name", name: 'first_name'},
                    {data: "last_name", name: 'last_name'},
                    {data: "email", name: "email"},
                    {data: "confirmed_label", name: "confirmed_label"},
                    {data: "roles_label", name: "roles.name"},
                    {data: "permissions_label", name: "permissions.name"},
                    {data: "social_buttons", name: "social_accounts.provider", "searchable": false},
                    {data: "last_updated", name: "last_updated"},
                    {data: "actions", name: "actions", "searchable": false}
                ],


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


            $(document).on('change', '#roles', function (e) {
                myTable.draw();
                e.preventDefault();
            });
        });

    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/auth/user/index.blade.php ENDPATH**/ ?>