<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Log;

class PaypalWebHooksController extends Controller
{
    //
    public function GetWebHooks(Request $request)
    {
        try {
           
            $headers = $request->headers->all();
            // Get data from request body
            $responseBody = $request->all();
            Log::info($responseBody);
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();

            // Get paypal headers from requests
            $headers = [
                'auth_algo' => $request->header('PAYPAL-AUTH-ALGO', null),
                'cert_url' => $request->header('PAYPAL-CERT-URL', null),
                'transmission_id' => $request->header('PAYPAL-TRANSMISSION-ID', null),
                'transmission_sig' => $request->header('PAYPAL-TRANSMISSION-SIG', null),
                'transmission_time' => $request->header('PAYPAL-TRANSMISSION-TIME', null),
            ];

            // Get paypal webhook id, get this from paypal developer site when you create webhook
            $paypal_webhook_id = env('PAYPAL_WEBHOOK_ID', null);

            // gather webhook data to verify it
            $verify_data = [
                'auth_algo'         => $headers['auth_algo'],
                'cert_url'          => $headers['cert_url'],
                'transmission_id'   => $headers['transmission_id'],
                'transmission_sig'  => $headers['transmission_sig'],
                'transmission_time' => $headers['transmission_time'],
                'webhook_id'        => $paypal_webhook_id,
                'webhook_event'     => $responseBody
            ];

            // Verify webhook
            $provider->verifyWebHook($verify_data);

            
        } catch(\Exception $e) {
            
            Log::info("error in webhook");
            Log::debug($e->getMessage());
            return $e->getMessage();
        }
    }
}
