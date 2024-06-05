<?php

namespace App\Http\Controllers\SalesSupport;

use App\Classes\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\TrialRequest;
use App\Repository\TrialRequestRepositoryInterface;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $trialRequestRepository;
    public function __construct(TrialRequestRepositoryInterface  $trialRequestRepository){
        $this->trialRequestRepository = $trialRequestRepository;

    }
    public function index(){

        $user = auth()->user();
        $trialRequests = $this->trialRequestRepository->allBy(['status' => StatusEnum::TrialUnScheduled]);
//dd($trialRequests[0]);
        return view('front.sales-support.dashboard', compact('user', 'trialRequests'));
    }

    public function summary(){

        return view('front.sales-support.summary');
    }
}
