var myApp = angular.module("myApp", []);

myApp.controller("MyController", function ($scope, $http) {
  $scope.init = function (id) {
    const data = {};
    $scope.page = 1;
    data.page = $scope.page;
    data.id   = id;
    $scope.syncLoginMember(data);
    $scope.username   = $("#username").val();
    $scope.phone      = $("#phone").val();
    $scope.education  = $("#education").val();
    $scope.about      = $("#about").val();
    $scope.work       = $("#work").val();
    $scope.getCities();
    $scope.getHobbies();
    $("#date_of_birth").prop('readonly',true);
    $scope.process_error = false;
    $scope.streaming = false;
  };

  $scope.logout = function(){
    Swal.fire({
      title: "Log Out?",
      text: "Do you want to log out?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, log out!"
      }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = base_url + "/logout";
      }
    });
  }
  
  $scope.showInvitorDetails = function(index){
    $("#profile-content").scrollTop(0);
    $("#profile").css("z-index", 5);
    $("#member-profile").css("z-index", 10);
    $("#member-profile").css("background-color", "rgba(0,0,0,0.5)");

    const data = {};
    data.id = index;

    $(".loading").show();
    const url = base_url + "/api/sync_login_member";
    $http({
      method: "POST",
      url: url,
      data: data,
    }).then(
      function (response) {
        if (response.status == 200) {
          $scope.invited_member = response.data.data;
          $scope.all_photoes    = [];
          for(let i=0; i<$scope.invited_member.gallery.length; i++){
            $scope.all_photoes.push($scope.invited_member.gallery[i].name);
          }
          $(".loading").hide();
        }
        else if(response.data.status == 403){
          new PNotify({
            title: 'Oh No!',
            text: message.A009,
            type: 'error',
            styling: 'bootstrap3'
          });
        }
      },
      function (error) {
        console.log(error);
      }
    );
  }

  $scope.show_photoes = function (target,all_photoes){
    const body              = document.querySelector('body');
    const getCarousel       = document.querySelector(".carousel-inner");
    const currentPage       = document.querySelector("#current-page");
    const carouselWrapper   = document.querySelector("#carousel-wrapper");
    carouselWrapper.style.zIndex = '20';
    carouselWrapper.classList.remove('opacity-0');

    let index = $scope.all_photoes.indexOf(target);
    for (let x = 0; x < $scope.all_photoes.length; x++) {
        let img = document.createElement('img');
        let div = document.createElement('div');
        if (x == 0) {
            div.className = "carousel-item active";
            img.src = target;
            currentPage.innerHTML = index+1 + ' of '+ $scope.all_photoes.length;
        } else {
            div.className = "carousel-item";
            let indexOf = index;
            indexOf += x;
            if (indexOf >= $scope.all_photoes.length) {
                indexOf = indexOf - $scope.all_photoes.length;
            };
            img.src =  $scope.all_photoes[indexOf];
        }
        img.className = "d-block vh-100 object-fit-cover w-100";
        img.alt = "profile-photo";
        img.style.width = "10%";
        div.appendChild(img);
        getCarousel.appendChild(div);
        body.classList.remove('overflow-x-hidden');
        body.classList.add('overflow-hidden');
    }
  }

  $scope.displayCurrentPage = (btn) => {
    const currentPage       = document.querySelector("#current-page");
    let activeCarouselItem = document.querySelector('.carousel-item.active');
    let image = activeCarouselItem.querySelector('img');
    let imageSrc = image.getAttribute('src');
    let currentImageIndex = $scope.all_photoes.indexOf(imageSrc);

    btn == 'next' ? currentImageIndex++ : currentImageIndex--;
    if(currentImageIndex >= $scope.all_photoes.length){
        currentImageIndex = 0;
    }else if( currentImageIndex < 0 ){
        currentImageIndex = $scope.all_photoes.length-1;
    }
    currentPage.innerHTML = currentImageIndex+1 + ' of '+ $scope.all_photoes.length;
  }

  $scope.cancel_profile = function(){
    $("#member-profile").css("z-index", -10);
    $("#member-profile").css("background-color", "");
    $("#image-content").css("z-index", 10);
  }

  $scope.stop_image_view = function(){
    const body              = document.querySelector('body');
    const carouselWrapper   = document.querySelector("#carousel-wrapper");
    const getCarousel       = document.querySelector(".carousel-inner");

    body.classList.remove('overflow-hidden');
    body.classList.add('overflow-x-hidden');
    carouselWrapper.style.zIndex = -20;
    getCarousel.innerHTML = '';
    carouselWrapper.classList.add('opacity-0');
  }

  $scope.respondInvitation = function(response,id,user){
    Swal.fire({
      title: "Confirmation!",
      text: `Are you sure to ${response} ${user}?`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: `Yes, ${response} it!`
      }).then((result) => {
      if (result.isConfirmed) {
        $(".loading").show();
        const data = {};
        data['response'] = response;
        data['id'] = id;

        const url = base_url + "/api/invitation/respond";
        $http({
          method: "POST",
          url: url,
          data: data,
        }).then(
          function (response) {
            if (response.status == 200) {
              $(".loading").hide();
              const data  = {};
              data.id     = response.data.id;
              $scope.syncLoginMember(data);
            }
          },
          function (error) {
            console.log(error);
          }
        );
      }
    });
  }

  $scope.firstPage = function(){
    const data = {};
    $scope.page = 1;
    data.page = $scope.page;
    $scope.syncLoginMember(data);
  }

  $scope.prevPage = function(){
    const data = {};
    $scope.page = $scope.page - 1;
    data.page = $scope.page;
    $scope.syncLoginMember(data);
  }

  $scope.nextPage = function(){
    const data = {};
    $scope.page = $scope.page + 1;
    data.page = $scope.page;
    $scope.syncLoginMember(data);
  }

  $scope.lastPage = function(){
    const data = {};
    $scope.page = $scope.last_page;
    data.page = $scope.page;
    $scope.syncLoginMember(data);
  }

  $scope.syncLoginMember = function(data){
    $(".loading").show();
    $scope.member = {};
    const url = base_url + "/api/sync_login_member";
    $http({
      method: "POST",
      url: url,
      data: data,
    }).then(
      function (response) {
        if (response.status == 200) {
          // $scope.last_page = response.data.last_page;
          $scope.member = response.data.data;
          $scope.showPhoto($scope.member.gallery);

          $("#" + $scope.member.gender_name).prop("checked", true);
          $scope.religion = $scope.member.religion + "";

          if($scope.member.partner_gender == 1){
            $("#pmale").prop("checked",true);
          }
          else if($scope.member.partner_gender == 2){
            $("#pfemale").prop("checked",true);
          }
          else{
            $("#pboth").prop("checked",true);
          }

          $scope.min_age = $scope.member.partner_min_age;
          $scope.max_age = $scope.member.partner_max_age;

          $scope.selected_min_age = $scope.min_age + "";
          $scope.selected_max_age = $scope.max_age + "";
          $scope.min_ages_arr = [];
          $scope.max_ages_arr = [];
          for(let i=18; i<=$scope.max_age; i++){
            $scope.min_ages_arr.push(i);
          }
          for(let i=$scope.min_age; i<=55; i++){
            $scope.max_ages_arr.push(i);
          }

          $(".loading").hide();
        }
      },
      function (error) {
        console.log(error);
      }
    );
  }

  $scope.showPhoto = function (images) {
    for (let i = 0; i < images.length; i++) {
      const sort = images[i].sort;
      const image = images[i].name;
      $('#image'+sort).attr('src', image);
      $("#image"+sort).show();
      $("#label"+sort).show();

      if(sort == 1){
        $("#upload1").hide();
      }
      else{
        $("#upload"+sort).hide();
        $("#trash"+sort).show();
      }
    }
  };

  $scope.getCities = function(){
    const get_url = base_url + "/api/getCities";
    $http.get(get_url)
      .then(function (response) {
        if (response.status == 200) {
          $scope.cities = response.data.data;
        }
      });
  }

  $scope.getHobbies = function(){
    const get_url = base_url + "/api/getHobbies";
    $http.get(get_url)
      .then(function (response) {
        if (response.status == 200) {
          $scope.hobbies = response.data.data;
        }
      });
  }

  $scope.validate = function(){
    $scope.error_msg_username = "";
    $scope.error_msg_phone = "";
    $scope.error_msg_edu = "";
    $scope.error_msg_about = "";
    $scope.error_msg_work = "";
    $scope.error_msg_hobby = "";
    $scope.process_error = false;
    if($scope.username == ""){
      $scope.error_msg_username = message.A001 + " username";
      $scope.process_error = true;
    }
    if($scope.phone == ""){
      $scope.error_msg_phone = message.A001 + " your phone";
      $scope.process_error = true;
    }
    if($scope.education == ""){
      $scope.error_msg_edu = message.A001 + " your education";
      $scope.process_error = true;
    }
    if($scope.about == ""){
      $scope.error_msg_about = "Please tell me about yourself";
      $scope.process_error = true;
    }
    if($scope.work == ""){
      $scope.error_msg_work = message.A001 + " your work";
      $scope.process_error = true;
    }

    const hobbies_arr    = [];
    $('input[name="hobbies[]"]:checked').each(function(){
      hobbies_arr.push($(this).val());
    });
    $scope.hobbies_arr = hobbies_arr;
    if($scope.hobbies_arr.length == 0){
      $scope.error_msg_hobby = message.A002 + " your hobby";
      $scope.process_error = true;
    }
  }

  $scope.showForm = function(){
    for(let i =0; i< $scope.hobbies.length; i++){
      $scope.hobbies[i].checked = false;
    }
    for(let i =0; i<$scope.member.member_hobbies.length; i++){
      $scope.hobbies[$scope.member.member_hobbies[i].id-1].checked = true;
    }
  }

  $scope.closeForm = function () {
    $("#offcanvas_profile_btn").click();
  };

  $scope.closeVideo = function(){
    $scope.stopCamera();
    $(".photo-btn").hide();
    $("#openCamera").show();
    $("#video").hide();
    $("#photo").hide();

    $scope.closeForm();
  }

  $scope.chooseMinAge = function(){
    $scope.selected_min_age = $("#min_age").val();
    $scope.max_ages_arr = [];
    for(let i=$scope.selected_min_age; i<=55; i++){
      $scope.max_ages_arr.push(i);
    }
  }

  $scope.chooseMaxAge = function(){
    $scope.selected_max_age = $("#max_age").val();
    $scope.min_ages_arr = [];
    for(let i=18; i<=$scope.selected_max_age; i++){
      $scope.min_ages_arr.push(i);
    }
  }

  $scope.updateDetails = function(){
    const data = {};
    data.username       = $("#username").val();
    data.phone          = $("#phone").val();
    data.date_of_birth  = $("#date_of_birth").val();
    data.height_feet    = $("#height_feet").val();
    data.height_inches  = $("#height_inches").val();
    data.city           = $("#city").val();
    data.education      = $("#education").val();
    data.about          = $("#about").val();
    data.work           = $("#work").val();
    data.gender         = $('input[name="gender"]:checked').val();
    data.min_age        = $("#min_age").val();
    data.max_age        = $("#max_age").val();
    data.pgender        = $('input[name="pgender"]:checked').val();
    data.religion       = $("#religion").val();
    data.hobbies_arr    = [];
    $('input[name="hobbies[]"]:checked').each(function(){
      data.hobbies_arr.push($(this).val());
    });
    const url = base_url + "/api/member/edit";
    Swal.fire({
        title: "Are you sure to edit your details?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, change details!"
    }).then((result) => {
        if (result.isConfirmed) {
          $http({
            method: "POST",
            url: url,
            data: data,
          }).then(
            function (response) {
              if (response.status == 200) {
                // $scope.last_page = response.data.last_page;
                $scope.member = response.data.data;
                $scope.showPhoto($scope.member.gallery);
      
                $("#" + $scope.member.gender_name).prop("checked", true);
                $scope.religion = $scope.member.religion + "";
      
                if($scope.member.partner_gender == 1){
                  $("#pmale").prop("checked",true);
                }
                else if($scope.member.partner_gender == 2){
                  $("#pfemale").prop("checked",true);
                }
                else{
                  $("#pboth").prop("checked",true);
                }
      
                $scope.min_age = $scope.member.partner_min_age;
                $scope.max_age = $scope.member.partner_max_age;
      
                $scope.selected_min_age = $scope.min_age + "";
                $scope.selected_max_age = $scope.max_age + "";
                $scope.min_ages_arr = [];
                $scope.max_ages_arr = [];
                for(let i=18; i<=$scope.max_age; i++){
                  $scope.min_ages_arr.push(i);
                }
                for(let i=$scope.min_age; i<=55; i++){
                  $scope.max_ages_arr.push(i);
                }
      
                $(".loading").hide();
                $("#offcanvas_profile_btn").click();
              }
            },
            function (error) {
              console.log(error);
            }
          );
        }
    });
  }

  $scope.uploadPhotos = function(){
    $(".loading").show();
    for(let i=1; i<=6; i++){
      let input = $("#file"+i)[0];
      if(input.files.length > 0 && input.files){
        let filename = input.files[0].name;
        let fileExtension = filename.split(".").pop().toLowerCase();
        let allowedExtensions = ['jpg','jpeg','png','gif'];
        if(allowedExtensions.indexOf(fileExtension)>=0){
            let formData = new FormData();
            formData.append('file'+i, input.files[0]);
            // formData.append('sort',i);
        const url = base_url + "/api/photo/update";
        Swal.fire({
            title: "Are you sure to change your photos?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, change photos!"
        }).then((result) => {
            if (result.isConfirmed) {
              $http.post( url, formData, {
                headers: { 'Content-Type': undefined },
                // transformRequest: angular.identity
              }).then(function(response) {
                  if(response.data.status == 200){
                    $scope.init();
                    $(".loading").hide();
                    $("#close-btn").click();
                  }
              }).catch(function(error) {
                  console.log('Error:', error);
              });
            }
            else{
              $('.loading').hide();
            }
        });
        }
        else{
          alert("Only JPEG,JPG,PNG and GIF files are allowed");
        }
      }
    }
  }

  $scope.deletePhoto = function(sort){
    Swal.fire({
      title: "Are you sure to delete this photo?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
      }).then((result) => {
      if (result.isConfirmed) {
        $(".loading").show();
        let data = {};
        data['sort'] = sort;
        const url = base_url + "/api/photo/delete";
        $http({
          method: "POST",
          url: url,
          data: data,
        }).then(
          function (response) {
            if (response.data.status == 200) {
              $("#upload" + sort).show();
              $("#label" + sort).hide();
              $("#image" + sort).hide();
              $("#trash" + sort).attr("style", "display: none !important;");
              $(".loading").hide();
            }
          },
          function (error) {
            console.log(error);
          }
        );
      }
    });
  }

  $scope.openCamera = function(){
    const video = document.getElementById('video');

    $(".photo-btn").hide();
    $("#takePhoto").show();
    $("#video").show();
    $("#photo").hide();

    navigator.mediaDevices.getUserMedia({ video: true, audio: false })
    .then(function(stream) {
        $scope.stream = stream;
        video.srcObject = stream;
        video.play();
        $scope.streaming = true;
    })
    .catch(function(err) {
        console.log("An error occurred: " + err);
    });
  }

  $scope.takePhoto = function(){
    const canvas = document.getElementById('canvas');
    const photo = document.getElementById('photo');

    if (!$scope.streaming) {
      alert('Camera not opened yet!');
      return;
    }else{
      $(".photo-btn").hide();
      $("#submit").show();
      $("#reset").show();

      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;
      canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
      photo.src = canvas.toDataURL('image/png');
      $("#photo").show();
      $("#video").hide();
    }
  }

  $scope.reset = function(){
    $scope.openCamera();
  }

  $scope.submit = function(){
    $(".loading").show();
    const data = {};
    const image_src = $("#photo").attr('src');
    data['src'] = image_src;

    const url = base_url + "/api/photo/verify";
    $http({
        method: 'POST',
        url: url,
        data: data,
    }).then(function (response) {
        if(response.data.status == 200){
          $(".loading").hide();
          Swal.fire({
            title: "Successful",
            text: "Your Photo Is Successfully Uploaded For Verification!",
            icon: "success",
            showCancelButton: false,
            confirmButtonColor: "#3085d6",
          }).then((result) => {
            if (result.isConfirmed) {
              $("#Profile").click();
            }
          });
        }
    },function(error){
        console.log(error);
    });
  }

  $scope.stopCamera = function(){
    if($scope.streaming){
      $scope.stream.getTracks().forEach(track => track.stop());
    }
    $scope.streaming = false;
  }

  $scope.changePassword = function(){
    $scope.error    = false;
    $scope.oldpassword      = $('#oldpassword').val();
    $scope.newpassword      = $('#newpassword').val();
    $scope.confirmpassword  = $('#confirmpassword').val();
    if($scope.oldpassword == ''){
      $scope.error = true;
      new PNotify({
        title: 'Oh No!',
        text: message.A001 + " your old password",
        type: 'error',
        styling: 'bootstrap3'
      });
    }
    if($scope.newpassword == ''){
      $scope.error = true;
      new PNotify({
        title: 'Oh No!',
        text: message.A001 + " your new password",
        type: 'error',
        styling: 'bootstrap3'
      });
    }
    if($scope.confirmpassword == ''){
      $scope.error = true;
      new PNotify({
        title: 'Oh No!',
        text: message.A001 + " confirm password",
        type: 'error',
        styling: 'bootstrap3'
      });
    }
    if($scope.newpassword != $scope.confirmpassword){
      $scope.error = true;
      new PNotify({
        title: 'Oh No!',
        text: 'Password and confirm password do not match',
        type: 'error',
        styling: 'bootstrap3'
      });
    }
    if(!$scope.error){
      $(".loading").show();
      const data = {};
      data.oldpassword      = $scope.oldpassword;
      data.newpassword      = $scope.newpassword;
      data.confirmpassword  = $scope.confirmpassword;
      const url = base_url + "/api/changePassword";
      $http({
        method: "POST",
        url: url,
        data: data,
      }).then(
        function (response) {
          if (response.status == 200) {  
            $(".loading").hide();
          }
        },
        function (error) {
          console.log(error);
        }
      );
    }
  }
});
