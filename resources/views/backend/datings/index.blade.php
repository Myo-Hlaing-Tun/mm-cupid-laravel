@extends('backend.master')
@section('subtitle','Approved Dating Requests')
@section('content')
<div class="right_col" role="main">
    <div class="">
        <div class="row" style="display: block;">
            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Approved Datings List</h2>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">

                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead class="text-center">
                            <tr class="headings">
                            <th class="column-title">Invitor</th>
                            <th class="column-title">Invitor phone</th>
                            <th class="column-title">Acceptor</th>
                            <th class="column-title">Acceptor phone</th>
                            <th class="column-title">Action</th>
                          </tr>
                        </thead>

                        <tbody class="text-center">
                            @foreach ($requests as $request)
                            <tr class="even pointer">
                                <td class="align-middle">{{ $request->invite_id}}</td>
                                <td class="align-middle">{{ $request->getMemberByInviteId->phone}}</td>
                                <td class="align-middle">{{ $request->accept_id}}</td>
                                <td class="align-middle">{{ $request->getMemberByAcceptId->phone}}</td>
                                <td class="align-middle">
                                    <a href="{{ url('admin-backend/dating/details/' . $request->invite_id . "/" . $request->accept_id)}}" class="btn btn-primary d-block"><i class="fa fa-eye">  View Members Details</i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                      </table>
                      <div style="float: right;">
                        {{ $requests->links('pagination::bootstrap-4') }}
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