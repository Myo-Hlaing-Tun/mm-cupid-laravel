<?php

namespace App\Http\Controllers\Hobbies;

use App\Http\Controllers\Controller;
use App\Http\Requests\HobbyStoreRequest;
use App\Http\Requests\HobbyUpdateRequest;
use App\Repositories\Hobby\HobbyRepositoryInterface;
use App\ReturnedMessage;
use App\Utility;
use Illuminate\Support\Facades\DB;

class HobbiesController extends Controller
{
    private $hobbies_repository;
    public function __construct(HobbyRepositoryInterface $hobbyRepository){
        $this->hobbies_repository = $hobbyRepository;
        DB::connection()->enableQueryLog();
    }
    public function index(){
        try{
            $hobbies    = $this->hobbies_repository->getHobbies();
            $query_log  = DB::getQueryLog();
            Utility::saveDebugLog((string) "HobbiesController:index - \n",(array) $query_log);
            return view('backend.hobbies.showHobbies',compact(
                ['hobbies']
            ));
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "HobbiesController:index - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function createHobby(){
        try{
            return view('backend.hobbies.form');
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "HobbiesController:createHobby - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function storeHobby(HobbyStoreRequest $request){
        try{
            $result = $this->hobbies_repository->createHobby((array) $request->all());
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "HobbiesController:storeHobby - \n",(array) $query_log);
            if($result['status'] == ReturnedMessage::STATUS_OK){
                return redirect('admin-backend/hobby/index')
                        ->with('success_msg','Hobby Created Successfully');
            }
            else{
                return redirect('admin-backend/hobby/index')
                        ->with('error_msg','Hobby Failed To Create');
            }
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "HobbiesController:storeHobby - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function getEditHobby(int $id){
        try{
            $hobby = $this->hobbies_repository->getHobbyById((int) $id);
            if($hobby == null){
                abort(404);
            }
            $query_log = DB::connection()->getQueryLog();
            Utility::saveDebugLog((string) "HobbiesController:getEditHobby - \n",(array) $query_log);
            return view('backend.hobbies.form',compact(
                ['hobby']
            ));
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "HobbiesController:getEditHobby - \n",(string) $e->getMessage());
            if($e->getCode() == 0){
                abort(404);
            }
            abort(500);
        }
    }
    public function updateHobby(HobbyUpdateRequest $request){
        try{
            $result = $this->hobbies_repository->editHobby((array) $request->all());
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "HobbiesController:updateHobby - \n",(array) $query_log);
            if($result['status'] == ReturnedMessage::STATUS_OK){
                return redirect('admin-backend/hobby/index')
                        ->with('success_msg','Hobby Updated Successfully');
            }
            else{
                return redirect('admin-backend/hobby/index')
                        ->with('error_msg','Hobby Failed To Update');
            }
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "HobbiesController:updateHobby - \n",(string) $e->getMessage());
            abort(500);
        }
    }
}
