<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\DeletePhotoRequest;
use App\Http\Requests\Frontend\MemberUpdateRequest;
use App\Http\Requests\Frontend\PointPurchaseRequest;
use App\Http\Requests\Frontend\RespondInvitationRequest;
use App\Http\Requests\Frontend\SyncMemberRequest;
use App\Http\Requests\Frontend\UpdatePhotoRequest;
use App\Http\Requests\Frontend\VerifyPhotoRequest;
use App\Http\Resources\MembersResource;
use App\Repositories\Member\MemberRepositoryInterface;
use App\ReturnedMessage;
use App\Utility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    private $memberRepository;
    public function __construct(MemberRepositoryInterface $memberRepository){
        $this->memberRepository = $memberRepository;
        DB::enableQueryLog();
    }
    public function getProfile(){
        try{
            return view('frontend.profile');
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "ProfileController:getProfile - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function syncMember(SyncMemberRequest $request){
        try{
            $member = $this->memberRepository->getMember((int) $request->get('id'));
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "ProfileController:syncMember - \n",(array) $query_log);
            return new MembersResource($member);
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "ProfileController:syncMember - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function editMember(MemberUpdateRequest $request){
        try{
            $result = $this->memberRepository->updateMemberDetails((array) $request->all());
            if($result['status'] == ReturnedMessage::STATUS_OK){
                $query_log = DB::getQueryLog();
                Utility::saveDebugLog((string) "ProfileController:editMember - \n",(array) $query_log);
                return new MembersResource($result['member']);
            }
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "ProfileController:editMember - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function editPhoto(UpdatePhotoRequest $request){
        try{
            $result = $this->memberRepository->updatePhoto((array) $request->all());
            if($result['status'] == ReturnedMessage::STATUS_OK){
                $query_log = DB::getQueryLog();
                Utility::saveDebugLog((string) "ProfileController:editPhoto - \n",(array) $query_log);
                return response()->json($result);
            }
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "ProfileController:editPhoto - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function deletePhoto(DeletePhotoRequest $request){
        try{
            $result = $this->memberRepository->deletePhoto((int) $request->get('sort'));
            if($result['status'] == ReturnedMessage::STATUS_OK){
                $query_log = DB::getQueryLog();
                Utility::saveDebugLog((string) "ProfileController:deletePhoto - \n",(array) $query_log);
                return response()->json($result);
            }
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "ProfileController:deletePhoto - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function verifyPhoto(VerifyPhotoRequest $request){
        try{
            $result = $this->memberRepository->photoVerification((string) $request->get('src'));
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "ProfileController:verifyPhoto - \n",(array) $query_log);
            return response()->json($result);
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "ProfileController:verifyPhoto - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function respondInvitation(RespondInvitationRequest $request){
        try{
            $result = $this->memberRepository->respondInvitation((array) $request->all());
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "ProfileController:respondInvitation - \n",(array) $query_log);
            if($result['status'] == ReturnedMessage::STATUS_OK){
                return response()->json(['id'=>Auth::guard('member')->user()->id]);
            }
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "ProfileController:respondInvitation - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function purchasePoint(PointPurchaseRequest $request){
        try{
            $result = $this->memberRepository->purchasePoint((array) $request->all());
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "ProfileController:purchasePoint - \n",(array) $query_log);
            if($result['status'] == ReturnedMessage::STATUS_OK){
                return redirect('profile')
                        ->with('suc_msg','Point purchase is successful. Please wait for admin team to review screenshot and add your point');
            }
            else{
                return redirect('profile')
                        ->with('err_msg','Failed to purchase point. Please try again.');
            }
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "ProfileController:purchasePoint - \n",(string) $e->getMessage());
            abort(500);
        }
    }
}