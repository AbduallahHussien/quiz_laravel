<?php
if (!$this->session->flashdata('quiz_result')) {
    $sett = get_setting();
    $this->load->model('Quiz_Model');
    $level = $this->Quiz_Model->get_subject_id($lesson_id);

    $student_id = $this->session->userdata('user_id');
    $already_exits = $this->Quiz_Model->get_check_level($student_id, $lesson_id);
    $show_quiz = 1;
    if ($already_exits && $level->retake_exam == 0) {
        echo $this->lang->line('already_your_written_exam_your_cant_write_again');
        $show_quiz = 0;
    } else if ($level->start_date && $level->end_date) {
        if (!(strtotime(date("Y-m-d h:i:s")) >= strtotime($level->start_date) && strtotime(date("Y-m-d  h:i:s")) <= strtotime($level->end_date))) {
            echo '<div class="text-center text-danger"><h2>' . $this->lang->line('closed') . '</h2></div>';
            $show_quiz = 0;
        }
    } else if ($level->status == 0) {
        echo '<div class="text-center text-danger"><h2>' . $this->lang->line('currently_unavailable') . '</h2></div>';
        $show_quiz = 0;
    }

    if ($show_quiz) {
        $fliter['random_exam'] = $lesson_details['random_exam'];
        $fliter['easy_questions'] = $lesson_details['easy_questions'];
        $fliter['medium_questions'] = $lesson_details['medium_questions'];
        $fliter['hard_questions'] = $lesson_details['hard_questions'];
        //$fliter['limit_question'] = $lesson_details['limit_question'];
        $is_quiz_tottaly_marked = $this->crud_model->is_quiz_tottaly_marked($lesson_details['id'], $this->session->userdata('user_id'));
        $quiz_questions = $this->crud_model->get_quiz_questions($lesson_details['id'], $fliter);
        ?>
        <div id="quiz-body">
            <div class="" id="quiz-header">
                <?php echo $this->lang->line("quiz_title"); ?> : <strong><?php echo $lesson_details['name']; ?></strong><br>

                <?php
                $quiz_taken = $this->crud_model->is_quiz_taken($lesson_details['id'], $this->session->userdata('user_id'));
                if ($quiz_taken && $lesson_details['answer_manually'] == 1 && $is_quiz_tottaly_marked) {
                    echo '<span class="text-danger">';
                    echo $this->lang->line("u_take_quiz_before_ur_result_is");
                    ?> <strong><?php echo $quiz_taken; ?></strong><br></span>
                <?php } ?>

                <?php echo $this->lang->line("number_of_questions"); ?> : <strong><?php echo count($quiz_questions) ?></strong><br>

                <?php if ($level->quiz_instructions) { ?>
                    <div <?= $this->session->userdata('language') == 'english' ? 'class="text-left"' : 'class="text-right" dir="rtl"' ?> style="margin: 20px 0" id="lesson-summary">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?= $this->lang->line("instruction") ?> :</h5>
                                <p class="card-text"><?= $level->quiz_instructions ?></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if (count($quiz_questions) > 0): ?>
                    <button type="button" name="button" class="btn btn-sign-up mb-2" style="color: #fff;" onclick="getStarted(1)"><?php echo $this->lang->line("get_started"); ?></button>
                <?php endif; ?>
            </div>


            <?= form_open_multipart(base_url() . 'Home/handle_submit_quiz/' . $lesson_id, 'id = "quiz-form"') ?>
                    <!--<form class="" id = "quiz-form" action="<?//= base_url() ?>Home/handle_submit_quiz/<?//= $lesson_id ?>" method="post" enctype="multipart/form-data">-->
            <div class="hidden quiz_data">
                <p>
                    <?= $this->lang->line('total_answered') ?> : <span id="total_answered" class="text-right">0</span>
                    <br/>
                    <?php if ($level->show_line == 1) { ?>
                        <span class="number-of-questions"><?php echo $this->lang->line('total_questions') ?>: <?php echo count($quiz_questions) ?></span>
                    <?php } ?>
                </p>
                <span class="countdown"></span>
            </div>
            <input type="hidden" name="start_time" value="<?php echo date("Y-m-d h:i:s"); ?>" >
            <input type="hidden" name="total_timing" class="total_timing" value="<?php echo $level->total_time; ?>" >
            <input type="hidden" name="spent_time" class="spent_time" value="" >
            <input type="hidden" name="insert_id" value="" id="insert_id">
            <input type="hidden" name="total_question" value="<?php echo count($quiz_questions); ?>">
            <?php if (count($quiz_questions) > 0): ?>
                <?php
                foreach ($quiz_questions as $key => $quiz_question):
                    $options = $this->db->get_where('answer_list', array('question_id' => $quiz_question['id']))->result_array();
                    if ($level->random_answer_exam) {
                        shuffle($options);
                    }
                    //$options = json_decode($quiz_question['options']);
                    ?>
                    <input type="hidden" name="lesson_id" value="<?php echo $lesson_details['id']; ?>">
                    <div class="hidden question mt-4">
                        <div id = "question-number-<?php echo $key + 1; ?>" class="test-box <?php
                if ($level->show_line == 1) {
                    echo ($key + 1) <= ($level->question_per_page ) ? "current" : "quiz-hide";
                }
                    ?>" data-id="<?php echo $key + 1; ?>">
                            <div class="row justify-content-center">
                                <div class="col-lg-8 <?= $quiz_question['required'] ? 'answer_require' : '' ?>">
                                    <div class="card quiz-card <?= $this->session->userdata('language') == 'english' ? 'text-left' : 'text-right'; ?>">
                                        <div class="card-body">
                                            <h6 class="card-title"><?php echo $this->lang->line("question") . ' ' . ($key + 1); ?> : <strong><?php echo $quiz_question['name']; ?> <?= $quiz_question['required'] ? '<i class="text-danger">*</i>' : '' ?></strong></h6>
                                            <input type="hidden" value="<?= $quiz_question['id'] ?>" name="question_id" />
                                        </div>
                                        <ul class="list-group list-group-flush pr-0">
                                            <?php foreach ($options as $key2 => $option): ?>
                                                <li class="list-group-item quiz-options ">
                                                    <div class="form-check">
                                                        <input class="form-check-input answer_choice" type="radio" name="answer_id[<?php echo $quiz_question['id'] ?>]" data-question-id="<?= $quiz_question['id'] ?>" value="<?php echo $option['id']; ?>" id="quiz-id-<?php echo $quiz_question['id']; ?>-option-id-<?php echo $key2 + 1; ?>" onclick=""> <!-- enableNextButton('<?php //echo $quiz_question['id'];                                                         ?>') -->
                                                        <label class="form-check-label px-3" for="quiz-id-<?php echo $quiz_question['id']; ?>-option-id-<?php echo $key2 + 1; ?>">
                                                            <?php echo $option['answer']; ?>
                                                        </label>
                                                    </div>
                                                </li>
                                            <?php endforeach; ?>
                                            <?php if ($quiz_question['qu_type'] == 1 || $quiz_question['qu_type'] == 2) { ?>
                                                <textarea name="answer_id[<?php echo $quiz_question['id'] ?>]" class="form-control" rows="<?= $quiz_question['qu_type'] == 1 ? 2 : 6 ?>"></textarea>
                                            <?php } ?>
                                            <?php if ($quiz_question['qu_type'] == 3) { ?>
                                                <input type="file" name="files[<?php echo $quiz_question['id'] ?>]" class="files" />
                                            <?php } ?>
                                            <label id="answer_id[<?php echo $quiz_question['id']; ?>]-error" class="error" for="answer_id[<?php echo $quiz_question['id']; ?>]"></label>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="hidden quiz_data">
                    <div class="row  " style="margin-top: 20px;" >
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <div class="col-md-6 float-left">
                                <div class="next-question text-right"  >
                                    <?php if ($level->show_line == 1) { ?>
                                        <?php if ($this->session->userdata('language') == 'english') { ?>
                                            <button type="button" class="btn quiz-btn btn-next" onclick="nextBtn()"><?= $this->lang->line('next') ?> &nbsp;<i class="fa fa-arrow-right"></i></button>
                                        <?php } else { ?>
                                            <button type="button" class="btn quiz-btn btn-next" onclick="nextBtn()"><i class="fa fa-arrow-left"></i>&nbsp;<?= $this->lang->line('next') ?> </button>
                                        <?php } ?>
                                        <button type="submit" class="btn quiz-btn btn-submit" style="display: none;"><?= $this->lang->line('submit') ?> &nbsp;<i class="fa fa-save"></i></button>
                                    <?php } else { ?>
                                        <button type="submit" class="btn quiz-btn btn-submit" ><?= $this->lang->line('submit') ?> &nbsp;<i class="fa fa-save"></i></button>
                                    <?php } ?>

                                </div>
                            </div>

                            <div class="col-md-6 float-right">
                                <?php if ($level->disable_back_in_questions) { ?>

                                    <div class="next-question text-left previous-div" style="display: none">
                                        <?php if ($this->session->userdata('language') == 'english') { ?>
                                            <button type="button" class="btn quiz-btn btn-previous" onclick="prevBtn()"><i class="fa fa-arrow-left"></i> &nbsp; <?= $this->lang->line('previous') ?> </button>
                                        <?php } else { ?>
                                            <button type="button" class="btn quiz-btn btn-previous" onclick="prevBtn()"> <?= $this->lang->line('previous') ?> &nbsp;  <i class="fa fa-arrow-right"></i></button>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>

                <input type="hidden" name="current_stage" id="current_stage" class="current_stage"  >
                <input type="hidden" name="total_page" class="total_question" value="<?php echo count($quiz_questions) ? @ceil(count($quiz_questions) / @ $level->question_per_page) : 0; ?>">
                <input type="hidden" name="question_limit" class="question_limit" value="<?php echo $level->question_per_page; ?>">
                            <!--<button type="button" name="button" class="btn btn-sign-up mt-2 mb-2 quiz_data hidden" id = "next-btn-<?php //echo $quiz_question['id'];                                                                          ?>" style="color: #fff;" <?php if (count($quiz_questions) == $key + 1): ?>onclick="submitQuiz()"<?php else: ?>onclick="showNextQuestion('<?php echo $key + 2; ?>')"<?php endif; ?> disabled><?php echo count($quiz_questions) == $key + 1 ? $this->lang->line("check_result") : $this->lang->line("submit_and_next"); ?></button>-->
            <?php endif; ?>
            <?= form_close() ?>
        </div>
    <?php } ?>
<?php } else { ?>
    <div id="quiz-result" class="text-left">
        <?php $this->load->view('frontend/lessons/quiz_result', $page_result_data); ?>
    </div>
<?php } ?>


<?php if (!$this->session->flashdata('quiz_result')) { ?>
    <script type="text/javascript">
        start_quiz = 0;
        function getStarted(first_quiz_question) {
            $.ajax({
                url: '<?php echo site_url('home/start_quiz'); ?>',
                type: 'post',
                dataType: 'JSON',
                data: {'lesson_id': '<?= $lesson_id ?>', 'course_id': '<?= $course_id ?>',
                    '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash() ?>'},
                success: function (response) {
                    start_quiz = 1;
                    $(window).bind("beforeunload", function () {
                        return(false);
                    });

                    $('#quiz-header').hide();
                    $('#lesson-summary').hide();
                    $("#insert_id").val(response[0]);
                    $("input[name='token']").val(response[1]);
                    $(".quiz_data").show();
                    $(".question").show();
                    start_timers();
                    //  $('#question-number-' + first_quiz_question).show();
                }
            });
        }
        //        function showNextQuestion(next_question) {
        //            $('#question-number-' + (next_question - 1)).hide();
        //            $('#question-number-' + next_question).show();
        //        }
        //        function submitQuiz() {
        //            $.ajax({
        //                url: '<?php //echo site_url('home/submit_quiz');                                                                        ?>',
        //                type: 'post',
        //                data: $('form#quiz_form').serialize(),
        //                success: function (response) {
        //                    $('#quiz-body').hide();
        //                    $('#quiz-result').html(response);
        //                }
        //            });
        //        }
        //        function enableNextButton(quizID) {
        //            $('#next-btn-' + quizID).prop('disabled', false);
        //        }
        //page = 1;
        function validate_form() {
            if ($("#current_stage").val() == 1) {

                return true;
            }
            var id = $(".test-box.current:last").data("id");
            var question_limit = $(".question_limit").val();
            $(".test-box").removeClass("current").addClass("quiz-hide");
            for (var i = 0; i < question_limit; i++) {
                id++;
                //$(".test-box.current").prevAll(".test-box").eq(i).removeClass("current").addClass("quiz-hide");
                $(".test-box[data-id='" + id + "']").removeClass("quiz-hide").addClass('current');
                // $(".test-box[data-id='" + id + "']").nextAll(".test-box").eq(i).addClass("current");
            }


            var total_question = $(".total_question").val();
            var total_page = $(".test-box.current:last").attr("data-id");

            //alert(total_question  + "--" + (total_page / question_limit) );

            //$(this).parent().next(".test-box").toggle();
            //$(".test-box.current").removeClass("current").addClass(".quiz-hide");
            var count = $(".test-box.current:last").attr("data-id");
            // alert(count / question_limit );
            // $(".current_question").html(count);
            if (count > 1) {
                $(".previous-div").show();
            } else {
                $(".previous-div").hide();
            }
            //var total_question = $(".total_question").val();
            //alert(total_question + "---" + Math.ceil(total_page / question_limit));
            if (typeof total_page == 'undefined') {
                show_not_answered_qus();
            } else {
                if (total_question == Math.ceil(total_page / question_limit)) {
                    if ($('.show_in_last').length) {
                        $(".btn-submit").hide();
                        $(".btn-next").show();
                        //
                    } else {
                        $(".btn-submit").show();
                        $(".btn-next").hide();
                    }
                } else {
                    $(".btn-submit").hide();
                }
            }
            // page++;
            return false;
        }

    </script>
    <script>

        $(function () {
            var total_question = $(".total_question").val();
            var total_page = $(".test-box.current:last").attr("data-id");
            var question_limit = $(".question_limit").val();
            if (total_question == Math.ceil(total_page / question_limit)) {
                $(".btn-submit").show();
                $(".btn-next").hide();
            }
    <?php if (isset($sett) && $sett && $sett->quiz_file_max_size) { ?>
                $(".files").on("change", function () {
                    if (this.files[0].size > <?= $sett->quiz_file_max_size * 1000 ?>) {
                        alert("<?= $this->lang->line('plz_upload_file_less_than') ?> <?= $sett->quiz_file_max_size ?>KB.");
                        $(this).val('');
                        return;
                    }
                    var allowed_types = $.parseJSON('<?= json_encode(explode(',', str_replace('|', ',', $sett->quiz_file_allowed_types))) ?>');
                    if ($.inArray($(this).val().split('.').pop().toLowerCase(), allowed_types) == -1) {
                        alert("<?= $this->lang->line('only_allowed_types_are') ?> " + allowed_types.join(', '));
                        $(this).val('');
                    }
                });
    <?php } ?>
        });
        function show_not_answered_qus() {
            $(".test-box").removeClass("current").addClass("quiz-hide");
            $(".show_in_last .test-box").removeClass('quiz-hide').addClass('current');
            $(".show_in_last").removeClass('show_in_last');
            $(".btn-submit").show();
            $(".btn-next").hide();
            // validate_form();
        }

        function nextBtn() {
    <?php if (!$level->disable_back_in_questions) { ?>
                all_answered = true;
                $(".current .answer_require").find('.answer_choice:first').each(function () {
                    var input_name = $(this).attr('name');
                    if (typeof $("input[name='" + input_name + "']:checked").val() == 'undefined') {
                        alert('<?= $this->lang->line('you_must_answer_mandatory_qu') ?>');
                        all_answered = false;
                        return false;
                    }
                });
                if (!all_answered) {
                    return;
                }
    <?php } else { ?>
                // to save not answered question to be shown in last
                $(".current").find('.answer_choice:first').each(function () {
                    var input_name = $(this).attr('name');
                    if (typeof $("input[name='" + input_name + "']:checked").val() == 'undefined') {
                        $(this).closest('.question').addClass('show_in_last');
                    }
                });
    <?php } ?>
            var validate = validate_form();
            if (validate) {
                $("#quiz-form").submit();
            }

    <?php if ($level->qu_time) { ?>
                if (timerQuInterval) {
                    clearInterval(timerQuInterval);
                }
                qu_time = "<?php echo $level->qu_time; ?>:00";
                timerQuInterval = setInterval(countDownTimerPerQuestion, 1000);
    <?php } ?>
        }
        //$("body").on("click", ".btn-previous", function () {
        function prevBtn() {

            var id = $(".test-box.current:first").data("id");
            //alert(id);
            var question_limit = $(".question_limit").val();
            $(".test-box").removeClass("current").addClass("quiz-hide");
            ;
            for (var i = 0; i < question_limit; i++) {
                id--;
                //$(".test-box.current").prevAll(".test-box").eq(i).removeClass("current").addClass("quiz-hide");
                ///alert(i);
                $(".test-box[data-id='" + id + "']").removeClass('quiz-hide').addClass("current");
                //  $(".test-box[data-id='" + id + "']").prevAll(".test-box").eq(i).addClass("current");
            }


            // $(".test-box.current").prev(".test-box").addClass("current");
            // $(".test-box.current:first").next(".test-box").removeClass("current").addClass("quiz-hide");
            //$(this).parent().next(".test-box").toggle();
            //$(".test-box.current").removeClass("current").addClass(".quiz-hide");
            count = $(".test-box.current:first").attr("data-id");
            //alert(count);
            // $(".current_question").html(count);
            if (count > 1) {
                $(".previous-div").show();
            } else {
                $(".previous-div").hide();
                $(".btn-next").show();
                $(".btn-submit").hide();
            }
        }

        $("body").on("click", ".btn-submit", function (event) {
            event.preventDefault();
            //$("form").validate_form().cancelSubmit = true;
    <?php if ($level->disable_back_in_questions) { ?>
                all_answered = true;
                $(".answer_require").find('.answer_choice:first').each(function () {
                    var input_name = $(this).attr('name');
                    if (typeof $("input[name='" + input_name + "']:checked").val() == 'undefined') {
                        alert('<?= $this->lang->line('you_must_answer_mandatory_qu') ?>');
                        all_answered = false;
                        return false;
                    }
                });
                if (!all_answered) {
                    return;
                }
    <?php } ?>
            submit = 1;
            $("#current_stage").val(1);
            var validate = validate_form();
            if (validate) {
                $(this).prop('disabled', true);
                $(this).html('Loading...');
                $("#quiz-form").submit();
            }
            $(window).unbind('beforeunload');
        });
        answered_qu = [];
        $("body").on("click", ".answer_choice", function () {
            var question_id = $(this).attr('data-question-id');
            if ($.inArray(question_id, answered_qu) == -1) {
                answered_qu.push(question_id);
                $("#total_answered").text(answered_qu.length);
            }
        });

    </script>

    <script type="text/javascript">
        function start_timers() {
            // question exam timer 
    <?php if ($level->qu_time) { ?>
                qu_time = "<?php echo $level->qu_time; ?>:00";
                timerQuInterval = setInterval(countDownTimerPerQuestion, 1000);
        <?php
        // total exam timer
    } else if ($level->total_time) {
        ?>
                var timer2 = "<?php echo $level->total_time; ?>:00";
                var interval = setInterval(function () {

                    var timer = timer2.split(':');
                    //by parsing integer, I avoid all extra string processing
                    var minutes = parseInt(timer[0], 10);
                    var seconds = parseInt(timer[1], 10);
                    --seconds;
                    minutes = (seconds < 0) ? --minutes : minutes;
                    seconds = (seconds < 0) ? 59 : seconds;
                    seconds = (seconds < 10) ? '0' + seconds : seconds;
                    //minutes = (minutes < 10) ?  minutes : minutes;
                    $('.countdown').html(minutes + ':' + seconds);

                    if (minutes < 0)
                        clearInterval(interval);
                    //check if both minutes and seconds are 0
                    if ((seconds <= 0) && (minutes <= 0)) {
                        clearInterval(interval);
        <?php if ($level->expire_time_after_submit == 1) { ?>
                            // $("form").validate_form().cancelSubmit = true;
                            $("#current_stage").val(1);
                            var validate = validate_form();
                            if (validate) {
                                $(window).unbind('beforeunload');
                                $("#quiz-form").submit();
                            }
        <?php } ?>
                        return false;
                    }
                    timer2 = minutes + ':' + seconds;
                }, 1000);

    <?php } ?>
            // END total exam timer 
            setInterval(countTimer, 1000);
        }

        var totalSeconds = 0;

        function countTimer() {
            ++totalSeconds;
            var hour = Math.floor(totalSeconds / 3600);
            var minute = Math.floor((totalSeconds - hour * 3600) / 60);
            var seconds = totalSeconds - (hour * 3600 + minute * 60);
            if (hour < 10)
                hour = "0" + hour;
            if (minute < 10)
                minute = "0" + minute;
            if (seconds < 10)
                seconds = "0" + seconds;
            $(".spent_time").val(hour + ":" + minute + ":" + seconds);
            // console.log(hour + ":" + minute + ":" + seconds);
        }

        function countDownTimerPerQuestion() {

            var timer = qu_time.split(':');
            //by parsing integer, I avoid all extra string processing
            var minutes = parseInt(timer[0], 10);
            var seconds = parseInt(timer[1], 10);
            --seconds;
            minutes = (seconds < 0) ? --minutes : minutes;
            seconds = (seconds < 0) ? 59 : seconds;
            seconds = (seconds < 10) ? '0' + seconds : seconds;
            //minutes = (minutes < 10) ?  minutes : minutes;
            $('.countdown').html(minutes + ':' + seconds);

            if (minutes < 0)
                clearInterval(timerQuInterval);
            //check if both minutes and seconds are 0
            if ((seconds <= 0) && (minutes <= 0)) {
                clearInterval(timerQuInterval);

                var total_question = $(".total_question").val();
                var total_page = $(".test-box.current:last").attr("data-id");
                var question_limit = $(".question_limit").val();
                // This is the last question so submit the exam
                if (total_question == Math.ceil(total_page / question_limit)) {
                    // $("form").validate_form().cancelSubmit = true;
                    $("#current_stage").val(1);
                    var validate = validate_form();
                    if (validate) {
                        $("#quiz-form").submit();
                    }
                } else {
                    nextBtn();
                }
                return false;
            }
            qu_time = minutes + ':' + seconds;
        }


        document.addEventListener('keypress', function (e) {
            if (e.keyCode === 13 || e.which === 13) {
                e.preventDefault();
                return false;
            }

        });

        // function timeConvert(n) {
        // var num = n;
        //   var hours = (num / 60);
        //   var rhours = Math.floor(hours);
        //   var minutes = (hours - rhours) * 60;
        //   var rminutes = Math.round(minutes);
        //   return num + " minutes = " + rhours + " hour(s) and " + rminutes + " minute(s).";
        // }


    </script>
<?php } ?>

