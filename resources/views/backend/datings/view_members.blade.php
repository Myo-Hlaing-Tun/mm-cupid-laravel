@extends('backend.master')
@section('subtitle','Members Details')
@section('content')
<div class="right_col" role="main">
    <button class="btn btn-primary"><a href="{{ url('admin-backend/dating/index')}}" class="text-white"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back To Datings List</a></button>
	<div class="">
        <div class="container my-5">
            <div class="row">
                <div class="col-md-4">
                    <span style="font-size: 1.5rem;">Verification Photo</span>
                    @if ($accept_member->verify_photo == null)
                        <span class="d-block mt-3" style="font-size: 1.5rem;">No Verification Photo Yet</span>
                    @else
                        <img src="{{ $accept_member->verify_photo}}" width=100% class="my-4" alt="screenshot"/>
                        @if($accept_member->status == getMemberPendingPhotoVerificationStatus())
                        <a href="javascript:void(0)" class="btn btn-success d-block" onclick="confirmMember({{ $accept_member->id}})"><i class="fa fa-check">  Admin Confirm</i></a>
                        @endif
                    @endif
                </div>
                <div class="col-md-8 rounded shadow mt-4" style="padding-left: 50px;">
                    <h2 class="text-center display-4">Accept Member Details</h2>
                    <div class="mt-4">
                        <span style="font-size: 1.5rem;">Username - </span>
                        <span style="font-size: 1.5rem;">{{ $accept_member->username}}</span>
                    </div>
                    <div class="mt-4">
                        <span style="font-size: 1.5rem;">Email - </span>
                        <span style="font-size: 1.5rem;">{{ $accept_member->email}}</span>
                    </div>
                    <div class="mt-4">
                        <span style="font-size: 1.5rem;">Phone - </span>
                        <span style="font-size: 1.5rem;">{{ $accept_member->phone}}</span>
                    </div>
                    <div class="mt-4">
                        <span style="font-size: 1.5rem;">Gender - </span>
                        <span style="font-size: 1.5rem;">{{ $accept_member->gender_name}}</span>
                    </div>
                    <div class="mt-4">
                        <span style="font-size: 1.5rem;">Status - </span>
                        <span style="font-size: 1.5rem;" class="p-2 rounded">
                            @if($accept_member->status == getMemberRegisteredStatus())
                            Email Unconfirmed
                            @elseif($accept_member->status == getMemberEmailVerifiedStatus())
                            Email Confirmed
                            @elseif($accept_member->status == getMemberPendingPhotoVerificationStatus())
                            Pending Photo Verification
                            @elseif($accept_member->status == getMemberRejectPhotoVerificationStatus())
                            Failed Photo Verification
                            @elseif($accept_member->status == getMemberVerifiedStatus())
                            Photo Verified
                            @elseif($accept_member->status == getMemberBannedStatus())
                            Banned
                            @endif
                        </span>
                    </div>
                    <div class="mt-4">
                        <span style="font-size: 1.5rem;">Interested Partner Gender - </span>
                        <span style="font-size: 1.5rem;">{{ $accept_member->partner_gender_name}}</span>
                    </div>
                    <div class="mt-4">
                        <span style="font-size: 1.5rem;">Interested Partner Age - </span>
                        <span style="font-size: 1.5rem;">Between {{$accept_member->partner_min_age}} and {{$accept_member->partner_max_age}}</span>
                    </div>
                    <div class="my-4">
                        <span style="font-size: 1.5rem;">Remaining Points - </span>
                        <span style="font-size: 1.5rem;">{{ $accept_member->point}}</span>
                    </div>
                </div>
                <div class="col"></div>
            </div>
        </div>
    </div>
    <div class="">
        <div class="container my-5">
            <div class="row">
                <div class="col-md-4">
                    <span style="font-size: 1.5rem;">Verification Photo</span>
                    @if ($invite_member->verify_photo == null)
                        <span class="d-block mt-3" style="font-size: 1.5rem;">No Verification Photo Yet</span>
                    @else
                        <img src="{{ $invite_member->verify_photo}}" width=100% class="my-4" alt="screenshot"/>
                        @if($accept_member->status == getMemberPendingPhotoVerificationStatus())
                        <a href="javascript:void(0)" class="btn btn-success d-block" onclick="confirmMember({{ $accept_member->id}})"><i class="fa fa-check">  Admin Confirm</i></a>
                        @endif
                    @endif
                </div>
                <div class="col-md-8 rounded shadow mt-4" style="padding-left: 50px;">
                    <h2 class="text-center display-4">Invite Member Details</h2>
                    <div class="mt-4">
                        <span style="font-size: 1.5rem;">Username - </span>
                        <span style="font-size: 1.5rem;">{{ $invite_member->username}}</span>
                    </div>
                    <div class="mt-4">
                        <span style="font-size: 1.5rem;">Email - </span>
                        <span style="font-size: 1.5rem;">{{ $invite_member->email}}</span>
                    </div>
                    <div class="mt-4">
                        <span style="font-size: 1.5rem;">Phone - </span>
                        <span style="font-size: 1.5rem;">{{ $invite_member->phone}}</span>
                    </div>
                    <div class="mt-4">
                        <span style="font-size: 1.5rem;">Gender - </span>
                        <span style="font-size: 1.5rem;">{{ $invite_member->gender_name}}</span>
                    </div>
                    <div class="mt-4">
                        <span style="font-size: 1.5rem;">Status - </span>
                        <span style="font-size: 1.5rem;" class="p-2 rounded">
                            @if($invite_member->status == getMemberRegisteredStatus())
                            Email Unconfirmed
                            @elseif($invite_member->status == getMemberEmailVerifiedStatus())
                            Email Confirmed
                            @elseif($invite_member->status == getMemberPendingPhotoVerificationStatus())
                            Pending Photo Verification
                            @elseif($invite_member->status == getMemberRejectPhotoVerificationStatus())
                            Failed Photo Verification
                            @elseif($invite_member->status == getMemberVerifiedStatus())
                            Photo Verified
                            @elseif($invite_member->status == getMemberBannedStatus())
                            Banned
                            @endif
                        </span>
                    </div>
                    <div class="mt-4">
                        <span style="font-size: 1.5rem;">Interested Partner Gender - </span>
                        <span style="font-size: 1.5rem;">{{ $invite_member->partner_gender_name}}</span>
                    </div>
                    <div class="mt-4">
                        <span style="font-size: 1.5rem;">Interested Partner Age - </span>
                        <span style="font-size: 1.5rem;">Between {{$invite_member->partner_min_age}} and {{$invite_member->partner_max_age}}</span>
                    </div>
                    <div class="my-4">
                        <span style="font-size: 1.5rem;">Remaining Points - </span>
                        <span style="font-size: 1.5rem;">{{ $invite_member->point}}</span>
                    </div>
                </div>
                <div class="col"></div>
            </div>
        </div>
    </div>
    <button class="btn btn-success" onclick="confirm({{ $dating_id }})"><a href="javascript:void(0)" class="text-white"><i class="fa fa-check" aria-hidden="true"></i> Mark as Contacted</a></button>
</div>
@endsection
@section('javascript')
<script>
    function confirmMember(id){
        const url = "{{ route('member.confirm', 'id') }}".replace('id', +id);
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, confirm this member!"
            }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }
    function confirm(id){
        const url = "{{ route('dating.approve', 'id') }}".replace('id', +id);
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, approve this dating!"
            }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }
</script>
@endsection