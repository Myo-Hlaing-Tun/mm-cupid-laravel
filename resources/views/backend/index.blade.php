@extends('backend.master')
@section('subtitle','Admin Dashboard')
@section('content')
<div class="right_col" role="main">
  <div class="">
    <div class="row" style="display: inline-block;">
    <div class="top_tiles">
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-users"></i></div>
          <div class="count">{{ $total_registered_count}}</div>
          <h3>Total Registered Members</h3>
        </div>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-user-plus"></i></div>
          <div class="count">{{ $today_registered_count}}</div>
          <h3>Today Registered Members</h3>
        </div>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-user"></i></div>
          <div class="count">{{ $today_email_confirmed_count}}</div>
          <h3>Today Email Confirmed Members</h3>
        </div>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-heart"></i></div>
          <div class="count">{{ $today_date_requests_count}}</div>
          <h3>Today Date Requests Total</h3>
        </div>
      </div>
    </div>
  </div>

    <div class="row">
      <div class="col-md-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Registration Summary <small>Monthly progress</small></h2>
            <div class="filter">
            </div>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="col-md-9 col-sm-12 ">
              <div class="demo-container" style="height:280px">
                <div id="chart_plot_02" class="demo-placeholder"></div>
              </div>
              <!-- <div class="tiles">
                <div class="col-md-4 tile">
                  <span>Total Sessions</span>
                  <h2>231,809</h2>
                  <span class="sparkline11 graph" style="height: 160px;">
                        <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                  </span>
                </div>
                <div class="col-md-4 tile">
                  <span>Total Revenue</span>
                  <h2>$231,809</h2>
                  <span class="sparkline22 graph" style="height: 160px;">
                        <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                  </span>
                </div>
                <div class="col-md-4 tile">
                  <span>Total Sessions</span>
                  <h2>231,809</h2>
                  <span class="sparkline11 graph" style="height: 160px;">
                          <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                  </span>
                </div>
              </div> -->

            </div>

            <div class="col-md-3 col-sm-12" id="scrollable">
              <div>
                <div class="x_title">
                  <h2>Top Profiles</h2>
                  <ul class="nav navbar-right panel_toolbox">
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <ul class="list-unstyled top_profiles scroll-view">
                  @foreach ($members as $member)
                    <li class="media event">
                      <a class="pull-left border-aero profile_thumb" style="border: none !important;">
                        <img src="{{ $member->thumb_path }}" alt="thumb" style="border-radius: 100%;" width="30px" height="30px" />
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">{{ $member->username}}</a>
                        <p>{{ $member->age }} years old</p>
                        <p>View Counts: {{ $member->view_count }}</p>
                      </div>
                    </li>
                  @endforeach
                </ul>
              </div>
            </div>

            <!-- <div class="col-md-7" style="overflow:hidden;">
              <span class="sparkline_one" style="height: 160px; padding: 10px 25px;">
                            <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                        </span>
              <h4 style="margin:18px">Weekly sales progress</h4>
            </div>
            </div> -->
        </div>
      </div>
    </div>
  </div>
</div>
@endsection