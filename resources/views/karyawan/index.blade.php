@extends('layouts.main')
@section('content')
<div class="container">
    <h3>Data Karyawan</h3>
    <a href="{{ url('karyawan/create') }}" class="btn btn-outline-primary">+ Create Karyawan</a><br><br>

    @if(Session::has('status'))
        <p class="alert alert-{{ Session::get('alert-class', 'info') }}">{{ Session::get('status') }}</p>
    @endif

    <table class="table table-hover" style="text-align: center">
        <thead>
            <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Team</th>
            <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($getKaryawan as $getKaryawans)
            <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $getKaryawans['name'] }}</td>
            <td>{{ $getKaryawans['email'] }}</td>
            <td>{{ $getKaryawans['phone'] }}</td>
            <td>{{ $getKaryawans['team'] }}</td>
            <td><a href="{{ url('karyawan/edit', $getKaryawans['id']) }}" class="btn btn-warning btn-sm">✏️ Edit</a></td>
            <td>
                <form action="{{ action('KaryawanController@destroy', $getKaryawans['id']) }}" method="post">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="DELETE">
                <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Are you sure you want to delete this item?');">🗑️ Delete</button>
                </form>
            </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection