@extends('layouts.user_type.auth')

@section("title", "Car Owners List")

@section('css')


    @endsection
@section("content")
    <div class="p-4 bg-secondary rounded-1">
        <form action="{{route('repairmans.list')}}" method="GET" id="formFilter">
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
                            <input type="text" name="name" placeholder="Name" class="form-control form-control-alternative" value="{{ request()->get('name') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="shop_name" class="form-control form-control-alternative" id="exampleFormControlInput2" placeholder="Shop Name" value="{{ request()->get('shop_name') }}">
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
                        <input type="text" name="phone_number" placeholder="Phone Number" class="form-control form-control-alternative" value="{{ request()->get('phone_number') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group input-group-alternative mb-4">
                            <input class="form-control form-control-alternative" name="number_of_services" placeholder="Service Number" type="email" value="{{ request()->get('number_of_services') }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group has-success">
                        <input type="number" name="rating" placeholder="Rating" class="form-control form-control-alternative" value="{{ request()->get('rating') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group input-group-alternative mb-4">
                            <input class="form-control form-control-alternative" name="status" placeholder="Status" type="number" value="{{ request()->get('status') }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group has-success">
                        <input type="number" name="star" placeholder="Star" class="form-control form-control-alternative" value="{{ request()->get('star') }}">
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="input-group input-group-alternative mb-4">
                            <input class="form-control form-control-alternative" name="start_date" placeholder="Start Date" type="date" value="{{ request()->get('start_date') }}">
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
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Image</th>

                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">ID</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">User ID</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Shop Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Address</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Phone Number</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Certificates</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Number Of Services</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Rating</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Status</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Star</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Start Date</th>


                </tr>
                </thead>
                <tbody>
                @foreach($repairmans as $repairman)
                    <tr>
                        <td class="text-end">
                            <img src="{{isset($repairman)  ? asset('assets/img/team-4.jpg') :$repairman->image }}" class="avatar avatar-sm me-3" alt="User Image">
                        </td>
                        <td class="text-end">
                            <p class="text-xs font-weight-bold mb-0 m-3 ">{{ $repairman->id }}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-xs font-weight-bold mb-0 m-3 ">{{ $repairman->user_id }}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-xs font-weight-bold mb-0 m-3 ">{{ $repairman->name }}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-xs font-weight-bold mb-0 m-3" >{{ $repairman->shop_name }}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-xs font-weight-bold mb-0 m-3">{{ $repairman->address}}</p>
                        </td>
                        <td class="text-end">
                            <span class="text-secondary text-xs font-weight-normal m-3">{{ $repairman->phone_number }}</span>
                        </td>
                        <td class="text-end">
                            <span class="text-secondary text-xs font-weight-normal m-3">{{ $repairman->certificates}}</span>
                        </td>
                        <td class="text-end">
                            <span class="text-secondary text-xs font-weight-normal m-3">{{ $repairman->number_of_services}}</span>
                        </td> <td class="text-end">
                            <span class="text-secondary text-xs font-weight-normal m-3">{{ $repairman->rating}}</span>
                        </td>
                        <td class="text-end">
                            <span class="text-secondary text-xs font-weight-normal m-3">{{ $repairman->status}}</span>
                        </td>
                        <td class="text-end">
                            <span class="text-secondary text-xs font-weight-normal m-3">{{ $repairman->star}}</span>
                        </td>
                        <td class="text-end">
                            <span class="text-secondary text-xs font-weight-normal m-3">{{ $repairman->start_date}}</span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <div class="d-flex justify-content-center">
        {{ $repairmans->links() }}
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
