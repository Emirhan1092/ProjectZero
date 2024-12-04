@extends('layouts.user_type.auth')

@section("title", "Car Owners List")

@section('css')


    @endsection
@section("content")
    <div class="p-4 bg-secondary rounded-1">
        <form action="{{route('carOwners.list')}}" method="GET" id="formFilter">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="number" name="id" placeholder="ID" class="form-control form-control-alternative" value="{{ request()->get('id') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="number" name="user_id" class="form-control form-control-alternative" id="exampleFormControlInput1" placeholder="User ID" value="{{ request()->get('user_id') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                            <input type="number" name="vehicle_id" placeholder="Vehicle ID" class="form-control form-control-alternative" value="{{ request()->get('vehicle_id') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="number" name="accident_id" class="form-control form-control-alternative" id="exampleFormControlInput2" placeholder="Accident ID" value="{{ request()->get('accident_id') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group input-group-alternative mb-4">
                            <input class="form-control form-control-alternative" name="name" placeholder="Name" type="text" value="{{ request()->get('name') }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group has-success">
                        <input type="text" name="licence_informations" placeholder="Licence Informations" class="form-control form-control-alternative" value="{{ request()->get('licence_informations') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group input-group-alternative mb-4">
                            <input class="form-control form-control-alternative" name="Email" placeholder="Email" type="email" value="{{ request()->get('email') }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group has-success">
                        <input type="number" name="phone_number" placeholder="Phone Number" class="form-control form-control-alternative" value="{{ request()->get('phone_number') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group input-group-alternative mb-4">
                            <input class="form-control form-control-alternative" name="address" placeholder="Address" type="text" value="{{ request()->get('address') }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group has-success">
                        <input type="date" name="birth_date" placeholder="Birth Date" class="form-control form-control-alternative" value="{{ request()->get('birth_date') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn bg-gradient-info btn-lg d-flex w-100">Filtrele</button>
                </div>
                <div class="col-md-6">
                    <button type="reset" class="btn bg-gradient-danger btn-lg d-flex w-100" id="btnClearFilter">Filtreyi Temizle</button>
                </div>
            </div>
        </form>

    </div>
    <div class="card mb-2">
        <div class="table-responsive">
            <table class="table align-items-center mb-0">
                <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Image</th>

                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">ID</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">User ID</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Vehicle ID</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Accident ID</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">License Infromations</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Email</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Phone Number</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Address</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Birth Date</th>

                </tr>
                </thead>
                <tbody>
                @foreach($carOwners as $carOwner)
                    <tr>
                        <td class="text-end">
                            <img src="{{isset($carOwner)  ? asset('assets/img/team-4.jpg') :$carOwner->image }}" class="avatar avatar-sm me-3" alt="User Image">
                        </td>
                        <td class="text-end">
                            <p class="text-xs font-weight-bold mb-0 m-3 ">{{ $carOwner->id }}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-xs font-weight-bold mb-0 m-3 ">{{ $carOwner->user_id }}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-xs font-weight-bold mb-0 m-3 ">{{ $carOwner->vehicle_id }}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-xs font-weight-bold mb-0 m-3" >{{ $carOwner->accident_id }}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-xs font-weight-bold mb-0 m-3">{{ $carOwner->name }}</p>
                        </td>
                        <td class="text-end">
                            <span class="text-secondary text-xs font-weight-normal m-3">{{ $carOwner->licence_informations }}</span>
                        </td>
                        <td class="text-end">
                            <span class="text-secondary text-xs font-weight-normal m-3">{{ $carOwner->email}}</span>
                        </td>
                        <td class="text-end">
                            <span class="text-secondary text-xs font-weight-normal m-3">{{ $carOwner->phone_number}}</span>
                        </td> <td class="text-end">
                            <span class="text-secondary text-xs font-weight-normal m-3">{{ $carOwner->address}}</span>
                        </td>
                        <td class="text-end">
                            <span class="text-secondary text-xs font-weight-normal m-3">{{ $carOwner->birth_date}}</span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <div class="d-flex justify-content-center">
        {{ $carOwners->links() }}
    </div>
@endsection

@section('js')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#btnClearFilter').click(function (event) {
                event.preventDefault();


                let filters1 = $('#formFilter input');
                let filters2 = $('#formFilter select');
                let filters = filters1.toArray().concat(filters2.toArray());

                filters.forEach(function (element) {
                    element.value = null;
                    if (element.nodeName === "SELECT") {
                        $(element).val(null).trigger('change');
                    }
                    $('#formFilter').submit();

                });

            });


        });

    </script>
@endsection
