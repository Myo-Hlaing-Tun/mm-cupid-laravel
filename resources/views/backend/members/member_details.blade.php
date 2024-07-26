@extends('backend.master')
@section('subtitle','Member Details')
@section('content')
<div class="right_col" role="main">
	<div class="">
        <div class="container my-5">
            <button class="btn btn-primary"><a href="javascript:void(0)" onclick="window.history.back(); return false;" class="text-white"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back To All Members</a></button>
            <div class="row">
                @foreach ($member->getMemberGalleryByMember as $gallery)
                    <div class="col-2">
                        <a href="{{ url('/storage/member_images/'.$member->id.'/'.$gallery->name)}}" target="_blank">
                            <img src="{{ url('/storage/member_images/'.$member->id.'/'.$gallery->name)}}" width=100% height="150px" style="object-fit: cover;" class="my-4" alt="member_photo"/>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="">
                        @if($member->verify_photo != null)
                        <span style="font-size: 1.5rem;">Verification Photo</span>
                        <img src="{{ $member->verify_photo}}" width=100% class="my-4" alt="verify-photo">
                        @endif
                        @if($member->status == getMemberPendingPhotoVerificationStatus())
                        <a href="javascript:void(0)" class="btn btn-success d-block" onclick="confirmMember({{ $member->id}})"><i class="fa fa-check">  Admin Confirm</i></a>
                        @endif
                    </div>
                </div>
                @if ($member->verify_photo != null)
                <div class="col-md-8 rounded shadow mt-4" style="padding-left: 50px;">
                @else
                <div class="col-md-12 rounded shadow mt-4" style="padding-left: 50px;">
                @endif
                    <h2 class="display-4 text-center">Member Details</h2>
                    <div class="mt-4">
                        <span style="font-size: 1.5rem;">Username - </span>
                        <span style="font-size: 1.5rem;">{{ $member->username}}</span>
                    </div>
                    <div class="mt-4">
                        <span style="font-size: 1.5rem;">Email - </span>
                        <span style="font-size: 1.5rem;">{{ $member->email}}</span>
                    </div>
                    <div class="mt-4">
                        <span style="font-size: 1.5rem;">Phone - </span>
                        <span style="font-size: 1.5rem;">{{ $member->phone}}</span>
                    </div>
                    <div class="mt-4">
                        <span style="font-size: 1.5rem;">Gender - </span>
                        <span style="font-size: 1.5rem;">{{ $member->gender_name}}</span>
                    </div>
                    <div class="mt-4">
                        <span style="font-size: 1.5rem;">Date-of-birth - </span>
                        <span style="font-size: 1.5rem;">{{ $member->date_of_birth}}</span>
                    </div>
                    <div class="mt-4">
                        <span style="font-size: 1.5rem;">Age - </span>
                        <span style="font-size: 1.5rem;">{{ $member->age}}</span>
                    </div>
                    <div class="mt-4">
                        <span style="font-size: 1.5rem;">City - </span>
                        <span style="font-size: 1.5rem;">{{ getCityName((int) $member->city_id)}}</span>
                    </div>
                    <div class="mt-4">
                        <span style="font-size: 1.5rem;">Height - </span>
                        <span style="font-size: 1.5rem;">{{ $member->height}}</span>
                    </div>
                    <div class="mt-4">
                        <span style="font-size: 1.5rem;">Education - </span>
                        <span style="font-size: 1.5rem;">{{ $member->education}}</span>
                    </div>
                    <div class="mt-4">
                        <span style="font-size: 1.5rem;">About - </span>
                        <span style="font-size: 1.5rem;">{{ $member->about}}</span>
                    </div>
                    <div class="mt-4">
                        <span style="font-size: 1.5rem;">Work - </span>
                        <span style="font-size: 1.5rem;">{{ $member->work}}</span>
                    </div>
                    <div class="mt-4">
                        <span style="font-size: 1.5rem;">Religion - </span>
                        <span style="font-size: 1.5rem;">{{ $member->religion_name}}</span>
                    </div>
                    <div class="mt-4">
                        <span style="font-size: 1.5rem;">Hobbies - </span>
                        <span style="font-size: 1.5rem;">
                            {{getHobbies($member->getMemberHobbiesByMember)}}
                        </span>
                    </div>
                    <div class="mt-4">
                        <span style="font-size: 1.5rem;">Status - </span>
                        <span style="font-size: 1.5rem;" class="p-2 rounded">
                            @if($member->status == getMemberRegisteredStatus())
                            Email Unconfirmed
                            @elseif($member->status == getMemberEmailVerifiedStatus())
                            Email Confirmed
                            @elseif($member->status == getMemberPendingPhotoVerificationStatus())
                            Pending Photo Verification
                            @elseif($member->status == getMemberRejectPhotoVerificationStatus())
                            Failed Photo Verification
                            @elseif($member->status == getMemberVerifiedStatus())
                            Photo Verified
                            @elseif($member->status == getMemberBannedStatus())
                            Banned
                            @elseif($member->status == getMemberDatingStatus())
                            Dating
                            @endif
                        </span>
                    </div>
                    <div class="mt-4">
                        <span style="font-size: 1.5rem;">Interested Partner Gender - </span>
                        <span style="font-size: 1.5rem;">{{ $member->partner_gender_name}}</span>
                    </div>
                    <div class="mt-4">
                        <span style="font-size: 1.5rem;">Interested Partner Age - </span>
                        <span style="font-size: 1.5rem;">Between {{$member->partner_min_age}} and {{$member->partner_max_age}}</span>
                    </div>
                    <div class="my-4">
                        <span style="font-size: 1.5rem;">Remaining Points - </span>
                        <span style="font-size: 1.5rem;">{{ $member->point}}</span>
                    </div>
                </div>
                <div class="col"></div>
            </div>
        </div>
    </div>
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
            confirmButtonText: "Yes, confirm this user!"
            }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }
</script>
@endsection