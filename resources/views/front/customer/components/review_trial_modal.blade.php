<div class="modal fade review-trial" id="review-trial-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="border-0 modal-content">
            <div class="modal-header border-bottom px-4">
                <h4 class="modal-title text-sb px-18 text-sb">{{ __('Review Trial') }}</h4>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4">
                <label for=""
                    class="text-sb px-14 my-2">{{ __('Are you satisfied with the Teacher ?') }}</label>
                <div class="container">
                    <div class="row form-group feedback-radio">

                        <div class="form-check col-3">
                            <input class="form-check-input" checked type="radio" name="liked" value="yes"
                                id="yesReview">
                            <label class="form-check-label" for="yesReview">
                                {{ __('Yes') }}
                            </label>
                        </div>
                        <div class="form-check col-9">
                            <input class="form-check-input" type="radio" name="liked" value="no" id="noReview">
                            <label class="form-check-label" for="noReview">
                                {{ __('No') }}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="teacher-rating">
                    <form method="post" action="{{ route('customer.submitReview') }}" id="review-trial-form">@csrf
                    </form>
                    <input class="" type="hidden" name="trial_class_id" data-id="trial_class_id_inp"
                        form="review-trial-form" />
                    <input class="" type="hidden" name="student_id" data-id="trial_class_student_inp"
                        form="review-trial-form" />
                    <label class="text-sb px-14 my-3">{{ __('How was your Experience with the teacher ?') }}</label>
                    <div class="row text-med">
                        <div class="col-6">
                            <h5 class="py-2 px-14">{{ __('Communication') }}</h5>
                            <h5 class="py-2 px-14">{{ __('Teaching') }}</h5>
                            <h5 class="py-2 px-14">{{ __('Behaviour') }}</h5>
                        </div>
                        <div class="col-6 text-end">
                            <div class="star-rating py-2">
                                <span class="fa fa-star" data-rating="1"></span>
                                <span class="fa fa-star-o" data-rating="2"></span>
                                <span class="fa fa-star-o" data-rating="3"></span>
                                <span class="fa fa-star-o" data-rating="4"></span>
                                <span class="fa fa-star-o" data-rating="5"></span>
                                <input type="hidden" name="communication" class="rating-value" value="1"
                                    form="review-trial-form">
                            </div>
                            <div class="star-rating py-2">
                                <span class="fa fa-star" data-rating="1"></span>
                                <span class="fa fa-star-o" data-rating="2"></span>
                                <span class="fa fa-star-o" data-rating="3"></span>
                                <span class="fa fa-star-o" data-rating="4"></span>
                                <span class="fa fa-star-o" data-rating="5"></span>
                                <input type="hidden" name="teaching" class="rating-value" value="1"
                                    form="review-trial-form">
                            </div>
                            <div class="star-rating py-2">
                                <span class="fa fa-star" data-rating="1"></span>
                                <span class="fa fa-star-o" data-rating="2"></span>
                                <span class="fa fa-star-o" data-rating="3"></span>
                                <span class="fa fa-star-o" data-rating="4"></span>
                                <span class="fa fa-star-o" data-rating="5"></span>
                                <input type="hidden" name="behaviour" class="rating-value" value="1"
                                    form="review-trial-form">

                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary py-2 px-5"
                            form="review-trial-form">{{ __('Submit') }}</button>
                    </div>
                </div>
                <div class="reason d-none mt-4">
                    <h4 class="text-sb px-14">Do you want to Reschedule trial with another teacher ?</h4>
                    <h4 class="text-med px-14 mt-3">We are sorry that you were not satisfied with the teacher</h4>
                    <form method="post" action="{{ route('customer.requestTrialReschedule') }}"
                        id="review-trial-request-form">@csrf
                        <input class="" type="hidden" name="trial_class_id" data-id="trial_class_id_inp" />
                        <input class="" type="hidden" name="student_id" data-id="trial_class_student_inp" />
                    </form>
                    <textarea class="w-100 form-control mt-4" name="reason" id="" rows="4"
                        placeholder="{{ __('Please State the reason here') }}" form="review-trial-request-form"></textarea>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary py-2 px-5"
                            form="review-trial-request-form">{{ __('Request Reschedule') }}</button>
                        <a class="text-med mt-2 d-block"
                            href="{{ route('customer.helpSupport', [app()->getLocale(), 'child' => $student]) }}"
                            aria-label="Close">Need customer support</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <div class="modal fade review-teacher" id="review-teacher" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="border-0 modal-content">
            <div class="modal-header border-bottom">
                <h4 class="modal-title text-sb px-18 text-sb">Reschedule Trial</h4>
                <button  class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h4 class="text-sb px-14 mb-3">Do you want to Reschedule trial with another teacher ?</h4>
                <h4 class="text-med px-14 mb-4">We are sorry that you were not satisfied with the teacher</h4>
                <div>
                    <button class="btn btn-primary px-3 py-2 mb-2">Yes, With other teacher</button><br>
                    <button class="btn bg-transparent border-0 color-primary text-decoration-underline"
                        data-bs-dismiss="modal" aria-label="Close">Need customer support</button>
                </div>

            </div>
        </div>
    </div>
</div> --}}
@push('after-style')
    <style>
        .review-trial .star-rating .fa-star {
            color: #FFC107;
        }

        .review-trial .fa-star-o {
            color: #FFC107;
        }
    </style>
@endpush
@push('after-script')
    <script>
        // $('#liked').submit(function() {
        //     $('#review-trial-modal').modal('toggle');
        //     if ($("input[name='liked']:checked").val() === 'no') {
        //         $('#review-teacher').modal('toggle');
        //     }
        //     event.preventDefault();
        // })
        $('.feedback-radio').on('click', function() {
            if ($("input[name='liked']:checked").val() === 'yes') {
                $('.teacher-rating').removeClass('d-none');
                $('.reason').addClass('d-none');
            } else if ($("input[name='liked']:checked").val() === 'no') {
                $('.reason').removeClass('d-none');
                $('.teacher-rating').addClass('d-none');
            }
        })
        const $star_rating = $('.review-trial .star-rating .fa');

        const SetRatingStar = function(el) {
            const siblings = $(el).siblings('.fa').add($(el));
            return $(siblings).each(function(index, item) {
                if (parseInt($(el).siblings('input.rating-value').val()) >= parseInt($(this).data(
                        'rating'))) {
                    return $(this).removeClass('fa-star-o').addClass('fa-star');
                } else {
                    return $(this).removeClass('fa-star').addClass('fa-star-o');
                }
            });
        };

        $star_rating.on('click', function() {
            $(this).siblings('input.rating-value').val($(this).data('rating'));
            return SetRatingStar($(this));
        });
    </script>
@endpush
