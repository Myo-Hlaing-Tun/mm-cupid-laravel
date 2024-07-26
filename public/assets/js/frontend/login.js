var myApp = angular.module("myApp", []);

myApp.controller("MyController", function ($scope, $http) {
    $scope.data = {};

    $scope.alldefinitions = function(){
        $scope.email        = $('#email').val();
        $scope.password     = $('#password').val();
        $scope.email_exists = 1;
    }

    $scope.init = function () {
        $scope.alldefinitions();
        $scope.change();
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

    $scope.change = function () {
        $scope.alldefinitions();
        $scope.process_error = false;

        if ($scope.email == '') {
            $scope.process_error = true;
        }
        else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test($scope.email)) {
            $scope.process_error = true;
        }

        if ($scope.password == '') {
            $scope.process_error = true;
        }
        else  if ($scope.password.length < 8) {
            $scope.process_error = true;
        }
    }

    $scope.validate = function (field) {
        $scope.alldefinitions();
        const form_value = $('#' + field).val();
        if (form_value == '') {
            document.getElementById(`${field}`).focus();
            document.getElementById(`${field}`).scrollIntoView({behavior: "smooth"});
            switch (field) {
                case "email":
                    $scope.process_error = true;
                    $scope.error_msg_email = message.A001 + " your email";
                    break;
                case "password":
                    $scope.process_error = true;
                    $scope.error_msg_password = message.A001 + " your password";
                    break;
                default:
                    break;
            }
        } else {
            switch (field) {
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
                default:
                    break;
            }
        }
    }

    $scope.step1 = function () {
        $('#form').submit();
    }
})