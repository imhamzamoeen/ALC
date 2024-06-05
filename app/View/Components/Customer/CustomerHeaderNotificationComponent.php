<?php

namespace App\View\Components\Customer;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\Component;

class CustomerHeaderNotificationComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $Model;

    public function __construct()
    {
        $this->Model = User::select('id', 'name')->whereId(auth()->id())->with([
            'profiles' => function ($query) {
                $query->select('id', 'name', 'course_id', 'user_id','timezone');
                $query->whereHas('notifications', function ($query) {
                    $query->whereBetween(
                        'created_at',
                        [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]
                    );
                });
            },
            'profiles.notifications' => function ($query) {

                $query->whereBetween(
                    'created_at',
                    [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]
                );
            },
        ])->first();    // we are showing 1 week notifications of students 
     
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.customer.customer-header-notification-component');
    }
}
