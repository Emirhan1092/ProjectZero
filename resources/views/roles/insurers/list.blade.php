@extends('layouts.user_type.auth')

@section("title", "Insurers List")

@section('css')


    @endsection
@section("content")
    <div class="p-4 bg-secondary rounded-1">
        <form action="{{route('insurer.list')}}" method="GET" id="formFilter">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="id" placeholder="ID" class="form-control form-control-alternative" value="{{ request()->get('user_id') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="insurer_name" class="form-control form-control-alternative" id="exampleFormControlInput1" placeholder="Insurer Name" value="{{ request()->get('insurer_name') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="insurer_company" placeholder="Insurer Company" class="form-control form-control-alternative" value="{{ request()->get('insurer_company') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="email" name="email" class="form-control form-control-alternative" id="exampleFormControlInput2" placeholder="Email" value="{{ request()->get('email') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group input-group-alternative mb-4">
                            <input class="form-control form-control-alternative" name="phone_number" placeholder="Phone Number" type="number" value="{{ request()->get('phone_number') }}">
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
                @foreach($insurers as $insurer)
                    <tr>
                        <td class="text-end">
                            <img src="{{isset($insurer)  ? asset('assets/img/team-4.jpg') :$insurer->image }}" class="avatar avatar-sm me-3" alt="User Image">
                        </td>
                        <td class="text-end">
                            <p class="text-xs font-weight-bold mb-0 m-3 ">{{ $insurer->id }}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-xs font-weight-bold mb-0 m-3 ">{{ $insurer->user_id }}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-xs font-weight-bold mb-0 m-3 ">{{ $insurer->insurer_name }}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-xs font-weight-bold mb-0 m-3" >{{ $insurer->insurance_company }}</p>
                        </td>
                        <td class="text-end">
                            <p class="text-xs font-weight-bold mb-0 m-3">{{ $insurer->email }}</p>
                        </td>
                        <td class="text-end">
                            <span class="text-secondary text-xs font-weight-normal m-3">{{ $insurer->phone_number }}</span>
                        </td>
                        <td class="text-end">
                            <span class="text-secondary text-xs font-weight-normal m-3">{{ $insurer->address}}</span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <div class="d-flex justify-content-center">
        {{ $insurers->links() }}
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
