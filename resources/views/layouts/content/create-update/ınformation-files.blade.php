@extends('layouts.user_type.auth')

@section('title')
@endsection
@section('css')


    <style>
    .hidden{
        display: none;
    }
    .hiddenInsurance{
        display: none;
    }
    </style>
@endsection

@section('content')
    <div class="example-container">
        <div class="example-content">
    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="alert alert-danger">{{$error}}</div>
        @endforeach
    @endif
<form action="{{route('addInformationsFile.store' )}}" method="POST" enctype="multipart/form-data">
    @csrf
    @php
        use Spatie\Permission\Models\Role;
        $users = \App\Models\User::where('role' ,'car_owner' )->get();




    @endphp
    <div class="form-group">
        <label for="customerSelect">Customer Seçin</label>
        <select id="customerSelect" name="customerId" class="form-control form-control-lg @if($errors->has('user')) border-danger @endif">
            <option value="" class="" disabled selected>Rol seçiniz</option>
            @foreach($users as $user)
                <option value="{{$user->id}}">
                    {{$user->name }}
                </option>
            @endforeach
        </select>
        @if($errors->has('user'))
            <div class="invalid-feedback">
                {{ $errors->first('user') }}
            </div>
        @endif
    </div>



    <div class="card" id="partInformationsTable">
    </div>

    <div class="form-check">
        <input class="form-check-input " type="checkbox" value="" id="accidentCheck">
        <label class="form-check-label" for="flexCheckIndeterminate">
           Kaza Var Mı ?
        </label>
    </div>



    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="insuranceCheck">
        <label class="form-check-label" for="flexCheckIndeterminate">
            Kasko Var Mı ?
        </label>
    </div>

    <div class="mb-3">
        <label>Ruhsat Fotokobisi (Max:20 Resim Yüklenebilir )</label>
        <input type="file" id="vehicleRegistrationCertificateImages" name="vehicleRegistrationCertificateImages[]" multiple class="form-control @if($errors->has('vehicleRegistrationCertificateImages')) border-danger @endif" />
        <div id="vehicleRegistrationCertificatePreviews" class="mt-2"></div>
    </div>
    @if($errors->has('vehicleRegistrationCertificateImages'))

    <div class="text-danger">{{$errors->first('vehicleRegistrationCertificateImages')}}</div>
    @endif
    <div class="mb-3">
        <label>Ehliyet Fotokobisi (Max:20 Resim Yüklenebilir )</label>
        <input type="file" name="driverLicenseImages[]" multiple class="form-control @if($errors->has('driverLicenseImages')) border-danger @endif" />
    </div>
    @if($errors->has('driverLicenseImages'))
        <div class="text-danger">{{$errors->first('driverLicenseImages')}}</div>
    @endif

    <div class="mb-3 hiddenInsurance insuranceField">
        <label>Kasko Poliçesi  Fotokobisi(Max:20 Resim Yüklenebilir )</label>
        <input type="file" name="insuranceImages[]" multiple class="form-control  @if($errors->has('insuranceImages')) border-danger @endif" />
    </div>

    @if($errors->has('insuranceImages'))
        <div class="text-danger">{{$errors->first('insuranceImages')}}</div>
    @endif
    <div class="mb-3">
        <label>Hasarlı Bölgelerin Fotoğrafları (Max:20 Resim Yüklenebilir )</label>
        <input type="file" name="damageImages[]" multiple class="form-control  @if($errors->has('damageImages')) border-danger @endif" />
    </div>

    @if($errors->has('damageImages'))
        <div class="text-danger">{{$errors->first('damageImages')}}</div>
    @endif
    <div class="mb-3 hidden accidentField">
        <label>Polis Raporu (Max:20 Resim Yüklenebilir )</label>
        <input type="file" name="policeReportImages[]" multiple class="form-control  @if($errors->has('policeReportImages')) border-danger @endif" />
    </div>

    @if($errors->has('policeReportImages'))
        <div class="text-danger">{{$errors->first('policeReportImages')}}</div>
    @endif
    <div class="mb-3 hidden accidentField">
        <label>Sigorta Poliçesi Fotokobisi (Max:20 Resim Yüklenebilir )</label>
        <input type="file" name="trafficInsuranceImages[]" multiple class="form-control  @if($errors->has('trafficInsuranceImages')) border-danger @endif" />
    </div>
    @if($errors->has('trafficInsuranceImages'))
        <div class="text-danger">{{$errors->first('trafficInsuranceImages')}}</div>
    @endif
    <div class="mb-3 hidden accidentField">
        <label>Kaza Tespit Tutanağı Fotokobisi (Max:20 Resim Yüklenebilir )</label>
        <input type="file" name="accidentReportImages[]" multiple class="form-control @if($errors->has('accidentReportImages')) border-danger @endif" />
    </div>

    @if($errors->has('accidentReportImages'))
        <div class="text-danger">{{$errors->first('accidentReportImages')}}</div>
    @endif
    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Upload</button>
    </div>
</form>

 </div>
</div>

@endsection
@section('js')

    <script>
        $(document).on('change', '#customerSelect', function() {
            var userId = $(this).val();
            $.ajax({
                url: '/cartUserId/' + userId + '/parameters',
                type: 'GET',
                data: {
                    userId: userId
                },
                success: function(response) {
                    console.log("response", response);

                    response.forEach(function(partInformations){

                     var partInformationsTable = $('#partInformationsTable');
                     partInformationsTable.empty();
                        var partTable =  $(`<div class="table-responsive">
    <table class="table align-items-center mb-0">
        <tbody>
            <tr>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckIndeterminate">
                        <label class="form-check-label" for="flexCheckIndeterminate">
                           Ekle
                        </label>
                    </div>
                </td>
                <td>
                    <div class="d-flex px-2">
                        <div>
                            <img src="${partInformations.image}" alt="${partInformationsTable.part_id}" style="width: 100px; height: 100px">
                        </div>
                    </div>
                </td>
                <td>
                    <p class="text-xs font-weight-normal mb-0">${partInformations.part_id}</p>
                </td>



                <td class="align-middle">
                    <div class="d-flex align-items-center">

                        <span class="part-count mx-2" id="count_${partInformations.part_id.replace(/\s+/g, '-')}" style="font-size: 16px;">${partInformations.count}</span>

                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>`);

                        partInformationsTable.append(partTable);
                    });


                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        });
        $(document).ready(function () {

            function previewImages(inputId, previewContainerId) {
                const input = $('#' + inputId)[0];
                const previewContainer = $('#' + previewContainerId);


                previewContainer.empty();

                if (input.files) {

                    $.each(input.files, function (index, file) {
                        const reader = new FileReader();

                        reader.onload = function (e) {
                            const img = $('<img />', {
                                src: e.target.result,
                                class: 'img-thumbnail mr-2',
                                style: 'width: 150px; height: auto;'
                            });
                            previewContainer.append(img);
                        }

                        reader.readAsDataURL(file);
                    });
                }
            }

            $('#vehicleRegistrationCertificateImages').on('change', function () {
                previewImages('vehicleRegistrationCertificateImages', 'vehicleRegistrationCertificatePreviews');
            });
        });

        $(document).on('change' , '#accidentCheck' , function(){
            if(this.checked){
                $('.accidentField').removeClass('hidden').show();
            }
            else{
                $('.accidentField').addClass('hidden').hide();
            }
        });

        $(document).on('change' , '#insuranceCheck' , function(){
            if(this.checked){
                $('.insuranceField').removeClass('hidden').show();
            }
            else{
                $('.insuranceField').addClass('hidden').hide();
            }
        });


    </script>
@endsection
