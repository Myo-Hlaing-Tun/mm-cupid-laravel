@extends('backend.master')
@section('subtitle','Point Logs')
@section('content')
<div class="right_col" role="main">
    <div class="">
        <div class="row" style="display: block;">
            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Point Logs</h2>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">

                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead class="text-center">
                            <tr class="headings">
                            <th class="column-title">Point Buyer</th>
                            <th class="column-title">Added Point</th>
                            <th class="column-title">Purchase Id</th>
                            <th class="column-title">Screenshot</th>
                            <th class="column-title">Added User</th>
                          </tr>
                        </thead>

                        <tbody class="text-center">
                            @foreach ($point_logs as $log)
                            <tr class="even pointer">
                                <td class="align-middle">{{ $log->getMembersByPointLog->username}}</td>
                                <td class="align-middle">{{ $log->added_point}}</td>
                                <td class="align-middle">{{ $log->purchase_id}}</td>
                                <td class="align-middle">
                                    <img src="{{ url('storage/purchases/'. $log->getPurchaseDetailsByPointLog->member_id . '/' .$log->getPurchaseDetailsByPointLog->screenshot)}}" alt="screenshot" width="75px" height="100px"/>
                                </td>
                                <td class="align-middle">{{ $log->getUserByPointLog->username}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                      </table>
                      <div style="float: right;">
                        {{ $point_logs->links('pagination::bootstrap-4') }}
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection