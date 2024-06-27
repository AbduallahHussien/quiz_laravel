<!--<ul>-->
<style>
    .mr-3 {
        margin-right: 1rem;
    }
    .rtl .mr-3 {
        margin-right: 0rem !important;
        margin-left: 1rem;
    }
    .rtl .custom-radio:checked, .custom-radio:not(:checked){
        left: 9999px;
    }
</style>

<?php
foreach ($courses as $course):
    if ($course['subject_status'] == 3) {
        continue;
    }
    $teacher_ids = explode(',', $course['teacher']);
    $instructor_details = array();
    foreach ($teacher_ids as $teacher_id) {
        if ($teacher_id) {
            $instructor_details[] = $this->user_model->get_all_user($teacher_id)->row_array();
        }
    }
    $this->load->model('Quiz_Model');
    ?>

    <div class="row course_container mb-5 <?= $this->Quiz_Model->is_subject_passed($course['id']) ? 'passed_success' : '' ?>">
        <div class="img_container col-md-3 col-sm-5 col-5">
            <a href="<?php echo site_url('home/course/' . rawurlencode(slugify($course['subject_name'])) . '/' . $course['id']) ?>">
                <img src="<?php echo $this->crud_model->get_course_thumbnail_url($course['image']); ?>" alt="" class="img-fluid">
            </a>
        </div>
        <div class="col-md-6 col-sm-7 col-7 course_details_container">
            <h3 class="mt-3"><a href="<?php echo site_url('home/course/' . rawurlencode(slugify($course['subject_name'])) . '/' . $course['id']); ?>" class="course-title"><?php echo $course['subject_name'] ?></a></h3>
            <?php foreach ($instructor_details as $instructor) { ?>
                <a href="<?php echo site_url('home/instructor_page/' . $instructor['id']) ?>" class="course-instructor">
                    <span class="instructor-name"><?php echo $this->session->userdata('language') == 'english' ? $instructor['name'] : $instructor['arabic_name']; ?></span>
                </a>
            <?php } ?>

            <!--            <div class="course-subtitle">
            <?php //echo substr($course['subject_description'], 0, 100); ?>
                        </div>-->

            <div class="course-meta mt-4">
                <span class="mr-3"><i class="fas fa-play-circle"></i>&nbsp;
                    <?php
                    $number_of_lessons = $this->crud_model->get_lessons('course', $course['id'])->num_rows();
                    echo $number_of_lessons . ' ' . $this->lang->line('lessons');
                    ?>
                </span>
                <span class=""><i class="far fa-clock"></i>&nbsp;
                    <?php echo $this->crud_model->get_total_duration_of_lesson_by_course_id($course['id']); ?>
                </span>
                <!--<span class=""><i class="fas fa-closed-captioning"></i><?php //echo $this->lang->line($course['language']);                        ?></span>-->
                <!--<span class=""><i class="fa fa-level-up"></i><?php //echo $this->lang->line($course['level']);                        ?></span>-->
            </div>

            <div class="row mt-4" style="padding: 5px;">
                <div class="">
                    <?php if (isset($semester_id) && $semester_id && is_purchased($semester_id, 1)) { ?>
                        <a href="<?php echo site_url('home/course/' . rawurlencode(slugify($course['subject_name'])) . '/' . $course['id']); ?>" class="btn course_details"><?php echo $this->lang->line('course_detail'); ?></a>
                        <?php if (course_available($course['id'])) { ?>
                            <a href="<?php echo site_url('home/lesson/' . rawurlencode(slugify($course['subject_name'])) . '/' . $course['id']); ?>" class="btn start_lesson"><?php echo $this->lang->line('start_lesson'); ?></a>
                        <?php } ?>
                        <?php //} else { ?>
        <!--                                <span class="course_details"></span>
                <span class="start_lesson"></span>-->
                    <?php } ?> 
                </div>
            </div>

        </div>
    </div>

            <!--        <li class="<?= $this->Quiz_Model->is_subject_passed($course['id']) ? 'passed_success' : '' ?>">
                        <div class="course-box-2">
                            <div class="course-image float-left">
                                <a href="<?php echo site_url('home/course/' . rawurlencode(slugify($course['subject_name'])) . '/' . $course['id']) ?>">
                                    <img src="<?php echo $this->crud_model->get_course_thumbnail_url($course['image']); ?>" alt="" class="img-fluid">
                                </a>
                            </div>
                            <div class="course-details float-left">
                                <h3 class="mt-3"><a href="<?php echo site_url('home/course/' . rawurlencode(slugify($course['subject_name'])) . '/' . $course['id']); ?>" class="course-title"><?php echo $course['subject_name'] ?></a></h3>
    <?php foreach ($instructor_details as $instructor) { ?>
                                                <a href="<?php echo site_url('home/instructor_page/' . $instructor['id']) ?>" class="course-instructor">
                                                    <span class="instructor-name"><?php echo $this->session->userdata('language') == 'english' ? $instructor['name'] : $instructor['arabic_name']; ?></span>
                                                </a>
    <?php } ?>

                                <div class="course-subtitle">
    <?php //echo substr($course['subject_description'], 0, 100); ?>
                                </div>

                                <div class="course-meta">
                                    <span class=""><i class="fas fa-play-circle"></i>
    <?php
    $number_of_lessons = $this->crud_model->get_lessons('course', $course['id'])->num_rows();
    echo $number_of_lessons . ' ' . $this->lang->line('lessons');
    ?>
                                    </span>
                                    <span class=""><i class="far fa-clock"></i>
    <?php echo $this->crud_model->get_total_duration_of_lesson_by_course_id($course['id']); ?>
                                    </span>
                                    <span class=""><i class="fas fa-closed-captioning"></i><?php //echo $this->lang->line($course['language']);                        ?></span>
                                    <span class=""><i class="fa fa-level-up"></i><?php //echo $this->lang->line($course['level']);                        ?></span>
                                </div>

                                <div class="row mt-4" style="padding: 5px;">
                                    <div class="col-md-12 <?= isset($semester_id) && $semester_id && is_purchased($semester_id, 1) ? '' : 'btns_container' ?>"  >
    <?php if (isset($semester_id) && $semester_id && is_purchased($semester_id, 1)) { ?>
                                                        <a href="<?php echo site_url('home/course/' . rawurlencode(slugify($course['subject_name'])) . '/' . $course['id']); ?>" class="btn course_details"><?php echo $this->lang->line('course_detail'); ?></a>
                                                        <a href="<?php echo site_url('home/lesson/' . rawurlencode(slugify($course['subject_name'])) . '/' . $course['id']); ?>" class="btn start_lesson"><?php echo $this->lang->line('start_lesson'); ?></a>
        <?php //} else { ?>
                                                                <span class="course_details"></span>
                                                        <span class="start_lesson"></span>
    <?php } ?> 
                                    </div>
                                </div>


                            </div>

                            <div class="course-price-rating">
    <?php if ($course['whatsapp_link']) { ?>
                                                <span class="px-1w5" title="Whatsapp Link"><a href="<?= $course['whatsapp_link'] ?>" target=”_blank”><i class="fab fa-whatsapp"></i></a></span>
    <?php } ?>
    <?php if ($course['telegram_link']) { ?>
                                                <span class="px-1w5" title="Telegram Link"><a href="<?= $course['telegram_link'] ?>" target=”_blank”><i class="fab fa-telegram"></i></a></span>
    <?php } ?>
    <?php if ($course['youtube_link']) { ?>
                                                <span class="px-1w5" title="Youtube Link"><a href="<?= $course['youtube_link'] ?>" target=”_blank”><i class="fab fa-youtube"></i></a></span>
    <?php } ?>
    <?php if ($course['instagram_link']) { ?>
                                                <span class="px-1w5" title="Instagram Link"><a href="<?= $course['instagram_link'] ?>" target=”_blank”><i class="fab fa-instagram"></i></a></span>
    <?php } ?>

                                                    <div class="course-price">
    <?php //if ($course['is_free_course'] == 1):  ?>
                                                            <span class="current-price"><?php //echo $this->lang->line('free');                       ?></span>
    <?php //else:  ?>
    <?php //if ($course['discount_flag'] == 1): ?>
                                                                <span class="current-price"><?php //echo currency($course['discounted_price']);                       ?></span>
                                                                <span class="original-price"><?php //echo currency($course['price']);                        ?></span>
    <?php //else:  ?>
                                                                <span class="current-price"><?php //echo currency($course['price']);                       ?></span>
    <?php //endif;  ?>
    <?php //endif; ?>
                                                    </div>
                                                    <div class="rating">
    <?php
//                        $total_rating = $this->crud_model->get_ratings('course', $course['id'], true)->row()->rating;
//                        $number_of_ratings = $this->crud_model->get_ratings('course', $course['id'])->num_rows();
//                        if ($number_of_ratings > 0) {
//                            $average_ceil_rating = ceil($total_rating / $number_of_ratings);
//                        } else {
//                            $average_ceil_rating = 0;
//                        }
//
//                        for ($i = 1; $i < 6; $i++):
    ?>
    <?php //if ($i <= $average_ceil_rating): ?>
                                                                <i class="fas fa-star filled"></i>
    <?php //else:  ?>
                                                                <i class="fas fa-star"></i>
    <?php //endif;  ?>
    <?php //endfor; ?>
                                                        <span class="d-inline-block average-rating"><?php //echo $average_ceil_rating;                       ?></span>
                                                    </div>
                                                    <div class="rating-number">
    <?php //echo $this->crud_model->get_ratings('course', $course['id'])->num_rows() . ' ' . $this->lang->line('ratings');  ?>
                                                    </div>
                            </div>
                        </div>
                    </li>-->
<?php endforeach; ?>
<!--</ul>-->
