<link rel="stylesheet" href="<?= base_url() ?>assets/css/comments.css">
<style>
    .rtl_dir .header_container{
        direction: rtl;
    }
    .rtl_dir .site_logo{
        text-align: right;
    }
    .rtl_dir .btn-link{
        text-align: right !important;
    }
    .rtl_dir .accordion_icon{
        float: left !important;
    }
    .rtl_dir .sidebar_lesson_details{
        text-align: right !important;
        direction: rtl;
    }
    .rtl_dir .complete_lesson_check{
        margin-left: 5px;
    }
    .rtl_dir #lessonTab{
        direction: rtl;
        padding-right: 0px;
    }
    .rtl_dir .comment_header{
        direction: rtl;
    }
    .rtl_dir .comment_header .symbol-circle{
        margin-right: 0rem !important;
        margin-left: 0.75rem !important;
    }
    .rtl_dir .comment_header .text-hover-primary{
        float: right !important;
    }
    .rtl_dir .comment_header .text-muted{
        text-align: left !important;
    }
    .rtl_dir .comment_body{
        text-align: right;
    }
    .rtl_dir .fa-thumbs-up{
        margin-top: 3px;
        float: right;
    }
    .rtl_dir .likes_count{
        float: right;
        margin-right: 10px;
    }
    .rtl_dir .list-group-flush{
        direction: rtl;
    }
    body{
        overflow: hidden;
    }
    .mobile-nav-trigger span {
        left: 8px;
    }
    .mobile-search-trigger, .mobile-nav-trigger{
        height: 38.5px;
    }
    .mobile-main-nav .lesson_name{
        display: inline;
    }
    #mobile_menu{
        display: none;
    }
    .mobile_lessons_header{
        color: #000;
        margin: 12px 10px;
    }
    .rtl_dir .card-body{
        text-align: right;
    }

</style>
<?php
$course_details = $this->crud_model->get_course_by_id($course_id)->row_array();

if (isset($bundle_id) && $bundle_id > 0):
    $my_course_url = strtolower($this->session->userdata('role')) == 'user' ? site_url('home/my_bundles') : 'javascript::';
    $btn_title = 'my_bundles';
else:
    //$my_course_url = strtolower($this->session->userdata('role')) == 'user' ? site_url('home/my_courses') : 'javascript::';
    
    //$my_course_url = site_url('home/my_courses');
    //$btn_title = 'my_courses';
    $my_course_url = site_url('home/course/' . rawurlencode(slugify($course_details['subject_name'])) . '/' . $course_id);
    $btn_title = 'course_detail';
endif;
$course_details_url = site_url("home/course/" . slugify($course_details['subject_name']) . "/" . $course_id);
?>
<div class="container-fluid course_container quiz-test">
    <!-- Top bar -->
    <div class="row header_container">
        <div class="col-lg-9 course_header_col">
            <h5 class="site_logo">
                <a href='<?= base_url() ?>'><img src="<?php echo base_url(get_frontend_settings('w_logo')) ?>" height="25"></a> |
                <?php echo $course_details['subject_name'] ?>
            </h5>
        </div>
        <div class="col-lg-3 course_header_col btns_holder">
            <a href="javascript::" class="course_btn" id="toggle_lessons_view" onclick="toggle_lesson_view()"><i class="fa fa-arrows-alt-h"></i></a>
            <?php //if ($this->session->userdata('language') == 'english') { ?>
                <a href="<?php echo $my_course_url; ?>" class="course_btn"><!--<i class="fa fa-chevron-left"></i> &nbsp; --><?php echo $this->lang->line($btn_title); ?></a>
                <!--<a href="<?php //echo $course_details_url;  ?>" class="course_btn"><?php //echo $this->lang->line('course_details');  ?> &nbsp;<i class="fa fa-chevron-right"></i></a>-->
            <?php //} else { ?>
<!--                <a href="<?php //echo $my_course_url;  ?>" class="course_btn">  <?php //echo $this->lang->line($btn_title);  ?> &nbsp;<i class="fa fa-chevron-left"></i></a>
                <a href="<?php //echo $course_details_url;  ?>" class="course_btn"> <i class="fa fa-chevron-right"></i> &nbsp;<?php //echo $this->lang->line('course_details');  ?> </a>-->
            <?php //} ?>
            <div id="mobile_menu" >
                <a class="course_btn mobile-nav-trigger" href="#mobile-primary-nav"><i class="fas fa-align-justify"></i></a> <!-- was <a class="course_btn mobile-nav-trigger" href="#mobile-primary-nav"><span></span></a> -->
                <div class="main-nav-wrap">
                    <div class="mobile-overlay "></div>

                    <ul class="mobile-main-nav ">

                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id = "lesson-container">
        <?php if (isset($lesson_id)): ?>
            <!-- Course content, video, quizes, files starts-->
            <?php include 'course_content_body.php'; ?>
            <!-- Course content, video, quizes, files ends-->
        <?php endif; ?>

        <!-- Course sections and lesson selector sidebar starts-->
        <?php include 'course_content_sidebar.php'; ?>
        <!-- Course sections and lesson selector sidebar ends-->
    </div>


</div>

<div id="reply_textbox" style="display: none">
    <div class="reply_main_div">
        <textarea class="form-control form-control-solid" name="reply" rows="3" placeholder="<?= $this->lang->line('enter_your_reply') ?>"></textarea>
        <input type="hidden" name="reply_on" class="reply_on" />
        <button type="submit" class="btn btn-primary m-t-15 m-b-20 complete_course_btn"><?= $this->lang->line('add') ?></button>
        <div class="clearfix"></div>
    </div>
</div>