<form class="offcanvas offcanvas-end edit-profile scrollable px-4" data-bs-backdrop="false" tabindex="-1" id="offcanvasEditForm" aria-labelledby="offcanvasEditForm" action="" method="POST" enctype="multipart/form-data">
    <div class="bg-white edit-profile-header position-sticky top-0 p-2" style="z-index: 2;">
        <i class="fa fa-chevron-left fs-4" ng-click="closeForm()"></i>
    </div>
    <label for="username" class="fs-5 fw-bold">Username</label>
    <input type="text" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width: 100%;" placeholder="Enter Username" name="username" id="username" value="@{{member.username}}" ng-model="username" ng-change="validate()"/>
    <p ng-if="error_msg_username" class="text-danger">@{{error_msg_username}}</p>

    <label for="phone" class="fs-5 fw-bold">Phone</label>
    <input type="text" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width: 100%;" placeholder="Enter Phone" name="phone" id="phone" value="@{{member.phone}}" ng-model="phone" ng-change="validate()"/>
    <p ng-if="error_msg_phone" class="text-danger">@{{error_msg_phone}}</p>

    <label for="date_of_birth" class="fs-5 fw-bold">Date Of Birth</label>
    <input type="text" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width: 100%;" placeholder="Enter Date Of Birth" name="date_of_birth" id="date_of_birth" value="@{{member.date_of_birth}}"/>
    <p ng-if="error_msg_dob" class="text-danger">@{{error_msg_dob}}</p>
    <div class="row">
    <div class="col-6">
        <label for="height_feet" class="fs-5 fw-bold">Height In Feet</label>
        <select class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width: 100%;" name="height_feet" id="height_feet">
        <!-- <option value="">Select Your Height Feet</option> -->
            <option value="4" ng-if="member.height_feet != 4">4'</option>
            <option value="4" ng-if="member.height_feet == 4" selected>4'</option>
            <option value="5" ng-if="member.height_feet != 5">5'</option>
            <option value="5" ng-if="member.height_feet == 5" selected>5'</option>
            <option value="6" ng-if="member.height_feet != 6">6'</option>
            <option value="6" ng-if="member.height_feet == 6" selected>6'</option>
            <option value="7" ng-if="member.height_feet != 7">7'</option>
            <option value="7" ng-if="member.height_feet == 7" selected>7'</option>
        </select>
        <p ng-if="error_msg_ft" class="text-danger">@{{error_msg_ft}}</p>
    </div>
    <div class="col-6">
        <label for="height_inches" class="fs-5 fw-bold">Height In Inches</label>
        <select class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width: 100%;" name="height_inches" id="height_inches">
            <!-- <option value="" selected>Select Your Height Inch</option> -->
            <option value="0" ng-if="member.height_inches != 0">0''</option>
            <option value="0" ng-if="member.height_inches == 0" selected>0''</option>
            <option value="1" ng-if="member.height_inches != 1">1''</option>
            <option value="1" ng-if="member.height_inches == 1" selected>1''</option>
            <option value="2" ng-if="member.height_inches != 2">2''</option>
            <option value="2" ng-if="member.height_inches == 2" selected>2''</option>
            <option value="3" ng-if="member.height_inches != 3">3''</option>
            <option value="3" ng-if="member.height_inches == 3" selected>3''</option>
            <option value="4" ng-if="member.height_inches != 4">4''</option>
            <option value="4" ng-if="member.height_inches == 4" selected>4''</option>
            <option value="5" ng-if="member.height_inches != 5">5''</option>
            <option value="5" ng-if="member.height_inches == 5" selected>5''</option>
            <option value="6" ng-if="member.height_inches != 6">6''</option>
            <option value="6" ng-if="member.height_inches == 6" selected>6''</option>
            <option value="7" ng-if="member.height_inches != 7">7''</option>
            <option value="7" ng-if="member.height_inches == 7" selected>7''</option>
            <option value="8" ng-if="member.height_inches != 8">8''</option>
            <option value="8" ng-if="member.height_inches == 8" selected>8''</option>
            <option value="9" ng-if="member.height_inches != 9">9''</option>
            <option value="9" ng-if="member.height_inches == 9" selected>9''</option>
            <option value="10" ng-if="member.height_inches != 10">10''</option>
            <option value="10" ng-if="member.height_inches == 10" selected>10''</option>
            <option value="11" ng-if="member.height_inches != 11">11''</option>
            <option value="11" ng-if="member.height_inches == 11" selected>11''</option>
        </select>
        <p ng-if="error_msg_in" class="text-danger">@{{error_msg_in}}</p>
    </div>
    </div>

    <label for="city" class="fs-5 fw-bold">City</label>
    <select class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width: 100%;" name="city" id="city">
    <!-- <option value="" selected>Please Select Your City</option> -->
        <option value="@{{city.id}}" ng-repeat="city in cities" ng-if="city.name != member.city.name">@{{city.name}}</option>
        <option value="@{{city.id}}" ng-repeat="city in cities" ng-if="city.name == member.city.name" selected>@{{city.name}}</option>
    </select>
    <p ng-if="error_msg_city" class="text-danger">@{{error_msg_city}}</p>

    <label for="education" class="fs-5 fw-bold">Education</label>
    <textarea rows="3" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width: 100%;" name="education" id="education" ng-model="education" ng-change="validate()" placeholder="Please Describe Your Education">@{{member.education}}</textarea>
    <p ng-if="error_msg_edu" class="text-danger">@{{error_msg_edu}}</p>

    <label for="about" class="fs-5 fw-bold">About</label>
    <textarea rows="3" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width: 100%;" name="about" id="about" ng-model="about" ng-change="validate()" placeholder="Please Tell Me About Yourself">@{{member.about}}</textarea>
    <p ng-if="error_msg_about" class="text-danger">@{{error_msg_about}}</p>

    <label for="work" class="fs-5 fw-bold">Work</label>
    <textarea rows="3" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width: 100%;" name="work" id="work" ng-model="work" ng-change="validate()" placeholder="Please Describe Your Business">@{{member.work}}</textarea>
    <p ng-if="error_msg_work" class="text-danger">@{{error_msg_work}}</p>

    <span class="d-block fs-4 mt-3 fw-bold">Please select your gender</span>
    <div class="row ms-2">
        <div class="col-md-3 form-check form-check-inline mt-2 pe-2">
            <input class="form-check-input gender" type="radio" name="gender" id="Male" value="{{ getGender((string) 'male')}}" ng-model="gender"/>
            <label class="form-check-label" for="Male">Male</label>
        </div>
        <div class="col-md-3 form-check form-check-inline mt-2 pe-2">
            <input class="form-check-input gender" type="radio" name="gender" id="Female" value="{{ getGender((string) 'female')}}" ng-model="gender"/>
            <label class="form-check-label" for="Female">Female</label>
        </div>
    </div>
    <p ng-if="error_msg_gender" class="text-danger">@{{error_msg_gender}}</p>
    <div class="row mb-3">
        <span class="d-block fs-4 mt-3 fw-bold">Choose Your Hobbies</span>
        <div class="form-check form-check-inline col-md-3 ms-4" ng-repeat="hobby in hobbies" id="hobbies">
            <label class="form-check-label" for="hobby-@{{hobby.id}}">@{{hobby.name}}</label>
            <input class="form-check-input hobby" type="checkbox" id="hobby-@{{hobby.id}}" value="@{{hobby.id}}" name="hobbies[]" ng-model="hobby.checked" ng-change="validate()"/>
        </div>
        <p ng-if="error_msg_hobby" class="text-danger d-block">@{{error_msg_hobby}}</p>
    </div>
    <div class="row">
    <div class="col-6">
        <label for="min_age" class="fs-5 fw-bold">Minimum Age</label>
        <select class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width: 100%;" name="min_age" id="min_age" ng-model="selected_min_age" ng-change="chooseMinAge()">
        <option value="@{{age}}" ng-repeat="age in min_ages_arr">@{{age}}</option>
        </select>
        <p ng-if="error_msg_min_age" class="text-danger">@{{error_msg_min_age}}</p>
    </div>
    <div class="col-6">
        <label for="max_age" class="fs-5 fw-bold">Maximum Age</label>
        <select class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width: 100%;" name="max_age" id="max_age" ng-model="selected_max_age" ng-change="chooseMaxAge()">
        <option value="@{{age}}" ng-repeat="age in max_ages_arr">@{{age}}</option>
        </select>
        <p ng-if="error_msg_max_age" class="text-danger">@{{error_msg_max_age}}</p>
    </div>
    </div>
    <span class="d-block fs-4 mt-3 fw-bold">Please select partner gender</span>
    <div class="row ms-2">
        <div class="col-md-3 form-check form-check-inline mt-2 pe-2">
            <input class="form-check-input pgender" type="radio" name="pgender" id="pmale" value="{{ getPartnerGender((string) 'male')}}" ng-model="pgender" ng-blur="validate('pgender')" ng-change="change(); validate('pgender')"/>
            <label class="form-check-label" for="pmale">Male</label>
        </div>
        <div class="col-md-3 form-check form-check-inline mt-2 pe-2">
            <input class="form-check-input pgender" type="radio" name="pgender" id="pfemale" value="{{ getPartnerGender((string) 'female')}}" ng-model="pgender" ng-blur="validate('pgender')" ng-change="change(); validate('pgender')"/>
            <label class="form-check-label" for="pfemale">Female</label>
        </div>
        <div class="col-md-3 form-check form-check-inline mt-2 pe-2">
            <input class="form-check-input pgender" type="radio" name="pgender" id="pboth" value="{{getPartnerGender((string) 'both')}}" ng-model="pgender" ng-blur="validate('pgender')" ng-change="change(); validate('pgender')"/>
            <label class="form-check-label" for="pboth">Both</label>
        </div>
    </div>
    <p ng-if="error_msg_pgender" class="text-danger">@{{error_msg_pgender}}</p>

    <label for="religion" class="mt-2 fs-5 fw-bold">Religion</label>
    <select class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" style="width: 100%;" name="religion" id="religion" ng-model="religion">
    <!-- <option value="" selected>Please Select Your Religion</option> -->
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

    <input type="hidden" name="form-sub" id="form-sub" value="1"/>
    <input type="hidden" name="member_id" id="member_id" value="member.id"/>
    <button class="btn btn-dark rounded rounded-5 btn-lg mt-4 mb-2" type="button" id="next_btn1" style="width: 100%;" ng-click="updateDetails();" ng-disabled="process_error">Update</button>
</form>