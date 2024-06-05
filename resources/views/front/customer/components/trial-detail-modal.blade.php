<div class="modal fade" id="trial-details-modal-{{ @$student->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="border-0 modal-content border-custom-left">
            <div class="modal-header border-bottom">
                <h4 class="modal-title text-sb">Trial Details</h4>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
                <div class="h-100 d-flex justify-content-between align-items-center">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td class="ps-0 text-med" width="50%">{{ __('Student Name') }}</td>
                                <th class="text-end pr-0" scope="row">{{ @$student->name ?? '--' }}</th>
                            </tr>
                            <tr>
                                <td class="ps-0 text-med" width="50%">{{ __('Course') }}</td>
                                <th class="text-end pr-0" scope="row">{{ @$student->course->title ?? '--' }}</th>
                            </tr>
                            <tr>
                                <td class="ps-0 text-med" width="50%">{{ __('Availability') }}</td>
                                <th class="text-end" scope="row">
                                    @isset($student->trialRequest->days)
                                        @if (count($student->trialRequest->days))
                                            @foreach ($student->trialRequest->days as $day)
                                                {{ __(\App\Classes\AlQuranConfig::DaysMin[$day->day_id]) }}{!! !$loop->last ? ',' : '' !!}
                                            @endforeach
                                        @endif
                                    @endisset
                                </th>
                            </tr>
                            <tr>
                                <td class="ps-0 text-med" width="50%">{{ __('Shift') }}</td>
                                <th class="text-end" scope="row">
                                    {{ __(\App\Classes\AlQuranConfig::Shifts[$student->shift_id]) ?? '--' }}
                                </th>
                            </tr>
                            @if (!empty(@$student->trialRequest->trialClass))
                                <tr>
                                    <td class="ps-0 text-med" width="50%">{{ __('Teacher Name') }}</td>
                                    <th class="text-end pr-0" scope="row">{{ @$student->teacher->name ?? '--' }}
                                    </th>
                                </tr>
                                <tr>
                                    <td class="ps-0 text-med" width="50%">{{ __('Trial Scheduled') }}</td>
                                    <th class="text-end pr-0" scope="row">{!! format_time(
                                        convertTimeToUSERzone(@$student->trialRequest->trialClass->starts_at, @$student->timezone),
                                        false,
                                    ) ?? '--' !!}</th>
                                </tr>
                            @endif
                            <tr>
                                <td class="ps-0 text-med align-middle" width="50%">{{ __('Status') }}</td>
                                <th class="text-end pr-0" scope="row">
                                    <p class="mt-0 mb-0"> <span
                                            class="badge w-100 status-pill {{ \App\Classes\Enums\StatusEnum::$Subscription_status_color[@$student->subscription_status] ?? 'primary' }}">{{ beautify_slug(@$student->subscription_status) }}</span>
                                    </p>
                                </th>
                            </tr>
                            @if (!empty(@$student->trialRequest->trialClass))
                                <tr>
                                    <td class="ps-0 text-med align-middle" width="50%">{{ __('Class Link') }}</td>
                                    <th class="text-end pr-0" scope="row">
                                        <a target="_blank"
                                            href="{{ route('joinClassTrial', [app()->getLocale(), 'user' => @$student, 'TrialClass' => @$student->trialRequest->trialClass->session_key]) }}"
                                            target="_blank" class="btn btn-primary px-3 py-2">Join Class</a>

                                    </th>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
