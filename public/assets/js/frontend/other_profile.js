var myApp = angular.module("myApp", []);

myApp.controller("MyController", function ($scope, $http) {
  $scope.init = function (id) {
    const data  = {};
    data.id     = id;
    $scope.syncLoginMember(data);
  };

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
          $scope.all_photoes    = [];
          for(let i=0; i<$scope.member.gallery.length; i++){
            $scope.all_photoes.push($scope.member.gallery[i].name);
          }
          $(".loading").hide();
        }
      },
      function (error) {
        console.log(error);
      }
    );
  }
  $scope.showDetails = function(){
    $("#profile-content").scrollTop(0);
    $("#profile").css("z-index", 5);
    $("#member-profile").css("z-index", 10);
    $("#member-profile").css("background-color", "rgba(0,0,0,0.5)");
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
});
