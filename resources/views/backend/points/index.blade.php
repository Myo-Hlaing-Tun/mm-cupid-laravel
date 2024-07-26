@extends('backend.master')
@section('subtitle','Points Purchase')
@section('content')
<div class="right_col" role="main">
    <div class="">
        <div class="row" style="display: block;">
            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Members List</h2>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">

                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead class="text-center">
                            <tr class="headings">
                            <th>
                                <input type="checkbox" id="check-all" class="flat">
                            </th>
                            <th class="column-title">Username</th>
                            <th class="column-title">Phone</th>
                            <th class="column-title">Screenshot</th>
                            <th class="column-title">Actions</th>
                            <th class="bulk-actions" colspan="10">
                                <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                            </th>
                          </tr>
                        </thead>

                        <tbody class="text-center">
                            @foreach ($members as $member)
                            <tr class="even pointer">
                                <td class="a-center align-middle">
                                    <input type="checkbox" class="flat" name="table_records">
                                </td>
                                <td class="align-middle">{{ $member->getMemberByMemberId->username}}</td>
                                <td class="align-middle">{{ $member->getMemberByMemberId->phone}}</td>
                                <td class="align-middle">
                                    <img src="{{ $member->screenshot_path}}" alt="screenshot" width="75px" height="100px"/>
                                </td>
                                <td class="align-middle">
                                    <a href="{{ url('admin-backend/pointpurchase/' . $member->member_id)}}" class="btn btn-primary d-block"><i class="fa fa-eye">  View Details</i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                      </table>
                      <div style="float: right;">
                        {{ $members->links('pagination::bootstrap-4') }}
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
@section('javascript')
    
@endsection