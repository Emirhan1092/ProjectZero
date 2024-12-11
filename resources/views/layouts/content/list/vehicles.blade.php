@extends('layouts.user_type.auth')

@section("title", "User List")

@section('css')






@endsection
@section("content")
    <div class="p-4 bg-secondary rounded-1">
        <form action="{{route('vehicles.list')}}" method="GET" id="formFilter">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="number" name="id" placeholder="ID" class="form-control form-control-alternative" value="{{ request()->get('id') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="number" name="user_id" placeholder="UserID" class="form-control form-control-alternative" value="{{ request()->get('user_id') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="brand" placeholder="Brand" class="form-control form-control-alternative" value="{{ request()->get('brand') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="model" class="form-control form-control-alternative"  placeholder="Model" value="{{ request()->get('model') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group input-group-alternative mb-4">
                            <input class="form-control form-control-alternative" name="year" placeholder="Year" type="number" value="{{ request()->get('year') }}">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group input-group-alternative mb-4">
                        <input class="form-control form-control-alternative" name="color" placeholder="Color" type="text" value="{{ request()->get('color') }}">
                    </div>
                </div>
            </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group input-group-alternative mb-4">
                            <input class="form-control form-control-alternative" name="kilometers" placeholder="Kilometers" type="text" value="{{ request()->get('kilometers') }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">

                <div class="form-group">
                    <div class="input-group input-group-alternative mb-4">
                        <input class="form-control form-control-alternative" name="vehicle_register_plate" placeholder="Vehicle Register Plate" type="text" value="{{ request()->get('vehicle_register_plate') }}">
                    </div>
                </div>
            </div>
            </div>

            <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group input-group-alternative mb-4">
                                <input class="form-control form-control-alternative" name="engine" placeholder="Engine" type="text" value="{{ request()->get('engine') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="form-group">
                            <div class="input-group input-group-alternative mb-4">
                                <input class="form-control form-control-alternative" name="fuel_type" placeholder="Fuel Type" type="text" value="{{ request()->get('fuel_type') }}">
                            </div>
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
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">ID</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">User ID</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Brand</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Model</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Year</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Color</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Vehicle Register Plate</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">VIN</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Engine Number</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Fuel Type</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Actions</th>

                </tr>
                </thead>
                <tbody>
                @foreach($vehicles as $vehicle)
                    <tr>

                        <td class="text-end">
                            <p class="text-xs font-weight-bold mb-0 m-3 ">{{ $vehicle->id }}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-xs font-weight-bold mb-0 m-3 ">{{ $vehicle->user_id }}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-xs font-weight-bold mb-0 m-3 ">{{ $vehicle->brand }}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-xs font-weight-bold mb-0 m-3" >{{ $vehicle->model }}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-xs font-weight-bold mb-0 m-3">{{ $vehicle->year }}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-secondary text-xs font-weight-normal m-3">{{ $vehicle->color }}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-secondary text-end text-xs font-weight-normal m-3">{{ $vehicle->kilometers}}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-secondary text-end text-xs font-weight-normal m-3">{{ $vehicle->vehicle_register_plate}}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-secondary text-end text-xs font-weight-normal m-3">{{ $vehicle->VIN}}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-secondary text-end text-xs font-weight-normal m-3">{{ $vehicle->engine_number}}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-secondary text-end text-xs font-weight-normal m-3">{{ $vehicle->fuel_type}}</p>
                        </td>
                        <td class="text-end">
                            <a href="{{route('vehicles.edit' , [$vehicle->id ])}}" class="text-secondary font-weight-normal text-xs m-3" data-toggle="tooltip" data-original-title="Edit vehicle">
                                <i class="fa-solid fa-pen-to-square" style="color:black;"></i>


                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <div class="d-flex justify-content-center">
        {{ $vehicles->links() }}
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
