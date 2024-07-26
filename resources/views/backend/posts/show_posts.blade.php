@extends('backend.master')
@section('subtitle','Show Posts')
@section('content')
<div class="right_col" role="main">
    <div class="">
        <div class="row" style="display: block;">
            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                <div class="x_title">
                    <h2>Posts List</h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    <!-- <p>Add class <code>bulk_action</code> to table for bulk actions options on row select</p> -->

                    <div class="table-responsive">
                        @if(count($posts) > 0)
                        <table class="table table-striped jambo_table bulk_action">
                            <thead class="text-center">
                                <tr class="headings">
                                <th>
                                    <input type="checkbox" id="check-all" class="flat">
                                </th>
                                <th class="column-title">Id</th>
                                <th class="column-title">Thumb</th>
                                <th class="column-title">Title</th>
                                <th class="column-title">Description</th>
                                <th class="column-title">Actions</th>
                                <th class="bulk-actions" colspan="7">
                                    <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                </th>
                            </tr>
                            </thead>

                            <tbody class="text-center">
                                @foreach ($posts as $post)
                                <tr class="even pointer">
                                    <td class="a-center align-middle">
                                        <input type="checkbox" class="flat" name="table_records">
                                    </td>
                                    <td class="align-middle">{{ $post->id }}</td>
                                    <td class="align-middle">
                                        <img src="{{ url('storage/posts/'. $post->id . '/thumb/' .$post->thumb) }}" width=100px alt="company logo" />
                                    </td>
                                    <td class="align-middle">{{ $post->title }}</td>
                                    <td class="align-middle">{{ $post->description }}</td>
                                    <td class="align-middle">
                                        <a href="{{ url('admin-backend/post/edit/'. $post->id )}}" class="btn btn-success"><i class="fa fa-pencil">  Edit Post</i></a>
                                        <a href="javascript:void(0)" class="btn btn-danger" onclick="confirmDelete({{ $post->id }})"><i class="fa fa-trash">  Delete Post</i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                            <h3>There is no post</h3>
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
            const url = "{{ route('post.delete', 'id')}}".replace('id',+id);
            Swal.fire({
                title: "Are you sure?",
                text: "You are about to delete this post!",
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
    </script>
@endsection