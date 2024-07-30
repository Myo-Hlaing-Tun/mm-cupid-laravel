@extends('backend.master')
@section('subtitle','Members')
@section('content')
<div class="right_col" role="main">
    <div class="">
        <div class="row" style="display: block;">
            <div class="col-md-12 col-sm-12  ">
                <div class="float-right">
                    <div class="d-flex align-items-center">
                        <input type="text" name="keyword" id="keyword" class="form-control rounded" value="{{ isset($keyword) ? $keyword : ''}}" placeholder="Enter what you want to search for"/>
                        <button class="border-0 btn btn-lg" onclick="filterMembers()">
                            <i class="fa fa-search fs-5"></i>
                        </button>
                    </div>
                </div>
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
                            <th class="column-title">Username</th>
                            <th class="column-title">Email</th>
                            <th class="column-title">Phone</th>
                            <th class="column-title">Gender</th>
                            <th class="column-title">Birthday</th>
                            <th class="column-title">Status</th>
                            <th class="column-title">City</th>
                            <th class="column-title">Thumb</th>
                            <th class="column-title">Actions</th>
                            <th class="bulk-actions" colspan="10">
                                <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                            </th>
                          </tr>
                        </thead>

                        <tbody class="text-center">
                            @foreach ($members as $member)
                            <tr class="even pointer">
                                <td class="align-middle">{{ $member->username}}</td>
                                <td class="align-middle">{{ $member->email}}</td>
                                <td class="align-middle">{{ $member->phone}}</td>
                                <td class="align-middle">{{ $member->gender_name}}</td>
                                <td class="align-middle">{{ $member->date_of_birth}}({{ $member->age}})</td>
                                <td class="align-middle">
                                    @if($member->status == getMemberRegisteredStatus())
                                    <span class="badge badge-warning">Registered</span>
                                    @elseif($member-> status == getMemberEmailVerifiedStatus())
                                    <span class="badge badge-primary">Email Verified</span>
                                    @elseif($member->status == getMemberPendingPhotoVerificationStatus())
                                    <span class="badge badge-warning">Pending Photo Verification</span>
                                    @elseif($member->status == getMemberRejectPhotoVerificationStatus())
                                    <span class="badge badge-warning">Failed Photo Verification/span>
                                    @elseif($member->status == getMemberVerifiedStatus())
                                    <span class="badge badge-success">Photo Verified</span>
                                    @elseif($member->status == getMemberBannedStatus())
                                    <span class="badge badge-danger">Banned</span>
                                    @endif
                                </td>
                                <td class="align-middle">{{ getCityName((int) $member->city_id)}}</td>
                                <td class="align-middle"><img src="{{ $member->thumb_path}}" alt="thumb_image" width="75px" height="100px"/></td>
                                <td class="align-middle">
                                    <a href="javascript:void(0)" class="btn btn-danger d-block" onclick="deleteMember({{ $member->id}})"><i class="fa fa-trash">  Delete Member</i></a>
                                    @if($member->status == getMemberPendingPhotoVerificationStatus())
                                    <a href="javascript:void(0)" class="btn btn-success d-block" onclick="confirmMember({{ $member->id}})"><i class="fa fa-check">  Admin Confirm</i></a>
                                    @endif
                                    <a href="{{ url('admin-backend/member/' . $member->id)}}" class="btn btn-primary d-block"><i class="fa fa-eye">  View Details</i></a>
                                    <a href="{{ url('admin-backend/point/subtract/' . $member->id)}}" class="btn btn-info d-block" style="display: {{showPermission('admin-backend/point')}} !important"><i class="fa fa-diamond">  Point Management</i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                      </table>
                      <div class="float-right">
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
    <script>
        function deleteMember(id){
            const url = "{{ route('member.delete', 'id') }}".replace('id', +id);
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete this user!"
                }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
        function confirmMember(id){
            const url = "{{ route('member.confirm', 'id') }}".replace('id', +id);
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, confirm this user!"
                }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
        function filterMembers(){
            const keyword = document.getElementById('keyword').value;
            const url = "{{ url('/')}}" + "/admin-backend/member/filter/" +keyword;
            window.location.href = url;
        }
        @if ($errors->has('keyword'))
            new PNotify({
                title: 'Oh No!',
                text: "{{$errors->first('keyword')}}",
                type: 'error',
                styling: 'bootstrap3'
            });
        @endif
    </script>
@endsection