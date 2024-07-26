<?php

namespace App\Http\Controllers\Cities;

use App\Http\Controllers\Controller;
use App\Http\Requests\CityStoreRequest;
use App\Http\Requests\CityUpdateRequest;
use App\Repositories\City\CityRepositoryInterface;
use App\ReturnedMessage;
use App\Utility;
use Illuminate\Support\Facades\DB;

class CitiesController extends Controller
{
    private $cityRepository;
    public function __construct(CityRepositoryInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
        DB::connection()->enableQueryLog();
    }
    public function getCities(){
        try{
            $cities = $this->cityRepository->getCities();
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "CitiesController:getCities - \n",(array) $query_log);
            return view('backend.cities.showCities',compact(
                ['cities']
            ));
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "CitiesController:getCities - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function createCity(){
        try{
            return view('backend.cities.createCity');
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "CitiesController:createCity - \n",(string) $e->getMessage());
            abort(500);
        }
    }

    public function storeCity(CityStoreRequest $request){
        try{
            $result = $this->cityRepository->addCity((array) $request->all());
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "CitiesController:storeCity - \n",(array) $query_log);
            if($result['status'] == ReturnedMessage::STATUS_OK){
                return redirect('admin-backend/city/index')
                        ->with('success_msg','City Created Successfully');
            }
            else{
                return redirect('admin-backend/city/index')
                        ->with('error_msg','City Failed To Create');
            }
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "CitiesController:storeCity - \n",(string) $e->getMessage());
            abort(500);
        }
    }

    public function getEditCity(int $id){
        try{
            $city = $this->cityRepository->getEditCity((int) $id);
            if($city == null){
                abort(404);
            }
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "CitiesController:getEditCity - \n",(array) $query_log);
            return view('backend.cities.createCity',compact(
                ['city']
            ));
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "CitiesController:getEditCity - \n",(string) $e->getMessage());
            if($e->getCode() == 0){
                abort(404);
            }
            abort(500);
        }
    }

    public function updateCity(CityUpdateRequest $request){
        try{
            $result = $this->cityRepository->updateCity((array) $request->all());
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "CitiesController:updateCity - \n",(array) $query_log);
            if($result['status'] == ReturnedMessage::STATUS_OK){
                return redirect('admin-backend/city/index')
                        ->with('success_msg','City Updated Successfully');
            }
            else{
                return redirect('admin-backend/city/index')
                        ->with('error_msg','City Failed To Update');
            }
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "CitiesController:updateCity - \n",(string) $e->getMessage());
            abort(500);
        }
    }
}