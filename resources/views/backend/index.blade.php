@extends('backend.master')
@section('subtitle','Admin Dashboard')
@section('content')
<div class="right_col" role="main">
  <div class="">
    <div class="row" style="display: inline-block;">
    <div class="top_tiles">
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-check-square-o"></i></div>
          <div class="count">{{ $total_registered_count}}</div>
          <h3>Total Registered Members</h3>
        </div>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-caret-square-o-right"></i></div>
          <div class="count">{{ $today_registered_count}}</div>
          <h3>Today Registered Members</h3>
        </div>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-comments-o"></i></div>
          <div class="count">{{ $today_email_confirmed_count}}</div>
          <h3>Today Email Confirmed Members</h3>
        </div>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 ">
        <div class="tile-stats">
          <div class="icon"><i class="fa fa-sort-amount-desc"></i></div>
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
              <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="col-md-9 col-sm-12 ">
              <div class="demo-container" style="height:280px">
                <div id="chart_plot_02" class="demo-placeholder"></div>
              </div>
              <div class="tiles">
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
              </div>

            </div>

            <div class="col-md-3 col-sm-12" id="scrollable">
              <div>
                <div class="x_title">
                  <h2>Today Date Requests</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#">Settings 1</a>
                          <a class="dropdown-item" href="#">Settings 2</a>
                        </div>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <ul class="list-unstyled top_profiles scroll-view">
                  @if(count($today_date_requests) == 0)
                  <li>
                    <p>There is no request today.</p>
                  </li>
                  @endif
                  @foreach ($today_date_requests as $request)
                    <li class="media event">
                      <a class="pull-left border-aero profile_thumb">
                        <i class="fa fa-user aero"></i>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">{{ $request->getMemberByInviteId->username}}</a>
                        <p>Senting to {{ $request->getMemberByAcceptId->username}}</p>
                        <p>
                          @if ($request->status == getDatingStatus((string) 'sent'))
                          <small class="text-info">Pending</small>
                          @elseif($request->status == getDatingStatus((string) 'accepted'))
                          <small class="text-success">Accepted</small>
                          @elseif($request->status == getDatingStatus((string) 'rejected'))
                          <small class="text-danger">Rejected</small>
                          @endif
                        </p>
                      </div>
                    </li>
                  @endforeach
                </ul>
              </div>
            </div>

            <div class="col-md-7" style="overflow:hidden;">
              <span class="sparkline_one" style="height: 160px; padding: 10px 25px;">
                            <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                        </span>
              <h4 style="margin:18px">Weekly sales progress</h4>
            </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
    const base_url = "{{url('/')}}";
</script>
@endsection