<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
   
    public function index(){
        
        return view('admin.dashboard');
    }


    public function login(){
        return view('admin.auth.login');
    }
}
