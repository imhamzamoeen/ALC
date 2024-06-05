<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Enums\UserTypesEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\NotifyCustomerWithResetPin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomersController extends Controller
{
    public function sendResetPinNotification(User $user){
        if($user->hasRole(UserTypesEnum::Customer)){
            try {
                DB::beginTransaction();
                $digits = 4;
                $pin = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);

                $user->update(['customer_pin' => Hash::make($pin)]);
                DB::commit();

                $user->notify(new NotifyCustomerWithResetPin($user, $pin));

                return redirect()->back()->with('success', 'Pin reset successful');
            }
            catch (\Exception $e){
                DB::rollBack();
                return redirect()->back()->with('error', 'Something went wrong. Please try again');
            }
        }
    }
}
