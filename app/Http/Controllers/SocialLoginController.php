<?php

namespace App\Http\Controllers;

use App\Classes\Enums\UserTypesEnum;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Spatie\Permission\Models\Role;

class SocialLoginController extends Controller
{
    public function callback($provider){
        try {
            // get user info from social site
            $user = Socialite::driver($provider)->stateless()->user();
            $email = $user->email;
            $db_user = User::where('email', $email)->first();

            if ($db_user) {
                auth()->login($db_user, true);
            }else{
                $db_user = $this->createUser($user, $provider);
                auth()->login($db_user, true);
            }
            return redirect()->route($db_user->user_type.'.dashboard', app()->getLocale());
        } catch (\Exception $e) {
            return redirect()->route('login');
        }
    }

    function createUser(SocialiteUser $social_info, $provider = 'google')
    {
        $email = $social_info->email;
        $user = User::where('email', $email)->first();
        if (!$user) {
            $user = User::create([
                'name' => $social_info->name,
                'email'      => $email,
                'password'   => Hash::make($social_info->id),
                'user_type'  => UserTypesEnum::Customer,
                'email_verified_at'=> Carbon::now(),
                'social_type'=> $provider,
                'social_id' => $social_info->id
            ]);
            $role = Role::whereName('customer')->pluck('id')->first();
            if (!is_null($role)){
                $arr[$role] = [
                    'model_type' => User::class,
                ];
                //dd($arr);
                $user->roles()->sync($arr);
            }
        }

        return $user;
    }
}
