@extends('layouts.main')
@section('content')
<div class="container">
    <h3>Data Karyawan</h3><br>
    <form action="{{ isset($getKaryawan) ? url('karyawan/edit', $getKaryawan->id) : url('karyawan/create') }}" method="POST">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" value="{{ isset($getKaryawan) ? ($getKaryawan->name ? $getKaryawan->name : '') : '' }}">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Email address</label>
            <input type="email" class="form-control" name="email" value="{{ isset($getKaryawan) ? ($getKaryawan->email ? $getKaryawan->email : '') : '' }}">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Phone</label>
            <input type="number" class="form-control" name="phone" value="{{ isset($getKaryawan) ? ($getKaryawan->phone ? $getKaryawan->phone : '') : '' }}">
        </div>
        <div class="form-group">
            <label>Select Team</label>
            <select class="form-control" name="team">
                <option value="DS">DS</option>
                <option value="IT">IT</option>
                <option value="Operational">Operational</option>
                <option value="Finance">Finance</option>
                <option value="Shipping">Shipping</option>
            </select>
        </div>

        <button class="btn btn-primary" type="submit">Update</button>
    </form>
</div>
@endsection