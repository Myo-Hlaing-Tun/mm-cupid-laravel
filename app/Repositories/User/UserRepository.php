<?php 
    namespace App\Repositories\User;

    use App\Constants;
    use App\Models\User;
    use App\ReturnedMessage;
    use App\Utility;
    use Illuminate\Support\Facades\DB;

    class UserRepository implements UserRepositoryInterface{
        public function getUserInfoByUsername(string $username){
            $userinfo   = User::SELECT('password','status','deleted_at')
                        ->WHERE('username',$username)
                        ->first();
            return $userinfo;
        }

        public function getRolePermissionByRoleId(int $role){
            $permission = DB::SELECT("SELECT route FROM `role_permission` WHERE role='$role'");
            return $permission;
        }
        public function storeUser(array $data){
            $returned_array     = [];
            $username           = $data['username'];
            $password           = bcrypt($data['password']);
            $role               = $data['role'];
            $insert             = [];
            $insert['username'] = $username;
            $insert['password'] = $password;
            $insert['role']     = $role;
            $insert['status']   = Constants::ADMIN_ENABLE_STATUS;
            $paramObj           = Utility::addCreatedBy((array) $insert);
            $result             = User::create($paramObj);
            if($result){
                $returned_array['status'] = ReturnedMessage::STATUS_OK;
            }
            else{
                $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
            }
            return $returned_array;
        }
        public function getUsers(){
            $users = User::SELECT('id','username','role','status')
                    ->selectRaw('CASE
                                    WHEN role = ' . Constants::ADMIN_ROLE . ' THEN "Admin"
                                    WHEN role = ' . Constants::Editor_ROLE . ' THEN "Editor"
                                    WHEN role = ' . Constants::CUSTOMER_SERVICE_ROLE . ' THEN "Customer Service"
                                    ELSE "Unknown"
                                END as role_name,
                                CASE
                                    WHEN status = ' . Constants::ADMIN_ENABLE_STATUS . ' THEN "Active"
                                    WHEN status = ' . Constants::ADMIN_DISABLE_STATUS . ' THEN "Inactive"
                                    ELSE "Unkown"
                                END as status_name')
                    ->whereNull('deleted_at')
                    ->get();
            return $users;
        }
        public function getUserById(int $id){
            $user = User::SELECT('id','username','role','status')
                    ->where('id','=',$id)
                    ->whereNull('deleted_at')
                    ->first();
            return $user;
        }
        public function updateUser(array $data){
            $returned_array     = [];
            $id                 = $data['id'];
            $username           = $data['username'];
            $role               = $data['role'];
            $insert             = [];
            $insert['username'] = $username;
            $insert['role']     = $role;
            $paramObj           = Utility::addUpdatedBy((array) $insert);
            $user               = User::find($id);
            $result             = $user->update($paramObj);
            if($result){
                $returned_array['status'] = ReturnedMessage::STATUS_OK;
            }
            else{
                $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
            }
            return $returned_array;
        }
        public function changePassword(array $data){
            $returned_array     = [];
            $id                 = $data['id'];
            $password           = bcrypt($data['password']);
            $insert             = [];
            $insert['password'] = $password;
            $paramObj           = Utility::addUpdatedBy((array) $insert);
            $user               = User::find($id);
            $result             = $user->update($paramObj);
            if($result){
                $returned_array['status'] = ReturnedMessage::STATUS_OK;
            }
            else{
                $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
            }
            return $returned_array;
        }
        public function deleteUser(int $id){
            $returned_array = [];
            $user           = User::find($id);
            $paramObj       = Utility::addDeletedBy((array) []);
            $result         = $user->update($paramObj);
            if($result){
                $returned_array['status'] = ReturnedMessage::STATUS_OK;
            }
            else{
                $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
            }
            return $returned_array;
        }
        public function banUser(int $id){
            $returned_array     = [];
            $user               = User::find($id);
            $insert             = [];
            $insert['status']   = Constants::ADMIN_DISABLE_STATUS;
            $paramObj           = Utility::addUpdatedBy((array) $insert);
            $result             = $user->update($paramObj);
            if($result){
                $returned_array['status'] = ReturnedMessage::STATUS_OK;
            }
            else{
                $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
            }
            return $returned_array;
        }
        public function unbanUser(int $id){
            $returned_array     = [];
            $user               = User::find($id);
            $insert             = [];
            $insert['status']   = Constants::ADMIN_ENABLE_STATUS;
            $paramObj           = Utility::addUpdatedBy((array) $insert);
            $result             = $user->update($paramObj);
            if($result){
                $returned_array['status'] = ReturnedMessage::STATUS_OK;
            }
            else{
                $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
            }
            return $returned_array;
        }
    }
?>