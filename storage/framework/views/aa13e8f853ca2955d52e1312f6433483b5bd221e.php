<?php $__env->startSection('title', __('labels.backend.certificates.title').' | '.app_name()); ?>

<?php $__env->startSection('content'); ?>

    <div class="card">
        <div class="card-header">
            <h3 class="page-title "><?php echo app('translator')->get('labels.backend.certificates.title'); ?></h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="table-responsive">

                        <table id="myTable"
                               class="table table-bordered table-striped ">
                            <thead>
                            <tr>
                                <th><?php echo app('translator')->get('labels.general.sr_no'); ?></th>
                                <th><?php echo app('translator')->get('labels.backend.certificates.fields.course_name'); ?></th>
                                <th><?php echo app('translator')->get('labels.backend.certificates.fields.progress'); ?></th>
                                <th><?php echo app('translator')->get('labels.backend.certificates.fields.action'); ?></th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php if(count($certificates) > 0): ?>
                                <?php $__currentLoopData = $certificates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$certificate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $key++; ?>
                                    <tr>
                                        <td><?php echo e($key); ?></td>
                                        <td><?php echo e($certificate->course->title); ?></td>
                                        <td><?php echo e($certificate->course->progress()); ?>%</td>
                                        <th>
                                            <?php if($certificate->course->progress() == 100): ?>
                                                <a href="<?php echo e(asset('storage/certificates/'.$certificate->url)); ?>" class="btn btn-success">
                                                    <?php echo app('translator')->get('labels.backend.certificates.view'); ?> </a>

                                                <a class="btn btn-primary" href="<?php echo e(route('admin.certificates.download',['certificate_id'=>$certificate->id])); ?>">
                                                    <?php echo app('translator')->get('labels.backend.certificates.download'); ?> </a>
                                            <?php endif; ?>
                                        </th>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
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

            $('#myTable').DataTable({
                dom: 'lfBrtip<"actions">',
                buttons: [
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [0, 1, 2]

                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2]
                        }
                    },
                    'colvis'
                ],
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
<?php echo $__env->make('backend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/certificates/index.blade.php ENDPATH**/ ?>