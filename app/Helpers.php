<?php 
use App\Constants;
use App\Models\Cities;
use App\Models\Hobbies;
use Illuminate\Support\Facades\Session;
    if(!function_exists('getMembersByCity')){
        function getMembersByCities($members){
            $members_name = "";
            foreach($members as $member){
                $members_name .= $member->username . ", ";
            }
            return rtrim($members_name, ", ");
        }
    }
    if(!function_exists('showPermission')){
        function showPermission(string $display_route){
            $route_group = Session::get('permission');
            foreach($route_group as $route){
                if($route->route == $display_route){
                    return '';
                }
            }
            return 'none';
        }
    }
    if(!function_exists('getUserRole')){
        function getUserRole(string $role){
            if($role == "admin"){
                return Constants::ADMIN_ROLE;
            }else if($role == "customer-service"){
                return Constants::CUSTOMER_SERVICE_ROLE;
            }else{
                return Constants::Editor_ROLE;
            }
        }
    }
    if(!function_exists('getGender')){
        function getGender(string $gender){
            if($gender == "male"){
                return Constants::GENDER_MALE;
            }
            else{
                return Constants::GENDER_FEMALE;
            }
        }
    }
    if(!function_exists('getPartnerGender')){
        function getPartnerGender(string $pgender){
            if($pgender == "male"){
                return Constants::PARTNER_GENDER_MALE;
            }
            else if($pgender == "female"){
                return Constants::PARTNER_GENDER_FEMALE;
            }
            else{
                return Constants::PARTNER_GENDER_BOTH;
            }
        }
    }
    if(!function_exists('getReligion')){
        function getReligion(string $religion){
            if($religion == 'buddhism'){
                return Constants::BUDDHISM_RELIGION;
            }
            else if($religion == 'christian'){
                return Constants::CHRISTIAN_RELIGION;
            }
            else if($religion == 'islam'){
                return Constants::ISLAM_RELIGION;
            }
            else if($religion == 'hinduism'){
                return Constants::HINDUISM_RELIGION;
            }
            else if($religion == 'jain'){
                return Constants::JAIN_RELIGION;
            }
            else if($religion == 'shinto'){
                return Constants::SHINTO_RELIGION;
            }
            else if($religion == 'atheism'){
                return Constants::ATHEISM_RELIGION;
            }
            else{
                return Constants::OTHERS_RELIGION;
            }
        }
    }
    if(!function_exists('getMemberRegisteredStatus')){
        function getMemberRegisteredStatus(){
           return Constants::MEMBER_REGISTERED_STATUS;
        }
    }
    if(!function_exists('getMemberEmailVerifiedStatus')){
        function getMemberEmailVerifiedStatus(){
           return Constants::MEMBER_EMAIL_CONFIRMED_STATUS;
        }
    }
    if(!function_exists('getMemberPendingPhotoVerificationStatus')){
        function getMemberPendingPhotoVerificationStatus(){
           return Constants::MEMBER_PENDING_PHOTO_VERIFICATION_STATUS;
        }
    }
    if(!function_exists('getMemberRejectPhotoVerificationStatus')){
        function getMemberRejectPhotoVerificationStatus(){
           return Constants::MEMBER_FAILED_PHOTO_VERIFICATION_STATUS;
        }
    }
    if(!function_exists('getMemberVerifiedStatus')){
        function getMemberVerifiedStatus(){
           return Constants::MEMBER_PHOTO_VERIFIED_STATUS;
        }
    }
    if(!function_exists('getMemberBannedStatus')){
        function getMemberBannedStatus(){
           return Constants::MEMBER_BANNED_STATUS;
        }
    }
    if(!function_exists('getCityName')){
        function getCityName(int $id){
            $city = Cities::select('name')
                    ->where('id','=',$id)
                    ->first();
            return $city->name;
        }
    }
    if(!function_exists('getHobbies')){
        function getHobbies($hobbies){
            $hobbies_arr = [];
            foreach($hobbies as $hobby){
                array_push($hobbies_arr, $hobby->hobby_id);
            }
            $hobbies_name = "";
            foreach($hobbies_arr as $hobby){
                $hobby_name = Hobbies::select('name')->where('id','=',$hobby)->first();
                $hobbies_name .= $hobby_name->name . ", ";
            }
            return rtrim($hobbies_name, ", ");
        }
    }
    if(!function_exists('getPointAction')){
        function getPointAction(string $action){
            if($action == 'add'){
                return Constants::ADD_POINT;
            }
            else{
                return Constants::SUBTRACT_POINT;
            }
        }
    }
    if(!function_exists('getDatingStatus')){
        function getDatingStatus(string $status){
            switch($status){
                case 'sent':
                    $dating_status = Constants::DATE_REQUEST_SENT;
                    break;
                case 'accepted':
                    $dating_status = Constants::DATE_REQUEST_ACCEPTED;
                    break;
                case 'rejected':
                    $dating_status = Constants::DATE_REQUEST_REJECTED;
                    break;
                default:
                    $dating_status = "unknown";
            }
            return $dating_status;
        }
    }
?>