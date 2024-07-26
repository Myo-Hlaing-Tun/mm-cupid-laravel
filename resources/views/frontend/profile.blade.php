@extends('frontend.master')
@section('subtitle','Profile')
@section('content')
<div class="article" ng-app="myApp" ng-controller="MyController" ng-init="init({{ Auth::guard('member')->user()->id }})">
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
<div style="width: 540px; height: 350px; margin: 0 auto;" class="offcanvas offcanvas-bottom rounded-top-5 p-3" tabindex="-1" id="offcanvasChangePassword" aria-labelledby="offcanvasChangePasswordLabel">
    <div class="offcanvas-header">
    <button type="button" id="close_btn" class="btn-close fs-5" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body small">

    <input type="password" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" id="oldpassword" style="width: 100%;" placeholder="Enter Your Old Password"/>
    <input type="password" class="form-control form-control-lg border border-1 border-black rounded rounded-4 mt-2" id="newpassword" style="width: 100%;" placeholder="Enter Your New Password"/>
    <input type="password" class="form-control form-control-lg border border-1 border-black rounded rounded-4 my-2" id="confirmpassword" style="width: 100%;" placeholder="Enter Your Confirm Password"/>
    <button class="btn btn-lg rounded-pill btn-dark w-100" ng-click="changePassword()">Change Password</button>
    </div>
</div>
<div id="member-profile" class="vw-100 vh-100 position-absolute top-0 left-0" style="z-index: -10;">
    <div class="d-flex justify-content-center align-items-center w-100 h-100" id="scroll-container">
      <div class="rounded-5 overflow-hidden opacity-100 bg-secondary position-relative" style="width: 540px; height: 80vh;">
        <div class="overflow-hidden">

          <div id="upper-container" class="position-absolute top-0 p-4" style="width: 100%;">
            <div class="d-flex text-white justify-content-between">
              <div class="d-flex align-items-center">
                <span class="fw-bold fs-4 me-2">@{{invited_member.username}}, @{{invited_member.age}}</span> <i class="fa fa-circle text-success" style="font-size: 7px;"></i>
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
            <div class="w-100 h-100">
              <img ng-src="@{{invited_member.gallery[0].name}}" class="profile-image w-100 h-100 object-fit-cover" alt="member-photo" ng-click="show_photoes(invited_member.gallery[0].name,all_photoes)"/>
            </div>
            <div class="">
              <div class="p-4">
                <div class="text-secondary fw-bold">About me</div>
                <div class="fs-5 fw-bold mt-2">
                  @{{invited_member.about}}
                </div>
              </div>
              <div class="p-4">
                <div class="text-secondary fw-bold">@{{invited_member.username}}'s info</div>
                <div class="mt-2 row g-2">
                  <span class="col-auto tag-color rounded-pill p-2 mx-1"><i class="fa-solid fa-ruler-vertical"></i> @{{invited_member.height}}</span>
                  <span class="col-auto tag-color rounded-pill p-2 mx-1"><i class="fa fa-graduation-cap"></i> @{{invited_member.education}} </span>
                  <span class="col-auto tag-color rounded-pill p-2 mx-1"><i class="fa fa-hands-praying"></i> @{{invited_member.religion_name}} </span>
                  <span class="col-auto tag-color rounded-pill p-2 mx-1"><i class="fa fa-briefcase"></i> @{{invited_member.work}} </span>
                </div>
              </div>
              <div class="mb-2" ng-repeat="photo in invited_member.gallery">
                <div class="w-100 h-100" style="padding-left: vw;">
                  <img ng-if="$index != 0" ng-src="@{{photo.name}}" class="profile-image w-100 h-100 object-fit-cover" alt="member-photo" ng-click="show_photoes(photo.name,photoes)"/>
                </div>
              </div>

              <div class="p-4">
                <div class="text-secondary fw-bold">Current location</div>
                <div class="fs-5 fw-bold mt-2">@{{invited_member.city.name}}</div>
              </div>
              <div class="p-4" style="margin-bottom: 70px;">
                    <div class="text-secondary fw-bold">Verification</div>
                    <div class="mt-2" ng-show="member.status == {{getMemberVerifiedStatus()}}"><i class="fa fa-certificate fs-5 me-2 text-primary"></i><span class="fs-5 fw-bold">@{{invited_member.username}} is photo verified</span></div>
                    <div class="mt-2" ng-show="member.status != {{getMemberVerifiedStatus()}}"><span class="fs-5 fw-bold">@{{invited_member.username}} is not photo verified</span></div>
                </div>
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
        @include('frontend.include-files.purchase_point')
        <header class="article-container-header d-flex justify-content-between">
            <span class="article-container-title" style="font-size: 26px">
            Profile
            </span>
            <div class=" justify-content-center">
                <div class="flex align-items-center" style="font-size: 20px;">
                    <i class="fa fa-sign-out fs-3" style="margin-right: 5px; vertical-align: middle; cursor: pointer;" title="logout" ng-click="logout()"></i>
                    <i class="fa fa-key" style="margin-right: 5px; vertical-align: middle; cursor: pointer;" title="change password" data-bs-toggle="offcanvas" data-bs-target="#offcanvasChangePassword"></i>
                    <button class="icon-button" onclick="showProfile()">
                        <i class="fa fa-user fs-4" title="edit details" id="offcanvas_profile_btn" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" style="vertical-align: middle;"></i>
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
                <div class="mt-5">
                <div class="row">
                    <p class="">  
                        <button type="button" class="btn active" data-bs-toggle="button" aria-pressed="true"
                        style="border-radius: 20px; width: 450px; height: 70px; margin-left: 35px;">
                        <img style="width: 30px; height: 30px; margin-right: 5px;" src = "{{ url('assets/images/frontend/heart.png') }}">
                        Take Control and Personalize Your Settings
                        <img style="width: 30px; height: 30px; margin-left: 35px ;" src = "{{ url('assets/images/frontend/chevron.png') }}">
                        </button> 
                    </p>
                </div>
                </div>

                <div class="mt-1">
                <div class="row">
                    <div class="col-md-6" style="text-align: center;">
                    <a style="font-weight: bold;"> Plans</a>
                    </div>
                    <div class="col-md-6" style="text-align: center;">
                    <a href="safty.html" style="font-weight: bold;">Safty</a>
                </div>    
                </div>
            </div>

            <div class="mt-1">
                <div class="row">
                    <div class="col-md-6">
                    <img style="width: 80px; height: 70px; margin-left: 80px;" src = "{{ url('assets/images/frontend/tachometer.png') }}">
                    <div>
                        <p style="font-size: smaller; margin-left: 100px; margin-bottom: 1px;">Activity </p>
                        <span style="font-size: large; color: red; margin-left: 90px;">
                            Average</span>
                    </div> 
                    </div>
                    <div class="col-md-6">
                    <img style="width: 50px; height: 50px; margin-left: 100px; margin-top: 15px;" src = "{{ url('assets/images/frontend/heart1.png') }}">
                    <div>
                    <p style="font-size: smaller; margin-left: 105px; margin-bottom: 1px; margin-top: 10px;">Credit</p>
                    <span style="font-size: large; margin-left: 115px;">
                        50</span>
                    </div> 
                </div>    
                </div>
            </div>
            
            <div class="mt-1">
                <div class="row">
                <div class="card w-100 mb-3" style="background-color: lightgray;">
                    <div class="card-body">
                    <h5 class="card-title" style="text-align: center;">Point Purchase</h5>
                    <p class="card-text" style="text-align: center;">Want to request dating to more users? Purchase the points</p>
                    <button class="btn d-block mx-auto cursor-pointer" style="background-color: #e9d8ff;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasPurchase" aria-controls="offcanvasPurchase">
                        Click Here to Purchase Points
                    </button>
                    </div>
                    </div>
                </div>
            </div>
            
            <hr>
            <div class="mt-1">
                <div ng-if="member.accepted_members.length == 0">
                    <p class="fs-3">No Invitations Yet!</p>
                </div>
                <table class="table" ng-if="member.accepted_members.length > 0">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 300px;">Who invited you?</th>
                            <th scope="col" style="width: 100px;">View User</th>
                            <th scope="col" style="width: 50px; text-align: center;">Accept</th>
                            <th scope="col" style="width: 50px; text-align: center;">Decline</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="invitor in member.accepted_members">
                            <td ng-if="invitor.status == 0">
                                <img style="width: 25px; height: 25px; margin-right: 5px;" src="{{ url('assets/images/frontend/heart1.png') }}">
                                <span>@{{invitor.details.username}}</span>
                            </td>
                            <td>
                                <button class="btn btn-white rounded-pill text-dark" ng-click="showInvitorDetails(invitor.invite_id)">
                                    <i class="fa fa-eye" style="text-shadow: 0 0 10px rgb(0,0,0)"></i>
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-white rounded-pill text-dark" ng-click="respondInvitation('accept',invitor.details.id,invitor.details.username)">
                                    <i class="fa fa-check" style="text-shadow: 0 0 10px rgb(0,0,0)"></i>
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-white rounded-pill text-dark" ng-click="respondInvitation('decline',invitor.details.id,invitor.details.username)">
                                    <i class="fa fa-times" style="text-shadow: 0 0 10px rgb(0,0,0)"></i>
                                </button>
                            </td>
                        </tr>
                       
                    </tbody>
                </table>
                <div class="text-center mb-2" ng-if="last_page > 1">
                    <button class="btn btn-sm btn-secondary" ng-disabled="page == 1" ng-click="firstPage()">
                        <i class="fa fa-chevron-left"></i><i class="fa fa-chevron-left"></i>
                    </button>
                    <button class="btn btn-sm btn-secondary" ng-disabled="page == 1" ng-click="prevPage()">
                        <i class="fa fa-chevron-left"></i>
                    </button>
                    <span class="btn btn-sm btn-primary">@{{page}}</span>
                    <button class="btn btn-sm btn-secondary" ng-disabled="page == last_page" ng-click="nextPage()">
                        <i class="fa fa-chevron-right"></i>
                    </button>
                    <button class="btn btn-sm btn-secondary" ng-disabled="page == last_page" ng-click="lastPage()">
                        <i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i>
                    </button>
                </div>
            </div>
            
            </div>
        </section>
        @include('frontend.layouts.template_profile_footer')
    </article>
</div>
@endsection
@section('javascript')
<!-- sweetalert2 -->
<script src="{{ url('assets/js/sweetalert2/sweetalert2.all.js') }}"></script>
<script src="{{ url('assets/js/frontend/profile.js?v=20240716') }}"></script>
<script src="{{ url('assets/js/frontend/bootstrap.bundle.min.js') }}"></script>

<!-- pnotify -->
<script src="{{ url('assets/js/pnotify/pnotify.js') }}"></script>

<script>
    function showProfile(){
        document.querySelector('body').style.backgroundColor = "#e9d8ff";
    }

    $(document).ready(function() {
        let today_date = new Date();
        let last_18_years_ago;
        if(today_date.getFullYear()%4 == 0 && today_date.getMonth() == 1 && today_date.getDate() == 29){
            last_18_years_ago = new Date(today_date.getFullYear()-18, today_date.getMonth(), today_date.getDate()-1);
        }
        else{
            last_18_years_ago = new Date(today_date.getFullYear()-18, today_date.getMonth(), today_date.getDate());
        }

        $("#date_of_birth").datepicker({
            changeYear : true,
            changeMonth : true,
            dateFormat: 'yy-mm-dd',
            maxDate:last_18_years_ago,
            yearRange: "-60:+0"
        });
    });

    function upload(value){
        $('#file'+value).click();
    }

    function fileupload(value){
    const fileInput =document.getElementById('file'+value);
	const fileContainer = document.getElementById('preview'+value);
    const inputContainer =document.getElementById('input_container'+value);

    let files = fileInput.files;
    let fileName =fileInput.value;
    let allowedExtensions = ['jpeg','jpg','png','gif'];

    let extension = fileName.split('.').pop().toLowerCase();
    if(allowedExtensions.indexOf(extension)<0){
        alert("Only jpeg, jpg, png and gif files are allowed");
        inputContainer.innerHTML = `<input type="file" style="display: none;" id="file${value}" name="file${value}" onchange="fileupload(${value})"/>`;
        $("#upload" + value).show();
        $("#label" + value).hide();
        $("#image" + value).hide();
        if(value != 1){
            $("#trash" + value).attr("style", "display: none !important;");
        }
    }
    else if (files.length > 0) {
        let file = files[0];

        let reader = new FileReader();

        reader.onload = function(e) {
            let imageLink = e.target.result;
            $("#upload" + value).hide();
            $("#label" + value).show();
            $("#image" + value).show();
            $("#image" + value).attr("src",e.target.result);
            if(value != 1){
                $('#trash' + value).show();
            }
        }

        reader.readAsDataURL(file);
    }

    if($("#file1").val() == "" && $("#file2").val() == "" && $("#file3").val() == "" && $("#file4").val() == "" && $("#file5").val() == "" && $("#file6").val() == ""){
        $("#uploadButton").prop("disabled",true);
    }
    else{
        $("#uploadButton").prop("disabled",false);
    }
	};

    const getProfile        = document.getElementById('profile-content');
    const getScrollBar      = document.getElementById('profile-scroll-bar-value');
    const footerMenu        = document.querySelectorAll("footer button");

    getProfile.addEventListener('scroll',function(e){
        let percent = Math.round((getProfile.scrollTop/(getProfile.scrollHeight-getProfile.clientHeight))*100);
        percent     = percent * 3/4;
        getScrollBar.style.top = `${percent}%`;
    });
    function choosePhoto(){
        $('#screenshot').click();
    }

	function showPhoto(){
		const fileInput     	= document.getElementById('screenshot');
		const fileContainer 	= document.getElementById('file-container');
		const previewElement 	= document.getElementById('preview');
		let files 				= fileInput.files;
		let fileName 			=fileInput.value;
		let allowedExtensions 	= ['jpeg','jpg','png','gif','webp'];

		let extension = fileName.split('.').pop().toLowerCase();
		if(allowedExtensions.indexOf(extension)<0){
			new PNotify({
            	title: 'Oh No!',
            	text: 'Only JPG,JPEG,PNG and GIF files are accepted',
            	type: 'error',
            	styling: 'bootstrap3'
        	});
			fileContainer.innerHTML = `<input type="file" name="screenshot" id="screenshot" onchange="showPhoto()" hidden/>`;
			previewElement.style.border = "1px solid gray";
			previewElement.innerHTML = `
										<div class="cursor-pointer position-absolute top-50 start-50 translate-middle" onclick="choosePhoto()">Upload</div>`;
		}
		else if (files.length > 0) {
			let file = files[0];

			let reader = new FileReader();

			reader.onload = function(e) {
				let imageLink = e.target.result;
				previewElement.innerHTML = `<img src=${imageLink} class='img-thumb rounded-lg' alt='preview image' width=100% onclick="choosePhoto()"/>`;
				previewElement.style.border = "none";
				previewElement.style.display = '';
			}
			reader.readAsDataURL(file);
		}
	};
    @if ($errors->has('screenshot'))
        new PNotify({
            title: 'Oh No!',
            text: "{{$errors->first('screenshot')}}",
            type: 'error',
            styling: 'bootstrap3'
        });
    @endif
</script>
@endsection