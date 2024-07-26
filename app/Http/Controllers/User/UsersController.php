<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use App\ReturnedMessage;
use App\Utility;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    private $userRepository;
    public function __construct(UserRepositoryInterface $userRepository){
        $this->userRepository = $userRepository;
        DB::connection()->enableQueryLog();
    }
    public function createUser(){
        try{
            return view('backend.users.form');
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "UsersController:createUser - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function storeUser(UserStoreRequest $request){
        try{
            $result = $this->userRepository->storeUser((array) $request->all());
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "UsersController:storeUser - \n",(array) $query_log);
            if($result['status'] == ReturnedMessage::STATUS_OK){
                return redirect('admin-backend/user/index')
                        ->with('success_msg','User Created Successfully');
            }
            else{
                return redirect('admin-backend/user/index')
                        ->with('error_msg','User Failed To Create');
            }
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "UsersController:storeUser - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function getUsers(){
        try{
            $users      = $this->userRepository->getUsers();
            $query_log  = DB::getQueryLog();
            Utility::saveDebugLog((string) "UsersController:getUsers - \n",(array) $query_log);
            return view('backend.users.show_users',compact(
                ['users']
            ));
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "UsersController:getUsers - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function getEditUser(int $id){
        try{
            $user = $this->userRepository->getUserById((int) $id);
            if($user == null){
                abort(404);
            }
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "UsersController:getEditUser - \n",(array) $query_log);
            return view('backend.users.form',compact(
                ['user']
            ));
        }
        catch(\Exception $e){
            if($e->getCode() == 0){
                abort(404);
            }
            Utility::saveErrorLog((string) "UsersController:getEditUser - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function updateUser(UserUpdateRequest $request){
        try{
            $result     = $this->userRepository->updateUser((array) $request->all());
            $query_log  = DB::getQueryLog();
            Utility::saveDebugLog((string) "UsersController:updateUser - \n",(array) $query_log);
            if($result['status'] == ReturnedMessage::STATUS_OK){
                return redirect('admin-backend/user/index')
                        ->with('success_msg','User Updated Successfully');
            }
            else{
                return redirect('admin-backend/user/index')
                        ->with('error_msg','User Failed To Update');
            }
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "UsersController:updateUser - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function getPasswordChanger(int $id){
        try{
            $user = $this->userRepository->getUserById((int) $id);
            if($user == null){
                abort(404);
            }
            else{
                return view('backend.users.edit_password',compact(
                    ['id']
                ));
            }
        }
        catch(\Exception $e){
            if($e->getCode() == 0){
                abort(404);
            }
            Utility::saveErrorLog((string) "UsersController:getPasswordChanger - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function changePassword(PasswordUpdateRequest $request){
        try{
            $result     = $this->userRepository->changePassword((array) $request->all());
            $query_log  = DB::getQueryLog();
            Utility::saveDebugLog((string) "UsersController:changePassword - \n",(array) $query_log);
            if($result['status'] == ReturnedMessage::STATUS_OK){
                return redirect('admin-backend/user/index')
                        ->with('success_msg','Password Changed Successfully');
            }
            else{
                return redirect('admin-backend/user/index')
                ->with('error_msg','Failed To Change Password');
            }
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "UsersController:changePassword - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function deleteUser(int $id){
        try{
            $user = $this->userRepository->getUserById((int) $id);
            if($user == null){
                abort(404);
            }
            $result = $this->userRepository->deleteUser((int) $id);
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "UsersController:deleteUser - \n",(array) $query_log);
            if($result['status'] == ReturnedMessage::STATUS_OK){
                return redirect('admin-backend/user/index')
                        ->with('success_msg','User Deleted Successfully');
            }
            else{
                return redirect('admin-backend/user/index')
                        ->with('error_msg','Failed To Delete User');
            }
        }
        catch(\Exception $e){
            if($e->getCode() == 0){
                abort(404);
            }
            Utility::saveErrorLog((string) "UsersController:deleteUser - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function banUser(int $id){
        try{
            $user = $this->userRepository->getUserById((int) $id);
            if($user == null){
                abort(404);
            }
            $result = $this->userRepository->banUser((int) $id);
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "UsersController:banUser - \n",(array) $query_log);
            if($result['status'] == ReturnedMessage::STATUS_OK){
                return redirect('admin-backend/user/index')
                        ->with('success_msg','User Banned Successfully');
            }
            else{
                return redirect('admin-backend/user/index')
                        ->with('error_msg','Failed To Ban User');
            }
        }
        catch(\Exception $e){
            if($e->getCode() == 0){
                abort(404);
            }
            Utility::saveErrorLog((string) "UsersController:banUser - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function unbanUser(int $id){
        try{
            $user = $this->userRepository->getUserById((int) $id);
            if($user == null){
                abort(404);
            }
            $result = $this->userRepository->unbanUser((int) $id);
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "UsersController:unbanUser - \n",(array) $query_log);
            if($result['status'] == ReturnedMessage::STATUS_OK){
                return redirect('admin-backend/user/index')
                        ->with('success_msg','User Unbanned Successfully');
            }
            else{
                return redirect('admin-backend/user/index')
                        ->with('error_msg','Failed To Unban User');
            }
        }
        catch(\Exception $e){
            if($e->getCode() == 0){
                abort(404);
            }
            Utility::saveErrorLog((string) "UsersController:unbanUser - \n",(string) $e->getMessage());
            abort(500);
        }
    }
}
