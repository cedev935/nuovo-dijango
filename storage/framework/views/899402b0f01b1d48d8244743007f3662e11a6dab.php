<?php $__env->startSection('title', __('menus.backend.sidebar.payments_requests.title').' | '.app_name()); ?>

<?php $__env->startSection('content'); ?>

<div class="card">
    <div class="card-header">
        <h3 class="page-title d-inline"><?php echo app('translator')->get('menus.backend.sidebar.payments_requests.title'); ?></h3>
    </div>
    <div class="card-body">
        <div class="d-block">
            <ul class="list-inline">
                <li class="list-inline-item">
                    <a href="<?php echo e(route('admin.payments.requests')); ?>"
                        style="<?php echo e(!request('status')? 'font-weight: 700': ''); ?>"><?php echo e(trans('labels.general.all')); ?></a>
                </li>
                |
                <li class="list-inline-item">
                    <a href="<?php echo e(route('admin.payments.requests')); ?>?status=1"
                        style="<?php echo e(request('status') == 1 ? 'font-weight: 700' : ''); ?>"><?php echo e(trans('labels.backend.payments.status.approved')); ?></a>
                </li>
                |
                <li class="list-inline-item">
                    <a href="<?php echo e(route('admin.payments.requests')); ?>?status=2"
                        style="<?php echo e(request('status') == 2 ? 'font-weight: 700' : ''); ?>"><?php echo e(trans('labels.backend.payments.status.rejected')); ?></a>
                </li>
            </ul>
        </div>
        <div class="table-responsive">
            <table id="earningTable" class="table table-bordered table-striped ">
                <thead>
                    <tr>
                        <th><?php echo app('translator')->get('labels.general.sr_no'); ?></th>
                        <th><?php echo app('translator')->get('labels.general.id'); ?></th>
                        <th><?php echo app('translator')->get('labels.backend.payments.fields.teacher_name'); ?></th>
                        <th><?php echo app('translator')->get('labels.backend.payments.fields.amount'); ?></th>
                        <th><?php echo app('translator')->get('labels.backend.payments.total_balance'); ?></th>
                        <th><?php echo app('translator')->get('labels.backend.payments.fields.status'); ?></th>
                        <th><?php echo app('translator')->get('labels.backend.payments.fields.date'); ?></th>
                        <?php if(!request('status')): ?>
                        <th><?php echo app('translator')->get('strings.backend.general.actions'); ?></th>
                        <?php endif; ?>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal" id="updateRequestModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateRequestForm" class="form-material" method="post" accept-charset="UTF-8" data-url=''>
                <div class="modal-header">
                    <h4 class="modal-title"><?php echo app('translator')->get('labels.general.buttons.update'); ?></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div id="update-notification-container"></div>
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="status" value="" id="request_status">
                    <input type="hidden" name="id" value="" id="update_id">
                    <?php echo Form::label('remarks', trans('labels.backend.payments.fields.remarks'), ['class' =>
                    'control-label']); ?>

                    <?php echo Form::textarea('remarks', old('remarks'), ['class' => 'form-control ', 'placeholder' =>
                    trans('labels.backend.payments.fields.remarks')]); ?>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"
                        data-dismiss="modal"><?php echo app('translator')->get('labels.general.buttons.cancel'); ?></button>
                    <button type="submit"
                        class="btn btn-primary waves-effect waves-light "><?php echo app('translator')->get('labels.general.buttons.save'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('after-scripts'); ?>
<script>
    $(document).ready(function () {
        var get_payment_request_data = '<?php echo e(route('admin.payments.get_payment_request_data')); ?>?status=<?php echo e(request('status')); ?>';


        $('#earningTable').DataTable({
            processing: true,
            serverSide: true,
            iDisplayLength: 10,
            retrieve: true,
            dom: 'lfBrtip<"actions">',
            buttons: [{
                    extend: 'csv',
                    exportOptions: {
                        columns: [ 0,1, 2,3,4,6]
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [ 0,1, 2,3,4,6]
                    }
                },
                'colvis'
            ],
            ajax: get_payment_request_data,
            columns: [

                {
                    data: "DT_RowIndex",
                    name: 'DT_RowIndex',
                    width: '8%'
                },
                {
                    data: "id",
                    name: 'id',
                    width: '8%'
                },
                {
                    data: "teacher_name",
                    name: 'teacher_name'
                },
                {
                    data: "amount",
                    name: 'amount'
                },
                {
                    data: "balance",
                    name: 'balance'
                },
                {
                    data: "status",
                    name: 'status'
                },
                {
                    data: "created_at",
                    name: 'created_at'
                },
                <?php if(!request('status')): ?> {
                    data: "actions",
                    name: "actions"
                },
                <?php endif; ?>
            ],
            language: {
                url: '<?php echo e(asset('plugins/jquery-datatable/lang/'.config('app.locale').'.json')); ?>',
                buttons: {
                    colvis: '<?php echo e(trans("datatable.colvis")); ?>',
                    pdf: '<?php echo e(trans("datatable.pdf")); ?>',
                    csv: '<?php echo e(trans("datatable.csv")); ?>',
                }
            },
            createdRow: function (row, data, dataIndex) {
                $(row).attr('data-entry-id', data.id);
            },
        });
    });

    $(document).on('click', '.update-status-request', function () {
        $('#updateRequestForm').attr('data-url', $(this).data('url'));
        $('#request_status').val($(this).data('status'));
        $('#update_id').val($(this).data('id'));
        $('#updateRequestModal').modal('show');
    });

    $(document).on('submit', 'form#updateRequestForm', function (event) {
        event.preventDefault();
        var url = $(this).data('url');
        var form = this;
        var data = new FormData(this);

        $.ajax({
            method: "POST",
            url: url,
            data: data,
            processData: false,
            contentType: false,
        }).done(function (response) {
            $(form)[0].reset();
            location.reload();
        }).fail(function (jqXhr) {
            var data = jqXhr.responseJSON;
            var errorsHtml = '<div class="alert alert-danger"><ul>';

            $.each(data.errors, function (key, value) {
                errorsHtml += '<li>' + value + '</li>';
            });
            errorsHtml += '</ul></div>';
            $('#update-notification-container').html(errorsHtml);
        });

    });
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/payments/payment_request.blade.php ENDPATH**/ ?>