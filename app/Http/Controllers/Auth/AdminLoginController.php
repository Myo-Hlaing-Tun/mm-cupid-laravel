<?php

namespace App\Http\Controllers\Auth;

use App\Constants;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepositoryInterface;
use App\Utility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AdminLoginController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        DB::connection()->enableQueryLog();
    }

    public function getLogin(){
        try{
            $company_name = Constants::COMPANY_NAME;
            if(Auth::guard('admin')->user() != null){
                return redirect('admin-backend/index');
            }
            return view('backend.login',compact(
                'company_name'
            ));
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "AdminLoginController:getLogin - \n",(string) $e->getMessage());
        }
    }

    public function adminLogin(AdminLoginRequest $request){
        try{
            $username   = $request->get('username');
            $password   = $request->get('password');
            $userinfo   = $this->userRepository->getUserInfoByUsername((string) $username);
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "AdminLoginController:adminLogin - \n",(array) $query_log);
            if($userinfo != null){
                if(!Hash::check($password,$userinfo->password)){
                    return redirect()
                        ->back()
                        ->withErrors(['login_error'=>"Password Does Not Match"])
                        ->withInput();
                }else if($userinfo->status != Constants::ADMIN_ENABLE_STATUS){
                    return redirect()
                        ->back()
                        ->withErrors(['login_error'=>"You Have Been Banned By Administrator"])
                        ->withInput();
                }else if($userinfo->deleted_at != null){
                    return redirect()
                        ->back()
                        ->withErrors(['login_error'=>"Your Account Have Been Deleted"])
                        ->withInput();
                }
                else{
                    $credentials = Auth::guard('admin')->attempt([
                        'username' => $request->get('username'),
                        'password' => $request->get('password'),
                    ]);
                    if($credentials){
                        $role = Auth::guard('admin')->user()->role;
                        $permission = $this->userRepository->getRolePermissionByRoleId((int) $role);
                        $query_log = DB::getQueryLog();
                        Utility::saveDebugLog((string) "AdminLoginController:adminLogin(get_role_permission) - \n",(array) $query_log);
                        Session::put('permission',$permission);
                        return redirect('admin-backend/index');
                    }
                    else
                    {
                        return redirect()
                            ->back()
                            ->withErrors(['login_error'=>"Unexpected Login Error"])
                            ->withInput();
                    }
                }
        }
        else{
            return redirect()
                ->back()
                ->withErrors(['login_error'=>$username . " Does Not Exist"])
                ->withInput();
        }
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "AdminLoginController:adminLogin - \n",(string) $e->getMessage());
            abort(500);
        }
    }   
    public function adminLogout(){
        try{
            Auth::guard('admin')->logout();
            Session::flush();
            return redirect('admin-backend');
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "AdminLoginController:adminLogout - \n",(string) $e->getMessage());
            dd($e->getMessage());
        }
    }
}
