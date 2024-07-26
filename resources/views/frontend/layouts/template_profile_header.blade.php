<header class="article-container-header d-flex justify-content-between">
  <span class="article-container-title" style="font-size: 26px">
    Home
  </span>
  <div class="d-flex justify-content-center align-items-center">
    <button class="icon-button bg-black justify-content-center me-1 d-flex align-items-center" style="height: 25px; width: 60px; border-radius: 100%/60px;">
      <i class="fa fa-database me-1 text-dark rounded-circle bg-white" style="font-size: 12px;padding: 2px 5px;"></i>
      <span class="text-white" id="point" style="font-size: 12px;">{{ Auth::guard('member')->user()->point }}</span>
    </button>
    <button class="icon-button" >
      <i class="fa fa-search fs-4 fw-bold" id="offcanvas_search_btn" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSearch" aria-controls="offcanvasSearch"></i>
    </button>

    <div style="width: 540px; height: 270px; margin: 0 auto;" class="offcanvas offcanvas-bottom rounded-top-5 p-3" tabindex="-1" id="offcanvasSearch" aria-labelledby="offcanvasSearchLabel">
      <div class="offcanvas-header">
        <button type="button" id="close_btn" class="btn-close fs-5" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body small">

        <div class="d-flex justify-content-between align-items-center mb-4" style="cursor: pointer;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasGender" aria-controls="offcanvasGender">
          <span><strong>Show me</strong></span>
          <span>@{{all_genders[partner_gender]}} <i class="fa fa-chevron-right ms-2"></i></span>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4" style="cursor: pointer" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAge" aria-controls="offcanvasAge">
          <span><strong>Age range</strong></span>
          <span>@{{selected_minimum_age}} - @{{selected_maximum_age}} <i class="fa fa-chevron-right ms-2"></i></span>
        </div>
        <button class="btn btn-lg rounded-pill btn-dark w-100" ng-click="new_search()">Apply Filters</button>
      </div>
    </div>

    <div style="width: 540px; height: 520px; margin: 0 auto;" class="offcanvas offcanvas-bottom rounded-top-5 p-3" tabindex="-1" id="offcanvasGender" aria-labelledby="offcanvasGenderLabel">
      <div class="offcanvas-header">
        <span type="button" ng-click="back_search_offcanvas()" class="fs-4 float-left" aria-label="Back"><i class="fa fa-chevron-left"></i></span>
      </div>
      <div class="offcanvas-body small">
        <h1 class="fs-3"><strong>Show me</strong></h1>
        <p class="mb-4">Which gender(s) would you like to see?</p>
        <label class="d-flex justify-content-between align-items-center mb-4 p-3 rounded-5" style="cursor: pointer; background-color: #e9d8ff;">
          <span><strong>Women</strong></span>
          <span><input type="radio" name="gender" value="2" id="Women" style="width: 20px; height: 20px; vertical-align: middle;"/></span>
        </label>
        <label class="d-flex justify-content-between align-items-center mb-4 p-3 rounded-5" style="cursor: pointer; background-color: #e9d8ff;">
          <span><strong>Men</strong></span>
          <span><input type="radio" name="gender" value="1" id="Men" style="width: 20px; height: 20px; vertical-align: middle;" /></span>
        </label>
        <label class="d-flex justify-content-between align-items-center mb-4 p-3 rounded-5" style="cursor: pointer; background-color: #e9d8ff;">
          <span><strong>Everyone</strong></span>
          <span><input type="radio" name="gender" value="3" id="Everyone" style="width: 20px; height: 20px; vertical-align: middle;" /></span>
        </label>
        <button class="btn btn-lg rounded-pill btn-dark w-100" ng-click="select_new_gender()">Apply</button>
      </div>
    </div>

    <div style="width: 540px; height: 350px; margin: 0 auto;" class="offcanvas offcanvas-bottom rounded-top-5 p-3" tabindex="-1" id="offcanvasAge" aria-labelledby="offcanvasAgeLabel">
      <div class="offcanvas-header">
        <span type="button" ng-click="back_search_offcanvas()" class="fs-4 float-left" aria-label="Back"><i class="fa fa-chevron-left"></i></span>
      </div>
      <div class="offcanvas-body small">
        <h1>Age Range</h1>
        <div class="row mb-4">
        <div class="col-6">
          <span>Minimum</span>
          <select class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" name="selected_min_age" id="selected_min_age" ng-model="min_age" ng-change="chooseMinAge()">
            <option value="@{{age}}" ng-repeat="age in min_ages_array">@{{age}}</option>
          </select>
        </div>
        <div class="col-6">
          <span>Maximum</span>
          <select class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" name="selected_max_age" id="selected_max_age" ng-model="max_age" ng-change="chooseMaxAge()">
            <option value="@{{age}}" ng-repeat="age in max_ages_array">@{{age}}</option>
          </select>
        </div>
        </div>
        <button class="btn btn-lg rounded-pill btn-dark w-100" ng-click="select_new_ages()">Apply</button>
      </div>
    </div>
  </div>
</header>