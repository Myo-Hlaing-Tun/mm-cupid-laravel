<?php

namespace App\Http\Controllers\Members;

use App\Constants;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ConfirmCodeRequest;
use App\Http\Requests\Frontend\EmailConfirmRequest;
use App\Http\Requests\Frontend\ForgetPasswordEmailRequest;
use App\Http\Requests\Frontend\MemberDetailsStoreRequest;
use App\Http\Requests\Frontend\MemberLoginRequest;
use App\Http\Requests\Frontend\RequestDateRequest;
use App\Http\Requests\Frontend\ResetPasswordRequest;
use App\Http\Requests\Frontend\SyncMembersRequest;
use App\Http\Requests\Frontend\ViewMemberRequest;
use App\Http\Resources\CitiesResource;
use App\Http\Resources\HobbiesResource;
use App\Http\Resources\MembersResource;
use App\Mail\ForgetPasswordMail;
use App\Mail\RegistrationConfirmMail;
use App\Repositories\City\CityRepositoryInterface;
use App\Repositories\Hobby\HobbyRepositoryInterface;
use App\Repositories\Member\MemberRepositoryInterface;
use App\Repositories\Setting\SettingRepositoryInterface;
use App\ReturnedMessage;
use App\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Mail;

class MembersController extends Controller
{
    private $cityRepository;
    private $hobbyRepository;
    private $memberRepository;
    private $settingRepository;
    public function __construct(
        CityRepositoryInterface $cityRepository,
        HobbyRepositoryInterface $hobbyRepository,
        MemberRepositoryInterface $memberRepository,
        SettingRepositoryInterface $settingRepository
        ){
          $this->cityRepository = $cityRepository;
          $this->hobbyRepository = $hobbyRepository;
          $this->memberRepository = $memberRepository;
          $this->settingRepository = $settingRepository;
          DB::enableQueryLog();  
    }
    public function getMembers(){
        try{
            $members    = $this->memberRepository->getMembers();
            $query_log  = DB::getQueryLog();
            Utility::saveDebugLog((string) "MembersController:getMembers - \n", (array) $query_log);
            return view('backend.members.show_members',compact(
                [ 'members' ]
            ));
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "MembersController:getMembers - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function register(){
        try{
            if(Auth::guard('member')->user() != null){
                return redirect('home');
            }
            return view('frontend.register');
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "MembersController:register - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function getCities(){
        try{
            $cities = $this->cityRepository->getCities();
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "MembersController:getCities - \n",(array) $query_log);
            return CitiesResource::collection($cities);
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "MembersController:getCities - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function getHobbies(){
        try{
            $hobbies = $this->hobbyRepository->getHobbies();
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "MembersController:getHobbies - \n",(array) $query_log);
            return HobbiesResource::collection($hobbies);
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "MembersController:getHobbies - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function matchEmail($email){
        try{
            $email_exists = $this->memberRepository->emailExists($email);
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "MembersController:matchEmail - \n",(array) $query_log);
            return response()->json($email_exists);
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "MembersController:matchEmail - \n",(string) $e->getMessage());
            abort(500);
        }
    }

    public function registerData(MemberDetailsStoreRequest $request){
        try{
            $result = $this->memberRepository->storeMemberDetails((array) $request->all());
            
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "MembersController:registerData - \n",(array) $query_log);
            $company_name = $this->settingRepository->getSetting()->company_name;
            $company_email = $this->settingRepository->getSetting()->company_email;
            $email_confirm_code = $result['member']['email_confirm_code'];

            $mailData = [
                'company_name' => $company_name,
                'email' => $company_email,
                'email_confirm_code' => $email_confirm_code
            ];
            Mail::to($result['member']['email'])->send(new RegistrationConfirmMail($mailData));
            return response()->json($result);
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "MembersController:registerData - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function emailConfirm(EmailConfirmRequest $request){
        try{
            $result     = $this->memberRepository->confirmEmail((string) $request->get('code'));
            $query_log  = DB::getQueryLog();
            Utility::saveDebugLog((string) "MembersController:emailConfirm - \n",(array) $query_log);
            if($result['status'] == ReturnedMessage::STATUS_OK){
                if(!isset($result['msg'])){
                    return redirect('login')
                        ->with('suc_msg','You have confirmed your email for mm-cupid. Now you can login.');
                }
                return redirect('login')
                        ->with('err_msg',$result['msg']);
            }
            else{
                return view('frontend.failed_email_confirm');
            }
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "MembersController:emailConfirm - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function getLogin(Request $request){
        try{
            if($request->get('success') == 1){
                return redirect('login')
                        ->with('suc_msg','Registration is successful. Please check your email for further account confirmation to log in');
            }
            if(Auth::guard('member')->user() != null){
                return redirect('home');
            }
            return view('frontend.login');
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "MembersController:getLogin - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function login(MemberLoginRequest $request){
        try{
            $member = $this->memberRepository->getMemberByEmail((string) $request->get('email'));
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "MembersController:login - \n",(array) $query_log);
            if($member != null){
                if(!Hash::check($request->get('password'),$member->password)){
                    return redirect('/login')
                        ->with('err_msg','Wrong password')
                        ->withInput();
                }
                else if($member['status'] == Constants::MEMBER_BANNED_STATUS){
                    return redirect('/login')
                            ->with('err_msg','Your account is banned by administrator')
                            ->withInput();
                }
                else if($member['deleted_at'] != null){
                    return redirect('/login')
                            ->with('err_msg','Your account has been deleted')
                            ->withInput();
                }
                else{
                    $credentials = Auth::guard('member')->attempt([
                        'email'     => $request->get('email'),
                        'password'  => $request->get('password'),
                    ]);
                    if(Auth::guard('member')->user() != null){
                        $result = $this->memberRepository->login((string) $request->get('email'));
                        $query_log = DB::getQueryLog();
                        Utility::saveDebugLog((string) "MembersController:getLogin - \n", (array) $query_log);
                        if($result['status'] == ReturnedMessage::STATUS_OK){
                            return redirect()
                                ->intended('home')
                                ->with('suc_msg','Successfully logged in');
                        }
                        else{
                            return redirect('/login')
                                    ->with('err_msg','Failed to log in')
                                    ->withInput();
                        }
                    }
                    else{
                        return redirect('/login')
                                ->with('err_msg','Failed to log in')
                                ->withInput();
                    }
                }
            }
            else{
                return redirect('/login')
                        ->with('err_msg','Wrong email')
                        ->withInput();
            }
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "MembersController:getLogin - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function logout(){
        try{
            Auth::guard('member')->logout();
            Session::flush();
            return redirect('login');
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "MembersController:logout - \n",(string) $e->getMessage());
        }
    }
    public function getInput(Request $request){
        try{
            if($request->get('fail') == 1){
                return redirect('forget-password')
                        ->with('err_msg','Reset code is expired. Please request again to resend password reset code.');
            }
            return view('frontend.forget_password');
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "MembersController:getInput - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function sendCode(ForgetPasswordEmailRequest $request){
        try{
            $member = $this->memberRepository->getMemberByEmail((string) $request->get('email'));
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "MembersController:sendCode - \n",(array) $query_log);
            if($member == null){
                return redirect('forget-password')
                        ->with('err_msg','Your email has already been deleted')
                        ->withInput();
            }
            else{
                $result = $this->memberRepository->generateToken((int) $member->id);
                $setting = $this->settingRepository->getSetting();
                $query_log = DB::getQueryLog();
                Utility::saveDebugLog((string) "MembersController:sendCode - \n",(array) $query_log);
                if($result['status'] == ReturnedMessage::STATUS_OK){
                    $mailData = [
                        'company_name' => $setting->company_name,
                        'email' => $setting->company_email,
                        'code' => $result['token']
                    ];
                    Mail::to($request->get('email'))->send(new ForgetPasswordMail($mailData));
                    return redirect('reset-password')
                            ->with('suc_msg','We have sent password reset code to your email. Please check your email and enter reset code here');
                }
                else{
                    if($result['msg'] != null){
                        return redirect('reset-password')
                            ->with('suc_msg','We have already sent password reset code to your email. Please check your email and enter reset code here');
                    }
                    else{
                        return redirect('forget-password')
                                ->with('err_msg','Fail to generate forget password token')
                                ->withInput();
                    }
                }
            }
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "MembersController:sendCode - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function getSendCode(){
        try{
            return view('frontend.send_code');
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "MembersController:getSendCode - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function confirmCode(ConfirmCodeRequest $request){
        try{
            $result = $this->memberRepository->confirmPasswordResetCode((string) $request->get('code'));
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "MembersController:confirmCodes - \n",(array) $query_log);
            return response()->json($result);
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "MembersController:confirmCodes - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function getChangePassword(string $token){
        try{
            return view('frontend.password_change',compact(['token']));
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "MembersController:getChangePassword - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function changePassword(ResetPasswordRequest $request){
        try{
            $result = $this->memberRepository->resetPassword((array) $request->all());
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "MembersController:changePassword - \n",(array) $query_log);
            if($result['status'] == ReturnedMessage::STATUS_OK){
                return redirect('login')
                        ->with('suc_msg','Password successfully changed');
            }
            else{
                return redirect('forget-password')
                        ->with('err_msg','Password failed to reset');
            }
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "MembersController:changePassword - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function getIndex(){
        try{
            return view('frontend.index');
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "MembersController:getIndex - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function syncMembers(SyncMembersRequest $request){
        try{
            $members = $this->memberRepository->syncMembers((array) $request->all());
            return MembersResource::collection($members);
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "MembersController:syncMembers - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function updateViewCount(ViewMemberRequest $request){
        try{
            $result = $this->memberRepository->updateView((int) $request->get('id'));
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "MembersController:updateViewCount - \n",(array) $query_log);
            if($result['status'] == ReturnedMessage::STATUS_OK){
                return response()->json($result);
            }
            else{
                return response()->json($result);
            }
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "MembersController:updateViewCount - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function requestDate(RequestDateRequest $request){
        try{
            $result = $this->memberRepository->requestDate((int) $request->get('id'));
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "MembersController:requestDate - \n",(array) $query_log);
            if($result['status'] == ReturnedMessage::STATUS_OK){
                return response()->json([
                    'member'    => new MembersResource($result['member']),
                    'point'     => $result['point']
                ]);
            }
            else{
                abort(500);
            }
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "MembersController:requestDate - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function viewMember(string $username,int $id){
        try{
            $member = $this->memberRepository->getMember((int) $id);
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "MembersController:viewMember - \n",(array) $query_log);
            if($member == null){
                abort(404);
            }
            $resource_member = new MembersResource($member);
            $id         = $member->id;
            $username   = $member->username;
            return view('frontend.other_profile',compact(
                'id' , 'username'
            ));
        }
        catch(\Exception $e){
            if($e->getCode() == 0){
                abort(404);
            }
            Utility::saveErrorLog((string) "MembersController:viewMember - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function deleteMember(int $id){
        try{
            $member = $this->memberRepository->getMemberById((int) $id);
            if($member == null){
                abort(404);
            }
            else{
                $result = $this->memberRepository->deleteMember((int) $id);
                $query_log = DB::getQueryLog();
                Utility::saveDebugLog((string) "MembersController:deleteMember - \n",(array) $query_log);
                if($result['status'] == ReturnedMessage::STATUS_OK){
                    return redirect('admin-backend/member/index')
                        ->with('success_msg','Member Deleted Successfully');
                }
                else{
                    return redirect('admin-backend/user/index')
                        ->with('error_msg','Failed To Delete Member');
                }
            }
        }catch(\Exception $e){
            if($e->getCode() == 0){
                abort(404);
            }
            Utility::saveErrorLog((string) "MembersController:deleteMember - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function confirmMember(int $id){
        try{
            $member = $this->memberRepository->getMemberById((int) $id);
            if($member == null){
                abort(404);
            }
            else{
                $result = $this->memberRepository->confirmMember((int) $id);
                $query_log = DB::getQueryLog();
                Utility::saveDebugLog((string) "MembersController:confirmMember - \n",(array) $query_log);
                if($result['status'] == ReturnedMessage::STATUS_OK){
                    return redirect('admin-backend/member/index')
                            ->with('success_msg','Member Confirmed Successfully');
                }
                else{
                    return redirect('admin-backend/user/index')
                            ->with('error_msg','Failed To Confirm Member');
                }
            }
        }catch(\Exception $e){
            if($e->getCode() == 0){
                abort(404);
            }
            Utility::saveErrorLog((string) "MembersController:confirmMember - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function viewMemberDetails(int $id){
        try{
            $member = $this->memberRepository->getMember((int) $id);
            if($member == null){
                abort(404);
            }
            else{
                $query_log = DB::getQueryLog();
                Utility::saveDebugLog((string) "MembersController:viewMemberDetails - \n",(array) $query_log);
                return view('backend.members.member_details',compact(
                    ['member']
                ));
            }
        }catch(\Exception $e){
            if($e->getCode() == 0){
                abort(404);
            }
            Utility::saveErrorLog((string) "MembersController:confirmMember - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function filterMembers(string $keyword){
        try{
            $members = $this->memberRepository->filterMembers((string) $keyword);
            $query_log  = DB::getQueryLog();
            Utility::saveDebugLog((string) "MembersController:filterMembers - \n", (array) $query_log);
            return view('backend.members.show_members',compact(
                [ 'members', 'keyword' ]
            ));
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "MembersController:filterMembers - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function getTodayMembers(){
        try{
            $members = $this->memberRepository->getRegisteredMembers();
            $query_log  = DB::getQueryLog();
            Utility::saveDebugLog((string) "MembersController:getTodayMembers - \n", (array) $query_log);
            return $members;
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "MembersController:getTodayMembers - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function showDatingRequests(){
        try{
            $requests = $this->memberRepository->getApprovedDatingRequests();
            $query_log  = DB::getQueryLog();
            Utility::saveDebugLog((string) "MembersController:showDatingRequests - \n", (array) $query_log);
            return view('backend.datings.index',compact(
                ['requests']
            ));
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "MembersController:getTodayMembers - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function showDatingMembers(int $invite_id, int $accept_id){
        try{
            $invite_member  = $this->memberRepository->getMember((int) $invite_id);
            $accept_member  = $this->memberRepository->getMember((int) $accept_id);
            $dating_id      = $this->memberRepository->getDatingId((int) $invite_id,(int) $accept_id);
            if($invite_member == null){
                abort(404);
            }
            if($accept_member == null){
                abort(404);
            }
            $query_log  = DB::getQueryLog();
            Utility::saveDebugLog((string) "MembersController:showDatingMembers - \n", (array) $query_log);
            return view('backend.datings.view_members',compact(
                ['invite_member', 'accept_member', 'dating_id']
            ));
        }
        catch(\Exception $e){
            if($e->getCode() == 0){
                abort(404);
            }
            Utility::saveErrorLog((string) "MembersController:getTodayMembers - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function approveDating(int $id){
        try{
            $result = $this->memberRepository->approveDatingRequest((int) $id);
            if($result['status'] == ReturnedMessage::STATUS_OK){
                return redirect('admin-backend/dating/index')
                        ->with('success_msg','Dating Approved Successfully');
            }
            else{
                return redirect('admin-backend/dating/index')
                        ->with('error_msg','Dating Failed To Approve');
            }
        }
        catch(\Exception $e){
            if($e->getCode() == 0){
                abort(404);
            }
            Utility::saveErrorLog((string) "MembersController:getTodayMembers - \n",(string) $e->getMessage());
            abort(500);
        }
    }
}
