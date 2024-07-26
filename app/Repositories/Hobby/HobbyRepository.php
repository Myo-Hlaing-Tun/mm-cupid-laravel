<?php 
    namespace App\Repositories\Hobby;
    use App\Models\Hobbies;
    use App\ReturnedMessage;
    use App\Utility;

    class HobbyRepository implements HobbyRepositoryInterface{
        public function getHobbies(){
            $hobbies = Hobbies::SELECT('id','name')
                        ->whereNull('deleted_at')
                        ->get();
            return $hobbies;
        }
        public function createHobby(array $data){
            $returned_array = [];
            $hobby_name     = $data['hobby'];
            $insert         = [];
            $insert['name'] = $hobby_name;
            $paramObj       = Utility::addCreatedBy((array) $insert);
            $result         = Hobbies::create($paramObj);
            if($result){
                $returned_array['status'] = ReturnedMessage::STATUS_OK;
            }
            else{
                $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
            }
            return $returned_array;
        }
        public function getHobbyById(int $id){
            $edit_hobby = Hobbies::SELECT('id','name')
                        ->where("id", "=", $id)
                        ->whereNull('deleted_at')
                        ->first();
            return $edit_hobby;
        }
        public function editHobby(array $data){
            $returned_array = [];
            $hobby          = $data['hobby'];
            $id             = $data['id'];
            $update_hobby   = Hobbies::find($id);
            $insert['name'] = $hobby;
            $paramObj       = Utility::addUpdatedBy((array) $insert);
            $result         = $update_hobby->update($paramObj);
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