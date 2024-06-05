<?php

namespace App\Actions\Fortify;

use App\Classes\AlQuranConfig;
use App\Jobs\SendSalesSupportEmail;
use App\Mail\SalesSupportMail;
use App\Models\User;
use App\Notifications\NewCustomerSignedUp;
use App\Notifications\WelcomeNewUserEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Rules\Password;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        
        Validator::make($input, [
            'name' => ['required', 'string', 'max:50', 'regex:/^[\pL\s\-]+$/u'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix'],
            'password' => ['required', 'string', 'min:6', 'max:20'],
            'phone' => ['required', 'string'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
            'g-recaptcha-response' => 'required|recaptchav3:register,0.5',
            'pf'=>['nullable','string','in:ppc,facebook,linkedin,twitter,instagram,printrest,youtube,email'],
            'pn'=>['nullable','string','max:110'],
        ],
        [
            'g-recaptcha-response' => ['recaptchav3' => 'Captcha error message',],
        ])->validate();

        $create = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'phone' => $input['phone'],
            'ip'    => get_client_ip(),
            'country'=>  ip_info("Visitor", 'Country'),
            'pf'=>$input['pf'],
            'pn'=>$input['pn'],
        ]);

        if($create){
            $create->assignRole('customer');
            try {
               
                // SendSalesSupportEmail::dispatch($input); // sends emaail to sales team that a new customer has signed up
                Notification::route('mail', env('REGISTRATION_ALERT_EMAIL'))->notify(new NewCustomerSignedUp($input));
                /*$create->notify(new WelcomeNewUserEmail($create));*/
            }catch (\Exception $e){

            }
        }
        return $create;
    }
}
