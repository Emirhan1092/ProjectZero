@extends('layouts.user_type.auth')

@section("title", "Lawyers List")

@section('css')


    @endsection
@section("content")
    <div class="p-4 bg-secondary rounded-1">
        <form action="{{route('lawyer.list')}}" method="GET" id="formFilter">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="number" name="user_id" placeholder="User ID" class="form-control form-control-alternative" value="{{ request()->get('user_id') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control form-control-alternative" id="exampleFormControlInput1" placeholder="Name" value="{{ request()->get('name') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Email" class="form-control form-control-alternative" value="{{ request()->get('email') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="number" name="phone_number" class="form-control form-control-alternative" id="exampleFormControlInput2" placeholder="Phone Number" value="{{ request()->get('phone_number') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group input-group-alternative mb-4">
                            <input class="form-control form-control-alternative" name="specialization" placeholder="Specialization" type="text" value="{{ request()->get('specialization') }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group has-success">
                        <input type="text" name="address" placeholder="Address" class="form-control form-control-alternative" value="{{ request()->get('address') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group input-group-alternative mb-4">
                            <input class="form-control form-control-alternative" name="license_number" placeholder="License Number" type="text" value="{{ request()->get('license_number') }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group has-success">
                        <input type="date" name="license_expiry" placeholder="License Expiry" class="form-control form-control-alternative" value="{{ request()->get('license_expiry') }}">
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
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Insurer Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Insurer Company</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Email</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Phone Number</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Address</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lawyers as $lawyer)
                    <tr>
                        <td class="text-end">
                            <img src="{{isset($lawyer)  ? asset('assets/img/team-4.jpg') :$lawyer->image }}" class="avatar avatar-sm me-3" alt="User Image">
                        </td>
                        <td class="text-end">
                            <p class="text-xs font-weight-bold mb-0 m-3 ">{{ $lawyer->id }}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-xs font-weight-bold mb-0 m-3 ">{{ $lawyer->user_id }}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-xs font-weight-bold mb-0 m-3 ">{{ $lawyer->name }}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-xs font-weight-bold mb-0 m-3" >{{ $lawyer->specialization }}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-xs font-weight-bold mb-0 m-3">{{ $lawyer->email }}</p>
                        </td>
                        <td class="text-end">
                            <span class="text-secondary text-xs font-weight-normal m-3">{{ $lawyer->phone_number }}</span>
                        </td>
                        <td class="text-end">
                            <span class="text-secondary text-xs font-weight-normal m-3">{{ $lawyer->address}}</span>
                        </td>
                        <td class="text-end">
                            <span class="text-secondary text-xs font-weight-normal m-3">{{ $lawyer->license_number}}</span>
                        </td> <td class="text-end">
                            <span class="text-secondary text-xs font-weight-normal m-3">{{ $lawyer->license_expiry}}</span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <div class="d-flex justify-content-center">
        {{ $lawyers->links() }}
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
