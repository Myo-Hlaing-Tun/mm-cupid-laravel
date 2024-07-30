@extends('backend.master')
@section('subtitle','Member Details')
@section('content')
<div class="right_col" role="main">
    <button class="btn btn-primary"><a href="{{ url('admin-backend/pointpurchase/index')}}" class="text-white"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back To Point Purchases</a></button>
    @foreach ($member->getPointPurchases as $purchase)
	<div class="">
        <div class="container my-5">
            <div class="row">
                <div class="col-md-4">
                    <a href="{{ url('/storage/purchases/'. $purchase->member_id . '/' . $purchase->screenshot)}}" target="_blank">
                        <img src="{{ url('/storage/purchases/'. $purchase->member_id . '/' . $purchase->screenshot)}}" width=100% class="my-4" alt="screenshot"/>
                    </a>
                </div>
                <div class="col-md-8 rounded shadow mt-4" style="padding-left: 50px;">
                    <h2 class="text-center display-4">Member Details</h2>
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
                    <form action="{{ route('point.confirm')}}" id="form" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $purchase->id}}"/>
                        <input type="number" name="point" id="point" class="w-100 p-3 rounded" placeholder="Enter Amount of Point to be Added"/>
                    </form>
                    <button class="d-block btn btn-dark rounded rounded-5 btn-lg mx-auto my-3 w-100" onclick="confirmPurchase()">
                        Confirm Purchase
                    </button>
                    <button class="d-block btn btn-danger rounded rounded-5 btn-lg mx-auto my-3 w-100" onclick="rejectPurchase({{ $purchase->id}})">Reject Purchase</button>
                </div>
                <div class="col"></div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
@section('javascript')
<script>
    @if ($errors->has('point'))
    new PNotify({
        title: 'Oh No!',
        text: "{{$errors->first('point')}}",
        type: 'error',
        styling: 'bootstrap3'
    });
    @endif
    function confirmPurchase(id){
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, confirm it!"
            }).then((result) => {
            if (result.isConfirmed) {
                $('#form').submit();
            }
        });
    }
    function rejectPurchase(id){
        const url = "{{ route('purchase.reject', 'id') }}".replace('id', +id);
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, reject it!"
            }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }
</script>
@endsection