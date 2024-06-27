<?php
$course_details = $this->crud_model->get_course_by_id($course_id)->row_array();
$instructor_details = $this->user_model->get_teachers($course_details['teacher']);
$teachers_ids = $course_details['teacher'] ? explode(',', $course_details['teacher']) : [];
$teachers_names = $instructor_details ? explode(',', $instructor_details) : [];
?>
<style>
    .both_container{
        direction: rtl;
    }
    .register_container,.course_details_container{
        direction: ltr;
    }
    .rtl .both_container{
        direction: ltr;
    }
    .rtl .register_container,.rtl .course_details_container{
        direction: rtl;
    }
</style>


<section class="category-header-area">
    <div class="container-lg">
        <div class="row">
            <div class="col">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo site_url('home'); ?>"><i class="fas fa-home"></i></a></li>
                        <?php if ($course_details['semester_id'] == 0) { ?>
                            <li class="breadcrumb-item">
                                <a href="<?= isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '' ?>">
                                    <?php echo $this->lang->line('courses'); ?>
                                </a>
                            </li>
                        <?php } else { ?>
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('home/institute') ?>">
                                    <?php echo $this->lang->line('institute'); ?>
                                </a>
                            </li>
                            <?php
                            $semester = $this->db->get_where('semesters', array('id' => $course_details['semester_id']))->row();
                            if ($semester) {
                                ?>
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('home/courses/0/' . $course_details['semester_id']) ?>">
                                        <?php echo $semester->title; ?>
                                    </a>
                                </li>
                            <?php } ?>

                        <?php } ?>
                        <li class="breadcrumb-item active">
                            <?= $course_details['subject_name'] ?>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>


<section class="course-header-area">
    <div class="container">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="course-header-wrap">
                    <h1 class="title"><?php echo $course_details['subject_name']; ?></h1>
                    <p class="subtitle"><?php echo substr($course_details['subject_description'], 0, 100); ?></p>
                    <br/>
                    <?php
                    if ($course_details['subject_description'] == '') {
                        echo '<br/><br/>';
                    }
                    ?>
                    <div class="rating-row">
                                                                                               ?></span><span>(<?php //echo $number_of_ratings . ' ' . $this->lang->line('ratings');                                                                           ?>)</span>-->
                        <span class="enrolled-num">
                            <?php
                            $number_of_enrolments = $this->crud_model->enrol_history($course_details['id'])->num_rows();
                            echo $number_of_enrolments . ' ' . $this->lang->line('students_enrolled');
                            ?>
                        </span>
                    </div>
                    <div class="created-row">
                        <span class="created-by">
                            <?php echo $this->lang->line('created_by'); ?>
                            <?php
                            $i = 0;
                            foreach ($teachers_ids as $teacher) {
                                if ($teacher) {
                                    ?>
                                    <a href="<?php echo site_url('home/instructor_page/' . $teacher); ?>"><?php echo $teachers_names[$i]; ?></a>
                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                        </span>
                        <?php //if ($course_details['update_at']):    ?>
                        <span class="last-updated-date"><?php echo $this->lang->line('last_updated') . ' ' . date('D, d-M-Y', strtotime($course_details['update_at'])); ?></span>
                        <?php //else:    ?>
                        <!--<span class="last-updated-date"><?php //echo $this->lang->line('last_updated') . ' ' . date('D, d-M-Y', $course_details['date_added']);                                                                    ?></span>-->
                        <?php //endif;     ?>
                        <!--<span class="comment"><i class="fas fa-comment"></i><?php //echo ucfirst($course_details['language']);                                                                      ?></span>-->
                    </div>
                </div>
            </div>
            <div class="col-lg-4">

            </div>
        </div>
    </div>
</section>


<section class="course-content-area">
    <div class="container both_container">
        <div class="row">

            <div class="col-lg-4 register_container">
                <div class="course-sidebar natural">
                    <?php //if ($course_details['video_url'] != ""):       ?>
                    <div class="preview-video-box">
                        <a data-toggle="modal" data-target="#CoursePreviewModal">
                            <img src="<?php echo $this->crud_model->get_course_thumbnail_url($course_details['image']); ?>" alt="" width="100%" class="img-fluid">
<!--                            <span class="preview-text"><?php //echo $this->lang->line('preview_this_course');                                                              ?></span>
                            <span class="play-btn"></span>-->
                        </a>
                    </div>
                    <?php //endif;       ?>
                    <div class="course-sidebar-text-box">
                       
                        <?php
                        $enrol_rec = $this->crud_model->enrol_rec($course_details['id']);
                        if ($enrol_rec && $enrol_rec->certificate_id && $course_details['show_certificates']) {
                            ?>

                            <div class="already_purchased mb-2">
                                <a <?= $course_details['certificate'] ? 'href="' . base_url() . 'home/download_certificate/' . base64_encode($course_details['id']) . '"' : ''; ?> title="<?php $course_details['certificate'] ? $this->lang->line('download_certificate') : '' ?> " class="btn-success"><?php echo $this->lang->line('you_pass_subject'); ?>
                                    <?php if ($course_details['certificate']) { ?>
                                        <?php echo $this->lang->line('you_can_download_cert_from_here'); ?>
                                        <i class="fas fa-download float-right mx-2"></i>
                                    <?php } ?>
                                </a>
                            </div>
                        <?php } else { ?>
                            <?php if (is_purchased($course_details['id'])) : ?>
                        
                                <span> <?= $this->lang->line('already_purchased') ?> </span>
                                <?php if ($course_details['semester_id'] == 0 || ($course_details['semester_id'] != 0 && course_available($course_details['id']))) { ?>
                                    <div class="already_purchased mb-2">
                                        <a href="<?php echo site_url('home/lesson/' . rawurlencode(slugify($course_details['subject_name'])) . '/' . $course_details['id']); ?>" ><?php echo $this->lang->line('start_lesson'); ?></a>
                                    </div>
                                <?php } else { ?>
                                    <br/>
                                    <span class="label label-danger label-inline font-weight-bold text-danger"> <?= $this->lang->line('course_not_available_now') ?> </span>
                                <?php } ?>
                                <?php if ($course_details['semester_id'] == 0) { ?>
                                    <div class="mb-2">
                                        <a href="<?php echo site_url('home/cancel_enrolled/' . $course_details['id']); ?>" class="btn btn-danger btn-block" ><?php echo $this->lang->line('cancel_enrollment'); ?></a>
                                    </div>
                                <?php } ?>
                            <?php else: ?>

                              
                                <?php if (!is_purchased($course_details['id'])) : ?>
                                    <div class="buy-btns">
                                        <?php if ($this->session->userdata('user_login') != 1): ?>
                                            <a href = "#" class="btn btn-buy-now" onclick="handleEnrolledButton()"><?php echo $this->lang->line('enroll'); ?></a>
                                        <?php else: ?>
                                            <?php if ($course_details['semester_id'] == 0 || ($course_details['semester_id'] != 0 && course_available($course_details['id']))) { ?>
                                                <a href = "<?php echo site_url('home/get_enrolled_to_free_course/' . $course_details['id']); ?>" class="btn btn-buy-now"><?php echo $this->lang->line('enroll'); ?></a>
                                            <?php }else{ ?>
                                                <br/>
                                                <span class="label label-danger label-inline font-weight-bold text-danger"> <?= $this->lang->line('course_not_available_now') ?> </span>
                                            <?php } ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                               
                            <?php endif; ?>
                        <?php } ?>


                        <div class="includes">
                            <div class="title"><b><?php echo $this->lang->line('includes'); ?>:</b></div>
                            <ul>
                                <li><i class="far fa-file-video"></i>
                                    <?php
                                    echo $this->crud_model->get_total_duration_of_lesson_by_course_id($course_details['id']) . ' ' . $this->lang->line('on_demand_videos');
                                    ?>
                                </li>
                                <li><i class="far fa-file"></i><?php echo $this->crud_model->get_lessons('course', $course_details['id'])->num_rows() . ' ' . $this->lang->line('lessons'); ?></li>
                                <li><i class="far fa-compass"></i><?php echo $this->lang->line('full_lifetime_access'); ?></li>
                                <li><i class="fas fa-mobile-alt"></i><?php echo $this->lang->line('access_on_mobile_and_tv'); ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 course_details_container">

              
                <br>
                <div class="description-box view-more-parent" style="margin-top: 40px">
                    <div class="view-more" onclick="viewMore(this, 'hide')">+ <?php echo $this->lang->line('view_more'); ?></div>
                    <div class="description-title"><?php echo $this->lang->line('description'); ?></div>
                    <div class="description-content-wrap">
                        <div class="description-content">
                            <?php echo $course_details['subject_description']; ?>
                        </div>
                    </div>
                </div>
                <br/>

                <div class="about-instructor-box">
                    <div class="about-instructor-title">
                        <?php echo $this->lang->line('about_the_instructors'); ?>
                    </div>

                    <?php
                    $i = 0;
                    foreach ($teachers_ids as $teacher) {
                        if ($teacher) {
                            ?>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="about-instructor-image">
                                        <img src="<?php echo $this->user_model->get_user_image_url($teacher); ?>" alt="" class="img-fluid">
                                        <ul>
                           
                                            <li>
                                                <i class="fas fa-user"></i><b>
                                                    <?php
                                                    $course_ids = $this->crud_model->get_instructor_wise_courses($teacher, 'simple_array');
                                                    $this->db->select('student_id');
                                                    $this->db->distinct();
                                                    $this->db->where_in('subject_id', $course_ids);
                                                    echo $this->db->get_where('subject_enrolled', array('is_semester' => 0))->num_rows();
                                                    ?>
                                                </b> <?php echo $this->lang->line('students') ?></li>
                                            <li><i class="fas fa-play-circle"></i><b>
                                                    <?php echo $this->crud_model->get_instructor_wise_courses($teacher)->num_rows(); ?>
                                                </b> <?php echo $this->lang->line('courses'); ?></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="about-instructor-details view-more-parent">
                                        <div class="view-more" onclick="viewMore(this)">+ <?php echo $this->lang->line('view_more'); ?></div>

                                        <?php
                                        $teacher_details = $this->db->get_where('teacher', array('id' => $teacher))->row();
                                        if ($teacher_details) {
                                            ?>
                                            <div class="instructor-name">
                                                <a href="<?php echo site_url('home/instructor_page/' . $teacher); ?>"><?php echo $teachers_names[$i]; ?></a>
                                            </div>
                                            <div class="instructor-title">
                                                <?php echo $this->lang->line('teacher'); ?>
                                            </div>
                                            <div class="instructor-bio">
                                                <?php echo $teacher_details->cv; ?>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php if ($i != count($teachers_ids) - 1) { ?>
                                <br/>
                                <hr/>
                                <br/>
                                <?php
                            }
                            $i++;
                        }
                    }
                    ?>

                </div>

                <br/>

                <div class="course-curriculum-box" style="margin-top: 40px;">
                    <div class="course-curriculum-title clearfix">
                        <div class="title float-left"><?php echo $this->lang->line('curriculum_for_this_course'); ?></div>
                        <div class="float-right">
                            <span class="total-lectures">
                                <?php echo $this->crud_model->get_lessons('course', $course_details['id'])->num_rows() . ' ' . $this->lang->line('lessons'); ?>
                            </span>
                            <span class="total-time">
                                <?php
                                echo $this->crud_model->get_total_duration_of_lesson_by_course_id($course_details['id']);
                                ?>
                            </span>
                        </div>
                    </div>
                    <div class="course-curriculum-accordion">
                        <?php
                        $sections = $this->crud_model->get_section('course', $course_id)->result_array();
                        $counter = 0;
                        foreach ($sections as $section):
                            ?>
                            <div class="lecture-group-wrapper">
                                <div class="lecture-group-title clearfix" data-toggle="collapse" data-target="#collapse<?php echo $section['id']; ?>" aria-expanded="<?php
                                if ($counter == 0)
                                    echo 'true';
                                else
                                    echo 'false';
                                ?>">
                                    <div class="title float-left">
                                        <?php echo $section['name']; ?>
                                    </div>
                                    <div class="float-right">
                                        <span class="total-lectures">
                                            <?php echo $this->crud_model->get_lessons('section', $section['id'])->num_rows() . ' ' . $this->lang->line('lessons'); ?>
                                        </span>
                                        <span class="total-time">
                                            <?php echo $this->crud_model->get_total_duration_of_lesson_by_section_id($section['id']); ?>
                                        </span>
                                    </div>
                                </div>

                                <div id="collapse<?php echo $section['id']; ?>" class="lecture-list collapse <?php if ($counter == 0) echo 'show'; ?>">
                                    <ul>
                                        <?php
                                        // $lessons = $this->crud_model->get_lessons('section', $section['id'])->result_array();
                                        $this->load->model('Quiz_Model');
                                        $lessons = $this->Quiz_Model->get_section_contents($section['id']);
                                        foreach ($lessons as $lesson):
                                            $quiz_taken = $this->crud_model->is_quiz_taken($lesson->id, $this->session->userdata('user_id'));
                                            $is_quiz_tottaly_marked = $this->crud_model->is_quiz_tottaly_marked($lesson->id, $this->session->userdata('user_id'));

                                            if (isset($lesson->type)) {
                                                $is_quiz = 0;
                                                $type = $lesson->type == 2 ? 'list' : 'video';
                                                $show_result = 0;
                                            } else {
                                                $is_quiz = 1;
                                                $type = $quiz_taken && strpos($quiz_taken, '(') === false  ? 'quiz_taken' : 'quiz';
                                                $show_result = $lesson->answer_manually;
                                            }
                                            ?>
                                            <li class="lecture has-preview <?= $type ?>">
                                                <?php if ($course_details['semester_id'] == 0 || ($course_details['semester_id'] != 0 && course_available($course_details['id']))) { ?>
                                                    <a href='<?= base_url() ?>home/lesson/<?= slugify($course_details['subject_name']) ?>/<?= $course_details['id'] ?>/<?= $lesson->id ?>/<?= $is_quiz ?>'>
                                                <?php } ?>
                                                    <span class="lecture-title "><?php echo $lesson->name; ?><!--<?//= $quiz_taken && $show_result && $is_quiz_tottaly_marked ? '<br/><span class="mx-2" title="' . $this->lang->line('quiz_result') . '">' . $quiz_taken . '</span>' : '' ?>--></span>
                                                <?php if ($course_details['semester_id'] == 0 || ($course_details['semester_id'] != 0 && course_available($course_details['id']))) { ?>
                                                    </a>
                                                <?php } ?>
                                                <?php if (isset($lesson->duration)) { ?>
                                                    <span class="lecture-time float-right"><?php echo isset($lesson->duration) && $lesson->duration ? readable_time_for_humans($lesson->duration) : ''; ?></span>
                                                    <?php
                                                } else {
                                                    $qu_count = $lesson->limit_question ? $lesson->limit_question : $lesson->total_question;
                                                    ?>

                                                    <span class="lecture-time float-right" style="min-width: 20%">
                                                        
                                                        <?php echo $lesson->total_time . ' ' . $this->lang->line('min') . ' / <i class="fa fa-question"></i> ' . $qu_count . ' Q';
                                                        ?>
                                                    </span>
                                                <?php } ?>
        <!-- <span class="lecture-preview float-right" data-toggle="modal" data-target="#CoursePreviewModal">Preview</span> -->
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                            <?php
                            $counter++;
                        endforeach;
                        ?>
                    </div>
                </div>       
           </div>
        </div>
    </div>
</section>

<!-- Modal -->

<!-- Modal -->

<style media="screen">
    .embed-responsive-16by9::before {
        padding-top : 0px;
    }
</style>
<script type="text/javascript">
    function handleCartItems(elem) {
        url1 = '<?php echo site_url('home/handleCartItems'); ?>';
        url2 = '<?php echo site_url('home/refreshWishList'); ?>';
        $.ajax({
            url: url1,
            type: 'POST',
            data: {course_id: elem.id,'<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash() ?>'},
            success: function (response)
            {
                $('#cart_items').html(response);
                if ($(elem).hasClass('addedToCart')) {
                    $(elem).removeClass('addedToCart')
                    $(elem).text("<?php echo $this->lang->line('add_to_cart'); ?>");
                } else {
                    $(elem).addClass('addedToCart')
                    $(elem).text("<?php echo $this->lang->line('added_to_cart'); ?>");
                }
                $.ajax({
                    url: url2,
                    type: 'POST',
                    success: function (response)
                    {
                        $('#wishlist_items').html(response);
                    }
                });
            }
        });
    }

    function handleBuyNow(elem) {

        url1 = '<?php echo site_url('home/handleCartItemForBuyNowButton'); ?>';
        url2 = '<?php echo site_url('home/refreshWishList'); ?>';
        urlToRedirect = '<?php echo site_url('home/shopping_cart'); ?>';
        var explodedArray = elem.id.split("_");
        var course_id = explodedArray[1];

        $.ajax({
            url: url1,
            type: 'POST',
            data: {course_id: course_id, '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash() ?>'},
            success: function (response)
            {
                $('#cart_items').html(response);
                $.ajax({
                    url: url2,
                    type: 'POST',
                    success: function (response)
                    {
                        $('#wishlist_items').html(response);
                        toastr.warning('<?php echo $this->lang->line('please_wait') . '....'; ?>');
                        setTimeout(
                                function ()
                                {
                                    window.location.replace(urlToRedirect);
                                }, 1500);
                    }
                });
            }
        });
    }

    function handleEnrolledButton() {
        $.ajax({
            url: '<?php echo site_url('home/isLoggedIn'); ?>',
            data: {'<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash() ?>'},
            success: function (response)
            {
                if (!response) {
                    window.location.replace("<?php echo site_url('login'); ?>");
                }
            }
        });
    }

    function handleAddToWishlist(elem) {
        $.ajax({
            url: '<?php echo site_url('home/handleWishList'); ?>',
            type: 'POST',
            data: {course_id: elem.id},
            success: function (response)
            {
                if (!response) {
                    window.location.replace("<?php echo site_url('login'); ?>");
                } else {
                    if ($(elem).hasClass('active')) {
                        $(elem).removeClass('active');
                        $(elem).text("<?php echo $this->lang->line('add_to_wishlist'); ?>");
                    } else {
                        $(elem).addClass('active');
                        $(elem).text("<?php echo $this->lang->line('added_to_wishlist'); ?>");
                    }
                    $('#wishlist_items').html(response);
                }
            }
        });
    }

    function pausePreview() {
        player.pause();
    }
</script>
