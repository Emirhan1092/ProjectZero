
@extends('layouts.user_type.auth')

@section("title")
    Customer And Vehicles Create
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/flatpickr.min.css">
@endsection

@section('content')
    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="alert alert-danger">{{$error}}</div>
        @endforeach
    @endif
    <form action="{{route('customerAndVehicles.create') }}"  method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="example-text-input" class="form-control-label">Customer Name</label>
            <input class="form-control @if($errors->has('name')) border-danger @endif" type="text" value="Customer Name" name="name" id="customerName">
            @if($errors->has('name'))
                <div class="text-danger">{{ $errors->first('name') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label for="email" class="form-control-label">Email</label>
            <input class="form-control @if($errors->has('email')) border-danger @endif" type="email" name="email" value="Email" id="email">
            @if($errors->has('email'))
                <div class="text-danger">{{ $errors->first('email') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="phone_number" class="form-control-label">Phone Number</label>
            <input class="form-control  @if($errors->has('phone_number')) border-danger @endif" type="number" value="Phone Number" name="phone_number" id="phone_number">
            @if($errors->has('phone_number'))
                <div class="text-danger">{{ $errors->first('phone_number') }}</div>
            @endif
        </div>



        <div class="form-group">
            <label for="image" class="form-control-label">User Image</label>
            <input class="form-control @if($errors->has('image')) border-danger @endif" type="file" name="image" id="image">
            @if(isset($user) && $user->image)
                <img src="{{ asset($user->image) }}" alt="Profile Image" class="img-fluid mt-2" style="max-height: 200px;">
            @endif
        </div>



        <div class="form-group">
            <label for="brand" class="form-control-label">Brand</label>
            <input class="form-control @if($errors->has('brand')) border-danger @endif" type="text" name="brand" value="{{ isset($vehicle) ? $vehicle->brand : '' }}" id="brand">
            @if($errors->has('brand'))
                <div class="text-danger">{{ $errors->first('brand') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label for="model" class="form-control-label">Model</label>
            <input class="form-control @if($errors->has('model')) border-danger @endif" type="text" name="model" value="{{ isset($vehicle) ? $vehicle->model : '' }}" id="model">
            @if($errors->has('model'))
                <div class="text-danger">{{ $errors->first('model') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label for="year" class="form-control-label">Year</label>
            <input class="form-control @if($errors->has('year')) border-danger @endif" type="number" name="year" value="{{ isset($vehicle) ? $vehicle->year : '' }}" id="year">
            @if($errors->has('year'))
                <div class="text-danger">{{ $errors->first('year') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label for="color" class="form-control-label">Color</label>
            <input class="form-control @if($errors->has('color')) border-danger @endif" type="text" name="color" value="{{ isset($vehicle) ? $vehicle->color : '' }}" id="color">
            @if($errors->has('color'))
                <div class="text-danger">{{ $errors->first('color') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label for="kilometers" class="form-control-label">Kilometers</label>
            <input class="form-control @if($errors->has('kilometers')) border-danger @endif" type="number" name="kilometers" value="{{ isset($vehicle) ? $vehicle->kilometers : '' }}" id="kilometers">
            @if($errors->has('kilometers'))
                <div class="text-danger">{{ $errors->first('kilometers') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label for="vehicle_register_plate" class="form-control-label">Vehicle Register Plate</label>
            <input class="form-control @if($errors->has('vehicle_register_plate')) border-danger @endif" type="text" name="vehicle_register_plate" value="{{ isset($vehicle) ? $vehicle->vehicle_register_plate : '' }}" id="vehicle_register_plate">
            @if($errors->has('vehicle_register_plate'))
                <div class="text-danger">{{ $errors->first('vehicle_register_plate') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label for="VIN" class="form-control-label">VIN</label>
            <input class="form-control @if($errors->has('VIN')) border-danger @endif" type="text" name="VIN" value="{{ isset($vehicle) ? $vehicle->VIN : '' }}" id="VIN">
            @if($errors->has('VIN'))
                <div class="text-danger">{{ $errors->first('VIN') }}</div>
            @endif
        </div>


        <div class="form-group">
            <label for="engine_number" class="form-control-label">Engine Number</label>
            <input class="form-control @if($errors->has('engine_number')) border-danger @endif" type="text" name="engine_number" value="{{ isset($vehicle) ? $vehicle->engine_number : '' }}" id="engine_number">
            @if($errors->has('engine_number'))
                <div class="text-danger">{{ $errors->first('engine_number') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="fuel_type" class="form-control-label">Fuel Type</label>
            <select class="form-control @if($errors->has('fuel_type')) border-danger @endif" name="fuel_type" id="fuel_type">
                <option value="" disabled selected>Select Fuel Type</option>
                <option value="Gasoline" {{ isset($vehicle) && $vehicle->fuel_type == 'Gasoline' ? 'selected' : '' }}>Gasoline</option>
                <option value="Diesel" {{ isset($vehicle) && $vehicle->fuel_type == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                <option value="Electric" {{ isset($vehicle) && $vehicle->fuel_type == 'Electric' ? 'selected' : '' }}>Electric</option>
                <option value="Hybrid" {{ isset($vehicle) && $vehicle->fuel_type == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
            </select>
            @if($errors->has('fuel_type'))
                <div class="text-danger">{{ $errors->first('fuel_type') }}</div>
            @endif
        </div>


        <div class="col-12 align-items-center">
            <button type="submit" class="btn btn-primary btn-lg">{{isset($accident) ? "Güncelle": "Kaydet"}}</button>
        </div>
    </form>

@endsection


@section('js')

@endsection
