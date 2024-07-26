<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingStoreRequest;
use App\Http\Requests\SettingUpdateRequest;
use App\Repositories\Setting\SettingRepositoryInterface;
use App\ReturnedMessage;
use App\Utility;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    private $settingRepository;
    public function __construct(SettingRepositoryInterface $settingRepository){
        $this->settingRepository = $settingRepository;
        DB::connection()->enableQueryLog();
    }
    public function index(){
        try{
            $setting = $this->settingRepository->getSetting();
            if($setting == null){
                abort(404);
            }
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "SettingController:index - \n",(array) $query_log);
            return view('backend.setting.show_setting',compact(
                ['setting']
            ));
        }
        catch(\Exception $e){
            if($e->getCode() == 0){
                abort(404);
            }
            Utility::saveErrorLog((string) "SettingController:index - \n",(string) $e->getMessage());
            abort(500);
        }
    }

    public function create(SettingStoreRequest $request){
        try{
            $result = $this->settingRepository->storeSetting((array) $request->all());
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "SettingController:create - \n",(array) $query_log);
            if($result['status'] == ReturnedMessage::STATUS_OK){
                return redirect('admin-backend/setting/index')
                        ->with('success_msg','Setting Created Successfully');
            }
            else{
                return redirect('admin-backend/setting/index')
                        ->with('error_msg','Setting Failed To Create');
            }
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "SettingController:create - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function getEdit(){
        try{
            $setting    = $this->settingRepository->getSetting();
            if($setting == null){
                abort(404);
            }
            $query_log  = DB::getQueryLog();
            Utility::saveDebugLog((string) "SettingController:getEdit - \n",(array) $query_log);
            return view('backend.setting.form',compact(
                ['setting']
            ));
        }
        catch(\Exception $e){
            if($e->getCode() == 0){
                abort(404);
            }
            Utility::saveErrorLog((string) "SettingController:getEdit - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function update(SettingUpdateRequest $request){
        try{
            $result = $this->settingRepository->updateSetting((array) $request->all());
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "SettingController:update - \n",(array) $query_log);
            if($result['status'] == ReturnedMessage::STATUS_OK){
                return redirect('admin-backend/setting/index')
                        ->with('success_msg','Setting Updated Successfully');
            }
            else{
                return redirect('admin-backend/setting/index')
                        ->with('error_msg','Setting Failed To Update');
            }
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "SettingController:update - \n",(string) $e->getMessage());
            abort(500);
        }
    }
}
