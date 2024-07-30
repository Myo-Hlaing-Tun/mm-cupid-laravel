var myApp = angular.module("myApp", []);

myApp.controller("MyController", function ($scope, $http) {
    $scope.init = function () {
        $scope.page = 1;
        $scope.member = [];
        $scope.members = [];
        $scope.next = false;
        $scope.prev = false;
        $scope.is_search = false;

        $scope.all_genders = all_genders;
        $scope.partner_gender = selected_gender;
        $("#"+$scope.all_genders[$scope.partner_gender]).prop("checked",true);

        $scope.min_age = min_age + "";
        $scope.max_age = max_age + "";

        $scope.selected_minimum_age = $scope.min_age;
        $scope.selected_maximum_age = $scope.max_age;

        $scope.min_ages_array = [];
        $scope.max_ages_array = [];
        for(x=18; x<= $scope.max_age; x++){
            $scope.min_ages_array.push(x);
        }
        for(x=$scope.min_age; x<= 55; x++){
            $scope.max_ages_array.push(x);
        }
        const data = {
            page: $scope.page, 
            search_gender: $scope.partner_gender,
            search_min_age: $scope.min_age,
            search_max_age: $scope.max_age
        };
        $scope.sync_member(data);
    }

    $scope.sync_member = function(data){
        $(".loading").show();
        const url = base_url + "/api/sync-members";
        $http({
            method: 'POST',
            url: url,
            data: data,
        }).then(function (response) {
            if(response.status == 200){
                $scope.members = $scope.members.concat(response.data.data);
                $scope.isShowMore(response.data.meta);
                $(".loading").hide();
            }
        },function(error){
            $(".loading").hide();
                if(!error.data.success){
                    for(x in error.data.errors){
                        new PNotify({
                            title: 'Oh no!',
                            text: error.data.errors[x][0],
                            type: 'error',
                            styling: 'bootstrap3'
                        });
                    }
                }
        });
    }
    $scope.isShowMore = function(meta){
        let total   = meta.total;
        let offset  = $scope.page * meta.per_page;
        if(total <= offset){
            $scope.more_members = false;
        } 
        else{
            $scope.more_members = true;
        }
    }

    $scope.loadmore = function () {
        $scope.page++;
        const data = $scope.is_search ? {page: $scope.page, search_gender: $scope.partner_gender, search_min_age: $scope.selected_minimum_age, search_max_age: $scope.selected_maximum_age} : {page: $scope.page, search_gender: $scope.partner_gender};
        $scope.sync_member(data);
    }

    $scope.back_search_offcanvas = function(){
        $('#offcanvas_search_btn').click();
    }

    $scope.chooseMinAge = function () {
        $scope.min_age = $("#selected_min_age").val();
        $scope.max_ages_array = [];
        for(let x=$scope.min_age; x<= 55; x++){
            $scope.max_ages_array.push(x);
        }
    }

    $scope.chooseMaxAge = function () {
        $scope.max_age = $("#selected_max_age").val();
        $scope.min_ages_array = [];
        for(let x=18; x<= $scope.max_age; x++){
            $scope.min_ages_array.push(x);
        }
    }

    $scope.show_profile = function (index){
        $scope.member = $scope.members[index];
        console.log($scope.member.gallery);
        $("#profile-content").scrollTop(0);
        $("#image-content").css("z-index", 5);
        $(".carousel-inner").html("");
        $("#member-profile").css("z-index", 10);
        $("#member-profile").css("background-color", "rgba(0,0,0,0.5)");

        $scope.date_request_members = [];
        for(let i = 0; i<$scope.member.invited_members.length; i++){
            $scope.date_request_members.push($scope.member.invited_members[i].accept_id);
        }
        for(let i = 0; i<$scope.member.accepted_members.length; i++){
            $scope.date_request_members.push($scope.member.accepted_members[i].invite_id);
        }
        $scope.updateView($scope.member.id);

        $scope.all_photoes = [];
        $scope.other_photoes = [];
        for(let x=0; x< $scope.member.gallery.length; x++){
            $scope.all_photoes.push($scope.member.gallery[x].name);
            if(x==0){
                $scope.first_photo = $scope.member.gallery[x].name;
            }else{
                $scope.other_photoes.push($scope.member.gallery[x].name);
            }
        }
        $scope.member_id = index;
        if($scope.member_id <= 0){
            $scope.prev = true;
        }else{
            $scope.prev = false;
        }

        if($scope.member_id >= ($scope.members.length-1)){
            $scope.next = true;
        }else{
            $scope.next = false;
        }
    }

    $scope.updateView = function(member_id){
        $(".loading").show();
        const data = { id : member_id};
        const url = base_url + "/api/viewcount/update";
        $http({
            method: 'POST',
            url: url,
            data: data,
        }).then(function (response) {
            if(response.data.status == 200){
                $(".loading").hide();
            }
        },function(error){
            $(".loading").hide();
            if(!error.data.success){
                for(x in error.data.errors){
                    new PNotify({
                        title: 'Oh no!',
                        text: error.data.errors[x][0],
                        type: 'error',
                        styling: 'bootstrap3'
                    });
                }
            }
        });
    }

    $scope.date_request = function(id){
        Swal.fire({
            title: "Dating Request",
            text: "Do you want to request date?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, request!"
            }).then((result) => {
            if (result.isConfirmed) {
                $(".loading").show();
                const data = {};
                data.id = id;
                const url = base_url + "/api/date/request";
                $http({
                    method: 'POST',
                    url: url,
                    data: data,
                }).then(function (response) {
                    if(response.status == 200){
                        $(".loading").hide();
                        const returned_member = response.data.member;
                        $scope.members = $scope.members.map(obj => obj.id == returned_member.id ? returned_member : obj);
                        $("#point").text(response.data.point);
                        new PNotify({
                            title: 'Success!',
                            text: success_message['Z001'],
                            type: 'success',
                            styling: 'bootstrap3'
                        });
                        $scope.cancel_profile();
                    }
                },function(error){
                    $(".loading").hide();
                    if(!error.data.success){
                        for(x in error.data.errors){
                            new PNotify({
                                title: 'Oh no!',
                                text: error.data.errors[x][0],
                                type: 'error',
                                styling: 'bootstrap3'
                            });
                        }
                    }
                });
            }
        });
    }

    $scope.respondInvitation = function(response,id){
        $(".loading").show();
        const data = {};
        data['response'] = response;
        data['id'] = id;

        const url = base_url + "api/respond_invitation.php";
        $http({
            method: "POST",
            url: url,
            data: data,
        }).then(
            function (response) {
            if (response.data.status == 200) {
                $(".loading").hide();
            }
            },
            function (error) {
                console.log(error);
            }
        );
      }

    $scope.prev_profile = function(index){
        if($scope.member_id > 0){
            $scope.member_id--;
            $scope.show_profile($scope.member_id);
        }
    }

    $scope.next_profile = function(index){
        if($scope.member_id < ($scope.members.length-1)){
            $scope.member_id++;
            $scope.show_profile($scope.member_id);
        }
    }

    $scope.cancel_profile = function(index) {
        $("#member-profile").css("z-index", -10);
        $("#member-profile").css("background-color", "");
        $("#image-content").css("z-index", 10);
        $scope.member = {};
        // document.getElementById(`profile-${index}`).scrollIntoView({behavior: "smooth", block: "start"});
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

    $scope.stop_image_view = function() {
        const body              = document.querySelector('body');
        const carouselWrapper   = document.querySelector("#carousel-wrapper");
        const getCarousel       = document.querySelector(".carousel-inner");

        body.classList.remove('overflow-hidden');
        body.classList.add('overflow-x-hidden');
        carouselWrapper.style.zIndex = -20;
        getCarousel.innerHTML = '';
        carouselWrapper.classList.add('opacity-0');
    }

    $scope.select_new_gender = function(){
        let selected_value = $('input[name="gender"]:checked').val();
        $scope.partner_gender = selected_value;
        $('#offcanvas_search_btn').click();
    }

    $scope.select_new_ages = function () {
        let selected_min_age = $("#selected_min_age").val();
        let selected_max_age = $("#selected_max_age").val();
        $scope.selected_minimum_age = selected_min_age;
        $scope.selected_maximum_age = selected_max_age;
        $('#offcanvas_search_btn').click();
    }

    $scope.new_search = function(){
        $scope.page = 1;
        $scope.members = [];
        $scope.more_members = true;
        const data = {page: $scope.page, search_gender: $scope.partner_gender, search_min_age: $scope.selected_minimum_age, search_max_age: $scope.selected_maximum_age};
        $scope.sync_member(data);
        $("#close_btn").click();
        $scope.is_search = true;
    }
    $scope.view_details = function(){
        const id = $scope.member.id;
        const username = $scope.member.username.replace(/\s+/g, '-');
        window.location.href = base_url + "/user/" + username + "/" + id;
    }
})