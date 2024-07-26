<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityStoreRequest;
use App\Http\Requests\EditCityStoreRequest;
use App\Models\Cities;
use App\Models\Member;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function test(){
        // dd(Auth::guard('admin')->user());
        // $name = "Mg Mg";
        // $age = 21;
        $cities = Cities::SELECT('id','name')
                ->orderBy('id','DESC')
                ->whereNull('deleted_at')
                ->get();
        $members = Member::SELECT('id','username','city_id')
                ->get();

        $setting = Setting::SELECT('point','company_logo','company_name','company_email','company_phone','company_address')
                    ->first();       
        // $fruits = ["apple","orange","banana"];
        if(Auth::guard('admin')->user()){
            return view('test.test',compact(
                // 'name',
                // 'age',
                'cities',
                'setting',
                'members'
                // 'fruits',
            ));
        }
        else{
            return redirect('login');
        }
    }

    public function formRequestStore(CityStoreRequest $request){
        // $name = $request->get('name');
        // $age = $request->get('age');
        // $fruits = ["apple","orange","banana"];
        // return view('test.test',compact(
        //     'name',
        //     'age',
        //     'fruits',
        // ));

        // $name = $request->get('name');
        // $age = $request->get('age');
        // $validated = $request->validate([
        //     'name' => 'required',
        //     'age' => 'required',
        // ]);
        // return view('test.test',compact('name','age'));

        // if($validated){
        //     $name = $validated['name'];
        //     $age = $validated['age'];
        //     // $fruits = ["apple","orange","banana"];
        //     return view('test.test',compact(
        //         'name',
        //         'age',
        //         // 'fruits',
        //     ));
        // }else{
        //     dd($validated['name']);
        // }

        $city = $request->get('city');
        // $paramObj = new Cities();
        // $paramObj->name = $city;
        // $paramObj->created_by = 1;
        // $paramObj->updated_by = 1;
        // $paramObj->created_at = date('Y-m-d H:i:s');
        // $paramObj->updated_at = date('Y-m-d H:i:s');
        // $paramObj->save();
        $insert = [];
        $insert['name'] = $city;
        $insert['created_by'] = 1;
        $insert['updated_by'] = 1;
        $insert['updated_at'] = date('Y-m-d H:i:s');
        Cities::create($insert);
        return redirect('student');
    }

    public function editCity(int $id){
        $cities = Cities::SELECT('id','name')
            ->orderBy('id','DESC')
            ->whereNull('deleted_at')
            ->get();

        $edit_city = Cities::SELECT('id','name')
                ->find($id);
        $members = Member::SELECT('id','username','city_id')
                ->get();
        return view('test.test', compact(
            'cities',
            'edit_city',
            'members'
        ));
    }

    public function formRequestUpdate(EditCityStoreRequest $request){
        $updated_city   = $request->get('city');
        $id             = $request->get('id');
        $update_city    = Cities::find($id);
        // $update_city->name          = $updated_city;
        // $update_city->updated_at    = date("Y-m-d h:i:s");
        // $update_city->save();
        $update_data            = [];
        $update_data['name']    = $updated_city;
        $update_city->update($update_data);

        return redirect('student');
    }

    public function deleteCity(int $id){
        $deleted_city = Cities::find($id);
        $deleted_data = [];
        $deleted_data['deleted_at'] = date('Y-m-d H:i:s');
        $deleted_data['deleted_by'] = 1;
        $deleted_city->update($deleted_data);

        return redirect('student');
    }
}
