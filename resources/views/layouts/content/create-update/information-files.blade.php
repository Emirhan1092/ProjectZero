@extends('layouts.user_type.auth')

@section('title')
@endsection
@section('css')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
          integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
          crossorigin=""/>

    <style>
        .hidden{
            display: none;
        }
        .hiddenInsurance{
            display: none;
        }
        .form-control-lg {

            font-size: 1rem ; !important;

        }

        .form-check {
            padding-left: 2rem ; !important;
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

            <form action="{{route('addInformations.store' )}}" method="POST" enctype="multipart/form-data">
                @csrf
                @php
                    use Spatie\Permission\Models\Role;
                    $users = \App\Models\User::where('role' ,'car_owner' )->get();




                @endphp
                <div class="form-group">
                    <label for="customerSelect">Müşteri Seçin</label>
                    <select id="customerSelect" name="customerId" class="form-control form-control-lg @if($errors->has('user')) border-danger @endif">
                        <option value="" class="" disabled selected>Müşteri seçiniz</option>
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
                    <label class="form-check-label" >
                        Kaza Var Mı ?
                    </label>
                </div>



                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="insuranceCheck">
                    <label class="form-check-label">
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
                    <input type="file" id="driverLicenseImages" name="driverLicenseImages[]" multiple class="form-control @if($errors->has('driverLicenseImages')) border-danger @endif" />
                    <div id="driverLicensePreviews" class="mt-2"></div>

                </div>
                @if($errors->has('driverLicenseImages'))
                    <div class="text-danger">{{$errors->first('driverLicenseImages')}}</div>
                @endif

                <div class="mb-3 hiddenInsurance insuranceField">
                    <label>Kasko Poliçesi  Fotokobisi(Max:20 Resim Yüklenebilir )</label>
                    <input type="file" id="insuranceImages" name="insuranceImages[]" multiple class="form-control  @if($errors->has('insuranceImages')) border-danger @endif" />
                    <div id="insurancePreviews" class="mt-2"></div>

                </div>

                @if($errors->has('insuranceImages'))
                    <div class="text-danger">{{$errors->first('insuranceImages')}}</div>
                @endif
                <div class="mb-3">
                    <label>Hasarlı Bölgelerin Fotoğrafları (Max:20 Resim Yüklenebilir )</label>
                    <input type="file" id="damageImages" name="damageImages[]" multiple class="form-control  @if($errors->has('damageImages')) border-danger @endif" />
                    <div id="damagePreviews" class="mt-2"></div>

                </div>

                @if($errors->has('damageImages'))
                    <div class="text-danger">{{$errors->first('damageImages')}}</div>
                @endif
                <div class="mb-3 hidden accidentField">
                    <label>Polis Raporu (Max:20 Resim Yüklenebilir )</label>
                    <input type="file" id="policeReportImages" name="policeReportImages[]" multiple class="form-control  @if($errors->has('policeReportImages')) border-danger @endif" />
                    <div id="policeReportPreviews" class="mt-2"></div>

                </div>

                @if($errors->has('policeReportImages'))
                    <div class="text-danger">{{$errors->first('policeReportImages')}}</div>
                @endif
                <div class="mb-3 hidden accidentField">
                    <label>Sigorta Poliçesi Fotokobisi (Max:20 Resim Yüklenebilir )</label>
                    <input type="file" id="trafficInsuranceImages" name="trafficInsuranceImages[]" multiple class="form-control  @if($errors->has('trafficInsuranceImages')) border-danger @endif" />
                    <div id="trafficInsurancePreviews" class="mt-2"></div>

                </div>
                @if($errors->has('trafficInsuranceImages'))
                    <div class="text-danger">{{$errors->first('trafficInsuranceImages')}}</div>
                @endif
                <div class="mb-3 hidden accidentField">
                    <label>Kaza Tespit Tutanağı Fotokobisi (Max:20 Resim Yüklenebilir )</label>
                    <input type="file"  id="accidentReportImages" name="accidentReportImages[]" multiple class="form-control @if($errors->has('accidentReportImages')) border-danger @endif" />
                    <div id="accidentReportPreviews" class="mt-2"></div>

                </div>

                @if($errors->has('accidentReportImages'))
                    <div class="text-danger">{{$errors->first('accidentReportImages')}}</div>
                @endif

                @php

                    $Insurers = \App\Models\Insurer::all();



                @endphp
                <div class="card">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sigrotacı İsmi</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Sigortacı Addresi</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Seç</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($Insurers as $Insurer)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-xs">{{$Insurer->insurer_name}}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{$Insurer->address}}</p>

                                    </td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{$Insurer->id}}" name="insurer_{{$Insurer->id}}" id="InsurerCheckBox_{{$Insurer->id}}">
                                            <label class="form-check-label" for="InsurerCheckBox_{{$Insurer->id}}">
                                                Ekle
                                            </label>
                                        </div>
                                    </td>
                                </tr>


                            </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </form>


                <div class="col-12">
                    <div class="buttons d-flex justify-content-between" id="buttonsToFınısh">

                        <button type="submit"  id="buttonToSendInsurance" class="btn btn-block bg-gradient-primary m-3  " >Sigortacıya Gönder</button>


                        <button type="button"  id="buttonToSelectInsurance" class="btn btn-block bg-gradient-primary m-3"  data-bs-toggle="modal" data-bs-target="#modal-default">Sigortacı  Seç</button>


                    </div>
                </div>
        </div>
    </div>


            <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
                <div class="modal-dialog" style="max-width: 90%;">
                    <div class="modal-content">

                        <div class="container pt-5 pb-5">
                            <div class="row justify-content-md-center">
                                <input class="mb-3" id="search" style="width: 350px;" type="text">
                                <button type="button" class="btn btn-block bg-gradient-primary mb-3" style="width:1000px" id="search-button">Search</button>
                            </div>
                            @php

                                $Insurers = \App\Models\Insurer::all();



                            @endphp
                            <div class="card">
                                <div class="table-responsive">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sigrotacı İsmi</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Sigortacı Addresi</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Seç</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($Insurers as $Insurer)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-xs">{{$Insurer->insurer_name}}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{$Insurer->address}}</p>

                                                </td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="{{$Insurer->id}}" name="insurer_{{$Insurer->id}}" id="InsurerCheckBox_Modal_{{$Insurer->id}}">
                                                        <label class="form-check-label" for="InsurerCheckBox_Modal_{{$Insurer->id}}">
                                                            Ekle
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>


                                        </tbody>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <ul id="result-list" class="col-4 list-group">
                                </ul>
                                <div class="col-8">
                                    <div id="map-container" style="height: 75vh;"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


@endsection
@section('js')
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
                    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
                    crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
                    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
                    crossorigin="anonymous"></script>
            <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
                    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
                    crossorigin=""></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/js-base64/3.7.5/base64.min.js"></script>


            <script>
                const searchInput = document.getElementById('search');
                const resultList = document.getElementById('result-list');
                const mapContainer = document.getElementById('map-container');
                const currentMarkers = [];

                const map = L.map(mapContainer).setView([20.13847, 1.40625], 2);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                document.getElementById('search-button').addEventListener('click', () => {
                    const query = searchInput.value;
                    fetch('https://nominatim.openstreetmap.org/search?format=json&polygon=1&addressdetails=1&q=' + query)
                        .then(result => result.json())
                        .then(parsedResult => {
                            setResultList(parsedResult);
                        });
                });

                function setResultList(parsedResult) {
                    resultList.innerHTML = "";
                    for (const marker of currentMarkers) {
                        map.removeLayer(marker);
                    }
                    map.flyTo(new L.LatLng(20.13847, 1.40625), 2);
                    for (const result of parsedResult) {
                        const li = document.createElement('li');
                        li.classList.add('list-group-item', 'list-group-item-action');
                        li.innerHTML = JSON.stringify({
                            displayName: result.display_name,
                            lat: result.lat,
                            lon: result.lon
                        }, undefined, 2);
                        li.addEventListener('click', (event) => {
                            for(const child of resultList.children) {
                                child.classList.remove('active');
                            }
                            event.target.classList.add('active');
                            const clickedData = JSON.parse(event.target.innerHTML);
                            const position = new L.LatLng(clickedData.lat, clickedData.lon);
                            map.flyTo(position, 10);
                        })
                        const position = new L.LatLng(result.lat, result.lon);
                        currentMarkers.push(new L.marker(position).addTo(map));
                        resultList.appendChild(li);
                    }
                }
                $(document).ready(function() {

                    $(document).on('change', '.form-check-input[id^="InsurerCheckBox_Modal_"]', function() {
                        var modalCheckboxId = $(this).attr('id');
                        var checkboxId = modalCheckboxId.replace('Modal_', '');

                        if (this.checked) {
                            $('#'+checkboxId).prop('checked', true);
                        } else {
                            $('#'+checkboxId).prop('checked', false);
                        }
                    });

                    $(document).on('change', '.form-check-input[id^="InsurerCheckBox_"]', function() {
                        var checkboxId = $(this).attr('id');
                        var modalCheckboxId = 'InsurerCheckBox_Modal_' + checkboxId.split('_')[1];

                        if (this.checked) {
                            $('#'+modalCheckboxId).prop('checked', true);
                        } else {
                            $('#'+modalCheckboxId).prop('checked', false);
                        }
                    });


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
                    var partInformationsTable = $('#partInformationsTable');
                    partInformationsTable.empty();
                    response.forEach(function(partInformations){


                        var partTable = $(`
<div class="table-responsive rounded-0 border-1 p-2 mb-3">
    <table class="table align-items-center mb-0 border">
        <tbody>

                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="${partInformations.part_id}/${partInformations.count}" name="partInfo_${partInformations.part_id}" id="flexCheckIndeterminate">
                        <label class="form-check-label" for="flexCheckIndeterminate">
                            Ekle
                        </label>
                    </div>
                </td>
                <td>
                    <div class="d-flex px-2">
                        <div>
                            <img src="${partInformations.image}" alt="${partInformations.part_id}" style="width: 100px; height: 100px">
                        </div>
                    </div>
                </td>
                <td>
                    <p class="text-xs font-weight-normal mb-0">${partInformations.part_id}</p>
                </td>
                <td class="align-middle text-start">
                    <div class="d-flex align-items-between justify-content-start">
                        <button class="btn btn-link pl-2 decrement" type="button" id="decrement_${partInformations.part_id}/${partInformations.part_group_id}/${partInformations.car_id}" style="font-size: 20px; cursor: pointer;">
                            <i class="fa-solid fa-minus" style="color:black"></i>
                        </button>
                        <span class="part-count mx-2 align-text-center mb-3 p-3" id="count_${partInformations.part_id.replace(/\s+/g, '-')}" style="font-size: 16px;">${partInformations.count}</span>
                        <button class="btn btn-link pl-2 increment" type="button" id="increment_${partInformations.part_id}/${partInformations.part_group_id}/${partInformations.car_id}" style="font-size: 20px; cursor: pointer;">
                            <i class="fa-solid fa-plus" style="color:black"></i>
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
`);


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
            $('#driverLicenseImages').on('change', function () {
                previewImages('driverLicenseImages', 'driverLicensePreviews');

            });
            $('#insuranceImages').on('change', function () {
                previewImages('insuranceImages', 'insurancePreviews');
            });
            $('#damageImages').on('change', function () {
                previewImages('damageImages', 'damagePreviews');
            });
            $('#policeReportImages').on('change', function () {
                previewImages('policeReportImages', 'policeReportPreviews');
            });
            $('#trafficInsuranceImages').on('change', function () {
                previewImages('trafficInsuranceImages', 'trafficInsurancePreviews');
            });
            $('#accidentReportImages').on('change', function () {
                previewImages('accidentReportImages', 'accidentReportPreviews');
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


        $('#buttonToSendInsurance').on('click', function() {
           $('form').submit(); // Formu gönder
       });
        $(document).on('click', '[id^="increment_"], [id^="decrement_"]', function () {
            var id = $(this).attr('id');
            var action = id.startsWith('increment_') ? 'increment' : 'decrement';
            var parts = id.replace(/(increment_|decrement_)/, '').split('/');
            var part_id = parts[0]
            var part_id_for_count = parts[0].replace(/\s+/g, '-');
            var group_id = parts[1];
            var car_id = parts[2];


            var countSpan = $(`#count_${part_id_for_count}`);
            console.log("countSpan", countSpan.attr('id'));

            var currentCount = parseInt(countSpan.text(), 10);

            if (action === 'increment') {
                currentCount++;
            } else if (action === 'decrement' && currentCount > 0) {
                currentCount--;
            }

            countSpan.text(currentCount);


                $.ajax({
                    url: '/update-part',
                    method: 'GET',
                    data: {
                        part_id: part_id,
                        group_id: group_id,
                        car_id: car_id,
                        count: currentCount,
                    },
                    success: function (response) {
                        console.log("Veritabanı güncellendi", response);
                    },
                    error: function (error) {
                        console.log('Error:', error);
                    }
                });
            });

        });

    </script>
@endsection
