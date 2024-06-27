<!DOCTYPE html>
<html lang="en">
    <head>

        <?php
        if ($page_name == 'course_page'):
            $title = $this->crud_model->get_course_by_id($course_id)->row_array()
            ?>
            <title><?php echo $title['title'] . ' | ' . get_settings('system_name'); ?></title>
        <?php else: ?>
            <title><?php echo ucwords($page_title) . ' | ' . get_settings('system_name'); ?></title>
        <?php endif; ?>


        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="author" content="<?php echo get_settings('author') ?>" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />


        <?php
        $seo_pages = array('lessons');
        if (in_array($page_name, $seo_pages)) {
            $course_details = $this->crud_model->get_lesson_by_id($lesson_id)->row_array();
            if ($is_quiz) {
                $course_details = $this->crud_model->get_level_by_id($lesson_id)->row_array();
            }
            if ($course_details) {
                ?>
                <meta name="keywords" content="<?php echo $course_details['meta_keyword']; ?>"/>
                <meta name="description" content="<?php echo $course_details['meta_description']; ?>" />
            <?php } ?>
            <?php
        } else {
            $setting = setting();
            ?>
            <meta name="keywords" content="<?php echo $setting->meta_keyword; ?>"/>
            <meta name="description" content="<?php echo $setting->meta_description; ?>" />
        <?php } ?>

        <link name="favicon" rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?><?php echo setting()->company_fav; ?>" />
    <!--<link name="favicon" type="image/x-icon" href="<?php //echo base_url(get_frontend_settings('w_fav_icon'));    ?>" rel="shortcut icon" />-->
        <?php include 'includes_top.php'; ?>

        <style>
            @media (max-width: 995px) {
                body{
                    overflow-y: scroll !important;
                }
            }
        </style>
    </head>
    <body class="gray-bg <?= $this->session->userdata('language') == 'arabic' ? 'rtl_dir' : '' ?>">
        <?php
        include 'lessons.php';
        include 'includes_bottom.php';
        include 'common_scripts.php';

        if (get_frontend_settings('cookie_status') == 'active'):
            include 'eu-cookie.php';
        endif;
        ?>
        <script src="<?= base_url() ?>assets/plugins/custom/datatables/datatables.bundle.js"></script>
        <script>
            $(function () {
                var lessonHeight = $(window).height() - ($(".header_container").height() + 5);
                $('.add_scroll_video_area').css('height', lessonHeight + 'px');

                var sidebarHeight = lessonHeight - ($(".lessons_header_txt").height() + $("#lessonTab").height() + 20);
                $('.add_scroll').css('height', sidebarHeight + 'px');
                // google drive video height
                $('.drive_video_payer').css('height', lessonHeight + 'px');

            });
        </script>
    </body>
</html>
