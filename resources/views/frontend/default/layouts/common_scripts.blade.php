<script type="text/javascript">
$(document).ready(function () {
    <?php if ($setting->buttons_color) { ?>
                document.body.style.setProperty('--btns-color', '{{$setting->buttons_color}}');
    <?php } ?>
    <?php if ($setting->headers_color) { ?>
                document.body.style.setProperty('--headers-color', '{{$setting->headers_color}}');
    <?php } ?>
    <?php if ($setting->light_clr_in_gradient) { ?>
                document.body.style.setProperty('--gradiant-light-color', '{{$setting->light_clr_in_gradient}}');
    <?php } ?>
});
function toggleRatingView(course_id) {
  $('#course_info_view_'+course_id).toggle();
  $('#course_rating_view_'+course_id).toggle();
  $('#edit_rating_btn_'+course_id).toggle();
  $('#cancel_rating_btn_'+course_id).toggle();
}

function publishRating(course_id) {
    var review = $('#review_of_a_course_'+course_id).val();
    var starRating = 0;
    starRating = $('#star_rating_of_course_'+course_id).val();
    if (starRating > 0) {
        $.ajax({
            type : 'POST',
            url  : '<?php echo'home/rate_course' ?>',
            data : {course_id : course_id, review : review, starRating : starRating},
            success : function(response) {
                location.reload();
            }
        });
    }else{

    }
}

function switch_language(language) {
        $.ajax({
            url: '<?php echo 'home/site_language' ?>',
            type: 'post',
            data: {language: language},
            success: function (response) {
                setTimeout(function () {
                    location.reload();
                }, 500);
            }
        });
    }
</script>
