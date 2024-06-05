<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ZoomtestController extends Controller
{

    public function __invoke(Request $request){
        $key = "QC58p1MWpHOXRwgKRvx34wyFee0Ji9e3Qgzb";
        $secret = "HXsYefpfRaE5VInoLLfW0UDJtJrGwocEcXyM";
        $meeting_number = "124";
        $role = 1;
        $token = array(
            "app_key"=> "QC58p1MWpHOXRwgKRvx34wyFee0Ji9e3Qgzb",
            "tpc"=> "safsa",
            "version"=> 1,
            "role_type"=> 1,
            "user_identity"=> "Alquran User",
            "session_key"=> "safsa",
            "iat"=> 1661335076,
            "exp"=> 1661342276,
            "pwd"=> "secret"
        );
        $encode = \Firebase\JWT\JWT::encode($token, $secret, 'HS256');
        return response()->json(['data'=> $encode],200);
    }
    //
}
