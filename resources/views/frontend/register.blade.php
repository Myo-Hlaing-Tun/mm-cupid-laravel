@extends('frontend.master')
@section('subtitle','Register')
@section('content')
<div class="container my-5" ng-app="myApp" ng-controller="MyController" ng-init="init()">
    <div class="row">
        <div class="col"></div>

        <div class="col-md-5">
            <h1 class="fw-bold" style="font-size: 60px">Sign up</h1>
            <div class="py-3" style="font-size: 14px;">
              Already have an account? <a href="{{ url('login') }}" class="text-black">Log in</a>
            </div>
            <divs style="width: 100%;" class="d-flex justify-content-between align-items-center mb-3">
                <div id="first" style="width: 50px; height: 50px; border-radius: 100%; line-height: 50px; position: relative;" class="bg-white shadow">
                  <p id="word1" class="text-black text-center">1</p>
                </div>
                <div style="width: 82%; height: 10px;" class="bg-white">
                    <div id="pole" style="width: 0%; height: 10px;" class="bg-dark"></div>
                </div>
                <div id="second" style="width: 50px; height: 50px; border-radius: 100%; line-height: 50px; position: relative;" class="bg-white shadow">
                  <p class="text-dark text-center">2</p>
                </div>
            </divs> 
            <form action="" method="POST" id="form" enctype="multipart/form-data">
                @csrf
                <div ng-if="user_details">
                  <input type="text" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width: 100%;" placeholder="Enter Username" name="username" id="username" ng-model="username" ng-blur="validate('username')" ng-change="change(); validate('username')"/>
                  <p ng-if="error_msg_username" class="text-danger">@{{error_msg_username}}</p>
                  <input type="email" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width: 100%;" placeholder="Enter Email" name="email" id="email" ng-model="email" ng-blur="validate('email')" ng-change="change(); validate('email')"/>
                  <p ng-if="error_msg_email" class="text-danger">@{{error_msg_email}}</p>
                  <div class="position-relative">
                    <input type="password" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width: 100%;" placeholder="Enter Password" name="password" id="password" ng-model="password" ng-blur="validate('password')" ng-change="change(); validate('password')"/>
                    <i class="fa fa-eye-slash position-absolute top-50 end-0 fs-4" style="transform: translate(-50%,-50%)" id="password_eye" ng-mousedown="reveal('password')" ng-mouseup="hide('password')"></i>
                  </div>
                  <p ng-if="error_msg_password" class="text-danger">@{{error_msg_password}}</p>
                  <div class="position-relative">
                    <input type="password" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width: 100%;" placeholder="Enter Confirm Password" name="confirm_password" id="confirm_password" ng-model="confirm_password" ng-blur="validate('confirm_password')" ng-change="validate('confirm_password'); change();"/>
                    <i class="fa fa-eye-slash position-absolute top-50 end-0 fs-4" style="transform: translate(-50%,-50%)" id="confirm_password_eye" ng-mousedown="reveal('confirm_password')" ng-mouseup="hide('confirm_password')"></i>
                  </div>
                  <p ng-if="error_msg_confirmpassword" class="text-danger">@{{error_msg_confirmpassword}}</p>
                  <input type="text" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width: 100%;" placeholder="Enter Phone" name="phone" id="phone" ng-model="phone" ng-blur="validate('phone')" ng-change="change(); validate('phone')"/>
                  <p ng-if="error_msg_phone" class="text-danger">@{{error_msg_phone}}</p>
                  <input type="text" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width: 100%;" placeholder="Enter Date Of Birth" name="date_of_birth" id="date_of_birth" ng-model="date_of_birth" ng-blur="validate('date_of_birth')" ng-change="change(); validate('date_of_birth')"/>
                  <p ng-if="error_msg_dob" class="text-danger">@{{error_msg_dob}}</p>
                  <div class="row">
                    <div class="col-6">
                      <select class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width: 100%;" name="height_feet" id="height_feet" ng-model="height_feet" ng-blur="validate('height_feet')" ng-change="change(); validate('height_feet')">
                        <option value="" selected>Select Your Height Feet</option>
                        <option value="4">4'</option>
                        <option value="5">5'</option>
                        <option value="6">6'</option>
                        <option value="7">7'</option>
                      </select>
                      <p ng-if="error_msg_ft" class="text-danger">@{{error_msg_ft}}</p>
                    </div>
                    <div class="col-6">
                      <select class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width: 100%;" name="height_inch" id="height_inch" ng-model="height_inch" ng-blur="validate('height_inch')" ng-change="change(); validate('height_inch')">
                        <option value="" selected>Select Your Height Inch</option>
                        <option value="0">0''</option>
                        <option value="1">1''</option>
                        <option value="2">2''</option>
                        <option value="3">3''</option>
                        <option value="4">4''</option>
                        <option value="5">5''</option>
                        <option value="6">6''</option>
                        <option value="7">7''</option>
                        <option value="8">8''</option>
                        <option value="9">9''</option>
                        <option value="10">10''</option>
                        <option value="11">11''</option>
                      </select>
                      <p ng-if="error_msg_in" class="text-danger">@{{error_msg_in}}</p>
                    </div>
                  </div>
                  <select class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width: 100%;" name="city" id="city" ng-model="city" ng-blur="validate('city')" ng-change="change(); validate('city')">
                    <option value="" selected>Please Select Your City</option>
                    <option value="@{{city.id}}" ng-repeat="city in cities">@{{city.name}}</option>
                  </select>
                  <p ng-if="error_msg_city" class="text-danger">@{{error_msg_city}}</p>
                  <textarea rows="3" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width: 100%;" name="education" id="education" placeholder="Please Describe Your Education" ng-model="education" ng-blur="validate('education')" ng-change="change(); validate('education')"></textarea>
                  <p ng-if="error_msg_edu" class="text-danger">@{{error_msg_edu}}</p>
                  <textarea rows="3" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width: 100%;" name="about" id="about" placeholder="Please Tell Me About Yourself" ng-model="about" ng-blur="validate('about')" ng-change="change(); validate('about')"></textarea>
                  <p ng-if="error_msg_about" class="text-danger">@{{error_msg_about}}</p>
                  <textarea rows="3" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width: 100%;" name="work" id="work" placeholder="Please Describe Your Business" ng-model="work" ng-blur="validate('work')" ng-change="change(); validate('work')"></textarea>
                  <p ng-if="error_msg_work" class="text-danger">@{{error_msg_work}}</p>
                  <span class="d-block fs-4 mt-3">Please select your gender</span>
                  <div class="form-check form-check-inline mt-2 pe-2">
                    <input class="form-check-input gender" type="radio" name="gender" id="male" value="{{ getGender((string) 'male')}}" ng-model="gender" ng-blur="validate('gender')" ng-change="change(); validate('gender')"/>
                    <label class="form-check-label" for="male">Male</label>
                  </div>
                  <div class="form-check form-check-inline mt-2 pe-2">
                    <input class="form-check-input gender" type="radio" name="gender" id="female" value="{{ getGender((string) 'female')}}" ng-model="gender" ng-blur="validate('gender')" ng-change="change(); validate('gender')"/>
                    <label class="form-check-label" for="female">Female</label>
                  </div>
                  <p ng-if="error_msg_gender" class="text-danger">@{{error_msg_gender}}</p>
                  <div class="row mb-3 ms-0">
                      <span class="d-block fs-4 mt-3">Choose Your Hobbies</span>
                      <div class="form-check form-check-inline col-md-3" ng-repeat="hobby in hobbies" id="hobbies">
                        <label class="form-check-label" for="hobby-@{{hobby.id}}">@{{hobby.name}}</label>
                        <input class="form-check-input hobby" type="checkbox" id="hobby-@{{hobby.id}}" value="@{{hobby.id}}" name="hobbies[]" ng-blur="validate('selectedhobbies')" ng-model="hobby.checked" ng-change="change(); validate('selectedhobbies')"/>
                      </div>
                      <p ng-if="error_msg_hobby" class="text-danger d-block">@{{error_msg_hobby}}</p>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <select class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width: 100%;" name="min_age" id="min_age" ng-model="min_age" ng-blur="validate('min_age')" ng-change="change(); validate('min_age'); chooseMinAge()">
                        <option value="" selected>Select Partner Min Age</option>
                        <option value="@{{age}}" ng-repeat="age in min_ages_arr">@{{age}}</option>
                      </select>
                      <p ng-if="error_msg_min_age" class="text-danger">@{{error_msg_min_age}}</p>
                    </div>
                    <div class="col-6">
                      <select class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width: 100%;" name="max_age" id="max_age" ng-model="max_age" ng-blur="validate('max_age')" ng-change="change(); validate('max_age'); chooseMaxAge()">
                        <option value="" selected>Select Partner Max Age</option>
                        <option value="@{{age}}" ng-repeat="age in max_ages_arr">@{{age}}</option>
                      </select>
                      <p ng-if="error_msg_max_age" class="text-danger">@{{error_msg_max_age}}</p>
                    </div>
                  </div>
                  <span class="d-block fs-4 mt-3">Please select partner gender</span>
                  <div class="form-check form-check-inline mt-2 pe-2">
                    <input class="form-check-input pgender" type="radio" name="pgender" id="pmale" value="{{ getPartnerGender((string) 'male')}}" ng-model="pgender" ng-blur="validate('pgender')" ng-change="change(); validate('pgender')"/>
                    <label class="form-check-label" for="pmale">Male</label>
                  </div>
                  <div class="form-check form-check-inline mt-2 pe-2">
                    <input class="form-check-input pgender" type="radio" name="pgender" id="pfemale" value="{{ getPartnerGender((string) 'female')}}" ng-model="pgender" ng-blur="validate('pgender')" ng-change="change(); validate('pgender')"/>
                    <label class="form-check-label" for="pfemale">Female</label>
                  </div>
                  <div class="form-check form-check-inline mt-2 pe-2">
                    <input class="form-check-input pgender" type="radio" name="pgender" id="pboth" value="{{ getPartnerGender((string) 'both')}}" ng-model="pgender" ng-blur="validate('pgender')" ng-change="change(); validate('pgender')"/>
                    <label class="form-check-label" for="pboth">Both</label>
                  </div>
                  <p ng-if="error_msg_pgender" class="text-danger">@{{error_msg_pgender}}</p>
                  <select class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width: 100%;" name="religion" id="religion" ng-model="religion" ng-blur="validate('religion')" ng-change="change(); validate('religion')">
                    <option value="" selected>Please Select Your Religion</option>
                    <option value="{{ getReligion((string) 'buddhism')}}">Buddhism</option>
                    <option value="{{ getReligion((string) 'christian')}}">Christian</option>
                    <option value="{{ getReligion((string) 'islam')}}">Islam</option>
                    <option value="{{ getReligion((string) 'hinduism')}}">Hinduism</option>
                    <option value="{{ getReligion((string) 'jain')}}">Jain</option>
                    <option value="{{ getReligion((string) 'shinto')}}">Shinto</option>
                    <option value="{{ getReligion((string) 'atheism')}}">Atheism</option>
                    <option value="{{ getReligion((string) 'others')}}">Others</option>
                  </select>
                  <p ng-if="error_msg_religion" class="text-danger">@{{error_msg_religion}}</p>
                  <button class="btn btn-dark rounded rounded-5 btn-lg mt-4" type="button" id="next_btn1" style="width: 100%;" ng-click="step1();" disabled>Next</button>
                </div>
                <div ng-if="user_photo">
                  <table style="width: 100%; margin-left: -7px; table-layout: fixed;">
                    <tr>
                      <td rowspan="2" colspan="2">
                        <div class="border border-primary bg-body-secondary rounded-2 m-1 m-md-2 d-flex justify-content-center align-items-center" style="height: 48vh; position: relative;" id="preview1">
                          <i class="fa fa-upload fs-1" style="cursor: pointer;" onclick="upload(1)"></i>
                        </div></td>
                      <td>
                        <div class="border border-primary bg-body-secondary rounded-2 m-1 m-md-2 d-flex justify-content-center align-items-center" style="height: 23vh; position: relative;" id="preview2">
                          <i class="fa fa-upload fs-2" style="cursor: pointer;" onclick="upload(2)"></i></i>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="border border-primary bg-body-secondary rounded-2 m-1 m-md-2 d-flex justify-content-center align-items-center" style="height: 23vh; position: relative;" id="preview3">
                          <i class="fa fa-upload fs-2" style="cursor: pointer;" onclick="upload(3)"></i>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="border border-primary bg-body-secondary rounded-2 m-1 m-md-2 d-flex justify-content-center align-items-center" style="height: 23vh; position: relative;" id="preview4">
                          <i class="fa fa-upload fs-2" style="cursor: pointer;" onclick="upload(4)"></i>
                        </div>
                      </td>
                      <td>
                        <div class="border border-primary bg-body-secondary rounded-2 m-1 m-md-2 d-flex justify-content-center align-items-center" style="height: 23vh; position: relative;" id="preview5">
                          <i class="fa fa-upload fs-2" style="cursor: pointer;" onclick="upload(5)"></i>
                        </div>
                      </td>
                      <td>
                        <div class="border border-primary bg-body-secondary rounded-2 m-2 d-flex justify-content-center align-items-center" style="height: 23vh; position: relative;" id="preview6">
                          <i class="fa fa-upload fs-2" style="cursor: pointer;" onclick="upload(6)"></i>
                        </div>
                      </td>
                    </tr>
                  </table>
                  <p ng-if="error_msg_photo" class="text-danger" id="err_msg_photo">@{{error_msg_photo}}</p>
                  <button class="btn btn-dark rounded rounded-5 btn-lg mt-4" type="button" id="next_btn2" style="width: 100%;" ng-click="step2();" disabled>Upload</button>
                  <button class="btn btn-dark rounded rounded-5 btn-lg mt-4" type="button" id="next_btn2" style="width: 100%;" ng-click="back();">Back to First Page</button>
                </div>
                <input type="hidden" name="form-sub" id="form-sub" value="1"/>
                <input type="hidden" name="member_id" id="member_id" value=""/>
                <div id="input_container1">
                  <input type="file" style="display: none;" id="file1" name="file1" onchange="fileupload1(1)"/>
                </div>
                <div id="input_container2">
                  <input type="file" style="display: none;" id="file2" name="file2" onchange="fileupload1(2)"/>
                </div>
                <div id="input_container3">
                  <input type="file" style="display: none;" id="file3" name="file3" onchange="fileupload1(3)"/>
                </div>
                <div id="input_container4">
                  <input type="file" style="display: none;" id="file4" name="file4" onchange="fileupload1(4)"/>
                </div>
                <div id="input_container5">
                  <input type="file" style="display: none;" id="file5" name="file5" onchange="fileupload1(5)"/>
                </div>
                <div id="input_container6">
                  <input type="file" style="display: none;" id="file6" name="file6" onchange="fileupload1(6)"/>
                </div>
            </form>
            <p class="w-100 mt-4 fw-medium text-center" style="font-size: 12px; line-height:16px;">By signing up, you agree to our
            <a href="javascript:void(0)" class="text-black">Terms & Conditions</a>. Learn how we
              use your data in our
            <a href="javascript:void(0)" class="text-black">Privacy Policy</a>
            </p>
        </div>
        <div class="col"></div>
    </div>
</div>

@endsection
@section('javascript')
<script src="{{ url('/assets/js/frontend/myapp.js?v=20240506') }}"></script>

<!-- pnotify -->
<script src="{{ url('assets/js/pnotify/pnotify.js')}}"></script>

<!-- smart wizard -->
<script src="{{ url('assets/js/frontend/jquery.smartWizard.min.js')}}"></script>

<script>
    $( function() {
        let today_date = new Date();
        let last_18_years_ago;
        if(today_date.getFullYear()%4 == 0 && today_date.getMonth() == 1 && today_date.getDate() == 29){
            last_18_years_ago = new Date(today_date.getFullYear()-18, today_date.getMonth(), today_date.getDate()-1);
        }
        else{
            last_18_years_ago = new Date(today_date.getFullYear()-18, today_date.getMonth(), today_date.getDate());
        }

        $( "#date_of_birth" ).datepicker({
            changeYear : true,
            changeMonth : true,
            dateFormat: 'yy-mm-dd',
            maxDate:last_18_years_ago,
            yearRange: "-60:+0"
        });
        $('#date_of_birth').prop('readonly',true);
    } );

    function upload(value){
        $('#file'+value).click();
    }

    function fileupload1(value){
        const fileInput =document.getElementById('file'+value);
        const fileContainer = document.getElementById('preview'+value);
        const inputContainer =document.getElementById('input_container'+value);
        let files = fileInput.files;
        let fileName =fileInput.value;
        let allowedExtensions = ['jpeg','jpg','png','gif'];

        let extension = fileName.split('.').pop().toLowerCase();
        if(allowedExtensions.indexOf(extension)<0){
            new PNotify({
                title: 'Oh no!',
                text: "Only jpeg, jpg, png and gif files are allowed",
                type: 'error',
                styling: 'bootstrap3'
            });
            inputContainer.innerHTML = `<input type="file" style="display: none;" id="file${value}" name="file${value}" onchange="fileupload1(${value})"/>`;
            fileContainer.innerHTML = `<i class="fa fa-upload fs-2" style="cursor: pointer;" onclick="upload(${value})"></i></i>`
        }
        else if (files.length > 0) {
            let file = files[0];

            let reader = new FileReader();

            reader.onload = function(e) {
                let imageLink = e.target.result;
                fileContainer.innerHTML = `<label class="change_photo" onclick="upload(${value})"><i class="fa fa-pencil"></i></label>
                                <img src=${imageLink} class="img-responsive" alt='preview image' width=100% height=100% style="object-fit: cover;"/>`;
            }

            reader.readAsDataURL(file);
        }

        if($("#file1").val() != ""){
        $("#err_msg_photo").hide();
        }
        else{
        $("#err_msg_photo").show();
        }

        if($("#file1").val() == "" && $("#file2").val() == "" && $("#file3").val() == "" && $("#file4").val() == "" && $("#file5").val() == "" && $("#file6").val() == ""){
            $("#next_btn2").prop("disabled",true);
            document.getElementById('pole').style.width = "50%";
        }
        else{
            $("#next_btn2").prop("disabled",false);
            document.getElementById('pole').style.width = "100%";
        }
    };
</script>
@endsection