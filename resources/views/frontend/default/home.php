<link rel="stylesheet" href="<?php echo base_url().'assets/frontend/default/css/slick.css'; ?>">
<link rel="stylesheet" href="<?php echo base_url().'assets/frontend/default/css/slick-theme.css'; ?>">
<style>
    body{
        margin: 0px !important;
    }
    .course-box .course-details .instructors{
        display: inline-block !important;
    }
    .home-banner-wrap{
        float: left;
        width: 100%;
    }
</style>
<section class="home-banner-area" style="background-image: url('<?= base_url("uploads/system/" . get_frontend_settings('banner_image')); ?>');
         background-position: center center;
         background-size: cover;
         background-repeat: no-repeat;
         padding: 170px 0 130px;
         color: #fff;">
    <div class="container-lg">
        <div class="row">
            <div class="col">
                <div class="home-banner-wrap">
                    <h2><?php echo get_frontend_settings('banner_title') ? get_frontend_settings('banner_title') : '&nbsp;' ?></h2>
                    <p style="margin-bottom: <?= get_frontend_settings('banner_sub_title') ? '45px' : '150px' ?>"><?php echo get_frontend_settings('banner_sub_title') ? get_frontend_settings('banner_sub_title') : '&nbsp;' ?></p>
                    <?= form_open_multipart(site_url('home/search')) ?>
                        <!--<form class="" action="<?php //echo site_url('home/search');  ?>" method="get">-->
                        <div class="input-group">
                            <input type="text" class="form-control" name = "query" placeholder="<?php echo $this->lang->line('what_do_you_want_to_learn'); ?>?">
                            <div class="input-group-append">
                                <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="home-fact-area">
    <div class="container-lg">
        <div class="row">
            <?php $courses = $this->crud_model->get_courses(); ?>
            <div class="col-md-4 d-flex">
                <div class="home-fact-box mr-md-auto mr-auto">
                    <i class="fas fa-bullseye float-left"></i>
                    <div class="text-box">
                        <h4><?php
                            $status_wise_courses = $this->crud_model->get_status_wise_courses();
                            $number_of_courses = $status_wise_courses['active']->num_rows();
                            echo $number_of_courses . ' ' . $this->lang->line('online_courses');
                            ?></h4>
                        <p><?php echo $this->lang->line('explore_a_variety_of_fresh_topics'); ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 d-flex">
                <div class="home-fact-box mr-md-auto mr-auto">
                    <i class="fa fa-check float-left"></i>
                    <div class="text-box">
                        <h4><?php echo $this->lang->line('expert_instruction'); ?></h4>
                        <p><?php echo $this->lang->line('find_the_right_course_for_you'); ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 d-flex">
                <div class="home-fact-box mr-md-auto mr-auto">
                    <i class="fa fa-clock float-left"></i>
                    <div class="text-box">
                        <h4><?php echo $this->lang->line('lifetime_access'); ?></h4>
                        <p><?php echo $this->lang->line('learn_on_your_schedule'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="course-carousel-area">
    <div class="container-lg">
        <div class="row">
            <div class="col">
                <h2 class="course-carousel-title mb-4"><?php echo $this->lang->line('top_courses'); ?></h2>
                <div class="course-carousel">
                    <?php
                    $top_courses = $this->crud_model->get_top_courses()->result_array();
                    $cart_items = $this->session->userdata('cart_items');
                    foreach ($top_courses as $top_course):
                        ?>
                        <div class="course-box-wrap">
                            <a href="<?php echo site_url('home/course/' . rawurlencode(slugify($top_course['subject_name'])) . '/' . $top_course['id']); ?>" class="has-popover">
                                <div class="course-box">
                                    <!-- <div class="course-badge position best-seller">Best seller</div> -->
                                    <div class="course-image">
                                        <img src="<?php echo $this->crud_model->get_course_thumbnail_url($top_course['image']); ?>" alt="" class="img-fluid">
                                    </div>
                                    <div class="course-details">
                                        <h5 class="title"><?php echo $top_course['subject_name'] ?></h5>
                                        <p class="instructors"><?php
                                            $instructors_name = $this->user_model->get_teachers($top_course['teacher']);
                                            echo $instructors_name;
                                            ?></p>
                                        <!--<button class="btn btn-secondary mb-3"><?//= $this->lang->line('enroll') ?></button>-->
                                        <!--<div class="rating">-->

                                        <?php
//                                        $total_rating =  $this->crud_model->get_ratings('course', $top_course['id'], true)->row()->rating;
//                                        $number_of_ratings = $this->crud_model->get_ratings('course', $top_course['id'])->num_rows();
//                                        if ($number_of_ratings > 0) {
//                                            $average_ceil_rating = ceil($total_rating / $number_of_ratings);
//                                        }else {
//                                            $average_ceil_rating = 0;
//                                        }
//
//                                        for($i = 1; $i < 6; $i++):
                                        ?>
                                        <?php //if ($i <= $average_ceil_rating): ?>
                    <!--<i class="fas fa-star filled"></i>-->
                                        <?php //else:  ?>
                    <!--<i class="fas fa-star"></i>-->
                                        <?php //endif; ?>
                                        <?php //endfor;  ?>
                <!--<span class="d-inline-block average-rating"><?php //echo $average_ceil_rating;         ?></span>-->
                                        <!--</div>-->
                                        <?php //if ($top_course['is_free_course'] == 1):  ?>
                                            <!--<p class="price text-right"><?php //echo $this->lang->line('free');         ?></p>-->
                                        <?php //else:  ?>
                                        <?php //if ($top_course['discount_flag'] == 1): ?>
                                                <!--<p class="price text-right"><small><?php //echo currency($top_course['price']);         ?></small><?php //echo currency($top_course['discounted_price']);         ?></p>-->
                                        <?php //else:  ?>
                                                <!--<p class="price text-right"><?php //echo currency($top_course['price']);          ?></p>-->
                                        <?php // endif;  ?>
                                        <?php //endif;  ?>
                                    </div>
                                </div>
                            </a>

                            <div class="webui-popover-content">
                                <div class="course-popover-content">
                                    <?php //if ($top_course['last_modified'] == ""): ?>
                                        <!--<div class="last-updated"><?php //echo $this->lang->line('last_updater').' '.date('D, d-M-Y', $top_course['date_added']);          ?></div>-->
                                    <?php //else:  ?>
                                        <!--<div class="last-updated"><?php //echo $this->lang->line('last_updater').' '.date('D, d-M-Y', $top_course['last_modified']);          ?></div>-->
                                    <?php //endif;  ?>

                                    <div class="course-title">
                                        <a href="<?php echo site_url('home/course/' . rawurlencode(slugify($top_course['subject_name'])) . '/' . $top_course['id']); ?>"><?php echo $top_course['subject_name']; ?></a>
                                    </div>
                                    <div class="course-meta">
                                        <span class=""><i class="fas fa-play-circle"></i>
                                            <?php echo $this->crud_model->get_lessons('course', $top_course['id'])->num_rows() . ' ' . $this->lang->line('lessons'); ?>
                                        </span>
                                        <span class=""><i class="far fa-clock"></i>
                                            <?php
                                            $total_duration = 0;
                                            $lessons = $this->crud_model->get_lessons('course', $top_course['id'])->result_array();
                                            foreach ($lessons as $lesson) {
                                                if ($lesson['type'] == 1) {
//                                            $time_array = explode(':', $lesson['duration']);
//                                            $hour_to_seconds = $time_array[0] * 60 * 60;
//                                            $minute_to_seconds = $time_array[1] * 60;
//                                            $seconds = $time_array[2];
                                                    $total_duration += $lesson['duration'];
                                                }
                                            }
                                            echo gmdate("H:i:s", $total_duration * 60) . ' ' . $this->lang->line('hours');
                                            ?>
                                        </span>
                                        <!--<span class=""><i class="fas fa-closed-captioning"></i><?php //echo ucfirst($top_course['language']);          ?></span>-->
                                    </div>
                                    <!--<div class="course-subtitle"><?php //echo $top_course['subject_description']; ?></div>-->

                                    <div class="what-will-learn">
                                        <?php if ($top_course['whatsapp_link']) { ?>
                                            <span class="px-1w5" title="Whatsapp Link"><a href="<?= $top_course['whatsapp_link'] ?>" target=”_blank”><i class="fab fa-whatsapp"></i></a></span>
                                        <?php } ?>
                                        <?php if ($top_course['telegram_link']) { ?>
                                            <span class="px-1w5" title="Telegram Link"><a href="<?= $top_course['telegram_link'] ?>" target=”_blank”><i class="fab fa-telegram"></i></a></span>
                                        <?php } ?>
                                        <?php if ($top_course['youtube_link']) { ?>
                                            <span class="px-1w5" title="Youtube Link"><a href="<?= $top_course['youtube_link'] ?>" target=”_blank”><i class="fab fa-youtube"></i></a></span>
                                        <?php } ?>
                                        <?php if ($top_course['instagram_link']) { ?>
                                            <span class="px-1w5" title="Instagram Link"><a href="<?= $top_course['instagram_link'] ?>" target=”_blank”><i class="fab fa-instagram"></i></a></span>
                                        <?php } ?>
                                    </div>
                                    <!--<div class="what-will-learn">
                                        <ul>-->
                                    <?php
//                                    $outcomes = json_decode($top_course['outcomes']);
//                                    foreach ($outcomes as $outcome):
                                    ?>
                                            <!--<li><?php //echo $outcome;         ?></li>-->
                                    <?php //endforeach;  ?>
                                    <!--</ul>
                                </div>-->
                                    <div class="popover-btns">
                                        <?php //if (is_purchased($top_course['id'])): ?>
                                        <!--                                <div class="purchased">
                                                                            <a href="<?php //echo site_url('home/my_courses');         ?>"><?php //echo $this->lang->line('already_purchased');         ?></a>
                                                                        </div>-->
                                        <?php //else: ?>
                                        <?php
                                        //if ($top_course['is_free_course'] == 1):
                                        if ($this->session->userdata('user_login') && is_purchased($top_course['id'])) {
                                            ?>
                                            <div class="already_purchased">
                                                <a href="<?php echo site_url('home/my_courses'); ?>"><?php echo $this->lang->line('already_purchased'); ?></a>
                                            </div>
                                            <?php
                                        } else {
                                            if ($this->session->userdata('user_login') != 1) {
                                                $url = "#";
                                            } else {
                                                $url = site_url('home/get_enrolled_to_free_course/' . $top_course['id']);
                                            }
                                            ?>
                                            <a href="<?php echo $url; ?>" class="btn add-to-cart-btn big-cart-button" onclick="handleEnrolledButton()"><?php echo $this->lang->line('enroll'); ?></a>
                                            <?php
                                        }
                                        //else: 
                                        ?>
                        <!--<button type="button" class="btn add-to-cart-btn <?php //if (in_array($top_course['id'], $cart_items)) echo 'addedToCart'; ?> big-cart-button-<?php //echo $top_course['id']; ?>" id = "<?php //echo $top_course['id']; ?>" onclick="handleCartItems(this)">-->
                                        <?php
//                                        if(in_array($top_course['id'], $cart_items))
//                                        echo $this->lang->line('added_to_cart');
//                                        else
//                                        echo $this->lang->line('add_to_cart');
                                        ?>
                                        <!--</button>-->
                                        <?php //endif;   ?>
                                        <!--<button type="button" class="wishlist-btn <?php //if ($this->crud_model->is_added_to_wishlist($top_course['id'])) echo 'active';      ?>" title="Add to wishlist" onclick="handleWishList(this)" id = "<?php //echo $top_course['id'];      ?>"><i class="fas fa-heart"></i></button>-->
                                        <?php //endif;   ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="course-carousel-area">
    <div class="container-lg">
        <div class="row">
            <div class="col">
                <h2 class="course-carousel-title mb-4"><?php echo $this->lang->line('top') . ' 10 ' . $this->lang->line('latest_courses'); ?></h2>
                <div class="course-carousel">
                    <?php
                    $latest_courses = $this->crud_model->get_latest_10_course();
                    foreach ($latest_courses as $latest_course):
                        ?>
                        <div class="course-box-wrap">
                            <a href="<?php echo site_url('home/course/' . rawurlencode(slugify($latest_course['subject_name'])) . '/' . $latest_course['id']); ?>">
                                <div class="course-box">
                                    <div class="course-image">
                                        <img src="<?php echo $this->crud_model->get_course_thumbnail_url($latest_course['image']); ?>" alt="" class="img-fluid">
                                    </div>
                                    <div class="course-details">
                                        <h5 class="title"><?php echo $latest_course['subject_name']; ?></h5>
                                        <p class="instructors">
                                            <?php
                                            $instructors_name = $this->user_model->get_teachers($latest_course['teacher']);
                                            echo $instructors_name;
                                            ?>
                                        </p>
                                        <!--<div class="rating">-->
                                        <?php
//                                        $total_rating =  $this->crud_model->get_ratings('course', $latest_course['id'], true)->row()->rating;
//                                        $number_of_ratings = $this->crud_model->get_ratings('course', $latest_course['id'])->num_rows();
//                                        if ($number_of_ratings > 0) {
//                                            $average_ceil_rating = ceil($total_rating / $number_of_ratings);
//                                        }else {
//                                            $average_ceil_rating = 0;
//                                        }
//
//                                        for($i = 1; $i < 6; $i++):
                                        ?>
                                        <?php //if ($i <= $average_ceil_rating):  ?>
                                                <!--<i class="fas fa-star filled"></i>-->
                                        <?php //else:  ?>
                                                <!--<i class="fas fa-star"></i>-->
                                        <?php //endif;   ?>
                                        <?php //endfor; ?>
    <!--                                    <span class="d-inline-block average-rating"><?php //echo $average_ceil_rating;         ?></span>
                                    </div>-->
                                        <?php //if ($latest_course['is_free_course'] == 1):  ?>
                                        <!--<p class="price text-right"><?php //echo $this->lang->line('free');          ?></p>-->
                                        <?php //else:  ?>
                                        <?php //if ($latest_course['discount_flag'] == 1):  ?>
                                            <!--<p class="price text-right"><small><?php //echo currency($latest_course['price']);         ?></small><?php //echo currency($latest_course['discounted_price']);         ?></p>-->
                                        <?php //else:  ?>
                                            <!--<p class="price text-right"><?php //echo currency($latest_course['price']);          ?></p>-->
                                        <?php //endif;   ?>
                                        <?php //endif;   ?>
                                    </div>
                                </div>
                            </a>

                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    function handleWishList(elem) {

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
                        $(elem).removeClass('active')
                    } else {
                        $(elem).addClass('active')
                    }
                    $('#wishlist_items').html(response);
                }
            }
        });
    }

    function handleCartItems(elem) {
        url1 = '<?php echo site_url('home/handleCartItems'); ?>';
        url2 = '<?php echo site_url('home/refreshWishList'); ?>';
        $.ajax({
            url: url1,
            type: 'POST',
            data: {course_id: elem.id},
            success: function (response)
            {
                $('#cart_items').html(response);
                if ($(elem).hasClass('addedToCart')) {
                    $('.big-cart-button-' + elem.id).removeClass('addedToCart')
                    $('.big-cart-button-' + elem.id).text("<?php echo $this->lang->line('add_to_cart'); ?>");
                } else {
                    $('.big-cart-button-' + elem.id).addClass('addedToCart')
                    $('.big-cart-button-' + elem.id).text("<?php echo $this->lang->line('added_to_cart'); ?>");
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

    $(document).ready(function () {
        if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            if ($(window).width() >= 840) {
                $('a.has-popover').webuiPopover({
                    trigger: 'hover',
                    animation: 'pop',
                    placement: 'horizontal',
                    delay: {
                        show: 100,
                        hide: null
                    },
                    width: 330
                });
            } else {
                $('a.has-popover').webuiPopover({
                    trigger: 'hover',
                    animation: 'pop',
                    placement: 'vertical',
                    delay: {
                        show: 100,
                        hide: null
                    },
                    width: 335
                });
            }
        }
    });
</script>
