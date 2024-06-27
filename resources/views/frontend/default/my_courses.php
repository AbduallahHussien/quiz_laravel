<?php
$my_courses = $this->user_model->my_courses()->result_array();
$categories = array();
foreach ($my_courses as $my_course) {
    $course_details = $this->crud_model->get_course_by_id($my_course['subject_id'])->row_array();
    if (!in_array($course_details['cat_id'], $categories)) {
        array_push($categories, $course_details['cat_id']);
    }
}
?>

<section class="category-header-area">
    <div class="container-lg">
        <div class="row">
            <div class="col">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo site_url('home'); ?>"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('home/courses') ?>">
                                <?php echo $this->lang->line('courses'); ?>
                            </a>
                        </li>

                        <li class="breadcrumb-item active">
                            <a href="">
                                <?php echo $this->lang->line('my_educational_board'); ?>
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<?php //include "profile_menus.php";  ?>
<div class="container">
    <ul class="nav nav-tabs nav-justified mt-5 pr-0" id="myTab" role="tablist">
        <li class="nav-item " role="presentation">
            <a class="nav-link active" id="courses-tab" data-toggle="tab" href="#courses" role="tab" aria-controls="courses" aria-selected="true"><?= $this->lang->line('my_courses') ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tracks-tab" data-toggle="tab" href="#tracks" role="tab" aria-controls="tracks" aria-selected="false"><?= $this->lang->line('my_tracks') ?></a>
        </li>

    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active px-3" id="courses" role="tabpanel" aria-labelledby="courses-tab">
            <section class="my-courses-area">
                <div class="container">
                    <div class="row align-items-baseline">
                        <div class="col-lg-6">
                            <div class="my-course-filter-bar filter-box">
                                <span><?php echo $this->lang->line('filter_by'); ?></span>
                                <div class="btn-group">
                                    <a class="btn btn-outline-secondary dropdown-toggle all-btn" href="#"data-toggle="dropdown">
                                        <?php echo $this->lang->line('categories'); ?>
                                    </a>

                                    <div class="dropdown-menu">
                                        <?php
                                        foreach ($categories as $category):
                                            $category_details = $this->crud_model->get_categories($category)->row_array();
                                            if ($category_details) {
                                                ?>
                                                <a class="dropdown-item" href="#" id = "<?php echo $category; ?>" onclick="getCoursesByCategoryId(this.id)"><?php echo $category_details['title']; ?></a>
                                                <?php
                                            }
                                        endforeach;
                                        ?>
                                    </div>
                                </div>

                                <div class="btn-group">
                                    <a href="<?php echo site_url('home/my_courses'); ?>" class="btn reset-btn" disabled><?php echo $this->lang->line('reset'); ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="my-course-search-bar">
                                <!--<form action="">-->
                                <?= form_open('') ?>
                                <div class="input-group">
                                    <input type="text" class="form-control search_textbox" placeholder="<?php echo $this->lang->line('search_my_courses'); ?>" onkeyup="getCoursesBySearchString(this.value)">
                                    <div class="input-group-append">
                                        <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                                <?= form_close() ?>
                            </div>
                        </div>
                    </div>
                    <div class="row no-gutters" id = "my_courses_area">
                        <?php
                        foreach ($my_courses as $my_course):
                            $course_details = $this->crud_model->get_course_by_id($my_course['subject_id'])->row_array();
                            $instructor_details = $this->user_model->get_teachers($course_details['teacher']);
                            ?>

                            <div class="col-lg-3">
                                <div class="course-box-wrap">
                                    <div class="course-box">
                                        <a href="<?php echo site_url('home/lesson/' . rawurlencode(slugify($course_details['subject_name'])) . '/' . $my_course['subject_id']); ?>" >
                                            <div class="course-image">
                                                <img src="<?php echo $this->crud_model->get_course_thumbnail_url($course_details['image']); ?>" alt="" class="img-fluid" width="100%">
                                                <!--<span class="play-btn"></span>-->
                                            </div>
                                        </a>

                                        <div class="" id = "course_info_view_<?php echo $my_course['subject_id']; ?>">
                                            <div class="course-details">
                                                <a href="<?php echo site_url('home/course/' . rawurlencode(slugify($course_details['subject_name'])) . '/' . $my_course['subject_id']); ?>" class="d-inline-block mb-3"><h5 class="title"><?php echo $course_details['subject_name']; ?></h5></a>
                                                <div class="progress" style="height: 5px;">
                                                    <div class="progress-bar progress-bar-striped blue-progressbar" role="progressbar" style="width: <?php echo course_progress($my_course['subject_id']); ?>%" aria-valuenow="<?php echo course_progress($my_course['subject_id']); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <small><?php echo ceil(course_progress($my_course['subject_id'])); ?>% <?php echo $this->lang->line('completed'); ?></small>
                                                <!--                                    <div class="rating your-rating-box" style="position: unset; margin-top: -18px;">
                                                
                                                <?php
//                                        $get_my_rating = $this->crud_model->get_user_specific_rating('course', $my_course['subject_id']);
//                                        for ($i = 1; $i < 6; $i++):
                                                ?>
                                                <?php //if ($i <= $get_my_rating['rating']):  ?>
                                                                                                <i class="fas fa-star filled"></i>
                                                <?php //else:  ?>
                                                                                                <i class="fas fa-star"></i>
                                                <?php //endif; ?>
                                                <?php //endfor;  ?>
                                                                     <p class="your-rating-text" id = "<?php //echo $my_course['subject_id'];     ?>" onclick="getCourseDetailsForRatingModal(this.id)">
                                                                        <span class="your"><?php //echo $this->lang->line('your');     ?></span>
                                                                        <span class="edit"><?php //echo $this->lang->line('edit');    ?></span>
                                                <?php //echo $this->lang->line('rating');  ?>
                                                                    </p> 
                                                                                        <p class="your-rating-text">
                                                                                            <a href="javascript::" id = "edit_rating_btn_<?php //echo $course_details['id'];     ?>" onclick="toggleRatingView('<?php echo $course_details['id']; ?>')" style="color: #2a303b"><?php echo $this->lang->line('edit_rating'); ?></a>
                                                                                            <a href="javascript::" class="hidden" id = "cancel_rating_btn_<?php //echo $course_details['id'];     ?>" onclick="toggleRatingView('<?php echo $course_details['id']; ?>')" style="color: #2a303b"><?php echo $this->lang->line('cancel_rating'); ?></a>
                                                                                        </p>
                                                                                    </div>-->
                                            </div>
                                            <div class="row" style="padding: 5px;">
                                                <div class="col-md-6 pt-2">
                                                    <!--<a href="<?php //echo site_url('home/course/' . rawurlencode(slugify($course_details['subject_name'])) . '/' . $my_course['subject_id']);     ?>" class="btn course_details"><?php //echo $this->lang->line('course_detail');     ?></a>-->
                                                </div>
                                                <div class="col-md-6 pt-2">
                                                    <!--<a href="<?php //echo site_url('home/lesson/' . rawurlencode(slugify($course_details['subject_name'])) . '/' . $my_course['subject_id']); ?>" class="btn start_lesson"><?php //echo $this->lang->line('start_learning'); ?></a>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        </div>
        <div class="tab-pane px-3" id="tracks" role="tabpanel" aria-labelledby="tracks-tab">
            <?php include 'institute_page.php'; ?>
        </div>
    </div>
</div>


<script type="text/javascript">
    function getCoursesByCategoryId(category_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('home/my_courses_by_category'); ?>',
            data: {category_id: category_id, '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash() ?>'},
            success: function (response) {
                $('#my_courses_area').html(response);
            }
        });
    }

    function getCoursesBySearchString(search_string) {
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('home/my_courses_by_search_string'); ?>',
            data: {search_string: search_string, '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash() ?>'},
            success: function (response) {
                $('#my_courses_area').html(response);
            }
        });
    }

    function getCourseDetailsForRatingModal(course_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('home/get_course_details'); ?>',
            data: {course_id: course_id, '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash() ?>'},
            success: function (response) {
                $('#course_title_1').append(response);
                $('#course_title_2').append(response);
                $('#course_thumbnail_1').attr('src', "<?php echo base_url() . 'uploads/thumbnails/course_thumbnails/'; ?>" + course_id + ".jpg");
                $('#course_thumbnail_2').attr('src', "<?php echo base_url() . 'uploads/thumbnails/course_thumbnails/'; ?>" + course_id + ".jpg");
                $('#course_id_for_rating').val(course_id);
                // $('#instructor_details').text(course_id);
                console.log(response);
            }
        });
    }
</script>
