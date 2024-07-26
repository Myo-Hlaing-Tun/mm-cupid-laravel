var myApp = angular.module("myApp", []);

myApp.controller("MyController", function ($scope, $http) {
    $scope.init = function(){
        return;
    }

    $scope.sendCode = function(){
        $(".loading").show();
        const url = base_url + "/api/send-code";
        let data = {};
        data['code'] = $scope.code;
        $http({
            method: 'POST',
            url: url,
            data: data,
        }).then(function(response) {
            if(response.data.status == 200){
                $(".loading").hide();
                let token = response.data.forget_password_token;
                window.location.href = base_url + "/new-password/" + token;
            }
            else{
                $(".loading").hide();
                window.location.href = base_url + "/forget-password?fail=1";
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
});