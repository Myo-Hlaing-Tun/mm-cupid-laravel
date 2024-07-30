@extends('backend.master')
@section('subtitle','Show Hobbies')
@section('content')
<div class="right_col" role="main">
    <div class="">
        <div class="row" style="display: block;">
            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Hobbies List</h2>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">

                <!-- <p>Add class <code>bulk_action</code> to table for bulk actions options on row select</p> -->

                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead class="text-center">
                            <tr class="headings">
                            <th class="column-title">Id</th>
                            <th class="column-title">Hobby Name</th>
                            <th class="column-title">Actions</th>
                            <th class="bulk-actions" colspan="7">
                                <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                            </th>
                          </tr>
                        </thead>

                        <tbody class="text-center">
                            @foreach ($hobbies as $hobby)
                            <tr class="even pointer">
                                <td class="align-middle">{{ $hobby->id }}</td>
                                <td class="align-middle">{{ $hobby->name }}</td>
                                <td class="align-middle">
                                    <a href="{{ url('admin-backend/hobby/edit/' . $hobby->id )}}" class="btn btn-success"><i class="fa fa-pencil">  Edit Hobby</i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                      </table>
                    </div>	
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection