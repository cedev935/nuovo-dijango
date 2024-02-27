<?php $request = app('Illuminate\Http\Request'); ?>

<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">
                <?php echo app('translator')->get('menus.backend.sidebar.general'); ?>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(active_class(Active::checkUriPattern('admin/dashboard'))); ?>"
                    href="<?php echo e(route('admin.dashboard')); ?>">
                    <i class="nav-icon icon-speedometer"></i> <?php echo app('translator')->get('menus.backend.sidebar.dashboard'); ?>
                </a>
            </li>


            <!--=======================Custom menus===============================-->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('order_access')): ?>
            <li class="nav-item ">
                <a class="nav-link <?php echo e($request->segment(1) == 'orders' ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.orders.index')); ?>">
                    <i class="nav-icon icon-bag"></i>
                    <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.orders.title'); ?></span>
                </a>
            </li>
            <?php endif; ?>
            <?php if($logged_in_user->isAdmin()): ?>
            <li class="nav-item ">
                <a class="nav-link <?php echo e($request->segment(2) == 'teachers' ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.teachers.index')); ?>">
                    <i class="nav-icon icon-directions"></i>
                    <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.teachers.title'); ?></span>
                </a>
            </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category_access')): ?>
            <li class="nav-item ">
                <a class="nav-link <?php echo e($request->segment(2) == 'categories' ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.categories.index')); ?>">
                    <i class="nav-icon icon-folder-alt"></i>
                    <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.categories.title'); ?></span>
                </a>
            </li>
            <?php endif; ?>
            <?php if((!$logged_in_user->hasRole('student')) && ($logged_in_user->hasRole('teacher') ||
            $logged_in_user->isAdmin() ||
            $logged_in_user->hasAnyPermission(['course_access','lesson_access','test_access','question_access','textgroup_access','bundle_access']))): ?>
            

            <li
                class="nav-item nav-dropdown <?php echo e(active_class(Active::checkUriPattern(['user/courses*','user/lessons*','user/tests*','user/questions*','user/live-lessons*','user/live-lesson-slots*']), 'open')); ?>">
                <a class="nav-link nav-dropdown-toggle <?php echo e(active_class(Active::checkUriPattern('admin/*'))); ?>" href="#">
                    <i class="nav-icon icon-puzzle"></i> <?php echo app('translator')->get('menus.backend.sidebar.courses.management'); ?>


                </a>

                <ul class="nav-dropdown-items">

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('course_access')): ?>
                    <li class="nav-item ">
                        <a class="nav-link <?php echo e($request->segment(2) == 'courses' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.courses.index')); ?>">
                            <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.courses.title'); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lesson_access')): ?>
                    <li class="nav-item ">
                        <a class="nav-link <?php echo e($request->segment(2) == 'lessons' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.lessons.index')); ?>">
                            <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.lessons.title'); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('test_access')): ?>
                    <li class="nav-item ">
                        <a class="nav-link <?php echo e($request->segment(2) == 'tests' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.tests.index')); ?>">
                            <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.tests.title'); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('course_access')): ?>
                    <li class="nav-item ">
                        <a class="nav-link <?php echo e($request->segment(2) == 'reorder-lesson-test' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.courses.reorder_lesson_test')); ?>">
                            <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.reoder-lesson-test.title'); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>


                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('question_access')): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($request->segment(2) == 'questions' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.questions.index')); ?>">
                            <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.questions.title'); ?></span>
                        </a>
                    </li>

                    <?php endif; ?>

                    
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($request->segment(2) == 'textgroups' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.textgroups.index')); ?>">
                            <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.textgroups.title'); ?></span>
                        </a>
                    </li>
                    

                    <li class="nav-item">
                        <a class="nav-link <?php echo e($request->segment(2) == 'testreports' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.testreports.index')); ?>">
                            <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.reports.title'); ?></span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?php echo e($request->segment(2) == 'charts' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.charts.index')); ?>">
                            <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.charts-tables.title'); ?></span>
                        </a>
                    </li>


                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('live_lesson_access')): ?>
                    <li class="nav-item ">
                        <a class="nav-link <?php echo e($request->segment(2) == 'live-lessons' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.live-lessons.index')); ?>">
                            <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.live_lessons.title'); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('live_lesson_slot_access')): ?>
                    <li class="nav-item ">
                        <a class="nav-link <?php echo e($request->segment(2) == 'live-lesson-slots' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.live-lesson-slots.index')); ?>">
                            <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.live_lesson_slots.title'); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>

                </ul>
            </li>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('bundle_access')): ?>
            <li class="nav-item ">
                <a class="nav-link <?php echo e($request->segment(2) == 'bundles' ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.bundles.index')); ?>">
                    <i class="nav-icon icon-layers"></i>
                    <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.bundles.title'); ?></span>
                </a>
            </li>
            <?php endif; ?>
            <?php if($logged_in_user->hasRole('teacher') || $logged_in_user->isAdmin()): ?>
            <li class="nav-item nav-dropdown <?php echo e(active_class(Active::checkUriPattern(['user/reports*']), 'open')); ?>">
                <a class="nav-link nav-dropdown-toggle <?php echo e(active_class(Active::checkUriPattern('admin/*'))); ?>" href="#">
                    <i class="nav-icon icon-pie-chart"></i><?php echo app('translator')->get('menus.backend.sidebar.reports.title'); ?>

                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item ">
                        <a class="nav-link <?php echo e($request->segment(1) == 'sales' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.reports.sales')); ?>">
                            <?php echo app('translator')->get('menus.backend.sidebar.reports.sales'); ?>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link <?php echo e($request->segment(1) == 'students' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.reports.students')); ?>"><?php echo app('translator')->get('menus.backend.sidebar.reports.students'); ?>
                        </a>
                    </li>
                </ul>
            </li>
            <?php endif; ?>
            <?php endif; ?>








            <?php if($logged_in_user->isAdmin() ||
            $logged_in_user->hasAnyPermission(['blog_access','page_access','reason_access'])): ?>
            <li
                class="nav-item nav-dropdown <?php echo e(active_class(Active::checkUriPattern(['user/contact','user/sponsors*','user/testimonials*','user/faqs*','user/footer*','user/blogs','user/sitemap*']), 'open')); ?>">
                <a class="nav-link nav-dropdown-toggle <?php echo e(active_class(Active::checkUriPattern('admin/*'))); ?>" href="#">
                    <i class="nav-icon icon-note"></i> <?php echo app('translator')->get('menus.backend.sidebar.site-management.title'); ?>
                </a>

                <ul class="nav-dropdown-items">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('page_access')): ?>
                    <li class="nav-item ">
                        <a class="nav-link <?php echo e($request->segment(2) == 'pages' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.pages.index')); ?>">
                            <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.pages.title'); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('blog_access')): ?>
                    <li class="nav-item ">
                        <a class="nav-link <?php echo e($request->segment(2) == 'blogs' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.blogs.index')); ?>">
                            <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.blogs.title'); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('reason_access')): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e($request->segment(2) == 'reasons' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.reasons.index')); ?>">
                            <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.reasons.title'); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if($logged_in_user->isAdmin()): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(active_class(Active::checkUriPattern('admin/menu-manager'))); ?>"
                            href="<?php echo e(route('admin.menu-manager')); ?>">
                            <?php echo e(__('menus.backend.sidebar.menu-manager.title')); ?></a>
                    </li>


                    <li class="nav-item ">
                        <a class="nav-link <?php echo e(active_class(Active::checkUriPattern('admin/sliders*'))); ?>"
                            href="<?php echo e(route('admin.sliders.index')); ?>">
                            <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.hero-slider.title'); ?></span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link <?php echo e($request->segment(2) == 'sponsors' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.sponsors.index')); ?>">
                            <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.sponsors.title'); ?></span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link <?php echo e($request->segment(2) == 'testimonials' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.testimonials.index')); ?>">
                            <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.testimonials.title'); ?></span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link <?php echo e($request->segment(2) == 'forums-category' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.forums-category.index')); ?>">
                            <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.forums-category.title'); ?></span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link <?php echo e($request->segment(2) == 'faqs' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.faqs.index')); ?>">
                            <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.faqs.title'); ?></span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link <?php echo e($request->segment(2) == 'contact' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.contact-settings')); ?>">
                            <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.contact.title'); ?></span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link <?php echo e($request->segment(2) == 'newsletter' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.newsletter-settings')); ?>">
                            <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.newsletter-configuration.title'); ?></span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link <?php echo e($request->segment(2) == 'footer' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.footer-settings')); ?>">
                            <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.footer.title'); ?></span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link <?php echo e($request->segment(2) == 'sitemap' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.sitemap.index')); ?>">
                            <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.sitemap.title'); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>

                </ul>


            </li>
            <?php else: ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('blog_access')): ?>
            <li class="nav-item ">
                <a class="nav-link <?php echo e($request->segment(2) == 'blogs' ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.blogs.index')); ?>">
                    <i class="nav-icon icon-note"></i>
                    <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.blogs.title'); ?></span>
                </a>
            </li>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('reason_access')): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo e($request->segment(2) == 'reasons' ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.reasons.index')); ?>">
                    <i class="nav-icon icon-layers"></i>
                    <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.reasons.title'); ?></span>
                </a>
            </li>
            <?php endif; ?>
            <?php endif; ?>

            <li class="nav-item ">
                <a class="nav-link <?php echo e($request->segment(1) == 'messages' ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.messages')); ?>">
                    <i class="nav-icon icon-envelope-open"></i> <span
                        class="title"><?php echo app('translator')->get('menus.backend.sidebar.messages.title'); ?></span>
                </a>
            </li>
            <?php if($logged_in_user->hasRole('student')): ?>
            <li class="nav-item ">
                <a class="nav-link <?php echo e($request->segment(1) == 'invoices' ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.invoices.index')); ?>">
                    <i class="nav-icon icon-notebook"></i> <span
                        class="title"><?php echo app('translator')->get('menus.backend.sidebar.invoices.title'); ?></span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link <?php echo e($request->segment(1) == 'certificates' ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.certificates.index')); ?>">
                    <i class="nav-icon icon-badge"></i> <span
                        class="title"><?php echo app('translator')->get('menus.backend.sidebar.certificates.title'); ?></span>
                </a>
            </li>
            <?php endif; ?>
            <?php if($logged_in_user->hasRole('teacher')): ?>
            <li class="nav-item ">
                <a class="nav-link <?php echo e($request->segment(1) == 'reviews' ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.reviews.index')); ?>">
                    <i class="nav-icon icon-speech"></i> <span
                        class="title"><?php echo app('translator')->get('menus.backend.sidebar.reviews.title'); ?></span>
                </a>
            </li>
            <?php endif; ?>

            <?php if($logged_in_user->isAdmin()): ?>
            <li class="nav-item ">
                <a class="nav-link <?php echo e($request->segment(1) == 'contact-requests' ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.contact-requests.index')); ?>">
                    <i class="nav-icon icon-envelope-letter"></i>
                    <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.contacts.title'); ?></span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link <?php echo e($request->segment(1) == 'contact-requests' ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.coupons.index')); ?>">
                    <i class="nav-icon icon-star"></i>
                    <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.coupons.title'); ?></span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link <?php echo e($request->segment(1) == 'contact-requests' ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.tax.index')); ?>">
                    <i class="nav-icon icon-credit-card"></i>
                    <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.tax.title'); ?></span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link <?php echo e($request->segment(1) == 'contact-requests' ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.payments.requests')); ?>">
                    <i class="nav-icon icon-people"></i>
                    <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.payments_requests.title'); ?></span>
                </a>
            </li>
            <?php endif; ?>
            <li class="nav-item ">
                <a class="nav-link <?php echo e($request->segment(1) == 'account' ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.account')); ?>">
                    <i class="nav-icon icon-key"></i>
                    <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.account.title'); ?></span>
                </a>
            </li>
           
           
            <?php if($logged_in_user->hasRole('student')): ?>
            <li class="nav-item ">
                <a class="nav-link <?php echo e($request->segment(1) == 'subscriptions' ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.subscriptions')); ?>">
                    <i class="nav-icon fas fa-briefcase"></i>
                    <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.subscription.title'); ?></span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link <?php echo e($request->segment(1) == 'wishlist' ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.wishlist.index')); ?>">
                    <i class="nav-icon fas fa-heart"></i>
                    <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.wishlist.title'); ?></span>
                </a>
            </li>

            <!-- <li class="nav-item ">
                <a class="nav-link <?php echo e($request->segment(1) == 'reports' ? 'active' : ''); ?>"
                   href="<?php echo e(url('user/testreports/studentreport')); ?>">
                    <i class="nav-icon fas fa-heart"></i>
                    <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.reports.title'); ?></span>
                </a>
            </li> -->
            
            <li class="nav-item nav-dropdown <?php echo e($request->segment(1) == 'reports' ? 'active' : ''); ?>">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon fas fa-heart"></i> <?php echo app('translator')->get('menus.backend.sidebar.reports.title'); ?>
                </a>
                <ul class="nav-dropdown-items">
                <li class="nav-item nav-dropdown <?php echo e($request->segment(1) == 'reports' ? 'active' : ''); ?>">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="nav-icon fas fa-download "></i> Reports 
                        </a>
                        <ul class="nav-dropdown-items">

                            <?php $__currentLoopData = $sidebarData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sidemenus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="nav-item nav-dropdown <?php echo e($request->segment(1) == 'reports' ? 'active' : ''); ?>">
                                 <a class="nav-link nav-dropdown-toggle" href="#">
                                    <i class="nav-icon fas fa-file-alt"></i><?php echo e($sidemenus['title']); ?>

                                </a>
                                <ul class="nav-dropdown-items">

                             <?php $__currentLoopData = $sidemenus['tests']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="nav-item" style="margin-left: 35px;">
                                <!-- <a download class="nav-link" href="<?php echo e(asset('/').'/'.$ts['report_pdf']); ?>"> -->
                                    <a  class="nav-link" href="<?php echo e(route('pdf.showreport',['course_id' => $sidemenus['id'],'slug'=>$ts['slug'],'test_id'=>$ts['id']])); ?>">
                                    <?php echo e($ts['title']); ?>

                                </a>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </li>
                             <li class="nav-item nav-dropdown <?php echo e($request->segment(1) == 'reports' ? 'active' : ''); ?>">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="nav-icon fas fa-download "></i> Domande
                        </a>
                        <ul class="nav-dropdown-items">

                            <?php $__currentLoopData = $sidebarData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sidemenus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="nav-item nav-dropdown <?php echo e($request->segment(1) == 'reports' ? 'active' : ''); ?>">
                                 <a class="nav-link nav-dropdown-toggle" href="#">
                                    <i class="nav-icon fas fa-file-alt"></i><?php echo e($sidemenus['title']); ?>

                                </a>
                                <ul class="nav-dropdown-items">

                             <?php $__currentLoopData = $sidemenus['tests']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="nav-item" style="margin-left: 35px;">
                                <!-- <a download class="nav-link" href="<?php echo e(asset('/').'/'.$ts['questions_ans_pdf']); ?>"> -->
                                    <a  class="nav-link" href="<?php echo e(route('pdf.show',['course_id' => $sidemenus['id'],'slug'=>$ts['slug'],'test_id'=>$ts['id']])); ?>">
                                    <?php echo e($ts['title']); ?>

                                </a>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </li>
                 

                </ul>
            </li>
            <?php endif; ?>
            <?php if($logged_in_user->isAdmin()): ?>
<!-- 
            <li class="nav-title">
                Time limit for answer
            </li> -->
            <li class="nav-title">
                <?php echo app('translator')->get('menus.backend.sidebar.system'); ?>
            </li>

            <li
                class="nav-item nav-dropdown <?php echo e(active_class(Active::checkUriPattern(['admin/stripe*','admin/stripe/plans*']), 'open')); ?>">
                <a class="nav-link nav-dropdown-toggle <?php echo e(active_class(Active::checkUriPattern('admin/stripe*'))); ?>"
                    href="#">
                    <i class="nav-icon fab fa-stripe"></i> <?php echo app('translator')->get('menus.backend.stripe.title'); ?>
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(active_class(Active::checkUriPattern('admin/stripe/plans*'))); ?>"
                            href="<?php echo e(route('admin.stripe.plans.index')); ?>">
                            <?php echo app('translator')->get('menus.backend.stripe.plan'); ?>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown <?php echo e(active_class(Active::checkUriPattern('admin/auth*'), 'open')); ?>">
                <a class="nav-link nav-dropdown-toggle <?php echo e(active_class(Active::checkUriPattern('admin/auth*'))); ?>"
                    href="#">
                    <i class="nav-icon icon-user"></i> <?php echo app('translator')->get('menus.backend.access.title'); ?>

                    <?php if($pending_approval > 0): ?>
                    <span class="badge badge-danger"><?php echo e($pending_approval); ?></span>
                    <?php endif; ?>
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(active_class(Active::checkUriPattern('admin/auth/user*'))); ?>"
                            href="<?php echo e(route('admin.auth.user.index')); ?>">
                            <?php echo app('translator')->get('labels.backend.access.users.management'); ?>

                            <?php if($pending_approval > 0): ?>
                            <span class="badge badge-danger"><?php echo e($pending_approval); ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(active_class(Active::checkUriPattern('admin/auth/role*'))); ?>"
                            href="<?php echo e(route('admin.auth.role.index')); ?>">
                            <?php echo app('translator')->get('labels.backend.access.roles.management'); ?>
                        </a>
                    </li>
                </ul>
            </li>


            <!--==================================================================-->
            <li class="divider"></li>

            <li class="nav-item nav-dropdown <?php echo e(active_class(Active::checkUriPattern('admin/*'), 'open')); ?>">
                <a class="nav-link nav-dropdown-toggle <?php echo e(active_class(Active::checkUriPattern('admin/settings*'))); ?>"
                    href="#">
                    <i class="nav-icon icon-settings"></i> <?php echo app('translator')->get('menus.backend.sidebar.settings.title'); ?>
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(active_class(Active::checkUriPattern('admin/settings'))); ?>"
                            href="<?php echo e(route('admin.general-settings')); ?>">
                            <?php echo app('translator')->get('menus.backend.sidebar.settings.general'); ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(active_class(Active::checkUriPattern('admin/log-viewer/logs*'))); ?>"
                            href="<?php echo e(route('admin.social-settings')); ?>">
                            <?php echo app('translator')->get('menus.backend.sidebar.settings.social-login'); ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(active_class(Active::checkUriPattern('admin/settings/zoom-settings*'))); ?>"
                            href="<?php echo e(route('admin.zoom-settings')); ?>">
                            <?php echo app('translator')->get('menus.backend.sidebar.settings.zoom_setting'); ?>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link <?php echo e($request->segment(1) == 'account' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.time_limit')); ?>">
                            <i class="nav-icon icon-key"></i>
                            <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.timelimmit.title'); ?></span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item nav-dropdown <?php echo e(active_class(Active::checkUriPattern('admin/log-viewer*'), 'open')); ?>">
                <a class="nav-link nav-dropdown-toggle <?php echo e(active_class(Active::checkUriPattern('admin/log-viewer*'))); ?>"
                    href="#">
                    <i class="nav-icon icon-list"></i> <?php echo app('translator')->get('menus.backend.sidebar.debug-site.title'); ?>
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(active_class(Active::checkUriPattern('admin/log-viewer'))); ?>"
                            href="<?php echo e(route('log-viewer::dashboard')); ?>">
                            <?php echo app('translator')->get('menus.backend.log-viewer.dashboard'); ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(active_class(Active::checkUriPattern('admin/log-viewer/logs*'))); ?>"
                            href="<?php echo e(route('log-viewer::logs.list')); ?>">
                            <?php echo app('translator')->get('menus.backend.log-viewer.logs'); ?>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item ">
                <a class="nav-link <?php echo e($request->segment(1) == 'translation-manager' ? 'active' : ''); ?>"
                    href="<?php echo e(asset('user/translations')); ?>">
                    <i class="nav-icon icon-docs"></i>
                    <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.translations.title'); ?></span>
                </a>
            </li>

            <li class="nav-item ">
                <a class="nav-link <?php echo e($request->segment(1) == 'backup' ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.backup')); ?>">
                    <i class="nav-icon icon-shield"></i>
                    <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.backup.title'); ?></span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link <?php echo e($request->segment(1) == 'update-theme' ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.update-theme')); ?>">
                    <i class="nav-icon icon-refresh"></i>
                    <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.update.title'); ?></span>
                </a>
            </li>
            <?php endif; ?>

            <?php if($logged_in_user->hasRole('teacher')): ?>
            <li class="nav-item ">
                <a class="nav-link <?php echo e($request->segment(2) == 'payments' ? 'active' : ''); ?>"
                    href="<?php echo e(route('admin.payments')); ?>">
                    <i class="nav-icon icon-wallet"></i>
                    <span class="title"><?php echo app('translator')->get('menus.backend.sidebar.payments.title'); ?></span>
                </a>
            </li>
            <?php endif; ?>

        </ul>
    </nav>

    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
<!--sidebar--><?php /**PATH /home/rvtsmdqo/diagnosiaziendale.it/resources/views/backend/includes/sidebar.blade.php ENDPATH**/ ?>