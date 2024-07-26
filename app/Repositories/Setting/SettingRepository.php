<?php 
    namespace App\Repositories\Setting;
    use App\Models\Setting;
    use App\ReturnedMessage;
    use App\Utility;
    use Illuminate\Support\Facades\File;
    use Illuminate\Support\Facades\Storage;

    class SettingRepository implements SettingRepositoryInterface{
        public function storeSetting(array $data){
            $returned_array             = [];
            $insert                     = [];
            $insert['point']            = $data['point'];
            $insert['company_name']     = $data['company_name'];
            $insert['company_email']    = $data['company_email'];
            $insert['company_address']  = $data['company_address'];
            $insert['company_phone']    = $data['company_phone'];
            if(isset($data['company_logo']) && $data['company_logo']->isValid()){
                $file               = $data['company_logo'];
                $unique_name        = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME) . "_" . date('Ymd_His') . "_" . uniqid() . "." . $file->getClientOriginalExtension();
                $destination_path   = storage_path('app/public/images');
                if(!File::exists($destination_path)){
                    File::makeDirectory($destination_path, 0755, true);
                }
                $file->storeAs('images',$unique_name,'public');
                $insert['company_logo'] = $unique_name;
            }
            $paramObj                   = Utility::addCreatedBy((array) $insert);
            $result                     = Setting::create($paramObj);
            if($result){
                $returned_array['status'] = ReturnedMessage::STATUS_OK;
            }else{
                $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
            }
            return $returned_array;
        }
        public function getSetting(){
            $setting = Setting::SELECT('point','company_logo','company_name','company_email','company_phone','company_address')
                        ->whereNull('deleted_at')
                        ->first();
            return $setting;
        }
        public function updateSetting(array $data){
            $returned_array             = [];
            $insert                     = [];
            $insert['point']            = $data['point'];
            $insert['company_name']     = $data['company_name'];
            $insert['company_email']    = $data['company_email'];
            $insert['company_address']  = $data['company_address'];
            $insert['company_phone']    = $data['company_phone'];
            $setting                    = Setting::first();
            if(isset($data['company_logo']) && $data['company_logo']->isValid()){
                $file               = $data['company_logo'];
                $unique_name        = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME) . "_" . date('Ymd_His') . "_" . uniqid() . "." . $file->getClientOriginalExtension();
                $destination_path   = storage_path('app/public/images');
                if(!File::exists($destination_path)){
                    File::makeDirectory($destination_path, 0755, true);
                }
                $file->storeAs('images',$unique_name,'public');
                $old_image_path = "images/" . $setting->company_logo;
                Storage::disk('public')->delete($old_image_path);
                $insert['company_logo'] = $unique_name;
            }
            $paramObj                   = Utility::addUpdatedBy((array) $insert);
            $result                     = $setting->update($paramObj);
            if($result){
                $returned_array['status'] = ReturnedMessage::STATUS_OK;
            }else{
                $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
            }
            return $returned_array;
        }
    }
?>