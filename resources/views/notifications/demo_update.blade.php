@isset($notification)
    <?php
    $NotificationContent = json_decode($notification->json);
    ?>



    <div class="px-14 py-3 text-med container px-0">
        <div class="row">
            <div class="col-1 pe-0">
                <i class="color-primary fa-circle fa-xs fas" aria-hidden="true"></i>
            </div>
            <div class="col-11 pe-0 pe-sm-2 ps-1">
                <div class="pb-2">

                    @isset($model)
                    <small></small>
                    @if (!is_null($NotificationContent))
                            @if(auth()->user()->user_type=='teacher')
                            A demo class has been {{ $NotificationContent->type }} against {{ $NotificationContent->demoClass->demo_request->student->user->name.'`s child '.$NotificationContent->demoClass->demo_request->student->name.' for Course:'.$NotificationContent->demoClass->demo_request->student->course->title}} 
                        
                            @else
                            A demo class has been {{ $NotificationContent->type }} against {{  $NotificationContent->demoClass->demo_request->student->name.' for Course:'.$NotificationContent->demoClass->demo_request->student->course->title }}  with Teacher {{ $NotificationContent->demoClass->demo_request->student->teacher->name  }}

                            @endif
                            The class is scheduled at 
                            {{ convertTimeToUSERzone(\Carbon\Carbon::parse($NotificationContent->demoClass->starts_at), $model->timezone)->format('d M, Y h:i A') }}
                            <br>
                            <a href="{{ route('joinClassDemo', [app()->getLocale(), 'user' => $model, 'DemoClass' => $NotificationContent->demoClass->session_key]) }}"
                                target="_blank" class="btn btn-primary px-3 py-2">Join Class</a>
                        @endif
                    @endisset

                </div>
            </div>
        </div>

    </div>

@endisset
