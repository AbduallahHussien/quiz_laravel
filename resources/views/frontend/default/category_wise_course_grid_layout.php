<style>
    .rtl .course_details, .rtl .start_lesson, .rtl .search_textbox {
        font-size: 12px !important;
    }
</style>
<div class="row">
    <?php
    foreach ($courses as $course):
        $teacher_ids = explode(',', $course['teacher']);
        $instructor_details = array();
        foreach ($teacher_ids as $teacher_id) {
            if ($teacher_id) {
                $instructor_details[] = $this->user_model->get_all_user($teacher_id)->row_array();
            }
        }
        ?>
        <div class="<?= $semester_id ? 'col-md-3 col-lg-3' : 'col-md-4 col-lg-4' ?>">
            <div class="course-box-wrap">
                <a href="<?php echo site_url('home/course/' . rawurlencode(slugify($course['subject_name'])) . '/' . $course['id']); ?>">
                    <div class="course-box">
                        <div class="course-image">
                            <img src="<?php echo $this->crud_model->get_course_thumbnail_url($course['image']); ?>" alt="" class="img-fluid" width="100%">
                        </div>
                        <div class="course-details">
                            <h5 class="title"><?php echo $course['subject_name']; ?></h5>
                            <p class="instructors">
                                <?php
                                foreach ($instructor_details as $instructor) {
                                    echo $this->session->userdata('language') == 'english' ? $instructor['name'] . ', ' : $instructor['arabic_name'] . ', ';
                                }
                                ?>
                            </p>

                            <div class="rating">
                                <p class="price text-right">
                                    <?php if ($course['whatsapp_link']) { ?>
                                        <span class="px-1" title="Whatsapp Link"><a href="<?= $course['whatsapp_link'] ?>" target=”_blank”><i class="fab fa-whatsapp"></i></a></span>
                                    <?php } ?>
                                    <?php if ($course['telegram_link']) { ?>
                                        <span class="px-1" title="Telegram Link"><a href="<?= $course['telegram_link'] ?>" target=”_blank”><i class="fab fa-telegram"></i></a></span>
                                    <?php } ?>
                                    <?php if ($course['youtube_link']) { ?>
                                        <span class="px-1" title="Youtube Link"><a href="<?= $course['youtube_link'] ?>" target=”_blank”><i class="fab fa-youtube"></i></a></span>
                                    <?php } ?>
                                    <?php if ($course['instagram_link']) { ?>
                                        <span class="px-1" title="Instagram Link"><a href="<?= $course['instagram_link'] ?>" target=”_blank”><i class="fab fa-instagram"></i></a></span>
                                    <?php } ?>
                                </p>
                            </div>


                        </div>
                        <?php if (isset($semester_id) && $semester_id && is_purchased($semester_id, 1)) { ?>
                            <div class="row" style="padding: 5px;">
                                <div class="col-md-6 pt-2">
                                    <a href="<?php echo site_url('home/course/' . rawurlencode(slugify($course['subject_name'])) . '/' . $course['id']); ?>" class="btn course_details"><?php echo $this->lang->line('course_detail'); ?></a>
                                </div>
                                <div class="col-md-6 pt-2 ">
                                    <a href="<?php echo site_url('home/lesson/' . rawurlencode(slugify($course['subject_name'])) . '/' . $course['id']); ?>" class="btn start_lesson"><?php echo $this->lang->line('start_lesson'); ?></a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
