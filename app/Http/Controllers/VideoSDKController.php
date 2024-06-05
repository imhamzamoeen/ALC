<?php

namespace App\Http\Controllers;

use App\Jobs\MarkClassStatusJob;
use App\Models\TrialClass;
use App\Models\Student;
use App\Models\User;
use App\Models\WeeklyClass;
use App\Services\JsonResponseService;
use App\Services\ZoomWebhookCalculationService;
use App\Traits\SDKTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VideoSDKController extends Controller
{
    //
    use SDKTrait;

    public function generateJWTKey(Request $request)
    {
        $session_id = '+4UZ8IgrToaqSIORu4pbBw==';

    //   return   $this->GetDetailOfSession('S+uI4hmnReygccTLJvUt4A==','past');
      MarkClassStatusJob::dispatch('S+uI4hmnReygccTLJvUt4A==')
                    ->delay(now()->addMinutes(1));
                    return "ok";
         return $response = $this->GetUsersOfSession('a/qbT45HSFObHqgES/3yRw==', 'past');
        // $data['payload']['object']['id'] = $session_id;
        // return $data;
        // return (new ZoomWebhookCalculationService)->StoreSessionAttendence($data);
        // return $response;
        //  return JsonResponseService::JsonSuccess("Success", json_decode($response,true)); 
        //  $response=$response->getData();
        //  return $response->message;
        // return $response['session_key'];

        // ['message'];
        // return gettype($response);

        // return   Http::withToken($encode)->acceptJson()->get('https://api.zoom.us/v2/videosdk/sessions');
        // return   Http::withToken($encode)->acceptJson()->get('https://api.zoom.us/v2/videosdk/sessions',$Query_Parameter);
    }


    public function index($en, $user, WeeklyClass $WeeklyClass, Request $request)
    {
        try {
            // this is for weekly class
            $model = $request->user;
            if ($model->user_type == 'teacher') {
                   DB::transaction(function () use ($WeeklyClass) {
                    $WeeklyClass->update([
                        'teacher_presence' => 1,
                    ]);
                });
            } else if ($model->user_type == 'student') {
                DB::transaction(function () use ($WeeklyClass) {
                    $WeeklyClass->update([
                        'student_presence' => 1,
                    ]);
                });
            }
            /* here we can also that time has not come , you cannot join the class before */
            // return view('zoom.joinClass', compact('model', 'WeeklyClass'));
            // return $session_key;
            return response()->view('zoom.joinClass', compact('model', 'WeeklyClass'))->withHeaders([
                'Cross-Origin-Opener-Policy' => 'same-origin',
                'Cross-Origin-Embedder-Policy' => 'require-corp'
            ]);
        } catch (Exception $e) {
            Log::info("some error in zoom attendence");
            // dd($e);
            abort(404);
        }
    }

    public function index2($en, $user, TrialClass $TrialClass, Request $request)
    {
        
        try {
      
            $model = $request->user;
            if ($model->user_type == 'teacher') {
                   DB::transaction(function () use ($TrialClass) {
                    $TrialClass->update([
                        'teacher_presence' => 1,
                    ]);
                });
            } else if ($model->user_type == 'student') {
                DB::transaction(function () use ($TrialClass) {
                    $TrialClass->update([
                        'student_presence' => 1,
                    ]);
                });
            }
            $WeeklyClass=$TrialClass;
     
            return response()->view('zoom.joinClass', compact('model', 'WeeklyClass'))->withHeaders([
                'Cross-Origin-Opener-Policy' => 'same-origin',
                'Cross-Origin-Embedder-Policy' => 'require-corp'
            ]);
        } catch (Exception $e) {
            Log::info("some error in zoom attendence");
            dd($e);
            abort(404);
        }
    }
}
