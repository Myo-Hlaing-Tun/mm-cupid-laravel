<?php 
    namespace App\Repositories\City;

    use App\Models\Cities;
    use App\ReturnedMessage;
    use App\Utility;

    class CityRepository implements CityRepositoryInterface{
        public function addCity(array $data){
            $returned_array = [];
            $insert = [];
            $insert['name'] = $data['city_name'];
            $paramObj = Utility::addCreatedBy((array) $insert);
            $result = Cities::create($paramObj);
            if($result){
                $returned_array['status'] = ReturnedMessage::STATUS_OK;
            }
            else{
                $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
            }
            return $returned_array;
        }
        public function getCities(){
            $cities = Cities::SELECT('id','name')
                        ->whereNull('deleted_at')
                        ->get();
            return $cities;
        }
        public function getEditCity(int $id){
            $city = Cities::find($id);
            return $city;
        }
        public function updateCity(array $data){
            $returned_array = [];
            $id             = $data['id'];
            $city           = $data['city_name'];
            $update         = [];
            $update['name'] = $city;
            $update_data    = Utility::addUpdatedBy((array) $update);
            $update_city    = Cities::find($id);
            $result         = $update_city->update($update_data);
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