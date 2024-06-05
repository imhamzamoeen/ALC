<style>
    :root {


        @if(auth()->user()->user_type == \App\Classes\Enums\UserTypesEnum::Customer)

            --primary-color: #0A5CD6;
            --secondary-color: #6EC5FF28;

        @elseif(auth()->user()->user_type == \App\Classes\Enums\UserTypesEnum::Teacher)

            --primary-color: #519872;
            --secondary-color: #51987233;

        @elseif(auth()->user()->user_type == \App\Classes\Enums\UserTypesEnum::TeacherCoordinator)

            --primary-color: #AC1335;
            --secondary-color: #AC133540;

        @elseif(auth()->user()->user_type == \App\Classes\Enums\UserTypesEnum::CustomerSupport)

            --primary-color: #882474;
            
        @elseif(auth()->user()->user_type == \App\Classes\Enums\UserTypesEnum::SalesSupport)

            --primary-color: #882474;
            --secondary-color: #88247440;

        @else

            --primary-color: #0A5CD6;

    @endif


}
</style>
