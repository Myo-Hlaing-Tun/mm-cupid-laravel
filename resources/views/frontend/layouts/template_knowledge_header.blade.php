<header class="article-container-header d-flex justify-content-between" ng-if="!searchbox">
  <span class="article-container-title" style="font-size: 26px">
    Knowledge
  </span>
  <div class="d-flex justify-content-center align-items-center">
    <button class="icon-button bg-black justify-content-center me-1 d-flex align-items-center" style="height: 25px; width: 60px; border-radius: 100%/60px;">
      <i class="fa fa-usd me-1 text-dark rounded-circle bg-white" style="font-size: 12px;padding: 2px 5px;"></i>
      <span class=" text-white" style="font-size: 12px;">{{ Auth::guard('member')->user()->point }}</span>
    </button>
    <button class="icon-button" >
      <i class="fa fa-search fs-4 fw-bold" id="offcanvas_search_btn" ng-click="showSearch()"></i>
    </button>
  </div>
</header>
<header style="width: 100%; margin: 0 auto;" class="p-3" ng-if="searchbox">
  <div class="d-flex justify-content-between align-items-center">
    <input type="text" id="keyword" placeholder="What Do You Want To Search For?" class="rounded px-2 py-1" style="width: 93%;"/>
    <button class="icon-button" ng-click="searchPost()">
      <i class="fa fa-search fs-4 fw-bold" ng-click="searchPost()"></i>
    </button>
  </div>
</header>