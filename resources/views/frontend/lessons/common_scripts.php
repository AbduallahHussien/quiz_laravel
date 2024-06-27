<script type="text/javascript">
//saving the current progress and starting from the saved progress
    var newProgress;
    var savedProgress;
    var currentProgress = '<?php echo lesson_progress($lesson_id); ?>';
    var lessonType = '<?php echo $lesson_details['type']; ?>';
    var videoProvider = '<?php echo isset($provider) ? $provider : null; ?>';

    function markThisLessonAsCompleted(lesson_id, automatic_check = 0) {
        $('#lesson_list_area').hide();
        $('#lesson_list_loader').show();
        var progress;
        if ($('input#' + lesson_id).is(':checked')) {
            progress = 1;
        } else {
            progress = 0;
        }
        if (automatic_check) {
            progress = 1;
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url('user/save_course_progress'); ?>',
            data: {lesson_id: lesson_id, progress: progress},
            success: function (response) {
                currentProgress = response;
                $('#lesson_list_area').show();
                $('#lesson_list_loader').hide();
            }
        });
    }


    var timer = setInterval(function () {
//  console.log('Current Progress is '+currentProgress);
        if (lessonType == 'video' && videoProvider == 'html5' && currentProgress != 1) {
            getCurrentTime();
        }
    }, 1000);

    $(document).ready(function () {
        if (lessonType == 'video' && videoProvider == 'html5') {
            var totalDuration = document.querySelector('#player').duration;

            if (currentProgress == 1 || currentProgress == totalDuration) {
                document.querySelector('#player').currentTime = 0;
            } else {
                document.querySelector('#player').currentTime = currentProgress;
            }
        }
    });
    var counter = 0;
<?php if (!isset($not_video)) { ?>
        player.on('canplay', event => {
            if (counter == 0) {
                if (currentProgress == 1) {
                    document.querySelector('#player').currentTime = 0;
                } else {
                    document.querySelector('#player').currentTime = currentProgress;
                }
            }
            counter++;
        });
<?php } ?>

    function getCurrentTime() {
        var lesson_id = '<?php echo $lesson_id; ?>';
        newProgress = document.querySelector('#player').currentTime;
        var totalDuration = document.querySelector('#player').duration;

//  console.log('Current Progress is '+currentProgress);
//  console.log('New Progress is '+newProgress);

        if (newProgress != savedProgress && newProgress > 0 && currentProgress != 1) {

            // if the user watches the entire video the lesson will be marked as seen automatically.
            if (totalDuration == newProgress) {
                newProgress = 1;
                $('input#' + lesson_id).prop('checked', true);
            }

            // update the video prgress here.
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('user/save_course_progress'); ?>',
                data: {lesson_id: lesson_id, progress: newProgress},
                success: function (response) {
                    savedProgress = response;
                }
            });
        }
    }

    function add_like(comment_id, elem) {
        var count = elem.closest('.comment_container').find('.likes_count').html();
        $.ajax({
            url: "<?= base_url() ?>quiz/add_like/" + comment_id,
            type: "POST",
            data: {'<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash() ?>'},
            success: function () {
                elem.closest('.comment_container').find('.likes_count').html(parseInt(count) + 1);
            }
        });
    }
    $(".reply_btn").click(function () {
        // remove all prev existing reply textareas
        $(".quiz-test .reply_main_div").each(function () {
            $(this).remove();
        });
        var comment_id = $(this).data('comment_id');
        $(".reply_on").val(comment_id);
        $(this).closest('.align-items-start').after($("#reply_textbox").html());

    });


</script>
