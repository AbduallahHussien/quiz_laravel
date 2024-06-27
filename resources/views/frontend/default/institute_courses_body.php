<div class="row no-gutters" id = "my_courses_area">
    <?php
    foreach ($courses as $course_details):
       // $course_details = $this->crud_model->get_course_by_id($course_details['id'])->row_array();
        $instructor_details = $this->user_model->get_teachers($course_details['teacher']);
        ?>

        <div class="col-lg-3">
            <div class="course-box-wrap">
                <div class="course-box">
                    <a href="<?php echo $course_details['subject_status'] == 1 || ($course_details['subject_status'] == 2 && $course_details['scheduled_date'] <= date('Y-m-d')) ? site_url('home/lesson/' . rawurlencode(slugify($course_details['subject_name'])) . '/' . $course_details['id']) : site_url('home/course/' . rawurlencode(slugify($course_details['subject_name'])) . '/' . $course_details['id']); ?>" >
                        <div class="course-image">
                            <img src="<?php echo $this->crud_model->get_course_thumbnail_url($course_details['image']); ?>" alt="" class="img-fluid" width="100%">
                            <!--<span class="play-btn"></span>-->
                        </div>
                    </a>

                    <div class="" id = "course_info_view_<?php echo $course_details['id']; ?>">
                        <div class="course-details">
                            <a href="<?php echo $course_details['subject_status'] == 1 || ($course_details['subject_status'] == 2 && $course_details['scheduled_date'] <= date('Y-m-d')) ? site_url('home/course/' . rawurlencode(slugify($course_details['subject_name'])) . '/' . $course_details['id']) : site_url('home/course/' . rawurlencode(slugify($course_details['subject_name'])) . '/' . $course_details['id']); ?>" class="d-inline-block mb-2"><h5 class="title"><?php echo $course_details['subject_name']; ?></h5></a>
                            <!--<p><?//= $instructor_details ?></p>-->
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar progress-bar-striped blue-progressbar" role="progressbar" style="width: <?php echo course_progress($course_details['id']); ?>%" aria-valuenow="<?php echo course_progress($course_details['id']); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small><?php echo ceil(course_progress($course_details['id'])); ?>% <?php echo $this->lang->line('completed'); ?></small>
                            <!--                                    <div class="rating your-rating-box" style="position: unset; margin-top: -18px;">
                            
                            <?php
//                                        $get_my_rating = $this->crud_model->get_user_specific_rating('course', $course_details['id']);
//                                        for ($i = 1; $i < 6; $i++):
                            ?>
                            <?php //if ($i <= $get_my_rating['rating']):  ?>
                                                                            <i class="fas fa-star filled"></i>
                            <?php //else:  ?>
                                                                            <i class="fas fa-star"></i>
                            <?php //endif; ?>
                            <?php //endfor;  ?>
                                                 <p class="your-rating-text" id = "<?php //echo $course_details['id'];      ?>" onclick="getCourseDetailsForRatingModal(this.id)">
                                                    <span class="your"><?php //echo $this->lang->line('your');      ?></span>
                                                    <span class="edit"><?php //echo $this->lang->line('edit');     ?></span>
                            <?php //echo $this->lang->line('rating');  ?>
                                                </p> 
                                                                    <p class="your-rating-text">
                                                                        <a href="javascript::" id = "edit_rating_btn_<?php //echo $course_details['id'];      ?>" onclick="toggleRatingView('<?php echo $course_details['id']; ?>')" style="color: #2a303b"><?php echo $this->lang->line('edit_rating'); ?></a>
                                                                        <a href="javascript::" class="hidden" id = "cancel_rating_btn_<?php //echo $course_details['id'];      ?>" onclick="toggleRatingView('<?php echo $course_details['id']; ?>')" style="color: #2a303b"><?php echo $this->lang->line('cancel_rating'); ?></a>
                                                                    </p>
                                                                </div>-->
                        </div>
                        <div class="row" style="padding: 5px;">
                            <div class="col-md-6 pt-2">
                                <!--<a href="<?php //echo site_url('home/course/' . rawurlencode(slugify($course_details['subject_name'])) . '/' . $course_details['id']);      ?>" class="btn course_details"><?php //echo $this->lang->line('course_detail');      ?></a>-->
                            </div>
                            <div class="col-md-6 pt-2">
                                <!--<a href="<?php //echo site_url('home/lesson/' . rawurlencode(slugify($course_details['subject_name'])) . '/' . $course_details['id']);  ?>" class="btn start_lesson"><?php //echo $this->lang->line('start_learning');  ?></a>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>