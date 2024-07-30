@extends('frontend.master')
@section('subtitle','Home')
@section('content')
<script>
    var all_genders = {1: "Men", 2: "Women", 3: "Everyone"};
    var selected_gender = {{ Auth::guard('member')->user()->partner_gender }};
    var min_age = {{ Auth::guard('member')->user()->partner_min_age }};
    var max_age = {{ Auth::guard('member')->user()->partner_max_age }};
</script>
<div ng-app="myApp" ng-controller="MyController" ng-init="init()">
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

                    <span id="profile-cancel-btn" ng-click="cancel_profile(member_id)" class="fs-4 fw-bold" style="cursor: pointer;">&#10005;</span>
                </div>
                </div>
            </div>

            <div id="profile-scroll-bar-container" class="position-absolute rounded" style="top: 40%; right: 3%; width: 5px; height: 80px; background-color: #e0e0e0;">
                <div id="profile-scroll-bar">
                <div id="profile-scroll-bar-value" class="bg-white shadow rounded position-absolute right-0" style="width: 100%; border: 0.2px solid #bdbdbd; height: 20px; top: 0; transform: scale(1.2);"></div>
                </div>
            </div>

            <div id="lower-container" class="position-absolute bottom-0 p-4" style="width: 100%; ">
                <div class="d-flex align-items-end justify-content-between">
                <button class="round-btn btn btn-light" ng-disabled="prev" style="width: 35px; height: 35px;" ng-click="prev_profile(member_id)">
                    <i class="fa fa-angle-left fs-3"></i>
                </button>
                <div class="d-flex">
                    <button class="round-btn me-3 btn btn-light" style="width: 60px; height: 60px;" ng-click="view_details()"><i class="fa fa-eye fs-3" title="view details"></i></button>
                    <div class="round-btn ms-3 btn btn-light" style="width: 60px; height: 60px;"><i class="fa fa-heart fs-3"></i></div>
                </div>
                <button class="round-btn btn btn-light" ng-disabled="next" style="width: 35px; height: 35px;" ng-click="next_profile(member_id)"><i class="fa fa-angle-right fs-3"></i></button>
                </div>
            </div>

            <div id="profile-content" class="overflow-y-auto bg-white" style="width:100%; height: 80vh; z-index: 5;">
                <div class="w-100 h-100">
                <img src="@{{member.gallery[0].name}}" class="profile-image w-100 h-100 object-fit-cover" alt="member-photo" ng-click="show_photoes(first_photo,all_photoes)"/>
                </div>
                <div class="">
                <div class="p-4" style="cursor:pointer;" ng-show="!date_request_members.includes({{ Auth::guard('member')->user()->id }})">
                    <span class="text-secondary fw-bold">Why @{{member.username}}'s here</span>
                    <div ng-show="member.status != 0 || member.status != 5" class="tag-color p-3 mt-2 rounded-4 d-flex justify-content-start align-items-center" ng-click="date_request(member.id)">
                    <i class="fa fa-coffee me-2 fs-3"></i><span class="fs-4 fw-bold">Here to date</span>
                    </div>
                </div>
                <div class="p-4">
                    <div class="text-secondary fw-bold">About me</div>
                    <div class="fs-5 fw-bold mt-2" style="white-space: pre-line;">
                    @{{member.about}}
                    </div>
                </div>
                <!-- <div class="p-4">
                    <div class="text-secondary fw-bold">@{{member.username}}'s info</div>
                    <div class="mt-2 row g-2">
                    <span class="col-auto tag-color rounded-pill p-2 mx-1"><i class="fa-solid fa-ruler-vertical"></i> @{{ member.height }}</span>
                    <span class="col-auto tag-color rounded-pill p-2 mx-1" style="white-space: pre-line;"><i class="fa fa-graduation-cap"></i> @{{member.education}} </span>
                    <span class="col-auto tag-color rounded-pill p-2 mx-1"><i class="fa fa-hands-praying"></i> @{{member.religion_name }} </span>
                    <span class="col-auto tag-color rounded-pill p-2 mx-1" style="white-space: pre-line;"><i class="fa fa-briefcase"></i> @{{member.work}} </span>
                    </div>
                </div> -->
                <!-- <div class="mb-2" ng-repeat="photo in member.gallery">
                    <div class="w-100 h-100" style="padding-left: vw;">
                    <img ng-if="$index != 0" ng-src="@{{photo.name}}" class="profile-image w-100 h-100 object-fit-cover" alt="member-photo" ng-click="show_photoes(photo.name,photoes)"/>
                    </div>
                </div> -->

                <div class="p-4">
                    <div class="text-secondary fw-bold">Current location</div>
                    <div class="fs-5 fw-bold mt-2">@{{ member.city.name }}</div>
                </div>
                <div class="p-4" style="margin-bottom: 70px;">
                    <div class="text-secondary fw-bold">Verification</div>
                    <div class="mt-2" ng-show="member.status == {{getMemberVerifiedStatus()}}"><i class="fa fa-certificate fs-5 me-2 text-primary"></i><span class="fs-5 fw-bold">@{{member.username}} is photo verified</span></div>
                    <div class="mt-2" ng-show="member.status != {{getMemberVerifiedStatus()}}"><span class="fs-5 fw-bold">@{{member.username}} is not photo verified</span></div>
                </div>
                </div>
            </div>

            </div>
        </div>
        </div>
    </div>
    <div class="article">
        <article class="article-container">
        @include('frontend.layouts.template_profile_header')
        <section class="article-container-body rtf" style="min-height: 77vh;">
            <div class="container" id="image-content" style="z-index: 10;">
            <div class="row my-2">
                <div class="col-md-4" style="height: 34vh;" ng-repeat="member in members">
                <div id="profile-@{{member.id}}" style="height: 85%;">
                    <img ng-src="@{{member.thumb_path}}" width="100%" height="100%" alt="" class="image rounded rounded-4 object-fit-cover" data-toggle="modal" data-target="#exampleModal" ng-click="show_profile($index)"/>
                </div>
                <p style="font-size: 12px; line-height: 16px; font-weight: 500" class="pt-2">@{{member.username}} , @{{member.age}}</p>
                </div>
            </div>
            <button class="d-block mx-auto bg-black text-white p-2 rounded load-more" id="load" ng-click="loadmore()" ng-show="more_members">...load more...</button>
            </div>
        </section>
        @include('frontend.layouts.template_profile_footer')
        </article>
    </div>
</div>
@endsection
@section('javascript')
<!-- jquery -->
<script src="{{ url('assets/js/frontend/jquery-3.5.1.slim.min.js') }}"></script>
<script src="{{ url('assets/js/frontend/popper.min.js') }}"></script>
<!-- bootstrap -->
<script src="{{ url('assets/js/frontend/bootstrap.bundle.min.js') }}"></script>

<!-- pnotify -->
<script src="{{ url('assets/js/pnotify/pnotify.js') }}"></script>

<!-- sweetalert -->
<script src="{{ url('assets/js/sweetalert2/sweetalert2.all.js') }}"></script>

<!-- custom angular js -->
<script src="{{ url('assets/js/frontend/index.js?v=20240705') }}"></script>

<script>
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