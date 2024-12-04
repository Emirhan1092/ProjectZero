@extends('layouts.user_type.auth')

@section("title", "User List")

@section('css')






@endsection
@section("content")
    <div class="p-4 bg-secondary rounded-1">
        <form action="{{route('accident.list')}}" method="GET" id="formFilter">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="id" placeholder="ID" class="form-control form-control-alternative" value="{{ request()->get('id') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="vehicle_id" placeholder="VehicleID" class="form-control form-control-alternative" value="{{ request()->get('vehicle_id') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="user_id" placeholder="UserID" class="form-control form-control-alternative" value="{{ request()->get('user_id') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="repairman_id" class="form-control form-control-alternative"  placeholder="RepairmanID" value="{{ request()->get('repairman_id') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group input-group-alternative mb-4">
                            <input class="form-control form-control-alternative" name="accident_type" placeholder="Accident Type" type="text" value="{{ request()->get('accident_type') }}">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group input-group-alternative mb-4">
                        <input class="form-control form-control-alternative" name="accident_date" placeholder="Accident Type" type="date" value="{{ request()->get('accident_date') }}">
                    </div>
                </div>
            </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group input-group-alternative mb-4">
                            <input class="form-control form-control-alternative" name="description" placeholder="Description" type="text" value="{{ request()->get('description') }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">

                <div class="form-group">
                    <div class="input-group input-group-alternative mb-4">
                        <input class="form-control form-control-alternative" name="accident_status" placeholder="Accident Status" type="text" value="{{ request()->get('accident_status') }}">
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

    </div>
    <div class="card mb-2">
        <div class="table-responsive">
            <table class="table align-items-center mb-0">
                <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">ID</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Vehicle ID</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">User ID</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Repairman ID</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Accident Type</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Accident Date</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Description</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Accident Status</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Actions</th>

                </tr>
                </thead>
                <tbody>
                @foreach($accidents as $accident)
                    <tr>

                        <td class="text-end">
                            <p class="text-xs font-weight-bold mb-0 m-3 ">{{ $accident->id }}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-xs font-weight-bold mb-0 m-3 ">{{ $accident->vehicle_id }}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-xs font-weight-bold mb-0 m-3 ">{{ $accident->user_id }}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-xs font-weight-bold mb-0 m-3" >{{ $accident->repairman_id }}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-xs font-weight-bold mb-0 m-3">{{ $accident->accident_type }}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-secondary text-xs font-weight-normal m-3">{{ $accident->accident_date }}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-secondary text-xs font-weight-normal m-3">
                                {{ substr($accident->description, 0, 25) }}{{ strlen($accident->description) > 25 ? '...' : '' }}
                            </p>
                        </td>

                        <td class="text-end">
                            <p class="text-secondary text-end text-xs font-weight-normal m-3">{{ $accident->accident_status}}</p>
                        </td>
                        <td class="text-end">
                            <a href="{{route('accidents.edit' , [$accident->id ])}}" class="text-secondary font-weight-normal text-xs m-3" data-toggle="tooltip" data-original-title="Edit accident">
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
        {{ $accidents->links() }}
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
