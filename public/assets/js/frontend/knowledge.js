var myApp = angular.module("myApp", []);

myApp.controller("MyController", function ($scope, $http, $sce ) {
    $scope.init = function(){
        $scope.postPage = 1;
        $scope.post = [];
        $scope.posts = [];
        $scope.prev = false;
        $scope.next = false;
        $scope.filteredPosts = [];
        $scope.searchbox = false;
        $scope.searchedPosts = false;

        const data = {page: $scope.postPage};
        $scope.getPosts(data);
    }

    $scope.getPosts = function(data){
        $(".loading").show();
        const url = base_url + "/api/posts/get";
        $http({
            method: 'POST',
            url: url,
            data: data,
        }).then(function (response) {
            if(response.status == 200){
                $scope.posts = $scope.posts.concat(response.data.data);
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
            $scope.more_posts = false;
        } 
        else{
            $scope.more_posts = true;
        }
    }

    $scope.loadmore = function(){
        $scope.postPage++;
        const data = {page: $scope.postPage};
        $scope.getPosts(data);
    }

    $scope.trustAsHtml = function(html) {
        return $sce.trustAsHtml(html);
    };

    $scope.show_post = function (index){
        $("#profile-content").scrollTop(0);
        $("#image-content").css("z-index", 5);
        $(".carousel-inner").html("");
        $("#member-profile").css("z-index", 10);
        $("#member-profile").css("background-color", "rgba(0,0,0,0.5)");

        $scope.post = $scope.posts[index];
        $scope.post_id = index;
        if($scope.post_id <= 0){
            $scope.prev = true;
        }else{
            $scope.prev = false;
        }

        if($scope.post_id >= ($scope.posts.length-1)){
            $scope.next = true;
        }else{
            $scope.next = false;
        }
    }

    $scope.cancel_profile = function(index) {
        $("#member-profile").css("z-index", -10);
        $("#member-profile").css("background-color", "");
        $("#image-content").css("z-index", 10);
        // document.getElementById(`profile-${index}`).scrollIntoView({behavior: "smooth", block: "start"});
    }

    $scope.prev_post = function(index){
        if($scope.post_id > 0){
            $scope.post_id--;
            $scope.show_post($scope.post_id);
        }
    }

    $scope.next_post = function(index){
        if($scope.post_id < ($scope.posts.length-1)){
            $scope.post_id++;
            $scope.show_post($scope.post_id);
        }
    }

    $scope.showSearch = function(){
        $scope.searchbox = true;
    }

    $scope.searchPost = function(){
        $scope.keyword = $("#keyword").val();
        $scope.filteredPosts = $scope.posts.filter(post=>{
            return post.title.toLowerCase().includes($scope.keyword.toLowerCase()) || post.description.toLowerCase().includes($scope.keyword.toLowerCase());
        });
        $scope.searchedPosts = true;

        // let regex = new RegExp($scope.keyword, 'gi');
        // for(let i=0; i<$scope.filteredPosts.length; i++){
        //     const getTitle = document.getElementById("filteredTitle-"+i);
        //     const getDesc  = document.getElementById("filteredDescription-"+i);

        //     let textContentTitle = getTitle.textContent;
        //     let textContentDesc  = getDesc.textContent;
        //     let newTitleHTML     = textContentTitle.replace(regex,function(matched){
        //         return `<span class="bg-success text-white p-2">` + matched + `</span>`;
        //     });
        //     let newDescHTML = textContentDesc.replace(regex,function(matched){
        //         return `<span class="bg-success text-white p-2">` + matched + `</span>`;
        //     })
        //     getTitle.innerHTML  = newTitleHTML;
        //     getDesc.innerHTML   = newDescHTML;
        // }
    }

    $scope.show_filtered_post = function(index){
        $scope.searchbox = false;
        $("#profile-content").scrollTop(0);
        $("#image-content").css("z-index", 5);
        $(".carousel-inner").html("");
        $("#member-profile").css("z-index", 10);
        $("#member-profile").css("background-color", "rgba(0,0,0,0.5)");

        $scope.post = $scope.filteredPosts[index];
        $("#prev").hide();
        $("#next").hide();
    }
})