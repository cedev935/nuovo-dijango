<?php $request = app('Illuminate\Http\Request'); ?>

<?php $__env->startSection('title', __('labels.backend.stripe.plan.title').' | '.app_name()); ?>

<?php $__env->startSection('content'); ?>

    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline"><?php echo app('translator')->get('labels.backend.stripe.plan.title'); ?></h3>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stripe_plan_create')): ?>
                <div class="float-right">
                    <a href="<?php echo e(route('admin.stripe.plans.create')); ?>"
                       class="btn btn-success"><?php echo app('translator')->get('strings.backend.general.app_add_new'); ?></a>

                </div>
            <?php endif; ?>
        </div>
        <div class="card-body">
                <div class="table-responsive">
                    <div class="d-block">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a href="<?php echo e(route('admin.stripe.plans.index')); ?>"
                                   style="<?php echo e(request('show_deleted') == 1 ? '' : 'font-weight: 700'); ?>"><?php echo e(trans('labels.general.all')); ?></a>
                            </li>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('course_delete')): ?>
                                |
                                <li class="list-inline-item">
                                    <a href="<?php echo e(route('admin.stripe.plans.index')); ?>?show_deleted=1"
                                       style="<?php echo e(request('show_deleted') == 1 ? 'font-weight: 700' : ''); ?>"><?php echo e(trans('labels.general.trash')); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <table id="myTable"
                           class="table table-bordered table-striped <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('stripe_plan_delete')): ?> <?php if( request('show_deleted') != 1 ): ?> dt-select <?php endif; ?> <?php endif; ?>">
                        <thead>
                        <tr>
                            <th><?php echo app('translator')->get('labels.general.sr_no'); ?></th>

                            <th><?php echo app('translator')->get('labels.backend.stripe.plan.fields.name'); ?></th>
                            <th><?php echo app('translator')->get('labels.backend.stripe.plan.fields.amount'); ?></th>
                            <th><?php echo app('translator')->get('labels.backend.stripe.plan.fields.interval'); ?></th>
                            <?php if( request('show_deleted') == 1 ): ?>
                                <th><?php echo app('translator')->get('strings.backend.general.actions'); ?> &nbsp;</th>
                            <?php else: ?>
                                <th><?php echo app('translator')->get('strings.backend.general.actions'); ?> &nbsp;</th>
                            <?php endif; ?>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>

        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('after-scripts'); ?>
    <script>

        $(document).ready(function () {
            var route = '<?php echo e(route('admin.stripe.plans.get_data')); ?>';


            <?php
            $show_deleted = (request('show_deleted') == 1) ? 1 : 0;
            $route = route('admin.stripe.plans.get_data',['show_deleted' => $show_deleted]);
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
                            columns: [ 1, 2, 3, 4, 5]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [ 1, 2, 3, 4, 5]
                        }
                    },
                    'colvis'
                ],
                ajax: route,
                columns: [
                    {data: "DT_RowIndex", name: 'DT_RowIndex', searchable: false, orderable:false},
                    {data: "name", name: 'name'},
                    {data: "amount", name: 'amount', searchable: false, orderable:false},
                    {data: "interval", name: 'interval', searchable: false, orderable:false},
                    {data: "actions", name: "actions", searchable: false, orderable:false}
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

<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/stripe/plan/index.blade.php ENDPATH**/ ?>