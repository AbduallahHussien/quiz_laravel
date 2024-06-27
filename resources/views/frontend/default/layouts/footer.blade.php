
    <footer class="footer-area d-print-none">
    <div class="container-xl">
        <div class="row">
            <div class="col-md-6">
                <p class="copyright-text">
                    @php $setting = setting(); @endphp
                    <a href=""><img src="{{ url('/').$setting->footer_image_name}}" alt="" class="d-inline-block" width="110"></a>
                </p>
            </div>
            <div class="col-md-6">
                <ul class="nav justify-content-md-end footer-menu">
                    <li>
                        <p class="mt-2">{{$setting->footer_text}}</p>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</footer>

<!-- PAYMENT MODAL -->
<!-- Modal -->
@php
$paypal_info = json_decode(get_settings('paypal'), true);
$stripe_info = json_decode(get_settings('stripe_keys'), true);

if ($paypal_info[0]['active'] == 0) {
    $paypal_status = 'disabled';
} else {
    $paypal_status = '';
}
if ($stripe_info[0]['active'] == 0) {
    $stripe_status = 'disabled';
} else {
    $stripe_status = '';
}
@endphp

<!-- Modal -->
<div class="modal fade multi-step" id="EditRatingModal" tabindex="-1" role="dialog" aria-hidden="true" reset-on-close="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content edit-rating-modal">
            <div class="modal-header">
                <h5 class="modal-title step-1" data-step="1">{{__('step') . ' 1'}}</h5>
                <h5 class="modal-title step-2" data-step="2">{{__('step') . ' 2'}}</h5>
                <h5 class="m-progress-stats modal-title">
                    &nbsp;of&nbsp;<span class="m-progress-total"></span>
                </h5>

                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="m-progress-bar-wrapper">
                <div class="m-progress-bar">
                </div>
            </div>
            <div class="modal-body step step-1">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="modal-rating-box">
                                <h4 class="rating-title">{{__('how_would_you_rate_this_course_overall')}}?</h4>
                                <fieldset class="your-rating">

                                    <input type="radio" id="star5" name="rating" value="5" />
                                    <label class = "full" for="star5"></label>

                                    <input type="radio" id="star4" name="rating" value="4" />
                                    <label class = "full" for="star4"></label>

                                    <input type="radio" id="star3" name="rating" value="3" />
                                    <label class = "full" for="star3"></label>


                                    <input type="radio" id="star2" name="rating" value="2" />
                                    <label class = "full" for="star2"></label>


                                    <input type="radio" id="star1" name="rating" value="1" />
                                    <label class = "full" for="star1"></label>


                                </fieldset>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="modal-course-preview-box">
                                <div class="card">
                                    <img class="card-img-top img-fluid" id = "course_thumbnail_1" alt="">
                                    <div class="card-body">
                                        <h5 class="card-title" class = "course_title_for_rating" id = "course_title_1"></h5>
                                        <p class="card-text" id = "instructor_details">

                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-body step step-2">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="modal-rating-comment-box">
                                <h4 class="rating-title">{{__('write_a_public_review')}}</h4>
                                <textarea id = "review_of_a_course" name = "review_of_a_course" placeholder="{{__('describe_your_experience_what_you_got_out_of_the_course_and_other_helpful_highlights') . '. ' . __('what_did_the_instructor_do_well_and_what_could_use_some_improvement')}}?" maxlength="65000" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="modal-course-preview-box">
                                <div class="card">
                                    <img class="card-img-top img-fluid" id = "course_thumbnail_2" alt="">
                                    <div class="card-body">
                                        <h5 class="card-title" class = "course_title_for_rating" id = "course_title_2"></h5>
                                        <p class="card-text">
                                            -
                                            @php
                                              $admin_details = get_admin_details();
                                            @endphp
                                           {{$admin_details->firstname . ' ' . $admin_details->lastname}}
                                            
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="course_id" id = "course_id_for_rating" value="">
            <div class="modal-footer">
                <button type="button" class="btn btn-primary next step step-1" data-step="1" onclick="sendEvent(2)">{{__('next')}}</button>
                <button type="button" class="btn btn-primary previous step step-2 mr-auto" data-step="2" onclick="sendEvent(1)">{{__('previous')}}</button>
                <button type="button" class="btn btn-primary publish step step-2" onclick="publishRating($('#course_id_for_rating').val())" id = "">{{__('publish')}}</button>
            </div>
        </div>
    </div>
</div><!-- Modal -->




