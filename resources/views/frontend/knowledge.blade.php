@extends('frontend.master_knowledge')
@section('subtitle','Knowledge')
@section('content')
<script>
    var all_genders = {1: "Men", 2: "Women", 3: "Everyone"};
    var selected_gender = {{ Auth::guard('member')->user()->partner_gender }};
    var min_age = {{ Auth::guard('member')->user()->partner_min_age }};
    var max_age = {{ Auth::guard('member')->user()->partner_max_age }};
</script>
<div ng-app="myApp" ng-controller="MyController" ng-init="init()">
  <div ng-show="!loading" id="carousel-wrapper" style="z-index: 1;" class="opacity-0 bg-black vw-100 position-fixed top-0 p-0" >
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
  <div ng-show="!loading" id="member-profile" class="vw-100 vh-100 position-absolute top-0 left-0" style="z-index: -10;">
    <div class="d-flex justify-content-center align-items-center w-100 h-100" id="scroll-container">
      <div class="rounded-5 overflow-hidden opacity-100 bg-secondary position-relative" style="width: 540px; height: 80vh;">
        <div class="overflow-hidden">

          <div id="upper-container" class="position-absolute top-0 p-4" style="width: 100%;">
            <div class="d-flex text-white justify-content-between">
              <div class="d-flex align-items-center"></div>
              <div class="d-flex justify-content-between align-items-center">
                <!-- <button class="btn border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom"><i class="fa fa-ellipsis-h text-light fs-3 me-3"></i></button> -->
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

                <span id="profile-cancel-btn" ng-click="cancel_profile(post_id)" class="fs-4 fw-bold" style="cursor: pointer;">&#10005;</span>
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
              <button class="round-btn btn btn-light" ng-disabled="prev" id="prev" style="width: 35px; height: 35px;" ng-click="prev_post(post_id)">
                <i class="fa fa-angle-left fs-3"></i>
              </button>
              <div class="d-flex" style="margin: auto !important;">
                <div class="round-btn me-3 btn btn-light" style="width: 60px; height: 60px;"><i class="fa fa-commenting-o fs-3"></i></div>
                <div class="round-btn ms-3 btn btn-light" style="width: 60px; height: 60px;" onclick="shareOnFacebook()"><i class="fa fa-share fs-3"></i></div>
              </div>
              <button class="round-btn btn btn-light" ng-disabled="next" id="next" style="width: 35px; height: 35px;" ng-click="next_post(post_id)"><i class="fa fa-angle-right fs-3"></i></button>
            </div>
          </div>

          <div id="profile-content" class="overflow-y-auto bg-white" style="width:100%; height: 80vh; z-index: 5;">
            <div class="w-100 h-100">
              <img ng-src="@{{post.full_photo}}" class="profile-image w-100 h-100 object-fit-cover" alt="member-photo" ng-click="show_photoes(first_photo,all_photoes)"/>
            </div>
            <div class="">
              <div class="p-4">
                <span class="text-secondary fs-1" style="font-weight: 900;">@{{post.title}}</span>
                <p class="fs-5" style="margin-bottom: 75px; white-space: pre-line;">@{{post.description}}</p>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
  <div ng-show="!loading" class="article">
    <article class="article-container">
      @include('frontend.layouts.template_knowledge_header')
      <section class="article-container-body rtf position-relative" style="min-height: 80vh;">
        <div class="container" id="image-content" style="z-index: 10;" ng-if="!searchedPosts">
          <div class="row my-2">
            <div class="col-md-6" style="height: 34vh;" ng-repeat="post in posts">
              <div id="profile-@{{post.post_id}}" style="height: 85%;">
                <div class="post" style="height: 120px;">
                  <img src="@{{post.thumb_path}}" width="100%" height="170px" alt="post_thumb" class="image rounded rounded-4 object-fit-cover mb-2" title="@{{post.description.slice(0,50)}}" ng-click="show_post($index)"/>
                  <p style="font-size: 20px; font-weight: 900; margin-top: -8px;" title="@{{post.title}}">@{{post.title}}</p>
                  <p style="font-size: 15px; font-weight: 500; margin-top: -16px;" title="@{{post.description.slice(0,50)}}">@{{post.description.slice(0,50)}}<span ng-if="post.description.length > 50">...</span></p>
                </div>
              </div>
            </div>
          </div>
          <button class="d-block mx-auto bg-black text-white p-2 rounded load-more" id="load" ng-click="loadmore()" ng-show="more_posts">...load more...</button>
        </div>
        <div class="p-3" ng-if="searchedPosts">
          <div class="row" ng-if="filteredPosts.length > 0" ng-repeat="post in filteredPosts" ng-click="show_filtered_post($index)">
            <div class="col-md-6">
              <img ng-src="@{{post.thumb}}" width="100%" height="170px" alt="post_thumb" class="image rounded rounded-4 object-fit-cover mb-2" title="@{{post.description.slice(0,50)}}"/>
            </div>
            <div class="col-md-6">
              <p style="font-size: 20px; font-weight: 900;" id="filteredTitle-@{{$index}}" title="@{{post.title}}">@{{post.title}}</p>
              <p style="font-size: 15px; font-weight: 500; margin-bottom: 0; white-space: pre-line;" id="filteredDescription-@{{$index}}" title="@{{post.description.slice(0,50)}}">@{{post.description.slice(0,50)}}<span ng-if="post.description.length > 50">...</span></p>
            </div>
          </div>
          <div class="mx-auto d-flex justify-content-center" ng-if="filteredPosts.length == 0">
            <span style="font-size: 32px;">No Posts Available</span>
          </div>
        </div>
      </section>
      @include('frontend.layouts.template_profile_footer')
    </article>
  </div>
</div>
@endsection
@section('javascript')
<script src="{{ url('assets/js/frontend/jquery-3.5.1.slim.min.js') }}"></script>
    <script src="{{ url('assets/js/frontend/popper.min.js') }}"></script>
    <script src="{{ url('assets/js/frontend/bootstrap.bundle.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular-sanitize.js"></script>
    <script src="{{ url('assets/js/frontend/knowledge.js') }}"></script>
    <!-- facebook share sdk -->
    <!-- <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script> -->
    <script>
      const getProfile        = document.getElementById('profile-content');
      const getScrollBar      = document.getElementById('profile-scroll-bar-value');
      const footerMenu        = document.querySelectorAll("footer button");

      getProfile.addEventListener('scroll',function(e){
          let percent = Math.round((getProfile.scrollTop/(getProfile.scrollHeight-getProfile.clientHeight))*100);
          percent     = percent * 3/4;
          getScrollBar.style.top = `${percent}%`;
      });

      window.fbAsyncInit = function() {
          FB.init({
              appId      : 831322612377416,
              xfbml      : true,
              version    : 'v10.0'
          });
      };

      (function(d, s, id){
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) {return;}
          js = d.createElement(s); js.id = id;
          js.src = "https://connect.facebook.net/en_US/sdk.js";
          fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));

      function shareOnFacebook(){
        var lk = "https://www.restaurantguide.com.mm/listing/akkhaya-tea-house-l00305629.html";
        var img =  "https://www.restaurantguide.com.mm/assets/images/listing/photo/L00305629/000..jpg";
        var obj = {
          method: 'feed',
          link: lk ,
          picture: img,
          name: "mm-cupid",
          caption:'Love Quotes: mm-cupid',
          display:'popup'
        };          
        FB.ui(obj);
      }
    </script>
@endsection