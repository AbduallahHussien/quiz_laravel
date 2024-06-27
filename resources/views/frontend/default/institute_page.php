<style>
    html{
        height: 100%;
    }
    body{
        display: flex;
        flex-direction: column;
        min-height: 100%;
    }
    .footer-area{
        margin-top: auto;
    }
/*    .title{
        padding-left: 20px;
    }*/
    /*    .course-curriculum-accordion .lecture-group-title:before{
            content: "\f02d";
            font-size: 13px;
        }*/
    .rtl .course-curriculum-accordion .lecture-group-title:before{
        right: 22px;
    }
    .rtl .course-curriculum-box .course-curriculum-title{
        padding-left: 31px;
        padding-right: 0px;
    }
/*    .rtl .title{
        padding-right: 20px;
    }*/
    .rtl .course-curriculum-accordion .lecture-group-title .total-time{
        text-align: left;
    }
    .book-icon{
        color: #007791;
    }
    .btn-blu{
        background-color: #007791;
        border-color: #007791;
    }
    .clr-blu{
        color: #007791;
    }
    .btn-icon{
        color: #FFF !important;
    }
</style>
<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/default/css/institute_semesters.css' ?>">
<!--<section class="course-header-area">
    <div class="container">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="course-header-wrap">
                    <h1 class="title"><?php //echo isset($my_institute) ? $this->lang->line('my_tracks') : $this->lang->line('institute') ?></h1>
                </div>
            </div>
            <div class="col-lg-4">

            </div>
        </div>
    </div>
</section>-->


<section class="course-content-area" style="margin-top: 40px">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="course-curriculum-box">
                    <div class="course-curriculum-title clearfix">
                        <div class="title float-left"><?php //echo $this->lang->line('institute_semesters');            ?></div>
                        <div class="float-right mb-2">
                            <span class="total-lectures">
                                <?php //echo $this->crud_model->get_semesters()->num_rows() . ' ' . $this->lang->line('semesters'); ?>
                            </span>
<!--                            <span class="total-time">
                            <?php
                            //echo $this->crud_model->get_total_duration_of_lesson_by_course_id($course_details['id']);
                            ?>
                            </span>-->
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        //$sections = $this->crud_model->get_section('course', $course_id)->result_array();
                        foreach ($semesters as $semester) {
                            $is_enrolled = is_purchased($semester->id, 1);
                            ?>
                            <div class="col-md-4 col-lg-4 col-sm-6 col-12">
                                <div class="course-box-wrap">
                                    <a <?= $semester->status == 0 || ($semester->status == 4 && !$is_enrolled) ? '' : 'href="' . base_url('home/courses/0/' . $semester->id) . '"' ?> >
                                    </a><div class="course-box" title="<?= $semester->status == 0 ? 'This course has been ended' : '' ?>"><a <?= $semester->status == 0 || ($semester->status == 4 && !$is_enrolled) ? '' : 'href="' . base_url('home/courses/0/' . $semester->id) . '"' ?> >
                                            <div class="course-image">
                                                <img src="<?= base_url() ?>uploads/semesters/<?= $semester->image ?>" alt="" class="img-fluid" width="100%">
                                            </div>
                                        </a><div class="course-details"><a <?= $semester->status == 0 || ($semester->status == 4 && !$is_enrolled) ? '' : 'href="' . base_url('home/courses/0/' . $semester->id) . '"' ?> >
                                                <h5 class="title"><?php echo $semester->title; ?></h5>
                                                <p class="instructors">
                                                    <span> <?php echo $this->crud_model->get_semester_courses($semester->id)->num_rows() . ' ' . $this->lang->line('courses'); ?> </span>
                                                    <?php if ($is_enrolled) { ?>
                                                        <span class="already_enrolled_txt"> <?= $this->lang->line('already_purchased') ?> </span>
                                                    <?php } ?>
                                                </p>
                                            </a>
                                            <div class="rating">
                                                <?php
                                                if (!$is_enrolled) {
                                                    if ($semester->status != 0) { // hidden 
                                                        if ($semester->status == 4) {  //archived
                                                            echo '<span>This course has been archived</span>';
                                                        } else {
                                                            ?>
                                                            <a class="btn btn-primary btn-block btn-pill mt-2" href="<?= base_url('home/get_enrolled_to_free_course/' . $semester->id . '/1') ?>" ><?= $this->lang->line('enroll') ?></a>
                                                            <?php
                                                        }
                                                    }
                                                } else {
                                                    ?>
                                                    <a class="btn btn-danger btn-block btn-pill mt-2" title="<?= $this->lang->line('already_purchased') ?>" href="<?= base_url('home/cancel_enrolled/' . $semester->id . '/1') ?>" ><?= $this->lang->line('cancel_enrollment') ?></a>
                                                <?php } ?>
                                            </div>


                                        </div>
                                    </div>

                                </div>
                            </div>
                        <?php } ?>
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
            data: {course_id: elem.id, '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash() ?>'},
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
            data: {course_id: elem.id, '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash() ?>'},
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
