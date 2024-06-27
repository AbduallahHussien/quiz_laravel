<style>
    .fa-minus,.fa-plus{
        pointer-events: none;
    }
    .add_scroll{
        max-height: 75vh;
        overflow-y: scroll;
    }
    .add_scroll_video_area{
        /*max-height: 85vh;*/
        overflow-y: scroll;
    }
</style>
<div class="col-lg-3 mt-5 order-md-2 course_col hidden" id="lesson_list_loader" style="text-align: center;">
    <img src="<?php echo base_url('assets/images/loader.gif'); ?>" alt="" height="50" width="50">
</div>
<div class="col-lg-3  order-md-2 course_col" id = "lesson_list_area">
    <div class="text-center lessons_header_txt" style="margin: 12px 10px;">
        <h5><?php echo $this->lang->line('course_content'); ?></h5>
    </div>
    <div class="row" style="margin: 12px -1px">
        <div class="col-12">
            <ul class="nav nav-tabs" id="lessonTab" role="tablist">
                <li class="nav-item" id="lessonTabHeader">
                    <a class="nav-link active" id="section_and_lessons-tab" data-toggle="tab" href="#section_and_lessons" role="tab" aria-controls="section_and_lessons" aria-selected="true"><?php echo $this->lang->line('lessons') ?></a>
                </li>

                <?php
                if ($is_quiz == 0 && isset($lesson_id) && $this->session->userdata('user_id')) {
                    if (!$this->session->flashdata('quiz_result')) {
                        ?>
                        <li class="nav-item" >
                            <a class="nav-link" id="comments-tab" data-toggle="tab" href="#comments" role="tab" aria-controls="comments" aria-selected="true"><?php echo $this->lang->line('comments') . ' (' . count($comments) . ')' ?></a>
                        </li>
                        <?php
                    }
                }
                ?>

                <?php
                if ($is_quiz == 0 && isset($lesson_id) && $this->session->userdata('user_id')) {
                    if (!$this->session->flashdata('quiz_result')) {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" id="fatawa-tab" data-toggle="tab" href="#fatawa" role="tab" aria-controls="fatawa" aria-selected="true"><?php echo $this->lang->line('fatawa') . ' (' . count($fatawas) . ')' ?></a>
                        </li>
                        <?php
                    }
                }
                ?>

                <!-- CERTIFICATE TAB -->
                <!--                <li class="nav-item">
                                    <a class="nav-link" id="certificate-tab" data-toggle="tab" href="#certificate" role="tab" aria-controls="certificate" aria-selected="false" onclick="checkCertificateEligibility()"><?php echo $this->lang->line('certificate'); ?></a>
                                </li>-->
                <!-- CERTIFICATE TAB -->
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="section_and_lessons" role="tabpanel" aria-labelledby="section_and_lessons-tab">
                    <div class="add_scroll" id="lessons_content">
                        <!-- Lesson Content starts from here -->
                        <div class="accordion" id="accordionExample">
                            <?php
                            $active = 0;
                            foreach ($sections as $key => $section):
                                $this->load->model('Quiz_Model');
                                $lessons = $this->Quiz_Model->get_section_contents($section['id']);
                                //$lessons = $this->crud_model->get_lessons('section', $section['id'])->result_array();
                                ?>
                                <div class="card" style="margin:0px 0px;">
                                    <div class="card-header course_card" id="<?php echo 'heading-' . $section['id']; ?>">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link w-100 text-left" type="button" data-toggle="collapse" data-target="<?php echo '#collapse-' . $section['id']; ?>" <?php if (isset($opened_section_id) && $opened_section_id == $section['id']): ?> aria-expanded="true" <?php else: ?> aria-expanded="false" <?php endif; ?> aria-controls="<?php echo 'collapse-' . $section['id']; ?>" style="color: #535a66; background: none; border: none; white-space: normal;" onclick = "toggleAccordionIcon(this, '<?php echo $section['id']; ?>')">
                                                <h6 style="color: #959aa2; font-size: 13px;">
                                                    <?php //echo $this->lang->line('section') . ' ' . ($key + 1); ?>
                                                    <span style="float: right; font-weight: 100;" class="accordion_icon" id="accordion_icon_<?php echo $section['id']; ?>">
                                                        <?php if (!isset($opened_section_id) || (isset($opened_section_id) && $opened_section_id == $section['id'])): ?>
                                                            <i class="fa fa-minus"></i>
                                                        <?php else: ?>
                                                            <i class="fa fa-plus"></i>
                                                        <?php endif; ?>
                                                    </span>
                                                </h6>
                                                <?php echo $section['name']; ?>
                                            </button>
                                        </h5>
                                    </div>

                                    <div id="<?php echo 'collapse-' . $section['id']; ?>" class="collapse <?php if ($section_id == $section['id']) echo 'show'; ?>" aria-labelledby="<?php echo 'heading-' . $section['id']; ?>" data-parent="#accordionExample">
                                        <div class="card-body"  style="padding:0px;">
                                            <table style="width: 100%;">
                                                <?php
                                                foreach ($lessons as $key => $lesson):
                                                    $this_is_quiz = 0;
                                                    if (!isset($lesson->type)) {
                                                        $lesson->type = 'quiz';
                                                        $this_is_quiz = 1;
                                                        $lesson->video_type = $lesson->attachment = '';
                                                    }
                                                    if ($lesson_id == $lesson->id) {
                                                        $active = 1;
                                                    }
                                                    ?>
                                                    <?php
                                                    if (isset($bundle_id) && $bundle_id > 0):
                                                        $lesson_url = site_url('addons/course_bundles/lesson/' . rawurlencode(slugify($course_details['title'])) . '/' . $bundle_id . '/' . $course_id . '/' . $lesson->id);
                                                    else:
                                                        $lesson_url = site_url('home/lesson/' . slugify($course_details['subject_name']) . '/' . $course_id . '/' . $lesson->id . '/' . $this_is_quiz);
                                                    endif;
                                                    ?>

                                                    <tr style="width: 100%; padding: 5px 0px;background-color: <?php
                                                    if ($lesson_id == $lesson->id)
                                                        echo '#E6F2F5';
                                                    else
                                                        echo '#fff';
                                                    ?>;" class="<?= $lesson_id == $lesson->id ? 'active' : '' ?> <?= $active == 2 ? 'next_lesson' : '' ?>">
                                                        <td style="text-align: left; padding:7px 10px;" class="sidebar_lesson_details">
                                                            <?php
                                                            if ($this_is_quiz) {
                                                                $quiz_taken = $this->crud_model->is_quiz_taken($lesson->id, $this->session->userdata('user_id'));

                                                                $lesson_progress = $quiz_taken ? 1 : 0;
                                                                $is_quiz_tottaly_marked = $this->crud_model->is_quiz_tottaly_marked($lesson->id, $this->session->userdata('user_id'));
                                                                $show_result = $lesson->answer_manually;
                                                            } else {
                                                                $lesson_progress = lesson_progress($lesson->id, '', $course_id);
                                                                $show_result = 0;
                                                                $quiz_taken = $is_quiz_tottaly_marked = false;
                                                            }
                                                            ?>
                                                            <div class="form-group">
                                                                <input type="checkbox" id="<?php echo $lesson->id; ?>" onchange="markThisLessonAsCompleted(this.id);" value = 1 <?php if ($lesson_progress == 1): ?> checked <?php endif; ?>>
                                                                <label for="<?php echo $lesson->id; ?>" class="complete_lesson_check"></label>
                                                            </div>

                                                            <a href="<?= $lesson_url; ?>" id = "<?php echo $lesson->id; ?>" class="lesson_name" style="color: #444549;font-size: 14px;font-weight: 400;">
                                                                <?php echo $key + 1; ?>:
                                                                <?php if ($lesson->type != 'other'): ?>
                                                                    <?php echo $lesson->name; ?>
                                                                <?php else: ?>
                                                                    <?php echo $lesson->name; ?>
                                                                                                                                                                                                                    <!-- <i class="fa fa-paperclip"></i> -->
                                                                <?php endif; ?>
                                                            </a>


                                                            <div class="lesson_duration">
                                                                <?php if ($lesson->video_type != ''): ?>
                                                                    <?php //echo $lesson['duration']; ?>
                                                                    <i class="far fa-play-circle"></i>
                                                                    <?php echo readable_time_for_humans($lesson->duration); ?>
                                                                <?php elseif ($lesson->type == 'quiz'): ?>
                                                                    <i class="far fa-question-circle"></i> <?php echo $this->lang->line('quiz'); ?>

                                                                <?php elseif ($lesson->type == 2): ?>
                                                                    <i class="fas fa-list"></i> &nbsp; <?php echo $this->lang->line('article'); ?>

                                                                <?php else: ?>
                                                                    <?php if ($lesson->attachment_type == 'iframe'): ?>
                                                                        <i class="fas fa-code"></i>  <?php echo $this->lang->line('external_source'); ?>
                                                                    <?php else: ?>
                                                                        <?php
                                                                        $tmp = explode('.', $lesson->attachment);
                                                                        $fileExtension = strtolower(end($tmp));
                                                                        ?>
                                                                        <?php if ($fileExtension == 'jpg' || $fileExtension == 'jpeg' || $fileExtension == 'png' || $fileExtension == 'bmp' || $fileExtension == 'svg'): ?>
                                                                            <i class="fas fa-camera-retro"></i>  <?php echo $this->lang->line('attachment'); ?>
                                                                        <?php elseif ($fileExtension == 'pdf'): ?>
                                                                            <i class="far fa-file-pdf"></i>  <?php echo $this->lang->line('attachment'); ?>
                                                                        <?php elseif ($fileExtension == 'doc' || $fileExtension == 'docx'): ?>
                                                                            <i class="far fa-file-word"></i>  <?php echo $this->lang->line('attachment'); ?>
                                                                        <?php elseif ($fileExtension == 'txt'): ?>
                                                                            <i class="far fa-file-alt"></i>  <?php echo $this->lang->line('attachment'); ?>
                                                                        <?php else: ?>
                                                                            <i class="fa fa-file"></i>  <?php echo $this->lang->line('attachment'); ?>
                                                                        <?php endif; ?>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                                <?= $quiz_taken && $show_result && $is_quiz_tottaly_marked ? '<br/><span class="mx-2" title="' . $this->lang->line('quiz_result') . '">' . $quiz_taken . '</span>' : '' ?>
                                                                <?php if ($quiz_taken && $is_quiz_tottaly_marked && $lesson->show_result_details && strpos($quiz_taken, '(') === false) { ?>
                                                                    <a class="btn btn-sm btn-info" href="<?= base_url('home/quiz_result/' . $lesson->id) ?>" title="<?= $this->lang->line('show_result_details') ?>"><i class="far fa-eye"></i></a>&nbsp;&nbsp;&nbsp;
                                                                <?php } ?>
                                                            </div>


                                                        </td>
                                                    </tr>
                                                    <?php
                                                    if ($active == 1) {
                                                        $active++;
                                                    } else {
                                                        $active = 0;
                                                    }
                                                endforeach;
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- Lesson Content ends from here -->
                    </div>
                </div>
                <?php
                if ($is_quiz == 0 && isset($lesson_id) && $this->session->userdata('user_id')) {
                    if (!$this->session->flashdata('quiz_result')) {
                        ?>
                        <div class="tab-pane fade" id="comments" role="tabpanel" aria-labelledby="comments-tab">

                            <div class="row my-4">
                                <div class="col-lg-12">
                                    <!--begin::Scroll-->
                                    <div class="scroll scroll-pull" data-mobile-height="350">
                                        <!--begin::Messages-->
                                        <?= form_open(base_url() . 'home/add_comment/' . $lesson_id) ?>
                                        <!--<form action="<?//= base_url() ?>home/add_comment/<?//= $lesson_id ?>" method="post" >-->
                                        <div class="messages">
                                            <?php foreach ($comments as $comment) { ?>
                                                <!--begin::Message In-->
                                                <div class="d-flex flex-column mb-5 align-items-start">

                                                    <div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold text-left comment_container" style="width: 100%">
                                                        <div class="d-flex align-items-center comment_header">
                                                            <div class="symbol symbol-circle symbol-35 mr-3">
                                                                <img alt="Pic" src="<?= base_url() ?>assets/images/users/<?= $comment->image != '' ? $comment->image : 'user-avatar.png' ?>" />
                                                            </div>
                                                            <div class="w-100">
                                                                <a class="text-dark-75 text-hover-primary font-weight-bold font-size-h6 float-text"><?php
                                                                    if ($comment->user_type == 0) {
                                                                        //echo $this->session->userdata('language') == "english" ? $comment->first_name : $comment->name_arabic;
                                                                        echo $comment->username;
                                                                    } else if ($comment->user_type == 1) {
                                                                        echo '<span class="text-primary" title="' . $this->lang->line('teacher') . '">' . $comment->teacher_name . '</span>';
                                                                    } else if ($comment->user_type == 2) {
                                                                        echo '<span class="text-danger" title="Admin">' . $comment->admin_name . '</span>';
                                                                    }
                                                                    ?></a>
                                                                <p class="text-muted font-size-sm margin text-right"><?= getFromInterval($comment->created_on) ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="rounded px-5 text-dark-50 font-weight-bold comment_container">
                                                            <p class="mt-2 comment_body"><?= $comment->comment ?></p>
                                                            <a onclick="add_like(<?= $comment->id ?>, $(this))"><i class="far fa-thumbs-up" title="<?= $this->lang->line('like') ?>"></i></a>
                                                            &nbsp;<span class="likes_count"><?= $comment->likes_count ?></span>
                                                            <a class="reply_margin reply_btn" data-comment_id="<?= $comment->id ?>"><?= $this->lang->line('reply') ?></a>
                                                        </div>
                                                        <?php if (count($comment->replies) > 0) { ?>
                                                            <hr/>
                                                        <?php } ?>

                                                        <?php foreach ($comment->replies as $reply) { ?>
                                                            <div class="d-flex flex-column mb-5 align-items-start reply">
                                                                <div class="d-flex align-items-center w-100">
                                                                    <div class="symbol symbol-circle symbol-35 mr-3">
                                                                        <img alt="Pic" src="<?= base_url() ?>assets/images/users/<?= $reply->image != '' ? $reply->image : 'user-avatar.png' ?>" />
                                                                    </div>
                                                                    <div class="w-100">
                                                                        <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6 float-text"><?php
                                                                            if ($reply->user_type == 0) {
                                                                                //echo $this->session->userdata('language') == "english" ? $reply->first_name : $reply->name_arabic;
                                                                                echo $reply->username;
                                                                            } else if ($reply->user_type == 1) {
                                                                                echo '<span class="text-primary" title="' . $this->lang->line('teacher') . '">' . $reply->teacher_name . '</span>';
                                                                            } else if ($reply->user_type == 2) {
                                                                                echo '<span class="text-danger" title="Admin">' . $reply->admin_name . '</span>';
                                                                            }
                                                                            ?></a>
                                                                        <p class="text-muted font-size-sm margin text-right"><?= getFromInterval($reply->created_on) ?></p>
                                                                    </div>
                                                                </div>
                                                                <div class="rounded px-5 text-dark-50 font-weight-bold comment_container">
                                                                    <p class="mt-2"><?= $reply->comment ?></p>
                                                                    <a onclick="add_like(<?= $reply->id ?>, $(this))"><i class="far fa-thumbs-up" title="<?= $this->lang->line('like') ?>"></i></a>
                                                                    &nbsp;<span class="likes_count"><?= $reply->likes_count ?></span>
                                                                </div>
                                                            </div>
                                                            <?php if ($comment->replies[count($comment->replies) - 1]->id != $reply->id) { ?>
                                                                <hr/>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <!--end::Message In-->

                                                <?php
                                            }
                                            if (count($comments) == 0) {
                                                echo '<p class="text-center">' . $this->lang->line('no_comments') . '</p>';
                                            }
                                            ?>


                                            <br/>
                                            <h3 class="comments_f_header <?= $this->session->userdata('language') == 'arabic' ? 'text-right' : '' ?>"><?= $this->lang->line('add_comment') ?></h3>
                                            <textarea class="form-control form-control-solid <?= $this->session->userdata('language') == 'arabic' ? 'text-right' : '' ?>" name="comment" rows="10"></textarea>
                                            <button type="submit" class="btn btn-primary m-t-15 complete_course_btn"><?= $this->lang->line('add') ?></button>
                                        </div>
                                        </form>
                                        <!--end::Messages-->
                                    </div>
                                    <!--end::Scroll-->
                                </div>
                            </div>

                        </div>
                        <?php
                    }
                }
                ?>


                <?php
                if ($is_quiz == 0 && isset($lesson_id) && $this->session->userdata('user_id')) {
                    if (!$this->session->flashdata('quiz_result')) {
                        ?>
                        <div class="tab-pane fade" id="fatawa" role="tabpanel" aria-labelledby="fatawas-tab">

                            <div class="row my-4">
                                <div class="col-lg-12">
                                    <!--begin::Scroll-->
                                    <div class="scroll scroll-pull" data-mobile-height="350">
                                        <!--begin::Messages-->
                                        <?= form_open(base_url() . 'home/add_fatwa_req/' . $lesson_id) ?>
                                        <!--<form action="<?= base_url() ?>home/add_fatwa_req/<?= $lesson_id ?>" method="post" >-->
                                        <div class="messages">
                                            <?php foreach ($fatawas as $fatawa) { ?>
                                                <!--begin::Message In-->
                                                <div class="d-flex flex-column mb-5 align-items-start">

                                                    <div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold text-left comment_container" style="width: 100%">
                                                        <div class="d-flex align-items-center comment_header">
                                                            <div class="symbol symbol-circle symbol-35 mr-3">
                                                                <img alt="Pic" src="<?= base_url() ?>assets/images/users/<?= $fatawa->image != '' ? $fatawa->image : 'user-avatar.png' ?>" />
                                                            </div>
                                                            <div class="w-100">
                                                                <a class="text-dark-75 text-hover-primary font-weight-bold font-size-h6 float-text"><?php
                                                                    if ($fatawa->user_type == 0) {
                                                                        //echo $this->session->userdata('language') == "english" ? $fatawa->first_name : $fatawa->name_arabic;
                                                                        echo $fatawa->username;
                                                                    } else if ($fatawa->user_type == 1) {
                                                                        echo '<span class="text-primary" title="' . $this->lang->line('teacher') . '">' . $fatawa->teacher_name . '</span>';
                                                                    } else if ($fatawa->user_type == 2) {
                                                                        echo '<span class="text-danger" title="Admin">' . $fatawa->admin_name . '</span>';
                                                                    }
                                                                    ?></a>
                                                                <p class="text-muted font-size-sm margin text-right"><?= getFromInterval($fatawa->created_on) ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="rounded px-5 text-dark-50 font-weight-bold comment_container">
                                                            <p class="mt-2 comment_body"><?= $fatawa->body ?></p>
                                                            <!--<a class="reply_margin reply_btn" data-comment_id="<?//= $fatawa->id ?>"><?//= $this->lang->line('reply') ?></a>-->
                                                        </div>
                                                        <?php if (count($fatawa->replies) > 0) { ?>
                                                            <hr/>
                                                        <?php } ?>

                                                        <?php
                                                        foreach ($fatawa->replies as $reply) {
                                                            if ($reply->hide == 1) {
                                                                continue;
                                                            }
                                                            ?>
                                                            <div class="d-flex flex-column mb-5 align-items-start reply">
                                                                <div class="d-flex align-items-center <?= $this->session->userdata('language') == 'arabic' ? 'comment_header' : '' ?> w-100">
                                                                    <div class="symbol symbol-circle symbol-35 mr-3">
                                                                        <img alt="Pic" src="<?= base_url() ?>assets/images/users/<?= $reply->image != '' ? $reply->image : 'user-avatar.png' ?>" />
                                                                    </div>
                                                                    <div class="w-100">
                                                                        <a href="#" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6 float-text"><?php
                                                                            if ($reply->user_type == 0) {
                                                                                // echo $this->session->userdata('language') == "english" ? $reply->first_name : $reply->name_arabic;
                                                                                echo $reply->username;
                                                                            } else if ($reply->user_type == 1) {
                                                                                echo '<span class="text-primary" title="' . $this->lang->line('teacher') . '">' . $reply->teacher_name . '</span>';
                                                                            } else if ($reply->user_type == 2) {
                                                                                echo '<span class="text-danger" title="Admin">' . $reply->admin_name . '</span>';
                                                                            }
                                                                            ?></a>
                                                                        <p class="text-muted font-size-sm margin text-right"><?= getFromInterval($reply->created_on) ?></p>
                                                                    </div>
                                                                </div>
                                                                <div class="rounded px-5 text-dark-50 font-weight-bold comment_container">
                                                                    <p class="mt-2"><?= $reply->body ?></p>
                                                                </div>
                                                            </div>
                                                            <?php if ($fatawa->replies[count($fatawa->replies) - 1]->id != $reply->id) { ?>
                                                                <hr/>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <!--end::Message In-->

                                                <?php
                                            }
                                            if (count($fatawas) == 0) {
                                                echo '<p class="text-center">' . $this->lang->line('no_fatawas') . '</p>';
                                            }
                                            ?>


                                            <br/>
                                            <h3 class="comments_f_header <?= $this->session->userdata('language') == 'arabic' ? 'text-right' : '' ?>"><?= $this->lang->line('add_question') ?></h3>
                                            <textarea class="form-control form-control-solid <?= $this->session->userdata('language') == 'arabic' ? 'text-right' : '' ?>" name="body" rows="10"></textarea>
                                            <button type="submit" class="btn btn-primary m-t-15 complete_course_btn"><?= $this->lang->line('add') ?></button>
                                        </div>
                                        </form>
                                        <!--end::Messages-->
                                    </div>
                                    <!--end::Scroll-->
                                </div>
                            </div>

                        </div>
                        <?php
                    }
                }
                ?>



                <!--                <div class="tab-pane fade" id="certificate" role="tabpanel" aria-labelledby="certificate-tab" style="text-align: center;">
                
                                    <div class="circular-progressdiv" id="course_progress_area"  data-percent="<?php //echo course_progress($course_id);                                          ?>">
                                        <svg class="circular-progress" viewport="0 0 100 100" version="1.1" xmlns="http://www.w3.org/2000/svg" style="height: 180; width: 180;">
                                        <circle r="80" cx="89" cy="89" fill="transparent" stroke-dasharray="502.4" stroke-dashoffset="0" ></circle>
                                        <circle class="bar" r="80" cx="89" cy="89" fill="transparent" stroke-dasharray="502.4" stroke-dashoffset="0"></circle>
                                        </svg>
                                    </div>
                
                                    <div class="alert alert-info" id="certificate-alert-warning" role="alert">
                                        <h4 class="alert-heading"><?php //echo $this->lang->line('Notice');                                          ?></h4>
                                        <hr>
                                        <p> <?php //echo $this->lang->line('you have completed');                                          ?> <span id="progression"></span>% <?php //echo $this->lang->line('of_the_course');                                          ?> </p>
                                        <p><?php //echo $this->lang->line('you_can_download_the_course_completion_certificate_after_completing_the_course');                                          ?></p>
                                    </div>
                
                                    <div class="alert alert-success" id="certificate-alert-success" role="alert">
                                        <h4 class="alert-heading"><?php //echo $this->lang->line('well_done');                                          ?></h4>
                                        <hr>
                                        <p><?php //echo $this->lang->line('congratulations') . '!!!';                                          ?></p>
                                        <p><?php //echo $this->lang->line('you_are_now_eligible_to_download_the_course_completion_certificate');                                          ?>.</p>
                                    </div>
                
                                    <div id="download_certificate_area" style="padding: 15px;">
                                        <a href="#" target="_blank" class="btn btn-primary" id = "certificate_download_btn" disabled><?php //echo $this->lang->line('get_certificate');                                          ?></a>
                
                                    </div>
                
                                </div>-->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

</script>
