<?php $__env->startSection('title', __('labels.backend.contacts.title').' | '.app_name()); ?>




<?php $__env->startSection('content'); ?>

    <div class="card">
        <div class="card-header">

                <h3 class="page-title d-inline"><?php echo app('translator')->get('labels.backend.contacts.title'); ?></h3>


        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">


                        <table id="myTable"
                               class="table table-bordered table-striped ">
                            <thead>
                            <tr>

                                <th><?php echo app('translator')->get('labels.general.sr_no'); ?></th>
                                <th><?php echo app('translator')->get('labels.general.id'); ?></th>
                                <th><?php echo app('translator')->get('labels.backend.contacts.fields.name'); ?></th>
                                <th><?php echo app('translator')->get('labels.backend.contacts.fields.email'); ?></th>
                                <th><?php echo app('translator')->get('labels.backend.contacts.fields.phone'); ?></th>
                                <th><?php echo app('translator')->get('labels.backend.contacts.fields.message'); ?></th>
                                <th><?php echo app('translator')->get('labels.backend.contacts.fields.time'); ?></th>
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
            var route = '<?php echo e(route('admin.contact_requests.get_data')); ?>';

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
                            columns: ':visible',
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':visible',
                        }
                    },
                    'colvis'
                ],
                ajax: route,
                columns: [

                    {data: "DT_RowIndex", name: 'DT_RowIndex', searchable: false},
                    {data: "id", name: 'id'},
                    {data: "name", name: 'name'},
                    {data: "email", name: 'email'},
                    {data: "number", name: 'number'},
                    {data: "message", name: "message"},
                    {data: "created_at", name: "time"},
                ],
                <?php if(request('show_deleted') != 1): ?>
                columnDefs: [
                    {"width": "5%", "targets": 0},
                    {"width": "15%", "targets": 5},
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
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/contacts/index.blade.php ENDPATH**/ ?>