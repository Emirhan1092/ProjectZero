
@extends('layouts.user_type.auth')

@section("title")
    User {{isset($user) ?  'Update' : 'Create'}}
@endsection

@section('css')
@endsection

@section('content')
    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="alert alert-danger">{{$error}}</div>
        @endforeach
    @endif
    <form action="{{isset($user) ? route('users.update' , ['id'  => $user->id]) : route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name" class="form-control-label">Name</label>
            <input class="form-control @if($errors->has('name')) border-danger @endif" type="text" name="name" value="{{ isset($user) ? $user->name : '' }}" id="name">
            @if($errors->has('name'))
                <div class="text-danger">{{ $errors->first('name') }}</div>
            @endif
        </div>
        @php
             use Spatie\Permission\Models\Role;
             $users = \App\Models\User::all();
            $uniqueRoles = $users->pluck('role_id')->unique()->sort();
            $roleNames = Role::whereIn('id', $uniqueRoles)->pluck('name', 'id');



        @endphp
        <div class="form-group">
            <label for="roleSelect ">Rol Seçin</label>
            <select id="roleSelect " name="role" class="form-control form-control-lg @if($errors->has('role')) border-danger @endif">
                <option value="" class="" disabled selected>Rol seçiniz</option>
            @foreach($uniqueRoles as $roleId)
                    <option value="{{ json_encode(['role_id' => $roleId, 'role' => $roleNames[$roleId] ?? 'Bilinmeyen Rol']) }}">
                        {{ $roleNames[$roleId] ?? 'Bilinmeyen Rol' }}
                    </option>
            @endforeach
        </select>
            @if($errors->has('role'))
                <div class="invalid-feedback">
                    {{ $errors->first('role') }}
                </div>
            @endif
        </div>
        <div class="form-group">
            <label for="email" class="form-control-label">Email</label>
            <input class="form-control @if($errors->has('email')) border-danger @endif" type="email" name="email" value="{{ isset($user) ? $user->email : '' }}" id="email">
            @if($errors->has('email'))
                <div class="text-danger">{{ $errors->first('email') }}</div>
            @endif
        </div>

        <div class="form-group">
            <label for="password" class="form-control-label">Password</label>
            <input class="form-control @if($errors->has('password')) border-danger @endif" type="password" name="password" id="password">
            @if($errors->has('password'))
                <div class="text-danger">{{ $errors->first('password') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="phoneNumber" class="form-control-label">Phone</label>
            <input class="form-control @if($errors->has('phone')) border-danger @endif" type="tel" name="phone" value="{{ isset($user) ? $user->phone : '' }}" id="phoneNumber">
            @if($errors->has('phone'))
                <div class="text-danger">{{ $errors->first('phone') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="image" class="form-control-label">Image</label>
            <input class="form-control @if($errors->has('image')) border-danger @endif" type="file" name="image" id="image">
            @if(isset($user) && $user->image)
                <img src="{{ asset($user->image) }}" alt="Profile Image" class="img-fluid mt-2" style="max-height: 200px;">
            @endif
        </div>
        <div class="col-12 align-items-center">
            <button type="submit" class="btn btn-primary btn-lg">{{isset($user) ? "Güncelle": "Kaydet"}}</button>
        </div>
    </form>

@endsection


@section('js')
@endsection
