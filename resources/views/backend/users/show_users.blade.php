@extends('backend.master')
@section('subtitle','Show Users')
@section('content')
<div class="right_col" role="main">
    <div class="">
        <div class="row" style="display: block;">
            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                <div class="x_title">
                    <h2>Users List</h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                <!-- <p>Add class <code>bulk_action</code> to table for bulk actions options on row select</p> -->

                    <div class="table-responsive">
                        @if(count($users) > 0)
                        <table class="table table-striped jambo_table bulk_action">
                            <thead class="text-center">
                                <tr class="headings">
                                <th class="column-title">Id</th>
                                <th class="column-title">User Name</th>
                                <th class="column-title">Role</th>
                                <th class="column-title">Status</th>
                                <th class="column-title">Actions</th>
                                <th class="bulk-actions" colspan="7">
                                    <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                </th>
                            </tr>
                            </thead>

                            <tbody class="text-center">
                                @foreach ($users as $user)
                                <tr class="even pointer">
                                    <td class="align-middle">{{ $user->id }}</td>
                                    <td class="align-middle">{{ $user->username }}</td>
                                    <td class="align-middle">{{ $user->role_name }}</td>
                                    <td class="align-middle">
                                        @if($user->status_name == "Active")
                                            <span class='badge badge-success'>{{ $user->status_name }}</span>
                                        @else
                                            <span class="badge badge-danger">{{ $user->status_name }}</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ url('admin-backend/user/edit/'. $user->id )}}" class="btn btn-success"><i class="fa fa-pencil">  Edit User</i></a>
                                        <a href="{{ url('admin-backend/user/password/edit/'. $user->id )}}" class="btn btn-primary"><i class="fa fa-gear">  Change Password</i></a>
                                        <a href="javascript:void(0)" class="btn btn-danger" onclick="confirmDelete({{ $user->id }})"><i class="fa fa-trash">  Delete</i></a>
                                        @if($user->status_name == "Active")
                                        <a href="javascript:void(0)" class="btn btn-danger" onclick="confirmBan({{ $user->id }})"><i class="fa fa-ban"></i> Disable User</a>
                                        @else
                                        <a href="javascript:void(0)" class="btn btn-success" onclick="confirmUnban({{ $user->id }})"><i class="fa fa-unlock">  Enable User</i></a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                            <h3>There is no user</h3>
                        @endif
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
        function confirmDelete(id){
            const url = "{{ route('user.delete', 'id') }}".replace('id', +id);
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
        function confirmBan(id){
            const url = "{{ route('user.ban', 'id') }}".replace('id', +id);
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, ban this user!"
                }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
        function confirmUnban(id){
            const url = "{{ route('user.unban', 'id') }}".replace('id', +id);
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, unban this user!"
                }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
    </script>
@endsection