

<!-- <div class="" style="background-color: #333;"> -->
<?php
if ($is_quiz) {
    $lesson_details = $this->db->get_where('level', array('id' => $lesson_id))->row_array();
    $lesson_details['type'] = 'quiz';
    $lesson_details['video_type'] = '';
} else {
    $lesson_details = $this->crud_model->get_lessons('lesson', $lesson_id)->row_array();
}
if (empty($lesson_details)) {
    die('<div class="text-center col-md-12"><h2 class="mt-4">' . $this->lang->line('no_lessons_yet') . '</h2></div>');
}
?>
<div class="col-lg-9  order-md-1 course_col add_scroll_video_area" id = "video_player_area" style="overflow-x: hidden">
    <div class="" <?= $lesson_details && $lesson_details['type'] != 2 ? 'style="text-align: center;"' : '' ?>>
        <?php
        if (empty($lesson_details)) {
            die('<div class="text-center"><h2 class="mt-4">' . $this->lang->line('no_lessons_yet') . '</h2></div>');
        }
        $lesson_thumbnail_url = $this->crud_model->get_lesson_thumbnail_url($lesson_id);
        $opened_section_id = $lesson_details['section_id'];
        // If the lesson type is video
        // i am checking the null and empty values because of the existing users does not have video in all video lesson as type
        if ($lesson_details['video_type'] != ''):
            $video_url = $lesson_details['video_url'];
            $provider = $lesson_details['video_type'];
            //$provider = 'youtube';
            ?>

            <!-- If the video is youtube video -->
            <?php if (strtolower($provider) == 'youtube'): ?>
                <!------------- PLYR.IO ------------>
                <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/global/plyr/plyr.css">

                <div class="plyr__video-embed" id="player">
                    <iframe height="500" src="<?php echo $video_url; ?>?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1&amp;" allowfullscreen allowtransparency allow="autoplay"></iframe>
                </div>
                <script src="<?php echo base_url(); ?>assets/frontend/global/plyr/plyr.js"></script>
                <script>

                    const player = new Plyr('#player', {'keyboard': {focused: true, global: true}});

                    player.on('ended', event => {
                        markThisLessonAsCompleted(<?= $lesson_id ?>, 1);
                        setTimeout(function () {
                            location.href = $(".next_lesson").find('a').prop('href');
                        }, 5000);

                    });</script>
                <!------------- PLYR.IO ------------>
                <!--<p class="mt-5"><?//= $lesson_details['desc'] ?></p>-->
                <!-- If the video is vimeo video -->
                <?php
            elseif (strtolower($provider) == 'vimeo'):
                $this->load->model('frontend/video_model');
                $video_details = $this->video_model->getVideoDetails($video_url);
                $video_id = $video_details['video_id'];
                ?>
                <!------------- PLYR.IO ------------>
                <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/global/plyr/plyr.css">
                <div class="plyr__video-embed" id="player">
                    <iframe height="550" width="100%" src="https://player.vimeo.com/video/<?php echo $video_id; ?>?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media" allowfullscreen allowtransparency allow="autoplay"></iframe>
                </div>

                <script src="<?php echo base_url(); ?>assets/frontend/global/plyr/plyr.js"></script>
                <script>const player = new Plyr('#player');</script>

                <!------------- PLYR.IO ------------>

                <!-- If the video is Amazon S3 video -->
            <?php elseif (strtolower($provider) == 'amazon'): ?>
                <!------------- PLYR.IO ------------>
                <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/global/plyr/plyr.css">
                <video poster="<?php echo $lesson_thumbnail_url; ?>" id="player" playsinline controls>
                    <?php if (get_video_extension($video_url) == 'mp4'): ?>
                        <source src="<?php echo $video_url; ?>" type="video/mp4">
                    <?php elseif (get_video_extension($video_url) == 'webm'): ?>
                        <source src="<?php echo $video_url; ?>" type="video/webm">
                    <?php else: ?>
                        <h4><?php $this->lang->line('video_url_is_not_supported'); ?></h4>
                    <?php endif; ?>
                </video>

                <script src="<?php echo base_url(); ?>assets/frontend/global/plyr/plyr.js"></script>
                <script>const player = new Plyr('#player');</script>
                <!------------- PLYR.IO ------------>
                <!-- If the video is Amazon S3 video -->

                <!-- If the video is self uploaded video -->
            <?php elseif (strtolower($provider) == 'system'): ?>
                <!------------- PLYR.IO ------------>
                <?php $video_url = base_url() . 'uploads/subjects/' . $lesson_details['attachment']; ?>
                <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/global/plyr/plyr.css">
                <video poster="<?php echo $lesson_thumbnail_url; ?>" id="player" playsinline controls>
                    <?php if (get_video_extension($video_url) == 'mp4'): ?>
                        <source src="<?php echo $video_url; ?>" type="video/mp4">
                    <?php elseif (get_video_extension($video_url) == 'webm'): ?>
                        <source src="<?php echo $video_url; ?>" type="video/webm">
                    <?php else: ?>
                        <h4><?php $this->lang->line('video_url_is_not_supported'); ?></h4>
                    <?php endif; ?>
                </video>

                <script src="<?php echo base_url(); ?>assets/frontend/global/plyr/plyr.js"></script>
                <script>const player = new Plyr('#player');</script>
                <!------------- PLYR.IO ------------>
                <!-- If the video is self uploaded video -->

            <?php elseif (strtolower($provider) == 'google_drive'): ?>
                <style type="text/css">
                    .hidebtn {
                        width: 110px !important;
                        height: 55px !important;
                        background: #00000000 !important;
                        position: absolute !important;
                        right: 0px !important;
                        top: 0px !important;
                        z-index: 999;
                    }
                </style>
                <!------------- PLYR.IO ------------>
                <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/global/plyr/plyr.css">
                <div class="">
                    <div class="">
                        <?php
                        //video id generate
                        $url_array_1 = explode("/", $lesson_details['video_url'] . '/');
                        $url_array_2 = explode("=", $lesson_details['video_url']);
                        $video_id = null;

                        if ($url_array_1[4] == 'd'):
                            $video_id = $url_array_1[5];
                        else:
                            $video_id = $url_array_2[1];
                        endif;
                        ?>

                        <div class="plyr__video-embed" id="player" style="position: relative;">
                            <div class="hidebtn"></div>
                            <div class="hidebtn"></div>
                            <iframe class="mobile_vedio_player drive_video_payer" src="https://drive.google.com/file/d/<?php echo $video_id; ?>/preview" style="border: 0px;" width="100%" allowfullscreen>
                            </iframe>

                        </div>
                    </div>
                </div>

                <script src="<?php echo base_url(); ?>assets/frontend/global/plyr/plyr.js"></script>
                <script>
                    const player = new Plyr('#player');
                </script>
                <!------------- PLYR.IO ------------>
                <!-- If the video is self uploaded video -->


            <?php else : ?>
                <!------------- PLYR.IO ------------>
                <?php $video_url = base_url() . 'uploads/subjects/' . $lesson_details['attachment']; ?>
                <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/global/plyr/plyr.css">
                <video poster="<?php echo $lesson_thumbnail_url; ?>" id="player" playsinline controls>
                    <?php if (get_video_extension($video_url) == 'mp4'): ?>
                        <source src="<?php echo $video_url; ?>" type="video/mp4">
                    <?php elseif (get_video_extension($video_url) == 'webm'): ?>
                        <source src="<?php echo $video_url; ?>" type="video/webm">
                    <?php else: ?>
                        <h4><?php $this->lang->line('video_url_is_not_supported'); ?></h4>
                    <?php endif; ?>
                </video>

                <script src="<?php echo base_url(); ?>assets/frontend/global/plyr/plyr.js"></script>
                <script>const player = new Plyr('#player');</script>
                <!------------- PLYR.IO ------------>
            <?php endif; ?>
            <?php
        elseif ($lesson_details['type'] == 'quiz'):
            $not_video = 1;
            ?>
            <div class="mt-5">
                <?php include 'quiz_view.php'; ?>
            </div>
            <?php
        elseif ($lesson_details['type'] == 2):
            $not_video = 1;
            ?>
            <div class="mt-5">
                <?php echo htmlspecialchars_decode($lesson_details['desc']); ?>
            </div>

            <?php
        elseif ($lesson_details['attachment_type'] == 'iframe'):
            $not_video = 1;
            ?>
            <div class="w-100">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" width="100%" height="550px" src="<?php echo $lesson_details['attachment']; ?>" allowfullscreen></iframe>
                </div>
            </div>
            <?php
        else:
            $not_video = 1;
            ?>
            <div class="mt-5 text-center">
                <?php
                if ($lesson_details['attachment_type'] == 'img'):
                    $img_size = getimagesize('uploads/subjects/' . $lesson_details['attachment']);
                    ?>
                    <img width="100%" style="max-width: <?php echo $img_size[0] . 'px'; ?>" height="auto" src="<?php echo base_url() . 'uploads/subjects/' . $lesson_details['attachment']; ?>"/>
                <?php elseif ($lesson_details['attachment_type'] == 'doc'): ?>
                    <?php if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1'): ?>
                        <p class="text-danger"><?php echo site_phrase('you_should_upload_the_application_on_a_live_server_to_preview_the_doc_file'); ?></p>
                    <?php endif; ?>
                    <iframe width="100%" height="500px" class="doc" src="https://docs.google.com/gview?url=<?php echo base_url() . 'uploads/subjects/' . $lesson_details['attachment']; ?>&embedded=true"></iframe>
                <?php else: ?>
                    <iframe class="embed-responsive-item" width="100%" height="500px" src="<?php echo base_url() . 'uploads/subjects/' . $lesson_details['attachment']; ?>" allowfullscreen></iframe>
                <?php endif; ?>
            </div>
        <?php endif; ?>


        <?php
//        else:
//        $not_video = 1;
        ?>
        <!--<div class="mt-5">
            <?//= $lesson_details['desc'] ?> -->
<!--                    <a href="<?php //echo base_url() . 'uploads/lesson_files/' . $lesson_details['attachment'];                             ?>" class="btn btn-sign-up" download style="color: #fff;">
                <i class="fa fa-download" style="font-size: 20px;"></i> <?php //echo $this->lang->line('download') . ' ' . $lesson_details['title'];                            ?>
            </a>-->
        <!--</div>-->
        <?php //endif;      ?>
        <!--</div>-->

        <!--    <div class="" style="margin: 20px 0;" id = "lesson-summary">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php //echo $lesson_details['lesson_type'] == 'quiz' ? $this->lang->line('instruction') : $this->lang->line("note");                         ?>:</h5>
        <?php //if ($lesson_details['summary'] == ""):      ?>
                            <p class="card-text"><?php //echo $lesson_details['lesson_type'] == 'quiz' ? $this->lang->line('no_instruction_found') : $this->lang->line("no_summary_found");                         ?></p>
        <?php //else:       ?>
                            <p class="card-text"><?php //echo $lesson_details['summary'];                           ?></p>
        <?php //endif;          ?>
                    </div>
                </div>
            </div>-->
    </div>
    <?php if (isset($lesson_details['desc']) && $lesson_details['desc'] && $lesson_details['type'] != 2) { ?>
        <div class="" style="margin: 20px 0;" id = "lesson-summary">
            <div class="card">
                <div class="card-body">
                    <!--<h5 class="card-title w-100 mb-3">Note</h5>-->
                    <?php echo htmlspecialchars_decode($lesson_details['desc']); ?>
                </div>
            </div>
        </div>
    <?php } ?>

</div>