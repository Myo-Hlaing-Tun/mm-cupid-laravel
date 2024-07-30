var myApp = angular.module("myApp", []);

myApp.controller("MyController", function ($scope, $http, $timeout) {
    $scope.ages_arr = [];
    $scope.min_ages_arr = [];
    $scope.max_ages_arr = [];
    $scope.user_photo = false;
    $scope.user_details = true;
    $scope.selectedhobbies = [];
    $scope.data = {};

    $scope.email_exists = '';

    $scope.alldefinitions = function(){
        $scope.username         = $('#username').val();
        $scope.email            = $('#email').val().trim();
        $scope.password         = $('#password').val();
        $scope.confirm_password = $('#confirm_password').val();
        $scope.phone            = $('#phone').val();
        $scope.gender           = $(".gender:checked").val();
        $scope.date_of_birth    = $('#date_of_birth').val();
        $scope.height_feet      = $('#height_feet').val();
        $scope.height_inch      = $('#height_inch').val();
        $scope.city             = $('#city').val();
        $scope.education        = $('#education').val();
        $scope.about            = $('#about').val();
        $scope.work             = $('#work').val();
        $scope.min_age          = $('#min_age').val();
        $scope.max_age          = $('#max_age').val();
        $scope.pgender          = $('.pgender:checked').val();
        $scope.religion         = $('#religion').val();
    }

    $scope.process_error = false;

    $scope.init = function () {
        for (let x = 18; x <= 55; x++) {
            $scope.ages_arr.push(x);
        }
        $scope.min_ages_arr = $scope.ages_arr;
        $scope.max_ages_arr = $scope.ages_arr;

        const get_url = base_url + "/api/getCities";
        $http.get(get_url)
            .then(function (response) {
                if (response.status == 200) {
                    $scope.cities = response.data.data;
                }
            });
        const hobby_url = base_url + "/api/getHobbies";
        $http.get(hobby_url)
            .then(function (response) {
                if (response.status == 200) {
                    $scope.hobbies = response.data.data;
                    for(let i =0; i< $scope.hobbies.length; i++){
                        $scope.hobbies[i].checked = false;
                    }
                    if($scope.selectedhobbies.length > 0){
                        for(let i =0; i<$scope.selectedhobbies.length; i++){
                            $scope.hobbies[$scope.selectedhobbies[i]].checked = true;
                        }
                    }
                }
            });
    }

    $scope.reveal = function (field) {
        $('#'+field).prop('type', 'text');
        $('#'+field+"_eye").removeClass('fa-eye-slash');
        $('#'+field+"_eye").addClass('fa-eye');
    }

    $scope.hide = function(field){
        $('#'+field).prop('type','password');
        $('#'+field+"_eye").removeClass('fa-eye');
        $('#'+field+"_eye").addClass('fa-eye-slash');
    }

    $scope.chooseMinAge = function () {
        $scope.min_age = $('#min_age').val();
        if ($scope.min_age != '') {
            $scope.max_ages_arr = [];
            for (let x = $scope.min_age; x <= 55; x++) {
                $scope.max_ages_arr.push(x);
            }
        } else {
            $scope.max_ages_arr = $scope.ages_arr;
        }
    }
    $scope.chooseMaxAge = function () {
        $scope.max_age = $('#max_age').val();
        if ($scope.max_age != '') {
            $scope.min_ages_arr = [];
            for (let x = 18; x <= $scope.max_age; x++) {
                $scope.min_ages_arr.push(x);
            }
        } else {
            $scope.min_ages_arr = $scope.ages_arr;
        }
    }

    $scope.change = function () {
        $scope.alldefinitions();
        $scope.process_error = false;

        if ($scope.username == '') {
            $scope.process_error = true;
        }
        if (!/[^\s]/.test($scope.username)){
            $scope.process_error = true;
        }
        if ($scope.email == '') {
            $scope.process_error = true;
        }
        else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test($scope.email)) {
            $scope.process_error = true;
        }
        if ($scope.password == '') {
            $scope.process_error = true;
        }
        else if($scope.confirm_password != "" && $scope.password == $scope.confirm_password){
            $scope.error_msg_confirmpassword = '';
        }
        if ($scope.confirm_password == '') {
            $scope.process_error = true;
        }
        else if ($scope.password != $scope.confirm_password) {
            $scope.process_error = true;
        }
        if ($scope.phone == '') {
            $scope.process_error = true;
        }
        if ($scope.gender == undefined) {
            $scope.process_error = true;
        }
        if ($scope.date_of_birth == '') {
            $scope.process_error = true;
        }
        else if (!/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/.test($scope.date_of_birth)) {
            $scope.process_error = true;
        }
        if ($scope.height_feet == "") {
            $scope.process_error = true;
        }
        if ($scope.height_inch == "") {
            $scope.process_error = true;
        }
        if ($scope.city == "") {
            $scope.process_error = true;
        }
        if ($scope.education == '') {
            $scope.process_error = true;
        }
        if ($scope.about == '') {
            $scope.process_error = true;
        }
        if ($scope.work == '') {
            $scope.process_error = true;
        }
        $scope.selectedhobby = false;

        for (let x = 0; x < $('#hobbies input').length; x++) {
            if ($('#hobbies input')[x].checked) {
                $scope.selectedhobby = true;
                break;
            }
        }
        if (!$scope.selectedhobby) {
            $scope.process_error = true;
        }
        if ($scope.min_age == "") {
            $scope.process_error = true;
        }
        if ($scope.max_age == "") {
            $scope.process_error = true;
        }
        if ($scope.pgender == undefined) {
            $scope.process_error = true;
        }
        if($scope.religion == ""){
            $scope.process_error = true;
        }

        if (!$scope.process_error) {
            $("#next_btn1").prop("disabled", false);
            document.getElementById('pole').style.width = "50%";
        } else {
            $("#next_btn1").prop("disabled", true);
            document.getElementById('pole').style.width = "0%";
        }
    }

    $scope.validate = function (field) {
        $scope.alldefinitions();
        const form_value = $('#' + field).val();
        if (form_value == '') {
            document.getElementById(`${field}`).focus();
            document.getElementById(`${field}`).scrollIntoView({behavior: "smooth"});
            switch (field) {
                case "username":
                    $scope.process_error = true;
                    $scope.error_msg_username = message.A001 + " username";
                    break;
                case "email":
                    $scope.process_error = true;
                    $scope.error_msg_email = message.A001 + " your email";
                    break;
                case "password":
                    $scope.process_error = true;
                    $scope.error_msg_password = message.A001 + " your password";
                    break;
                case "confirm_password":
                    $scope.process_error = true;
                    $scope.error_msg_confirmpassword = message.A001 + " confirm password";
                    break;
                case "phone":
                    $scope.process_error = true;
                    $scope.error_msg_phone = message.A001 + " your phone";
                    break;
                case "date_of_birth":
                    $scope.process_error = true;
                    $scope.error_msg_dob = message.A001 + " your birthday";
                    break;
                case "height_feet":
                    $scope.process_error = true;
                    $scope.error_msg_ft = message.A002 + " your height in feet";
                    break;
                case "height_inch":
                    $scope.process_error = true;
                    $scope.error_msg_in = message.A002 + " your height in inch";
                    break;
                case "city":
                    $scope.process_error = true;
                    $scope.error_msg_city = message.A001 + " your city";
                    break;
                case "education":
                    $scope.process_error = true;
                    $scope.error_msg_edu = message.A001 + " your education";
                    break;
                case "about":
                    $scope.process_error = true;
                    $scope.error_msg_about = message.A001 + " your bio";
                    break;
                case "work":
                    $scope.process_error = true;
                    $scope.error_msg_work = message.A001 + " your business";
                    break;
                case "min_age":
                    $scope.process_error = true;
                    $scope.error_msg_min_age = message.A002 + " your partner min age";
                    break;
                case "max_age":
                    $scope.process_error = true;
                    $scope.error_msg_max_age = message.A002 + " your partner max age";
                    break;
                case "religion":
                    $scope.process_error = true;
                    $scope.error_msg_religion = message.A002 + " your religion";
                    break;
                default:
                    break;
            }
        } else {
            switch (field) {
                case "username":
                    if(!/[^\s]/.test($scope.username)){
                        $scope.process_error = true;
                        $scope.error_msg_username = "Username must include at least one character";
                        break;
                    }
                    else{
                        $scope.error_msg_username = "";
                        break;
                    }
                case "email":
                    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test($scope.email)) {
                        $scope.process_error = true;
                        $scope.error_msg_email = "Invalid email format";
                        break;
                    } else {
                        $scope.error_msg_email = "";
                        break;
                    }
                case "password":
                    if ($scope.password.length < 8) {
                        $scope.process_error = true;
                        $scope.error_msg_password = "Password must be at least 8 in length";
                        break;
                    } else {
                        $scope.error_msg_password = "";
                        break;
                    }
                case "confirm_password":
                    if ($scope.password != $scope.confirm_password) {
                        $scope.process_error = true;
                        $scope.error_msg_confirmpassword = "Password and confirm password do not match";
                        break;
                    } else {
                        $scope.error_msg_confirmpassword = "";
                        break;
                    }
                case "phone":
                    $scope.error_msg_phone = "";
                    break;
                case "date_of_birth":
                    if (!/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/.test($scope.date_of_birth)) {
                        $scope.process_error = true;
                        $scope.error_msg_dob = "Birthday format must be in yyyy-mm-dd";
                    }else{
                        $scope.error_msg_dob = "";
                    }
                    break;
                case "height_feet":
                    $scope.error_msg_ft = "";
                    break;
                case "height_inch":
                    $scope.error_msg_in = "";
                    break;
                case "city":
                    $scope.error_msg_city = "";
                    break;
                case "education":
                    $scope.error_msg_edu = "";
                    break;
                case "about":
                    if($scope.about == ""){
                        $scope.process_error = true;
                        $scope.error_msg_about = message.A001 + " your bio";
                    }else{
                        $scope.error_msg_about = "";
                        break;
                    }
                case "work":
                    $scope.error_msg_work = "";
                    break;
                case "min_age":
                    $scope.error_msg_min_age = "";
                    break;
                case "max_age":
                    $scope.error_msg_max_age = "";
                    break;
                case "gender":
                    if ($scope.gender == undefined) {
                        $scope.process_error = true;
                        $scope.error_msg_gender = message.A002 + " your gender";
                    } else {
                        $scope.error_msg_gender = "";
                    }
                    break;
                case "selectedhobbies":
                    $scope.selectedhobby = false;
                    for (let x = 0; x < $('#hobbies input').length; x++) {
                        if ($('#hobbies input')[x].checked) {
                            $scope.selectedhobby = true;
                            break;
                        }
                    }
                    if (!$scope.selectedhobby) {
                        $scope.process_error = true;
                        $scope.error_msg_hobby = message.A002 + " your hobbies";
                    } else {
                        $scope.error_msg_hobby = "";
                    }
                    break;
                case "pgender":
                    if ($scope.pgender == undefined) {
                        $scope.process_error = true;
                        $scope.error_msg_pgender = message.A002 + " your partner gender";
                    } else {
                        $scope.error_msg_pgender = "";
                    }
                    break;
                case "religion":
                        $scope.error_msg_religion = "";
                        break;
                default:
                    break;
            }
        }
    }

    $scope.step1 = function () {
        if (!$scope.process_error) {
            const email_url = base_url + "/api/checkEmail/" + $scope.email;
            $(".loading").show();
            $http.get(email_url)
                .then(function (response) {
                    if (response.status == 200) {
                        $(".loading").hide();
                        $scope.email_exists = response.data;
                        if ($scope.email_exists == 1) {
                            $scope.process_error = true;
                            $scope.error_msg_email = $scope.email + " already exists";
                            $('#email').get(0).scrollIntoView();
                        }
                        if ($scope.process_error == false) {
                            $scope.selectedhobbies       = [];
                            $('.hobby:checked').each(function() {
                                if($(this).is(':checked')){
                                    $scope.selectedhobbies.push($(this).val());
                                }
                            });
                            $scope.user_photo = true;
                            $scope.user_details = false;
                        }
                    }
                });
        }
    }

    $scope.step2 = function() {
        $(".loading").show();
        let formData = new FormData();
        formData.append('username',$scope.username);
        formData.append('email',$scope.email);
        formData.append('password',$scope.password);
        formData.append('phone',$scope.phone);
        formData.append('date_of_birth',$scope.date_of_birth);
        formData.append('height_feet',$scope.height_feet);
        formData.append('height_inch',$scope.height_inch);
        formData.append('city',$scope.city);
        formData.append('education',$scope.education);
        formData.append('about',$scope.about);
        formData.append('work',$scope.work);
        formData.append('gender',$scope.gender);
        formData.append('hobbies',$scope.selectedhobbies);
        formData.append('min_age',$scope.min_age);
        formData.append('max_age',$scope.max_age);
        formData.append('pgender',$scope.pgender);
        formData.append('religion',$scope.religion);
        for(let i=1; i<=6; i++){
            let input = $("#file"+i)[0];
            if(input.files.length > 0 && input.files){
                formData.append('file'+i, input.files[0]);
            }
        }
        $scope.data.file = formData;
        const url = base_url + "/api/registerData";
            $http.post( url, formData, {
                headers: { 'Content-Type': undefined },
            }).then(function(response) {
                if(response.data.status == 200){
                    $(".loading").hide();
                    window.location.href = base_url + "/login?success=1";
                }
                else{
                    $(".loading").hide();
                    window.location.href = base_url + "/register";
                    new PNotify({
                        title: 'Oh no!',
                        text: "Member registration failed",
                        type: 'error',
                        styling: 'bootstrap3'
                    });
                }
            }).catch(function(error) {
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

    $scope.back = function() {
        $scope.user_photo = false;
        $scope.user_details = true;
        $scope.ages_arr = [];
        $scope.min_ages_arr = [];
        $scope.max_ages_arr = [];
        $scope.data = {};
        $scope.init();
        $scope.process_error = false;
        document.getElementById('pole').style.width = "50%";
        $timeout(
            function(){
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

                $('#next_btn1').prop('disabled',false);
            }
        ,1);
    }
})