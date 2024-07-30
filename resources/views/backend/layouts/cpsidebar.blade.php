<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="{{ url('admin-backend/index')}}" class="site_title d-flex align-items-center justify-content-around">
              <img src="{{ url('assets/images/cupid-32x32.png')}}" alt="" class="rounded-circle" width="30px">
              <span>MM Cupid</span>
            </a>
          </div>

          <div class="clearfix"></div>

          <!-- menu profile quick info -->
          <div class="profile clearfix">
            <div class="profile_pic">
              <img src="{{ url('assets/images/admin.png')}}" alt="admin" class="img-circle profile_img">
            </div>
            <div class="profile_info">
              <span>Welcome</span>
              <h2>{{ Auth::guard('admin')->user()->username}}</h2>
            </div>
          </div>
          <!-- /menu profile quick info -->

          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <ul class="nav side-menu">
                <li><a href="{{ url('admin-backend/index')}}"><i class="fa fa-home"></i> Home</a></li>
                <li style="display: {{showPermission((string) 'admin-backend/user') }}">
                  <a>
                    <i class="fa fa-user-secret"></i> User Management <span class="fa fa-chevron-down"></span>
                  </a>
                  <ul class="nav child_menu">
                    <li><a href="{{ url('admin-backend/user/create')}}">Create</a></li>
                    <li><a href="{{ url('admin-backend/user/index')}}">Show Users</a></li>
                  </ul>
                </li>
              </ul>
              <ul class="nav side-menu">
                <li style="display: {{showPermission((string) 'admin-backend/city') }}">
                  <a><i class="fa fa-building">                    
                    </i> City Management <span class="fa fa-chevron-down"></span>
                  </a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('admin-backend/city/create')}}">Create City</a></li>
                      <li><a href="{{ url('admin-backend/city/index')}}">Show Cities</a></li>
                    </ul>
                </li>
              </ul>
              <ul class="nav side-menu">
                <li style="display: {{showPermission((string) 'admin-backend/hobby') }}">
                  <a>
                    <i class="fa fa-futbol-o"></i> Hobby Management <span class="fa fa-chevron-down"></span>
                  </a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('admin-backend/hobby/create')}}">Create Hobby</a></li>
                      <li><a href="{{ url('admin-backend/hobby/index')}}">Show Hobbies</a></li>
                    </ul>
                </li>
              </ul>
              <ul class="nav side-menu">
                <li style="display: {{showPermission('admin-backend/member') }}">
                  <a href="{{ url('admin-backend/member/index')}}"><i class="fa fa-user"></i> Member Management</a>
                </li>
              </ul>
              <ul class="nav side-menu">
                  <li style="display: {{showPermission('admin-backend/post') }}">
                    <a>
                      <i class="fa fa-pencil-square-o"></i> Post Management <span class="fa fa-chevron-down"></span>
                    </a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('admin-backend/post/create')}}"> Create Post</a></li>
                      <li><a href="{{ url('admin-backend/post/index')}}"> Show Posts</a></li>
                    </ul>
                  </li>
              </ul>
              <ul class="nav side-menu">
                <li style="display: {{showPermission('admin-backend/pointpurchase') }}">
                  <a href="{{ url('admin-backend/pointpurchase/index')}}"><i class="fa fa-database"></i> Point Purchase Management</a>
                </li>
              </ul>
              <ul class="nav side-menu">
                <li style="display: {{showPermission('admin-backend/point') }}">
                  <a href="{{ url('admin-backend/point/log')}}"><i class="fa fa-history"></i> Point Logs</a>
                </li>
              </ul>
              <ul class="nav side-menu">
                <li style="display: {{showPermission('admin-backend/dating') }}">
                  <a href="{{ url('admin-backend/dating/index')}}"><i class="fa fa-heartbeat"></i> Approved Dating Requests Management</a>
                </li>
              </ul>
              <ul class="nav side-menu">
                <li style="display: {{showPermission((string) 'admin-backend/setting') }}">
                  <a href="{{ url('admin-backend/setting/index')}}"><i class="fa fa-gear"></i> Setting</a></li>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>