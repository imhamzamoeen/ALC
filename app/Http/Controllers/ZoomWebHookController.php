<?php

namespace App\Http\Controllers;

use App\Jobs\MarkAttendanceOfClas;
use App\Jobs\MarkClassStatusJob;
use App\Jobs\StoreSessionIdJob;
use App\Jobs\StoreUserJoinedJob;
use App\Jobs\StoreUserLeftJob;
use App\Jobs\ZoomGetAttendanceJob;
use App\Services\ZoomWebhookCalculationService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ZoomWebHookController extends Controller
{
    //

    public function VerifyWebhook(Request $request)
    {
        try {

            // same if ($request->hasHeader('X-Hub-Signature')) 
            if (($signature = $request->header('x-zm-signature')) == null) {
                throw new BadRequestHttpException('Header not set');   // signature tu h e nhe yeh kisi chabal na awein e request bhej di h 
            }



            $message = 'v0:' . $request->header('x-zm-request-timestamp') . ':' . $request->getContent();    //  making a string of header timestamp plus request ki body
            $zoomwebhooksecrettoken = 'b6bUzjA0QkuQ0SZO8j8q8w';
            $hashed_message = hash_hmac('sha256', $message, $zoomwebhooksecrettoken); // this function generates the hash of a string it takes arggument like kis mehanism ya method main hash krna and woh string and uska salt .. this is same as firebase jwt token packgage
            // Log::info("hashed message", $hashed_message);
            $hashed_message = 'v0=' . $hashed_message;
            $zoom_signature = $request->header('x-zm-signature');   // yeh woh jo 3rd partt hmien send krti apna signature

            if (!hash_equals($hashed_message, $zoom_signature)) {   // ab 2no hash check kro 
                throw new UnauthorizedException('Could not verify request signature ' . $zoom_signature);
            }
            return true;
        } catch (Exception $e) {

            Log::info('from verify method');
            Log::info($e);
            return $e->getMessage();
        }
    }

    public function GetWebHooks(Request $request)
    {
        try {

            if ($this->VerifyWebhook($request) == true) {
                // it is verified that it has come from zoom 
                Log::info($request->all());
                // we are using session joined because we dont have much data in session started 
                if ($request['event'] == 'session.started') {

                    StoreSessionIdJob::dispatch($request->all())
                        ->delay(now()->addSeconds(30));
                } else if ($request['event'] == 'session.user_joined') {
                    // a user have joined a session lets add his join time 
                    //what we will do is that we will add a entry to zoom attendace and make leave time empty and will fill that in user left 
                    StoreUserJoinedJob::dispatch($request->all())->delay(now()->addSeconds(60));
                } else if ($request['event'] == 'session.user_left') {
                    //what we will do is a user that joined before has left the session now its attendance time 
                    StoreUserLeftJob::dispatch($request->all())->delay(now()->addSeconds(70));
                } else if ($request['event'] == 'session.ended') {

                    Log::info("session end event");
                    // Log::info("andar");.
                    if ($request['payload']['object']['sessionkey'][0] == 'W' && $request['payload']['object']['sessionkey'][1] == 'K') {
                        // its data of weekly class and we mark status of class that only
                        MarkClassStatusJob::dispatch($request['payload']['object']['id'])
                        ->delay(now()->addSeconds(80));
                    }    
                
                    // ZoomGetAttendanceJob::dispatch($request->all())
                    //     ->delay(now()->addMinutes(2));           //q k ab hm attendance webhooks s kr  rhy
                    MarkAttendanceOfClas::dispatch($request->all())
                        ->delay(now()->addMinutes(3));

             
                } else if ($request['event'] == 'session.recording_completed') {
                    // Log::info("andar");
                }
                return response()->json(200);
            }
        } catch (Exception $e) {
            Log::info("error in webhook");
            Log::debug($e->getMessage());
            return [];
        }
    }
}
