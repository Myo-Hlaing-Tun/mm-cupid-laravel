@section('title','MM-cupid: ')
@section('meta_contents',"Myanmar Dating Website | Online Dating | Myanmar Cupid | MMCupid | သင့်ဖူးစာရှင်ကို ရှာဖွေလိုက်ပါ | {$username}" )
@section('meta_keywords',"mmcupid | MMcupid | myanmar dating | find love | find lover | future boyfriend | future partner | future girlfriend | online dating | ဖူးစာဖက် | ရည်းစားရှာ | ရည်းစား | ဒိတ် | {$username}")
@extends('frontend.profile_master')
@section('subtitle','Profile')
@section('content')
<div class="article" ng-app="myApp" ng-controller="MyController" ng-init="init({{$id}})">
<div id="carousel-wrapper" style="z-index: 1;" class="opacity-0 bg-black vw-100 position-fixed top-0 p-0" >
    <div role="button" id="cancel-btn" ng-click="stop_image_view()" style="z-index: 10; left: 3.5vw; width: 100px; height: 100px;" class="position-absolute text-secondary fw-bold fs-3 d-flex justify-content-center">
        <span id="carousel-cancel-btn">&#10005;</span>
    </div>
    <div class="carousel-indicators position-absolute top-0 mx-auto" style="height: 8%; ">
        <div class="fs-5 text-white w-100 h-100 d-flex justify-content-center align-items-center" style="background: rgba(0,0,0,0.5);"><span id="current-page"></span></div>
    </div>

    <div id="carousalexample" class="carousel slide mx-auto" data-bs-interval="false">
        <div class="carousel-inner mx-auto">
        </div>
        <a class="carousel-control-prev" ng-click="displayCurrentPage('prev')" id="prev-btn" data-bs-target="#carousalexample" type="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"  aria-hidden="true"></span>
        </a>
        <a class="carousel-control-next" ng-click="displayCurrentPage('next')" id="next-btn" data-bs-target="#carousalexample" type="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </a>
    </div>
</div>
<div id="member-profile" class="vw-100 vh-100 position-absolute top-0 left-0" style="z-index: -10;">
    <div class="d-flex justify-content-center align-items-center w-100 h-100" id="scroll-container">
      <div class="rounded-5 overflow-hidden opacity-100 bg-secondary position-relative" style="width: 540px; height: 80vh;">
        <div class="overflow-hidden">

          <div id="upper-container" class="position-absolute top-0 p-4" style="width: 100%;">
            <div class="d-flex text-white justify-content-between">
              <div class="d-flex align-items-center">
                <span class="fw-bold fs-4 me-2">@{{member.username}}, @{{member.age}}</span> <i class="fa fa-circle text-success" style="font-size: 7px;"></i>
              </div>
              <div class="d-flex justify-content-between align-items-center">

                <button class="btn border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom"><i class="fa fa-ellipsis-h text-light fs-3 me-3"></i></button>

                <div style="width: 540px; height: 260px; margin: 0 auto;" class="offcanvas offcanvas-bottom rounded-top-5 p-3" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
                  <div class="offcanvas-header">
                    <button type="button" class="btn-close fs-5" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                  </div>
                  <div class="offcanvas-body small fs-6 fw-semibold">
                    <div class="mb-4" style="cursor: pointer;">Add To Favorites</div>
                    <div class="text-danger mb-4" style="cursor: pointer;">Block</div>
                    <div class="text-danger" style="cursor: pointer;">Block And Report</div>
                  </div>
                </div>

                <span id="profile-cancel-btn" ng-click="cancel_profile()" class="fs-4 fw-bold" style="cursor: pointer;">&#10005;</span>
              </div>
            </div>
          </div>

          <div id="profile-scroll-bar-container" class="position-absolute rounded" style="top: 40%; right: 3%; width: 5px; height: 80px; background-color: #e0e0e0;">
            <div id="profile-scroll-bar">
              <div id="profile-scroll-bar-value" class="bg-white shadow rounded position-absolute right-0" style="width: 100%; border: 0.2px solid #bdbdbd; height: 20px; top: 0; transform: scale(1.2);"></div>
            </div>
          </div>


          <div id="profile-content" class="overflow-y-auto bg-white" style="width:100%; height: 80vh; z-index: 5;">
            <div class="w-100 h-100" ng-repeat="gallery in member.gallery">
              <img ng-src="@{{gallery.name}}" class="profile-image w-100 h-100 object-fit-cover" alt="member-photo" ng-click="show_photoes(gallery.name,all_photoes)"/>
            </div>
          </div>

        </div>
      </div>
    </div>
</div>
    <article class="article-container profile-container position-relative" id="profile">
        @include('frontend.include-files.own_profile_edit')
        @include('frontend.include-files.edit_profile_form')
        @include('frontend.include-files.photo_verification')
        <header class="article-container-header d-flex justify-content-between">
            <span class="article-container-title" style="font-size: 26px">
            Profile
            </span>
            <div class=" justify-content-center">
                <div class="flex align-items-center" style="font-size: 20px;">
                    <button class="icon-button" onclick="window.history.back(); return false;">
                        <i class="fa fa-arrow-left"></i>
                    </button>
                </div>
            </div>
        </header>
        <section class="article-container-body profile-body rtf">
            <div class="container">
                <div class="mt-1">
                    <div class="row">
                        <div class="col-md-3 position-relative">
                            <img ng-src="@{{member.thumb_path}}" class="img-fluid rounded-circle" alt="Profile Photo"/>
                            <div class="position-absolute d-flex" style="top: 70%; right: 10%;" ng-if="member.status == 4">
                                <i class="fa fa-certificate fs-1 text-primary position-absolute" style="top: 50%; right: 50%;"></i>
                            </div>
                            <div class="position-absolute d-flex" style="top: 74%; right: 14%;" ng-if="member.status == 4">
                                <i class="fa fa-check fs-5 text-white position-absolute" style="top: 50%; right: 50%;"></i>
                            </div>
                        </div>
                        <div class="col-md-6">
                        <h3 class="mt-4">@{{member.username}}, @{{member.age}}</h3>
                        <button type="button" class="btn btn-outline-secondary btn-sm btn-smaller">
                            <i class="fas fa-mug-hot icon-bigger"></i>
                        Here To Date</button>
                    </div>    
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center m-3 p-4 rounded-1" style="background-color: #e8e9ea">
                    <div>
                        <span class="d-block fw-bold fs-4">@{{member.username}}, @{{member.age}}</span>
                        <span class="d-block">@{{member.gender_name}}, @{{member.city.name}}</span>
                    </div>
                </div>
                <div class="mx-3 mb-4 p-4 rounded-1" style="background-color: #e8e9ea;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="d-block fw-bold fs-4">Work</span>
                            <span class="d-block">@{{member.work}}</span>
                        </div>
                    </div>
                </div>
                <div class="mx-3 mb-4 p-4 rounded-1" style="background-color: #e8e9ea;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="d-block fw-bold fs-4">Education</span>
                            <span class="d-block">@{{member.education}}</span>
                        </div>
                    </div>
                </div>
                <div class="mx-3 mb-4 p-4 rounded-1" style="background-color: #e8e9ea;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="d-block fw-bold fs-4">About</span>
                            <span class="d-block">@{{member.about}}</span>
                        </div>
                    </div>
                </div>
                <div class="mx-3 mb-4 p-4 rounded-1" style="background-color: #e8e9ea;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="d-block fw-bold fs-4">Height</span>
                            <span class="d-block">@{{member.height}}</span>
                        </div>
                    </div>
                </div>
                <div class="mx-3 mb-4 p-4 rounded-1" style="background-color: #e8e9ea;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="d-block fw-bold fs-4 mb-2">Hobbies</span>
                            <span class="me-2 px-3 py-1 rounded-pill" style="background-color: #e9d8ff;" ng-repeat="hobby in member.member_hobbies">@{{ hobby.details.name}}</span>
                        </div>
                    </div>
                </div>
                <div class="mx-3 mb-4 p-4 rounded-1" style="background-color: #e8e9ea;">
                    <div class="d-block fw-bold fs-4 mb-2">Verification</div>
                    <div class="d-block" ng-show="member.status == {{getMemberVerifiedStatus()}}"><i class="fa fa-certificate fs-5 me-2 text-primary"></i><span class="d-block">@{{member.username}} is photo verified</span></div>
                    <div class="d-block" ng-show="member.status != {{getMemberVerifiedStatus()}}"><span class="d-block">@{{member.username}} is not photo verified</span></div>
                </div>
                <button class="d-block btn btn-dark rounded rounded-5 btn-lg mx-auto my-3" style="width: 96%;" ng-click="showDetails()">
                    <i class="fa fa-search me-2"></i>View All Photos
                </button>
            </div>
        </section>
        @include('frontend.layouts.template_profile_footer')
    </article>
</div>
@endsection
@section('javascript')
<!-- sweetalert2 -->
<script src="{{ url('assets/js/sweetalert2/sweetalert2.all.js') }}"></script>
<script src="{{ url('assets/js/frontend/other_profile.js?v=20240716') }}"></script>
<script src="{{ url('assets/js/frontend/bootstrap.bundle.min.js') }}"></script>

<!-- pnotify -->
<script src="{{ url('assets/js/pnotify/pnotify.js') }}"></script>

<script>
    function showProfile(){
        document.querySelector('body').style.backgroundColor = "#e9d8ff";
    }

    const getProfile        = document.getElementById('profile-content');
    const getScrollBar      = document.getElementById('profile-scroll-bar-value');
    const footerMenu        = document.querySelectorAll("footer button");

    getProfile.addEventListener('scroll',function(e){
        let percent = Math.round((getProfile.scrollTop/(getProfile.scrollHeight-getProfile.clientHeight))*100);
        percent     = percent * 3/4;
        getScrollBar.style.top = `${percent}%`;
    });
</script>
@endsection