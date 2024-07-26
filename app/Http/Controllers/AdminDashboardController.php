<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Repositories\Member\MemberRepositoryInterface;
use App\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    private $memberRepository;
    public function __construct(MemberRepositoryInterface $memberRepository){
        $this->memberRepository = $memberRepository;
        DB::enableQueryLog();
    }
    public function dashboard(){
        try{
            $total_registered_count         = $this->memberRepository->getTotalRegisteredMembers();
            $today_registered_count         = $this->memberRepository->getTodayRegisteredMembers();
            $today_email_confirmed_count    = $this->memberRepository->getTodayEmailConfirmedMembers();
            $today_date_requests_count      = $this->memberRepository->getTodayDateRequestsCount();
            $today_date_requests            = $this->memberRepository->getTodayDateRequests();
            return view('backend.index',compact(
                [
                    'total_registered_count',
                    'today_registered_count',
                    'today_email_confirmed_count',
                    'today_date_requests_count',
                    'today_date_requests'
                ]
            ));
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "AdminDashboardController:dashboard - \n",(string) $e->getMessage());
            abort(500);
        }
    }
}