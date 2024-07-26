<style>
    input[type=text], select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    }

    input[type=submit] {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    }

    input[type=submit]:hover {
    background-color: #45a049;
    }

    form {
    width: 50%;
    margin: 30px auto;
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
    }
</style>
<h1>Cities</h1>
<table border="1" style="border-collapse: collapse;">
    <tr>
        <th style="width: 200px;">City Id</th>
        <th style="width: 300px;">Name</th>
        <th style="width: 500px;">Members Name</th>
        <th style="width: 300px;">Actions</th>
    </tr>
    @foreach ($cities as $city)
        <tr>
            <td>{{$city->id}}</td>
            <td>{{$city['name']}}</td>
            <td>
                @if($city->getMembersByCities != null)
                    {{getMembersByCities($city->getMembersByCities)}}
                @endif
            </td>
            <td>
                <a href="{{url('student/edit/'.$city->id)}}">Edit</a>
                <a href="{{url('student/delete/'.$city->id)}}">Delete</a>
            </td>
        </tr>
    @endforeach
</table>

<hr/>

@if(isset($edit_city))
    <form action="{{route('form.post.update')}}" method="POST">
        <input type="hidden" name="id" value="{{$edit_city->id}}"/>
@else
    <form action="{{route('form.post.store')}}" method="POST">
@endif
    @csrf
        <label for="city">City Name</label>
        <input type="text" id="city" name="city" placeholder="Enter city name.." value="{{ old('city',isset($edit_city) ? $edit_city->name : '') }}">
        @if($errors->has('city'))
            <span style="color: red;">{{ $errors->first('city')}}</span>
        @endif

        <input type="submit" value="Submit"/>
    </form>

<h1>Members</h1>
<table border="1" style="border-collapse: collapse;">
    <tr>
        <th style="width: 200px;">Member Id</th>
        <th style="width: 300px;">Username</th>
        <th style="width: 300px;">City</th>
    </tr>
    @foreach ($members as $member)
        <tr>
            <td>{{$member->id}}</td>
            <td>{{$member['username']}}</td>
            <td>
                @if ($member->getCitiesByMember != null)
                    {{$member->getCitiesByMember->name}}
                @endif
            </td>
            <td>
                <a href="{{url('student/edit/'.$city->id)}}">Edit</a>
                <a href="{{url('student/delete/'.$city->id)}}">Delete</a>
            </td>
        </tr>
    @endforeach
</table>