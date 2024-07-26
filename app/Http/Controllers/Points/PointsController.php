<?php

namespace App\Http\Controllers\Points;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfirmPointPurchaseRequest;
use App\Http\Requests\PointManageRequest;
use App\Repositories\Member\MemberRepositoryInterface;
use App\Repositories\Point\PointRepositoryInterface;
use App\ReturnedMessage;
use App\Utility;
use Illuminate\Support\Facades\DB;

class PointsController extends Controller
{
    private $pointRepository;
    private $memberRepository;
    public function __construct(
            PointRepositoryInterface $pointRepository,
            MemberRepositoryInterface $memberRepository
        ){
        $this->pointRepository  = $pointRepository;
        $this->memberRepository = $memberRepository;
        DB::enableQueryLog();
    }
    public function index(){
        try{
            $members = $this->pointRepository->getMembers();
            $query_log  = DB::getQueryLog();
            Utility::saveDebugLog((string) "PointsController:index - \n", (array) $query_log);
            if($members != null){
                return view('backend.points.index',compact(
                    ['members']
                ));
            }
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "PointsController:index - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function viewDetails(int $id){
        try{
            $member = $this->memberRepository->getMember((int) $id);
            if($member == null){
                abort(404);
            }
            else{
                $query_log  = DB::getQueryLog();
                Utility::saveDebugLog((string) "PointsController:viewDetails - \n", (array) $query_log);
                return view('backend.points.view_member',compact(
                    ['member']
                ));
            }
        }
        catch(\Exception $e){
            if($e->getCode() == 0){
                abort(404);
            }
            Utility::saveErrorLog((string) "PointsController:viewDetails - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function confirmPurchase(ConfirmPointPurchaseRequest $request){
        try{
            $result = $this->pointRepository->addPoints((array) $request->all());
            $query_log  = DB::getQueryLog();
            Utility::saveDebugLog((string) "PointsController:confirmPurchase - \n", (array) $query_log);
            if($result['status'] == ReturnedMessage::STATUS_OK){
                return redirect('admin-backend/pointpurchase/index')
                            ->with('success_msg','Member Point Added Successfully');
            }
            else{
                return redirect('admin-backend/pointpurchase/index')
                            ->with('error_msg','Failed To Add Point');
            }
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "PointsController:confirmPurchase - \n",(string) $e->getMessage());
            abort(500);
        };
    }
    public function rejectPurchase(int $id){
        try{
            $result = $this->pointRepository->rejectPurchase((int) $id);
            $query_log  = DB::getQueryLog();
            Utility::saveDebugLog((string) "PointsController:rejectPurchase - \n", (array) $query_log);
            if($result['status'] == ReturnedMessage::STATUS_OK){
                return redirect('admin-backend/pointpurchase/index')
                            ->with('success_msg','Point Purchase Rejected Successfully');
            }
            else{
                return redirect('admin-backend/pointpurchase/index')
                            ->with('error_msg','Failed To Reject Point Purchase');
            }
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "PointsController:rejectPurchase - \n",(string) $e->getMessage());
            abort(500);
        };
    }
    public function editPoints(int $id){
        try{
            $member = $this->memberRepository->getMemberById((int) $id);
            if($member == null){
                abort(404);
            }
            else{
                $query_log = DB::getQueryLog();
                Utility::saveDebugLog((string) "PointsController:editPoints - \n",(array) $query_log);
                return view('backend.members.subtract_points',compact(
                    ['member']
                ));
            }
        }
        catch(\Exception $e){
            if($e->getCode() == 0){
                abort(404);
            }
            Utility::saveErrorLog((string) "PointsController:confirmMember - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function storePoints(PointManageRequest $request){
        try{
            $result = $this->memberRepository->subtractPoints((array) $request->all());
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "PointsController:storePoints - \n",(array) $query_log);
            if($result['status'] == ReturnedMessage::STATUS_OK){
                return redirect('admin-backend/member/index')
                            ->with('success_msg','Point Updated Successfully');
            }
            else{
                return redirect('admin-backend/member/index')
                            ->with('error_msg','Failed to update point');
            }
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "PointsController:confirmMember - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function showPoints(){
        try{
            $point_logs = $this->pointRepository->showPoints();
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "PointsController:showPoints - \n",(array) $query_log);
            return view('backend.points.pointlog',compact(
                ['point_logs']
            ));
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "PointsController:showPoints - \n",(string) $e->getMessage());
            abort(500);
        }
    }
}
