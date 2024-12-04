
@extends('layouts.user_type.auth')

@section("title")
    User {{isset($vehicle) ?  'Update' : 'Create'}}
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
    <form action="{{isset($vehicle) ? route('vehicles.update', ['id' => $vehicle->id]) : route('vehicles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @php
            $vehicles2 = \App\Models\Accident::pluck('user_id')->unique();

            $repairmans = [];

            foreach ($vehicles2 as $vehicle2) {
                $repairmans[] = \App\Models\User::where('id', $vehicle2)->first();
            }


        @endphp

        <div class="form-group">
            <label for="repairmanSelect ">Tamirci Seçiniz</label>
            <select id="repairmanSelect " name="repairman_id" class="form-control form-control-lg @if($errors->has('repairman_id')) border-danger @endif">
                <option value="" class="" disabled selected>Tamirci Seçiniz</option>
                @foreach($repairmans as $repairman)
                    <option value="{{$repairman->id }}">
                        {{ $repairman->name }}
                    </option>
                @endforeach
            </select>
            @if($errors->has('repairman_id'))
                <div class="invalid-feedback">
                    {{ $errors->first('repairman_id') }}
                </div>
            @endif
        </div>
        @php
            $users = \App\Models\User::all();


        @endphp

        <div class="form-group">
            <label for="userSelect ">Kullanıcı Seçiniz</label>
            <select id="userSelect " name="user_id" class="form-control form-control-lg @if($errors->has('user_id')) border-danger @endif">
                <option value="" class="" disabled selected>Kullanıcı Seçiniz</option>
                @foreach($users as $user)
                    <option value="{{$user->id }}">
                        {{$user->name }}
                    </option>
                @endforeach
            </select>
            @if($errors->has('user_id'))
                <div class="invalid-feedback">
                    {{ $errors->first('user_id') }}
                </div>
            @endif
        </div>
        @php
            $vehicles3 = \App\Models\Accident::pluck('vehicle_id')->unique();

            $repairmans = [];

            foreach ($vehicles3 as $vehicle3) {
                $repairmans[] = \App\Models\Vehicle::where('id', $vehicle3)->first();
            }

        @endphp

        <div class="form-group">
            <label for="vehicleSelect ">Araç Seçin</label>
            <select id="vehicleSelect " name="vehicle_id" class="form-control form-control-lg @if($errors->has('repairman_id')) border-danger @endif">
                <option value="" class="" disabled selected>Araç Seçiniz</option>
                @foreach($repairmans as $repairman)
                    <option value="{{$repairman->id }}">
                        {{ $repairman->VIN }}
                    </option>
                @endforeach
            </select>
            @if($errors->has('repairman_id'))
                <div class="invalid-feedback">
                    {{ $errors->first('repairman_id') }}
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="example-datetime-local-input" class="form-control-label">Datetime</label>
            <input class="form-control" type="datetime-local"  name="vehicle_date" value="{{isset($vehicle)  ?  $vehicle->vehicle_date: '' }}" id="example-datetime-local-input">
        </div>



        @php

            $vehicles = \App\Models\Accident::all();
           $AccidentStatus = $vehicles->pluck('vehicle_status')->unique()->sort();


        @endphp

        <div class="form-group">
            <label for="vehicle_status">Kaza Durumu Seçin</label>
            <select id="vehicle_status" name="vehicle_status" class="form-control form-control-lg @if($errors->has('vehicle_status')) border-danger @endif">
                <option value="" class="" disabled selected>Kaza Durumunu Seçiniz</option>
                @foreach($AccidentStatus as $AccidentStatu)
                    <option value="{{$AccidentStatu}}">
                        {{ $AccidentStatu}}
                    </option>
                @endforeach
            </select>
            @if($errors->has('vehicle_status'))
                <div class="invalid-feedback">
                    {{ $errors->first('vehicle_status') }}
                </div>
            @endif
        </div>
        @php

            $vehicles = \App\Models\Accident::all();
           $AccidentTypes = $vehicles->pluck('vehicle_type')->unique()->sort();

        @endphp
        <div class="form-group">
            <label for="vehicle_type ">Kaza Tipi Seçiniz</label>
            <select id="vehicle_type " name="vehicle_type" class="form-control form-control-lg @if($errors->has('vehicle_type')) border-danger @endif">
                <option value="" class="" disabled selected>Kaza Tipi Seçiniz</option>
                @foreach($AccidentTypes as $AccidentType)
                    <option value="{{$AccidentType}}">
                        {{ $AccidentType}}
                    </option>
                @endforeach
            </select>
            @if($errors->has('vehicle_type'))
                <div class="invalid-feedback">
                    {{ $errors->first('vehicle_type') }}
                </div>
            @endif
        </div>
        <div class="form-group">
            <label for="example-text-input" class="form-control-label">Açıklama Giriniz</label>
            <input class="form-control" type="text" value="Açıklama Giriniz" name="description" id="description">
        </div>
        <div class="col-12 align-items-center">
            <button type="submit" class="btn btn-primary btn-lg">{{isset($vehicle) ? "Güncelle": "Kaydet"}}</button>
        </div>
    </form>

@endsection


@section('js')

@endsection
