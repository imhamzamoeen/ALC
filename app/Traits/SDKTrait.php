<?php

namespace App\Traits;

use App\Jobs\SendJobErrorMailJob;
use App\Services\JsonResponseService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Config;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

trait SDKTrait
{
    /* in laravel 9 we can change withtoken wihtin rety method  */
    /* so if we will update to the 9 then we can use withtoken change within retry function but here we will check whether cache has that token or not */

    // public $AccessToken; // to store the access token zoom api returns us .. this token is for 1 hour 

    // public function __construct()
    // {

    //     $this->AccessToken = NULL;
    // }

    public function CheckToken()
    {
        return Cache::has('AccessToken');
    }

    public function GetAccessToken()
    {
        try {
            // this function convert jwt token to a encode signature .. the firebase jwt already include header in it that is mostly asked in header like  
            // {
            //     "alg": "HS256",
            //     "typ": "JWT"
            //   }
            $payload = array(
                "iss" => Config::get('app.Video_SDK_Api_Key'),
                "exp" => Carbon::now()->addDays()->timestamp,   // 1 din k lie bnao
            );
            $secret = Config::get('app.Video_SDK_Api_Secret');

            $jwt_token = JWT::encode($payload, $secret, 'HS256');



            // // Create token header as a JSON string
            //    $secret = Config::get('app.Video_SDK_Api_Secret');

            // $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);

            // // Create token payload as a JSON string
            // $payload = json_encode([        "iss" => Config::get('app.Video_SDK_Api_Key'),
            //        "exp" => Carbon::now()->addDays()->timestamp,   ]);

            // // Encode Header to Base64Url String
            // $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

            // // Encode Payload to Base64Url String
            // $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

            // // Create Signature Hash
            // $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload,$secret , true);

            // // Encode Signature to Base64Url String
            // $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

            // // Create JWT
            // $jwt_token = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;





            if (!empty($jwt_token)) {
                Cache::put('AccessToken', $jwt_token, $seconds = 86400);   //mean next day  
                return $jwt_token;
            } else
                throw new Exception("Token Could not be generated", 30);
        } catch (Exception $e) {
            // dispatch(new SendJobErrorMailJob(['function' => 'GetAccessToken', 'message' => $e->getMessage()]));
            Log::info($e);
            return [];
        }
    }

    public function GetSession($type = 'past', $from = null, $to = null)
    {
        if ($this->CheckToken() == false)   // agar token expire hogia tu dobara kro 
            $this->GetAccessToken();
        $from = $from ?? Carbon::now()->startOfMonth()->format('Y-m-d');   // if it is set then wohi else dosri value
        $to = $to ?? Carbon::now()->endOfMonth()->format('Y-m-d');


        // this api return data as paginate .. so it has next page token that we send as query parameter to get next page data..
        try {
            $sessions = collect();
            $next_page_token = 'try';
            $Query_Parameter = [
                'type' => $type,
                'from' => $from,
                'to' => $to,
            ];
            while (!empty($next_page_token)) {
                $response = Http::withHeaders([
                    'accept' => 'application/json',
                ])->acceptJson()->withToken(Cache::get('AccessToken'))->retry(2, 50000, function ($exception = null, $request = null) {
                    if ($exception->response->status() == 401) {
                        //its an invalid token now refresh that token
                        if (!is_null($request))
                            $request->withToken($this->GetAccessToken());
                        else
                            $this->GetAccessToken();
                    }
                    return true;
                })->get('https://api.zoom.us/v2/videosdk/sessions', $Query_Parameter);
                if ($response->successful()) {
                    $Query_Parameter['next_page_token'] = $response['next_page_token'];
                    $next_page_token = $response['next_page_token'];

                    foreach ($response['sessions'] as $eachuser) {
                        $sessions->push($eachuser);
                    }
                } else {
                    $next_page_token = null;
                }
            }
            return $sessions;
        } catch (Exception $e) {
            // dispatch(new SendJobErrorMailJob(['function' => 'GetSession', 'message' => $e->getMessage()]));
            Log::info($e);
            return [];
        }
    }

    public function GetDetailOfSession($SessionId = null,$type = 'past')
    {
        if (is_null($SessionId))
            return [];
        if ($this->CheckToken() == false)   // agar token expire hogia tu dobara kro 
            $this->GetAccessToken();
        // this api return data as paginate .. so it has next page token that we send as query parameter to get next page data..
        try {

            $Query_Parameter = [
                'type' => $type,
            ];

            $response = Http::withHeaders([
                'accept' => 'application/json',
            ])->acceptJson()->withToken(Cache::get('AccessToken'))->retry(2, 1000, function ($exception = null, $request = null) use ($Query_Parameter) {
                if ($exception->response->status() == 3001) {
                    $Query_Parameter['type'] = $Query_Parameter['type'] == 'live' ? 'past' : 'live';
                    return true;
                }
                if ($exception->response->status() == 401) {
                    //its an invalid token now refresh that token
                    if (!is_null($request))
                        $request->withToken($this->GetAccessToken());
                    else
                        $this->GetAccessToken();
                }
                return true;
            })->get("https://api.zoom.us/v2/videosdk/sessions/{$SessionId}",$Query_Parameter);
            if ($response->successful()) {
                return $response;
            } else {
                return [];
            }
        } catch (Exception $e) {
            Log::info("GetDetailOfSession function error");
            // dispatch(new SendJobErrorMailJob(['function' => 'GetDetailOfSession', 'message' => $e->getMessage()]));
            Log::info($e);
            return [];
        }
    }

    public function GetUsersOfSession($SessionId = null, $type = 'past')
    {
        //this api tells that how much users were present, when they joined and left etc
        if (is_null($SessionId))
            return [];
        if ($this->CheckToken() == false)   // agar token expire hogia tu dobara kro 
            $this->GetAccessToken();


        // this api return data as paginate .. so it has next page token that we send as query parameter to get next page data..
        try {
            $users = collect();
            $next_page_token = 'try';
            $Query_Parameter = [
                'type' => $type,

            ];
            while (!empty($next_page_token)) {
                $response = Http::withHeaders([
                    'accept' => 'application/json',
                ])->acceptJson()->withToken(Cache::get('AccessToken'))->retry(2, 1000, function ($exception = null, $request = null) {
                    if ($exception->response->status() == 401) {
                        //its an invalid token now refresh that token
                        if (!is_null($request))
                            $request->withToken($this->GetAccessToken());
                        else
                            $this->GetAccessToken();
                    }
                    return true;
                })->get("https://api.zoom.us/v2/videosdk/sessions/{$SessionId}/users", $Query_Parameter);
                if ($response->successful()) {
                    $Query_Parameter['next_page_token'] = $response['next_page_token'];
                    $next_page_token = $response['next_page_token'];
                    foreach ($response['users'] as $eachuser) {
                        $users->push($eachuser);
                    }
                } else {
                    $next_page_token = null;
                }
            }
            return $users->toArray();
        } catch (Exception $e) {
            Log::info("GetUsersOfSession function error");
            // dispatch(new SendJobErrorMailJob(['function' => 'GetSession', 'message' => $e->getMessage()]));
            Log::info($e);
            return [];
           
        }
    }


    public function GetRecordingOfSession($SessionId = null)
    {

        if (is_null($SessionId))
            return;
        if ($this->CheckToken() == false)   // agar token expire hogia tu dobara kro 
            $this->GetAccessToken();


        // this api return data as paginate .. so it has next page token that we send as query parameter to get next page data..
        try {
            $Recordings = collect();
            $Query_Parameter = [];
            $response = Http::withHeaders([
                'accept' => 'application/json',
            ])->acceptJson()->withToken(Cache::get('AccessToken'))->retry(2, 1000, function ($exception = null, $request = null) {
                if ($exception->response->status() == 401) {
                    //its an invalid token now refresh that token
                    if (!is_null($request))
                        $request->withToken($this->GetAccessToken());
                    else
                        $this->GetAccessToken();
                }
                return true;
            })->get("https://api.zoom.us/v2/videosdk/sessions/{$SessionId}/recordings", $Query_Parameter);
            if ($response->successful()) {
                foreach ($response['recording_files'] as $eachuser) {
                    $Recordings->push($eachuser);
                }
            }

            return $Recordings;
        } catch (Exception $e) {
            // dispatch(new SendJobErrorMailJob(['function' => 'GetSession', 'message' => $e->getMessage()]));
            Log::info($e);
         
        }
    }

    public function GetRecordings($from = null, $to = null)
    {


        if ($this->CheckToken() == false)   // agar token expire hogia tu dobara kro 
            $this->GetAccessToken();

        $from = $from ?? Carbon::now()->startOfMonth()->format('Y-m-d');   // if it is set then wohi else dosri value
        $to = $to ?? Carbon::now()->endOfMonth()->format('Y-m-d');
        // this api return data as paginate .. so it has next page token that we send as query parameter to get next page data..
        try {
            $Recordings = collect();
            $next_page_token = 'try';
            $Query_Parameter = [
                'from' => $from,
                'to' => $to,
            ];
            while (!empty($next_page_token)) {
                $response = Http::withHeaders([
                    'accept' => 'application/json',
                ])->acceptJson()->withToken(Cache::get('AccessToken'))->retry(2, 1000, function ($exception = null, $request = null) {
                    if ($exception->response->status() == 401) {
                        //its an invalid token now refresh that token
                        if (!is_null($request))
                            $request->withToken($this->GetAccessToken());
                        else
                            $this->GetAccessToken();
                    }
                    return true;
                })->get("https://api.zoom.us/v2/videosdk/recordings", $Query_Parameter);
                if ($response->successful()) {
                    $Query_Parameter['next_page_token'] = $response['next_page_token'];
                    $next_page_token = $response['next_page_token'];

                    foreach ($response['sessions'] as $eachuser) {
                        $Recordings->push($eachuser);
                    }
                } else {
                    $next_page_token = null;
                }
            }
            return $Recordings;
        } catch (Exception $e) {
            // dispatch(new SendJobErrorMailJob(['function' => 'GetSession', 'message' => $e->getMessage()]));
            Log::info($e);
          
        }
    }


    public function RecordingPatchApi($SessionId = null, $method = 'recording.start')
    {
        //to start end recording etc

        if (is_null($SessionId))
            return;
        if ($this->CheckToken() == false)   // agar token expire hogia tu dobara kro 
            $this->GetAccessToken();
        // this api return data as paginate .. so it has next page token that we send as query parameter to get next page data..
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->acceptJson()->withToken(Cache::get('AccessToken'))->withBody(json_encode(['method' => $method]), 'application/json')->retry(2, 2000, function ($exception = null, $request = null) {

                if ($exception->response->status() == 401) {
                    //invalid token 
                    if (!is_null($request)) {

                        $request->withToken($this->GetAccessToken());
                    } else {
                        $this->GetAccessToken();
                    }

                    return true;
                } else {
                    return false;
                }
            })->PUT("https://api.zoom.us/v2/videosdk/sessions/{$SessionId}/events");

            return $response;
        } catch (Exception $e) {
            // dispatch(new SendJobErrorMailJob(['function' => 'EndSession', 'message' => $e->getMessage()]));
            Log::info($e);
         
        }
    }


    public function GetSessionDetails($SessionId = null)
    {

        if (is_null($SessionId))
            return;
        if ($this->CheckToken() == false)   // agar token expire hogia tu dobara kro 
            $this->GetAccessToken();
        // this api return data as paginate .. so it has next page token that we send as query parameter to get next page data..
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->acceptJson()->withToken(Cache::get('AccessToken'))->retry(2, 2000, function ($exception = null, $request = null) {

                if ($exception->response->status() == 401) {
                    //invalid token 
                    if (!is_null($request)) {

                        $request->withToken($this->GetAccessToken());
                    } else {
                        $this->GetAccessToken();
                    }

                    return true;
                } else {
                    return false;
                }
            })->Get("https://api.zoom.us/v2/videosdk/sessions/{$SessionId}/livestream");

            return $response;
        } catch (Exception $e) {
            Log::info("GetSessionDetails function error");
            // dispatch(new SendJobErrorMailJob(['function' => 'EndSession', 'message' => $e->getMessage()]));
            Log::info($e);
        
        }
    }




    public function DeleteSessionRecording($SessionId = null, $action = 'trash')
    {
        //to start end recording etc

        if (is_null($SessionId))
            return;
        if ($this->CheckToken() == false)   // agar token expire hogia tu dobara kro 
            $this->GetAccessToken();
        // this api return data as paginate .. so it has next page token that we send as query parameter to get next page data..
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->acceptJson()->withToken(Cache::get('AccessToken'))->retry(2, 2000, function ($exception = null, $request = null) {

                if ($exception->response->status() == 401) {
                    //invalid token 
                    if (!is_null($request)) {

                        $request->withToken($this->GetAccessToken());
                    } else {
                        $this->GetAccessToken();
                    }

                    return true;
                } else {
                    return false;
                }
            })->Delete("https://api.zoom.us/v2/videosdk/sessions/{$SessionId}/recordings", [
                'action' => $action
            ]);

            return $response;
        } catch (Exception $e) {
            // dispatch(new SendJobErrorMailJob(['function' => 'EndSession', 'message' => $e->getMessage()]));
            Log::info($e);
          
        }
    }


    public function RecoverSessionRecording($SessionId = null)
    {
        //to start end recording etc

        if (is_null($SessionId))
            return;
        if ($this->CheckToken() == false)   // agar token expire hogia tu dobara kro 
            $this->GetAccessToken();
        // this api return data as paginate .. so it has next page token that we send as query parameter to get next page data..
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->acceptJson()->withToken(Cache::get('AccessToken'))->withBody(json_encode(['action' => 'recover']), 'application/json')->retry(2, 2000, function ($exception = null, $request = null) {

                if ($exception->response->status() == 401) {
                    //invalid token 
                    if (!is_null($request)) {

                        $request->withToken($this->GetAccessToken());
                    } else {
                        $this->GetAccessToken();
                    }

                    return true;
                } else {
                    return false;
                }
            })->PUT("https://api.zoom.us/v2/videosdk/sessions/{$SessionId}/recordings/status");

            return $response;
        } catch (Exception $e) {
            // dispatch(new SendJobErrorMailJob(['function' => 'EndSession', 'message' => $e->getMessage()]));
            Log::info($e);
           
        }
    }
}
