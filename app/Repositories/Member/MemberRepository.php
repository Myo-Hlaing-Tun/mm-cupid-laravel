<?php 
    namespace App\Repositories\Member;
    use App\Constants;
    use App\Models\Date_request;
    use App\Models\Member_gallery;
    use App\Models\Member_hobbies;
    use App\Models\Members;
    use App\Models\Point_logs;
    use App\Models\Point_Purchase;
    use App\Repositories\Setting\SettingRepositoryInterface;
    use App\ReturnedMessage;
    use App\Utility;
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\File;
    use Illuminate\Support\Facades\Storage;

    class MemberRepository implements MemberRepositoryInterface{
        private $settingRepository;
        public function __construct(SettingRepositoryInterface $settingRepository){
            $this->settingRepository = $settingRepository;
        }
        public function getMemberById(int $id){
            $member = Members::find($id);
            return $member;
        }
        public function getMemberByEmail(string $email){
            $member = Members::where('email', '=', $email)
                        ->whereNull('deleted_at')
                        ->first();
            return $member;
        }
        public function getMemberByResetCode(string $code){
            $member = Members::where('forget_password_token','=',$code)
                        ->whereNull('deleted_at')
                        ->first();
            return $member;
        }
        public function emailExists($email){
            $member = Members::where('email',$email)
                        ->whereNull('deleted_at')
                        ->first();
            if($member == null){
                return false;
            }
            else{
                return true;
            }
        }
        public function storeMemberDetails(array $data){
            DB::beginTransaction();
            try{
                $returned_array = [];
                $insert = [];
                $insert['username']             = $data['username'];
                $insert['email']                = $data['email'];
                $insert['password']             = bcrypt($data['password']);
                $insert['email_confirm_code']   = self::unique_email_code();
                $insert['phone']                = $data['phone'];
                $insert['date_of_birth']        = $data['date_of_birth'];
                $insert['height_feet']          = $data['height_feet'];
                $insert['height_inches']        = $data['height_inch'];
                $insert['city_id']              = $data['city'];
                $insert['education']            = $data['education'];
                $insert['about']                = $data['about'];
                $insert['work']                 = $data['work'];
                $insert['gender']               = $data['gender'];
                $insert['partner_min_age']      = $data['min_age'];
                $insert['partner_max_age']      = $data['max_age'];
                $insert['partner_gender']       = $data['pgender'];
                $insert['religion']             = $data['religion'];
                $insert['status']               = Constants::MEMBER_REGISTERED_STATUS;
                $insert['point']                = $this->settingRepository->getSetting()->point;
                $insert['view_count']           = 0;
                $result                         = Members::create($insert);
                DB::commit();

                $hobbies = $data['hobbies'];
                $hobbies = explode(',',$hobbies);
                $insert_id = $result->id;
                foreach($hobbies as $hobby){
                    $hobby_insert               = [];
                    $hobby_insert['member_id']  = $insert_id;
                    $hobby_insert['hobby_id']   = $hobby;
                    $hobby_insert['created_by'] = $insert_id;
                    $hobby_insert['updated_by'] = $insert_id;
                    Member_hobbies::create($hobby_insert);
                    DB::commit();
                }

                for($i=1; $i<=6; $i++){
                    $filename           = "file" . $i;
                    if(isset($data[$filename]) && $data[$filename]->isValid()){
                        $file               = $data[$filename];
                        $unique_name        = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME) . "_" . date('Ymd_His') . "_" . uniqid() . "." . $file->getClientOriginalExtension();

                        $gallery_insert                 = [];
                        $gallery_insert['member_id']    = $insert_id;
                        $gallery_insert['name']         = $unique_name;
                        $gallery_insert['sort']         = $i;
                        $gallery_insert['created_by']   = $insert_id;
                        $gallery_insert['updated_by']   = $insert_id;
                        Member_gallery::create($gallery_insert);
                        DB::commit();
                    }
                    if($i== 1 && isset($data['file1']) && $data['file1']->isValid()){
                        $thumb_name         = "thumb_" . $unique_name; 
                        $update_thumb = [];
                        $update_thumb['thumb'] = $thumb_name;
                        $member = Members::find($insert_id);
                        $member->update($update_thumb);
                        DB::commit();
                    }
                }
                if($result){
                    $member_gallery = Member_gallery::SELECT('name','sort')
                                        ->where('member_id','=',$insert_id)
                                        ->whereNull('deleted_at')
                                        ->get();
                    $thumb = true;
                    foreach($member_gallery as $gallery){
                        $unique_file_name = $gallery['name'];
                        $destination_path   = storage_path('app/public/member_images/' .$insert_id);
                        if(!File::exists($destination_path)){
                            File::makeDirectory($destination_path, 0755, true);
                        }
                        $filename           = "file" . $gallery['sort'];
                        $file               = $data[$filename];
                        $save_file = $file->storeAs('member_images/' .$insert_id . "/",$unique_file_name,'public');
                        if($thumb && $save_file){
                            $inserted_member = Members::find($insert_id);
                            $thumb = $inserted_member['thumb'];
                            $thumb_path = $destination_path . "/thumb/";
                            if(!File::exists($thumb_path)){
                                File::makeDirectory($thumb_path, 0755, true);
                            }
                            Utility::saveThumb($data['file1'], $thumb_path , $thumb, Constants::THUMB_WIDTH, Constants::THUMB_HEIGHT);
                        }
                        $thumb = false;
                    }
                    $returned_array['status'] = ReturnedMessage::STATUS_OK;
                    $returned_array['member'] = $result;
                }
                else{
                    DB::rollBack();
                    $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
                }
                return $returned_array;
            }
            catch (\Exception $e) {
                DB::rollBack();
                Utility::saveErrorLog((string) "MemberRepository:storeMemberDetails - \n",(string) $e->getMessage());
                abort(500);
            }
        }
        protected static function unique_email_code()
        {
            $seed = date('YmdHis');
            return md5($seed . uniqid());
        }
        public function confirmEmail(string $code){
            $returned_array = [];
            $member = Members::select('status')
                        ->where('email_confirm_code','=',$code)
                        ->whereNull('deleted_at')
                        ->first();
            if($member == null){
                $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
            }
            else{
                $insert = [];
                if($member->status == Constants::MEMBER_REGISTERED_STATUS){
                    $insert['status'] = Constants::MEMBER_EMAIL_CONFIRMED_STATUS;
                    $result = $member->update($insert);
                    if($result){
                        $returned_array['status'] = ReturnedMessage::STATUS_OK;
                    }
                    else{
                        $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
                    }
                }
                else{
                    $returned_array['status'] = ReturnedMessage::STATUS_OK;
                    $returned_array['msg']    = "You have already confirmed your account.";
                }
            }
            return $returned_array;
        }
        public function generateToken(int $id){
            $returned_array = [];
            $member = Members::find($id);
            if($member->forget_password_token_created_at != null){
                $carbon_created_at = Carbon::parse($member->forget_password_token_created_at);
                $now = Carbon::now();
                $secondsInOneDay = 24 * 60 * 60;
                $secondsDifference = $now->diffInSeconds($carbon_created_at);
                if ($secondsDifference < $secondsInOneDay) {
                    $returned_array['status']   = ReturnedMessage::INTERNAL_SERVER_ERROR;
                    $returned_array['msg']      = "Reset code has already been sent to your email";
                }
                else{
                    $insert                             = [];
                    $insert['forget_password_token']    = self::unique_email_code();
                    $insert['forget_password_token_created_at'] = date('Y-m-d H:i:s');
                    $result = $member->update($insert);
                    if($result){
                        $returned_array['status']   = ReturnedMessage::STATUS_OK;
                        $returned_array['token']    = $member->forget_password_token;
                    }
                    else{
                        $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
                    }
                }
            }
            else{
                $insert                             = [];
                $insert['forget_password_token']    = self::unique_email_code();
                $insert['forget_password_token_created_at'] = date('Y-m-d H:i:s');
                $result = $member->update($insert);
                if($result){
                    $returned_array['status']   = ReturnedMessage::STATUS_OK;
                    $returned_array['token']    = $member->forget_password_token;
                }
                else{
                    $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
                }
            }
            return $returned_array;
        }
        public function confirmPasswordResetCode(string $code){
            $returned_array = [];
            $member = Members::SELECT('forget_password_token','forget_password_token_created_at')
                        ->where('forget_password_token','=',$code)
                        ->first();
            if($member == null){
                $returned_array['status'] == ReturnedMessage::INTERNAL_SERVER_ERROR;
            }
            else{
                $carbon_created_at = Carbon::parse($member->forget_password_token_created_at);
                $now = Carbon::now();
                $secondsInOneDay = 24 * 60 * 60;
                $secondsDifference = $now->diffInSeconds($carbon_created_at);
                if ($secondsDifference > $secondsInOneDay) {
                    $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
                    $returned_array['msg']    = "Reset code is expired. Please request again to resend the reset code in your email";
                }
                else{
                    $returned_array['status']   = ReturnedMessage::STATUS_OK;
                    $returned_array['forget_password_token'] = $member->forget_password_token;
                }
            }
            return $returned_array;
        }
        public function resetPassword(array $data){
            $returned_array = [];
            $member = self::getMemberByResetCode((string) $data['code']);
            if($member == null){
                $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
            }
            else{
                $insert = [];
                $insert['password'] = bcrypt($data['password']);
    
                $result = $member->update($insert);
                if($result){
                    $returned_array['status'] = ReturnedMessage::STATUS_OK;
                }
                else{
                    $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
                }
            }
            return $returned_array;
        }
        public function login(string $email){
            $returned_array         = [];
            $update                 = [];
            $update['last_login']   = date("Y-m-d H:i:s");
            $member                 = self::getMemberByEmail((string) $email);
            $result = $member->update($update);
            if($result){
                $returned_array['status'] = ReturnedMessage::STATUS_OK;
            }
            else{
                $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
            }
            return $returned_array;
        }
        public function syncMembers(array $data){
            $curr_page      = $data['page'];
            $member_id      = Auth::guard('member')->user()->id;
            $partner_gender = Auth::guard('member')->user()->partner_gender;
            $min_age        = Auth::guard('member')->user()->partner_min_age;
            $max_age        = Auth::guard('member')->user()->partner_max_age;
            if(array_key_exists('search_gender',$data)){
                $partner_gender = $data['search_gender'];
            }
            if(array_key_exists('search_min_age',$data)){
                $min_age = $data['search_min_age'];
            }
            if(array_key_exists('search_max_age',$data)){
                $max_age = $data['search_max_age'];
            }
            $base_url = url('/');
            $members = Members::select('*', 
                                DB::raw("TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) AS age"),
                                DB::raw(
                                    'CASE religion
                                        WHEN ' . Constants::BUDDHISM_RELIGION . ' THEN "Buddhism"
                                        WHEN ' . Constants::CHRISTIAN_RELIGION . ' THEN "Christian"
                                        WHEN ' . Constants::ISLAM_RELIGION . ' THEN "Islam"
                                        WHEN ' . Constants::HINDUISM_RELIGION . ' THEN "Hinduism"
                                        WHEN ' . Constants::JAIN_RELIGION . ' THEN "Jain"
                                        WHEN ' . Constants::SHINTO_RELIGION . ' THEN "Shinto"
                                        WHEN ' . Constants::ATHEISM_RELIGION . ' THEN "Atheism"
                                        ELSE "Others"
                                    END AS religion_name'),
                                DB::raw("CONCAT(height_feet ,\"' \", height_inches,\"''\") AS height"),
                                DB::raw("CONCAT('". $base_url ."/storage/member_images/', id, '/thumb/', thumb) AS thumb_path"),
                            )
                                ->where('id', '!=', $member_id)
                                ->whereNull('deleted_at');
            if($partner_gender == Constants::PARTNER_GENDER_MALE || $partner_gender == Constants::PARTNER_GENDER_FEMALE){
                $members = $members->where('gender','=',$partner_gender);
            }
            $members = $members->where('date_of_birth', '<=' , now()->subYears($min_age)->toDateString());
            $members = $members->where('date_of_birth', '>=' , now()->subYears($max_age)->toDateString());
            $members = $members->paginate(Constants::RECORDS_PER_PAGE, ['*'], 'page', $curr_page);
            
            return $members;
        }
        public function updateView(int $id){
            $returned_array = [];
            $insert         = [];
            $member         = self::getMemberById((int) $id);
            $insert['view_count'] = $member['view_count'] + 1;
            $result         = $member->update($insert);
            if($result){
                $returned_array['status'] = ReturnedMessage::STATUS_OK;
            }
            else{
                $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
            }
            return $returned_array;
        }
        public function requestDate(int $id){
            DB::beginTransaction();
            try{
                $returned_array = [];
                $insert = [];
                $insert['invite_id']    = Auth::guard('member')->user()->id;
                $insert['accept_id']    = $id;
                $insert['status']       = Constants::DATE_REQUEST_SENT;
                $insert['created_by']   = Auth::guard('member')->user()->id;
                $insert['updated_by']   = Auth::guard('member')->user()->id;
                $result = Date_request::create($insert);
                if($result){
                    $member             = self::getMemberById((int) Auth::guard('member')->user()->id);
                    $update             = [];
                    $update['point']    = $member->point - Constants::DATE_REQUEST_POINT;
                    $point_update = $member->update($update);
                    if($point_update){
                        $log_update = [];
                        $log_update['member_id']        = Auth::guard('member')->user()->id;
                        $log_update['date_request_id']  = $result->id;
                        $log_update['point']            = Constants::DATE_REQUEST_POINT;
                        $log_update['created_by']       = Auth::guard('member')->user()->id;
                        $log_result = Point_logs::create($log_update);
                        if($log_result){
                            DB::commit();
                            Auth::guard('member')->user()->point = $update['point'];
                            $returned_member = self::getMember($id);
                            $returned_array['status']   = ReturnedMessage::STATUS_OK;
                            $returned_array['member']   = $returned_member;
                            $returned_array['point']    = $update['point']; 
                        }
                        else{
                            $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
                        }
                    }
                    else{
                        $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
                    }
                }
                else{
                    $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
                }
            return $returned_array;
            }
            catch (\Exception $e) {
                DB::rollBack();
                Utility::saveErrorLog((string) "MemberRepository:requestDate - \n",(string) $e->getMessage());
                abort(500);
            }
        }
        public function getMember(int $id){
            $base_url = url('/');
            $member = Members::select('*', 
                                DB::raw("TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) AS age"),
                                DB::raw(
                                    'CASE religion
                                        WHEN ' . Constants::BUDDHISM_RELIGION . ' THEN "Buddhism"
                                        WHEN ' . Constants::CHRISTIAN_RELIGION . ' THEN "Christian"
                                        WHEN ' . Constants::ISLAM_RELIGION . ' THEN "Islam"
                                        WHEN ' . Constants::HINDUISM_RELIGION . ' THEN "Hinduism"
                                        WHEN ' . Constants::JAIN_RELIGION . ' THEN "Jain"
                                        WHEN ' . Constants::SHINTO_RELIGION . ' THEN "Shinto"
                                        WHEN ' . Constants::ATHEISM_RELIGION . ' THEN "Atheism"
                                        ELSE "Others"
                                    END AS religion_name'),
                                DB::raw(
                                    'CASE gender
                                        WHEN ' . Constants::GENDER_MALE . ' THEN "Male"
                                        ELSE "Female"
                                    END AS gender_name'),
                                DB::raw(
                                    'CASE partner_gender
                                        WHEN ' . Constants::PARTNER_GENDER_MALE . ' THEN "Male"
                                        WHEN ' . Constants::PARTNER_GENDER_FEMALE . ' THEN "Female"
                                        ELSE "BOTH"
                                    END AS partner_gender_name'
                                ),
                                DB::raw("CONCAT(height_feet ,\"' \", height_inches,\"''\") AS height"),
                                DB::raw("CONCAT('". $base_url ."/storage/member_images/', id, '/thumb/', thumb) AS thumb_path"),
                            )
                                ->find($id);
            return $member;
        }
        public function updateMemberDetails(array $data){
            DB::beginTransaction();
            try{
                $returned_array = [];
                $update = [];
                $update['username']             = $data['username'];
                $update['phone']                = $data['phone'];
                $update['date_of_birth']        = $data['date_of_birth'];
                $update['height_feet']          = $data['height_feet'];
                $update['height_inches']        = $data['height_inches'];
                $update['city_id']              = $data['city'];
                $update['education']            = $data['education'];
                $update['about']                = $data['about'];
                $update['work']                 = $data['work'];
                $update['gender']               = $data['gender'];
                $update['partner_min_age']      = $data['min_age'];
                $update['partner_max_age']      = $data['max_age'];
                $update['partner_gender']       = $data['pgender'];
                $update['religion']             = $data['religion'];
                $member                         = self::getMemberById((int) Auth::guard('member')->user()->id);
                $result                         = $member->update($update);
                if($result){
                    DB::commit();
                    $hobbies    = $data['hobbies_arr'];
                    $insert_id  = $member->id;
                    $delete_old_hobbies = Member_hobbies::where('member_id', '=', $insert_id)->delete();
                    if($delete_old_hobbies){
                        DB::commit();
                        foreach($hobbies as $hobby){
                            $hobby_insert               = [];
                            $hobby_insert['member_id']  = $insert_id;
                            $hobby_insert['hobby_id']   = $hobby;
                            $hobby_insert['created_by'] = $insert_id;
                            $hobby_insert['updated_by'] = $insert_id;
                            $hobbies_update = Member_hobbies::create($hobby_insert);
                            if($hobbies_update){
                                DB::commit();
                                $returned_array['status'] = ReturnedMessage::STATUS_OK;
                                $returned_array['member'] = self::getMember((int) $insert_id);
                            }
                            else{
                                $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
                            }
                        }
                    }
                    else{
                        $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
                    }
                }
                else{
                    $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
                }
                return $returned_array;
            }
            catch (\Exception $e) {
                DB::rollBack();
                Utility::saveErrorLog((string) "MemberRepository:updateMemberDetails - \n",(string) $e->getMessage());
                abort(500);
            }
        }
        public function updatePhoto(array $data){
            DB::beginTransaction();
            try{
                $returned_array             = [];
                $id             = Auth::guard('member')->user()->id;
                for($i=1; $i<=6; $i++){
                    $filename           = "file" . $i;
                    if(isset($data[$filename]) && $data[$filename]->isValid()){
                        $update         = [];
                        $file           = $data[$filename];
                        $unique_name    = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME) . "_" . date('Ymd_His') . "_" . uniqid() . "." . $file->getClientOriginalExtension();
                        $update['name'] = $unique_name;
                        $member_gallery = Member_gallery::where('sort', '=', $i)
                                                        ->where('member_id' , '=', $id)
                                                        ->whereNull('deleted_at')
                                                        ->first();
                        if($member_gallery != null){
                            $old_gallery_name  = $member_gallery['name'];
                            $member_gallery->update($update);
                        }
                        else{
                            $insert                 = [];
                            $insert['member_id']    = $id;
                            $insert['name']         = $unique_name;
                            $insert['sort']         = $i;
                            $insert['created_by']   = $id;
                            $insert['updated_by']   = $id;
                            Member_gallery::create($insert);
                        }
                        DB::commit();
                        $returned_array['status']   = ReturnedMessage::STATUS_OK;
                        try{
                            $destination_path   = storage_path('app/public/member_images/' .$id);
                            if(!File::exists($destination_path)){
                                File::makeDirectory($destination_path, 0755, true);
                            }
                            $file               = $data[$filename];
                            $file->storeAs('member_images/' .$id . "/",$unique_name,'public');
                            $returned_array['status']   = ReturnedMessage::STATUS_OK;
                        }
                        catch (\Exception $e) {
                            DB::rollBack();
                            Utility::saveErrorLog((string) "MemberRepository:updatePhoto - \n",(string) $e->getMessage());
                            abort(500);
                        }
                        if($i == 1){
                            $thumb_name             = "thumb_" . $unique_name;
                            $member                 = self::getMemberById((int) $id);
                            $old_thumb_name         = $member['thumb'];
                            $old_thumb_path         = "member_images/" . $id . "/thumb/" . $old_thumb_name;
                            $thumb_update           = [];
                            $thumb_update['thumb']  = $thumb_name;
                            $member->update($thumb_update);
                            DB::commit();
                            $returned_array['status']   = ReturnedMessage::STATUS_OK;
                            try{
                                $destination_path   = storage_path('app/public/member_images/' .$id);
                                $thumb_path         = $destination_path . "/thumb/";
                                if(!File::exists($thumb_path)){
                                    File::makeDirectory($thumb_path, 0755, true);
                                }
                                Utility::saveThumb($data['file1'], $thumb_path , $thumb_name, Constants::THUMB_WIDTH, Constants::THUMB_HEIGHT);
                                $returned_array['status']   = ReturnedMessage::STATUS_OK;
                                try{
                                    Storage::disk('public')->delete($old_thumb_path);
                                    $returned_array['status']   = ReturnedMessage::STATUS_OK;
                                }
                                catch (\Exception $e) {
                                    DB::rollBack();
                                    Utility::saveErrorLog((string) "MemberRepository:updatePhoto - \n",(string) $e->getMessage());
                                    abort(500);
                                }
                            }
                            catch (\Exception $e) {
                                DB::rollBack();
                                Utility::saveErrorLog((string) "MemberRepository:updatePhoto - \n",(string) $e->getMessage());
                                abort(500);
                            }
                        }
                        try{
                            if($member_gallery != null){
                                $old_gallery_path   = "member_images/" . $id . "/" . $old_gallery_name;
                                Storage::disk('public')->delete($old_gallery_path);
                                $returned_array['status']   = ReturnedMessage::STATUS_OK;
                            }
                        }
                        catch (\Exception $e) {
                            DB::rollBack();
                            Utility::saveErrorLog((string) "MemberRepository:updatePhoto - \n",(string) $e->getMessage());
                            abort(500);
                        }
                    }
                }
                return $returned_array;
            }
            catch (\Exception $e) {
                DB::rollBack();
                Utility::saveErrorLog((string) "MemberRepository:updatePhoto - \n",(string) $e->getMessage());
                abort(500);
            }
        }
        public function deletePhoto(int $sort){
            $returned_array = [];
            $id             = Auth::guard('member')->user()->id;
            $member_gallery = Member_gallery::where('sort', '=', $sort)
                                ->where('member_id' , '=', $id)
                                ->whereNull('deleted_at')
                                ->first();
            if($member_gallery == null){
                $returned_array['status'] = ReturnedMessage::STATUS_OK;
            }
            else{
                $update = [];
                $update['deleted_by'] = $id;
                $update['deleted_at'] = date('Y-m-d H:i:s');
                $result = $member_gallery->update($update);
                if($result){
                    $returned_array['status'] = ReturnedMessage::STATUS_OK;
                }
                else{
                    $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
                }
            }
            return $returned_array;
        }
        public function photoVerification(string $base64){
            $returned_array         = [];
            $update                 = [];
            $update['verify_photo'] = $base64;
            $update['status']       = Constants::MEMBER_PENDING_PHOTO_VERIFICATION_STATUS;
            $member                 = self::getMemberById((int) Auth::guard('member')->user()->id);
            $result                 = $member->update($update);
            if($result){
                $returned_array['status'] = ReturnedMessage::STATUS_OK;
            }
            else{
                $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
            }
            return $returned_array;
        }
        public function respondInvitation(array $data){
            DB::beginTransaction();
            try{
                $returned_array = [];
                $insert         = [];
                $login_id       = Auth::guard('member')->user()->id;
                if($data['response'] == 'accept'){
                    $insert['status']       = Constants::DATE_REQUEST_ACCEPTED;
                    $insert['updated_by']   = Auth::guard('member')->user()->id;
                }
                else{
                    $insert['status'] = Constants::DATE_REQUEST_REJECTED;
                }
                $date_request       = Date_request::where('invite_id','=',$data['id'])
                                        ->where('accept_id','=',$login_id)
                                        ->where('status','=',Constants::DATE_REQUEST_SENT)
                                        ->whereNull('deleted_at')
                                        ->first();
                $date_request->update($insert);
                DB::commit();
                try{
                    if($data['response'] == 'accept'){
                        $member_update              = [];
                        $member_update['status']    = Constants::MEMBER_DATING_STATUS;
                        $member                     = self::getMemberById((int) $login_id);
                        $member->update($member_update);
                        DB::commit();
                        try{
                            $accepted_member = self::getMemberById((int) $data['id']);
                            $result = $accepted_member->update($member_update);
                            if($result){
                                DB::commit();
                                $returned_array['status'] = ReturnedMessage::STATUS_OK;
                            }
                            else{
                                $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
                            }
                        }
                        catch (\Exception $e) {
                            DB::rollBack();
                            Utility::saveErrorLog((string) "MemberRepository:respondInvitation - \n",(string) $e->getMessage());
                            abort(500);
                        }
                    }
                    else{
                        $returned_array['status'] = ReturnedMessage::STATUS_OK;
                    }
                    return $returned_array;
                }
                catch (\Exception $e) {
                    DB::rollBack();
                    Utility::saveErrorLog((string) "MemberRepository:respondInvitation - \n",(string) $e->getMessage());
                    abort(500);
                }
            }
            catch (\Exception $e) {
                DB::rollBack();
                Utility::saveErrorLog((string) "MemberRepository:respondInvitation - \n",(string) $e->getMessage());
                abort(500);
            }
        }
        public function getMembers(){
            $base_url   = url('/');
            $members    = Members::select('*',
                                DB::raw("TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) AS age"),
                                DB::raw(
                                    'CASE religion
                                        WHEN ' . Constants::BUDDHISM_RELIGION . ' THEN "Buddhism"
                                        WHEN ' . Constants::CHRISTIAN_RELIGION . ' THEN "Christian"
                                        WHEN ' . Constants::ISLAM_RELIGION . ' THEN "Islam"
                                        WHEN ' . Constants::HINDUISM_RELIGION . ' THEN "Hinduism"
                                        WHEN ' . Constants::JAIN_RELIGION . ' THEN "Jain"
                                        WHEN ' . Constants::SHINTO_RELIGION . ' THEN "Shinto"
                                        WHEN ' . Constants::ATHEISM_RELIGION . ' THEN "Atheism"
                                        ELSE "Others"
                                    END AS religion_name'),
                                DB::raw(
                                    'CASE gender
                                        WHEN ' . Constants::GENDER_MALE . ' THEN "Male"
                                        ELSE "Female"
                                    END AS gender_name'),
                                DB::raw("CONCAT(height_feet ,\"' \", height_inches,\"''\") AS height"),
                                DB::raw("CONCAT('". $base_url ."/storage/member_images/', id, '/thumb/', thumb) AS thumb_path"),
                            )
                                ->with('getCitiesByMember')
                                ->whereNull('deleted_at')
                                ->orderByRaw(
                                    "CASE
                                        WHEN status = " . Constants::MEMBER_PENDING_PHOTO_VERIFICATION_STATUS . " THEN 0
                                        ELSE 1
                                    END"
                                )
                                ->orderBy('status','asc')
                                ->paginate(Constants::RECORDS_PER_PAGE);
            return $members;
        }
        public function deleteMember(int $id){
            $returned_array         = [];
            $update                 = [];
            $update['status']       = Constants::MEMBER_BANNED_STATUS;
            $update['deleted_at']   = date('Y-m-d H:i:s');
            $paramObj               = Utility::addDeletedBy((array) $update);
            $member                 = Members::find($id);
            $result                 = $member->update($paramObj);
            if($result){
                $returned_array['status'] = ReturnedMessage::STATUS_OK;
            }
            else{
                $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
            }
            return $returned_array;
        }
        public function confirmMember(int $id){
            $returned_array     = [];
            $update             = [];
            $update['status']   = Constants::MEMBER_PHOTO_VERIFIED_STATUS;
            $member             = Members::find($id);
            $result             = $member->update($update);
            if($result){
                $returned_array['status'] = ReturnedMessage::STATUS_OK;
            }
            else{
                $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
            }
            return $returned_array;
        }
        public function purchasePoint(array $data){
            $returned_array         = [];
            if(isset($data['screenshot']) && $data['screenshot']->isValid()){
                $file                   = $data['screenshot'];
                $unique_name            = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME) . "_" . date('Ymd_His') . "_" . uniqid() . "." . $file->getClientOriginalExtension();
                $id                     = Auth::guard('member')->user()->id;
                $destination_path   = storage_path('app/public/purchases/' .$id);
                if(!File::exists($destination_path)){
                    File::makeDirectory($destination_path, 0755, true);
                }
                $file_save = $file->storeAs('purchases/' . $id . "/", $unique_name ,'public');
                if(1==1){
                    $insert                 = [];
                    $insert['member_id']    = $id;
                    $insert['screenshot']   = $unique_name;
                    $insert['status']       = Constants::PURCHASE_SENT_STATUS;
                    $insert['created_by']   = $id;
                    $result = Point_Purchase::create($insert);
                    if($result){
                        $returned_array['status'] = ReturnedMessage::STATUS_OK;
                    }
                    else{
                        $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
                    }
                }
            }
            return $returned_array;
        }
        public function subtractPoints(array $data){
            DB::beginTransaction();
            try{
                $member_id              = $data['id'];
                $returned_array         = [];
                $update                 = [];
                $update['member_id']    = $member_id;
                if($data['action'] == Constants::ADD_POINT){
                    $update['added_point'] = $data['point'];
                }
                else{
                    $update['subtracted_point'] = $data['point'];
                }
                $paramObj = Utility::addCreatedBy($update);
                Point_logs::create($paramObj);
                DB::commit();
                try{
                    $member_update = [];
                    $member = Members::find($member_id);
                    if($data['action'] == Constants::ADD_POINT){
                        $member_update['point'] = $member->point + $data['point'];
                    }
                    else{
                        $member_update['point'] = $member->point - $data['point'];
                    }
                    $member->update($member_update);
                    DB::commit();
                    $returned_array['status'] = ReturnedMessage::STATUS_OK;
                }
                catch (\Exception $e) {
                    DB::rollBack();
                    Utility::saveErrorLog((string) "MemberRepository:subtractPoints - \n",(string) $e->getMessage());
                    abort(500);
                }
                return $returned_array;
            }
            catch (\Exception $e) {
                DB::rollBack();
                Utility::saveErrorLog((string) "MemberRepository:subtractPoints - \n",(string) $e->getMessage());
                abort(500);
            }
        }
        public function filterMembers(string $keyword){
            $base_url   = url('/');
            $members    = Members::select('*',
                                DB::raw("TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) AS age"),
                                DB::raw(
                                    'CASE religion
                                        WHEN ' . Constants::BUDDHISM_RELIGION . ' THEN "Buddhism"
                                        WHEN ' . Constants::CHRISTIAN_RELIGION . ' THEN "Christian"
                                        WHEN ' . Constants::ISLAM_RELIGION . ' THEN "Islam"
                                        WHEN ' . Constants::HINDUISM_RELIGION . ' THEN "Hinduism"
                                        WHEN ' . Constants::JAIN_RELIGION . ' THEN "Jain"
                                        WHEN ' . Constants::SHINTO_RELIGION . ' THEN "Shinto"
                                        WHEN ' . Constants::ATHEISM_RELIGION . ' THEN "Atheism"
                                        ELSE "Others"
                                    END AS religion_name'),
                                DB::raw(
                                    'CASE gender
                                        WHEN ' . Constants::GENDER_MALE . ' THEN "Male"
                                        ELSE "Female"
                                    END AS gender_name'),
                                DB::raw("CONCAT(height_feet ,\"' \", height_inches,\"''\") AS height"),
                                DB::raw("CONCAT('". $base_url ."/storage/member_images/', id, '/thumb/', thumb) AS thumb_path"),
                            )
                                ->with('getCitiesByMember')
                                ->whereNull('deleted_at')
                                ->orderByRaw(
                                    "CASE
                                        WHEN status = " . Constants::MEMBER_PENDING_PHOTO_VERIFICATION_STATUS . " THEN 0
                                        ELSE 1
                                    END"
                                );
            if($keyword != ''){
                $members = $members->where('username','like','%' . $keyword . '%')
                                ->orWhere('email','like', '%' . $keyword . '%')
                                ->orWhere('phone','like','%' . $keyword . '%');
            }
            $members = $members->orderBy('status','asc')
                                ->paginate(Constants::RECORDS_PER_PAGE);
            return $members;
        }
        public function getRegisteredMembers(){
            $members = Members::select(DB::raw('DATE(created_at) as date_group'), DB::raw('COUNT(*) as total'))
                            ->where('created_at', '>=', DB::raw('CURDATE() - INTERVAL 30 DAY'))
                            ->groupBy(DB::raw('DATE(created_at)'))
                            ->orderBy(DB::raw('DATE(created_at)'), 'ASC')
                            ->whereNull('deleted_at')
                            ->get();
            $data = [];
            foreach($members as $member) {
                $result = [];
                $date_string    = $member->date_group;
                $timestamp      = strtotime($date_string) * 1000;
                array_push($result,$timestamp);
                array_push($result,$member->total);
                array_push($data, $result);
            }
            return $data;
        }
        public function getTotalRegisteredMembers(){
            $count = Members::whereNull('deleted_at')
                                ->count();
            return $count;
        }
        public function getTodayRegisteredMembers(){
            $today = Carbon::today();
            $count = Members::whereDate('created_at', $today)->count();
            return $count;
        }
        public function getTodayEmailConfirmedMembers(){
            $today = Carbon::today();
            $count = Members::whereDate('created_at', $today)
                            ->where('status','=',Constants::MEMBER_EMAIL_CONFIRMED_STATUS)
                            ->where('status','=',Constants::MEMBER_PENDING_PHOTO_VERIFICATION_STATUS)
                            ->where('status','=',Constants::MEMBER_FAILED_PHOTO_VERIFICATION_STATUS)
                            ->where('status','=',Constants::MEMBER_PHOTO_VERIFIED_STATUS)
                            ->where('status','=',Constants::MEMBER_DATING_STATUS)
                            ->count();
            return $count;
        }
        public function getTodayDateRequestsCount(){
            $today = Carbon::today();
            $count = Date_request::whereDate('created_at', $today)->count();
            return $count;
        }
        public function getTodayDateRequests(){
            $today = Carbon::today();
            $requests = Date_request::select('invite_id','accept_id','status')
                                    ->whereDate('created_at', $today)
                                    ->get();
            return $requests;
        }
        public function getApprovedDatingRequests(){
            $requests = Date_request::select('invite_id','accept_id')
                                    ->where('status','=',Constants::DATE_REQUEST_ACCEPTED)
                                    ->paginate(5);
            return $requests;
        }
    }
?>