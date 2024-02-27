<!-- Start of footer area
    ============================================= -->
<?php
    $footer_data = json_decode(config('footer_data'));
?>

<?php if($footer_data != ""): ?>
<footer>
    <section id="footer-area" class="footer-area-section">
        <div class="container">
            <div class="footer-content pb10">
                <div class="row">
                    <div class="col-md-4">
                        <div class="footer-widget ">
                            <div class="footer-logo mb35">
                                <img src="<?php echo e(asset("storage/logos/".config('logo_b_image'))); ?>" alt="logo">
                            </div>
                            <?php if($footer_data->short_description->status == 1): ?>
                                <div class="footer-about-text">
                                    <p><?php echo $footer_data->short_description->text; ?> </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <?php if($footer_data->section1->status == 1): ?>
                                <?php
                                    $section_data = section_filter($footer_data->section1)
                                ?>

                                <?php echo $__env->make('frontend.layouts.partials.footer_section',['section_data' => $section_data], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endif; ?>

                            <?php if($footer_data->section2->status == 1): ?>
                                <?php
                                    $section_data = section_filter($footer_data->section2)
                                ?>

                                <?php echo $__env->make('frontend.layouts.partials.footer_section',['section_data' => $section_data], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endif; ?>

                            <?php if($footer_data->section3->status == 1): ?>
                                <?php
                                    $section_data = section_filter($footer_data->section3)
                                ?>

                                <?php echo $__env->make('frontend.layouts.partials.footer_section',['section_data' => $section_data], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /footer-widget-content -->
            

            <?php if($footer_data->bottom_footer->status == 1): ?>
            <div class="copy-right-menu">
                <div class="row">
                    <?php if($footer_data->copyright_text->status == 1): ?>
                    <div class="col-md-6">
                        <div class="copy-right-text">
                            <p>Powered By <a href="//diagnosiaziendale.it/" target="_blank" class="mr-4"> <?php echo app('translator')->get('strings.backend.general.boilerplate_link'); ?></a>  <?php echo $footer_data->copyright_text->text; ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if(($footer_data->bottom_footer_links->status == 1) && (count($footer_data->bottom_footer_links->links) > 0)): ?>
                    <div class="col-md-6">
                        <div class="copy-right-menu-item float-right ul-li">
                            <ul>
                                <?php $__currentLoopData = $footer_data->bottom_footer_links->links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="<?php echo e($item->link); ?>"><?php echo e($item->label); ?></a></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if(config('show_offers')): ?>
                                    <li><a href="<?php echo e(route('frontend.offers')); ?>"><?php echo app('translator')->get('labels.frontend.layouts.partials.offers'); ?></a> </li>
                                <?php endif; ?>
                                <li><a href="<?php echo e(route('frontend.certificates.getVerificationForm')); ?>"><?php echo app('translator')->get('labels.frontend.layouts.partials.certificate_verification'); ?></a></li>
                            </ul>
                        </div>
                    </div>
                     <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>
</footer>
<?php endif; ?>
<!-- End of footer area
============================================= -->

<?php $__env->startPush('after-scripts'); ?>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script>
        window.addEventListener('load', function () {
            alertify.set('notifier', 'position', 'top-right');
        });

        function showNotice(type, message) {
            var alertifyFunctions = {
                'success': alertify.success,
                'error': alertify.error,
                'info': alertify.message,
                'warning': alertify.warning
            };

            alertifyFunctions[type](message, 10);
        }
    </script>
    <script src="<?php echo e(asset('js/wishlist.js')); ?>"></script>
    <style>
        .alertify-notifier .ajs-message{
            color: #ffffff;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/frontend/layouts/partials/footer.blade.php ENDPATH**/ ?>