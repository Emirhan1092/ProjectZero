@extends('layouts.user_type.auth')

@section("title", "Catalog List")

@section('css')
    <style>
        .d-flex {
            display: block !important;
        }
        .select-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .select-like {
            appearance: none;
            -moz-appearance: none;
            -webkit-appearance: none;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            font-size: 1rem;
            width: 100%;
            cursor: pointer;
        }
        .datalist-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .datalist-wrapper input {
            appearance: none;
            -moz-appearance: none;
            -webkit-appearance: none;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            font-size: 1rem;
            width: 100%;
            cursor: pointer;
        }





    </style>
@endsection

@section("content")

    <div class="form-group">
        <label for="catalogSelect">Car Katalog</label>
        <select class="form-control" id="catalogSelect">
            <option value="">Catalog Seçiniz</option>
            @foreach($catalogs as $catalog)
                <option value="{{$catalog->catalog_id}}">{{$catalog->brand_name}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="modelSelect">Models</label>
        <select class="form-control" id="modelSelect">
            <option value="">Model Seçiniz</option>
        </select>
    </div>

    <div class="modal fade" id="showCarsModal" tabindex="-1" aria-labelledby="showCarsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="parametersSelectContainer2" class="d-flex flex-wrap">
                    </div>
                    <div id="modalParametersList" class="list-group mt-3">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#catalogSelect').on('change', function () {
                var catalogName = $(this).val();

                if (catalogName) {
                    $.ajax({
                        url: '/cars/catalog/' + catalogName + '/models',
                        method: 'GET',
                        success: function (data) {
                            console.log("Veri geldi:", data);

                            if (Array.isArray(data.models) && data.models.length > 0) {
                                $('#modelSelect').empty().append('<option value="">Model Seçiniz</option>');
                                data.models.forEach(function (model) {
                                    $('#modelSelect').append('<option value="' + model + '">' + model + '</option>');
                                });
                            } else {
                                $('#modelSelect').empty().append('<option value="">Model bulunamadı</option>');
                            }
                        },
                        error: function () {
                            alert("Bir hata oluştu!");
                        }
                    });
                } else {
                    $('#modelSelect').empty().append('<option value="">Model Seçiniz</option>');
                }
            });
            var createForData = [];
            $('#modelSelect').on('change', function () {
                var modelName = $(this).val();
                var catalogName = $('#catalogSelect').val();

                if (modelName && catalogName) {
                    $.ajax({
                        url: '/cars/catalog/' + catalogName + '/models/' + modelName + '/parameters',
                        method: 'GET',
                        success: function (data) {
                            createForData = data;
                            console.log("createForData", createForData);

                            $('#parametersSelectContainer').remove();
                            $('#dynamicShowCarsButton').remove();

                            var container = $('<div id="parametersSelectContainer"></div>');
                            container.insertBefore('#footer');

                            if (Array.isArray(data.parameters) && data.parameters.length > 0) {
                                var addedParameters = {};

                                data.parameters.forEach(function (parameterArray) {
                                    if (Array.isArray(parameterArray)) {
                                        parameterArray.forEach(function (parameter) {
                                            if (parameter && parameter.name) {
                                                if (!addedParameters[parameter.name]) {
                                                    addedParameters[parameter.name] = true;

                                                    var parameterDiv = `
                                            <div class="form-group" id="parameterContainer_${parameter.name}">
                                                <label>${parameter.name}</label>
                                                <div class="datalist-wrapper">
                                                    <input
                                                        class="form-control"
                                                        id="parameter_${parameter.key}"
                                                        name="parameters[${parameter.name}]"
                                                        list="parameterOptions_${parameter.key}"
                                                        placeholder="${parameter.name} Seçiniz"
                                                        autocomplete="off">
                                                    <datalist id="parameterOptions_${parameter.key}">
                                                        <option value="${parameter.value}"></option>
                                                    </datalist>
                                                </div>
                                            </div>`;
                                                    container.append(parameterDiv);
                                                } else {
                                                    var datalist = $('#parameterOptions_' + parameter.key);
                                                    if (datalist.length > 0) {
                                                        var existingOptions = datalist.find('option').map(function () {
                                                            return $(this).val();
                                                        }).get();

                                                        if (parameter.value && !existingOptions.includes(parameter.value)) {
                                                            datalist.append(`<option value="${parameter.value}"></option>`);
                                                        }
                                                    }
                                                }
                                            }
                                        });
                                    }
                                });

                                createShowCarsButton();
                            } else {
                                container.append('<p>Parametre bulunamadı</p>');
                            }
                        },
                        error: function () {
                            alert("Bir hata oluştu!");
                        }
                    });
                } else {
                    $('#parametersSelectContainer').remove();
                    $('#dynamicShowCarsButton').fadeOut();
                }
            });


            var selectedCarData = [];

            $(document).on('change', '[id^="parameter2_"]', function () {

                var changedId = $(this).attr('id');
                var changedValue = $(this).val();

                if (changedId.startsWith("parameter2_")) {
                    var key = changedId.replace('parameter2_', '');
                    $('#parameter_' + key).val(changedValue);

                }

                updateSelectedValues();
            });
            $('#showCarsModal').on('shown.bs.modal', function () {
                $('[id^="parameter_"]').each(function () {
                    var key = $(this).attr('id').replace('parameter_', '');
                    var value = $(this).val();

                    var targetSelect = $('#parameter2_' + key);
                    if (targetSelect.length > 0) {
                        targetSelect.val(value);
                        updateSelectedValues();
                    }
                });
            });


            function updateSelectedValues() {
                var selectedValues = [];

                $('[id^="parameter_"]').each(function () {
                    var selectedValue = $(this).val();
                    var key = $(this).attr('id').replace('parameter_', '');
                    if (selectedValue && !selectedValues.some(v => v.key === key)) {
                        selectedValues.push({key: key, value: selectedValue});
                        console.log("selectedValues1 ", selectedValues);


                    }
                });

                $('[id^="parameter2_"]').each(function () {
                    var selectedValue = $(this).val();
                    var key = $(this).attr('id').replace('parameter2_', '');
                    if (selectedValue && !selectedValues.some(v => v.key === key)) {
                        selectedValues.push({key: key, value: selectedValue});
                        console.log("selectedValues ", selectedValues);

                    }
                });

                console.log('Seçilen Değerler:', selectedValues);
                var modelName = $('#modelSelect').val();

                $.ajax({
                    url: '/cars/models/' + modelName + '/parameters',
                    method: 'GET',
                    data: {
                        selectedValues: JSON.stringify(selectedValues),
                    },
                    traditional: true,
                    success: function (response) {
                        console.log('Sunucudan gelen yanıt:', response);

                        if (response.length > 0) {
                            selectedCarData = response;
                            updateModalList()
                            console.log("selectedCarData, response ile güncellendi:", selectedCarData);
                        } else {
                            selectedCarData = response;
                            updateModalList()
                            console.log('Herhangi bir parametre bulunamadı');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX hatası:', status, error);
                        alert('Bir hata oluştu!');
                    }
                });
            }


            function createShowCarsButton() {
                var showCarsButton = $('<button id="dynamicShowCarsButton" class="btn btn-primary mt-3 mx-auto d-grid col-4 mx-auto">Show Cars</button>');
                (showCarsButton).insertBefore('#footer');

            }
            $(document).on('click', '#dynamicShowCarsButton', function () {
                modalParameters();
            });


            $(document).on('change', '[id^="parameter2_"]', function () {
                var modalList = $('#modalParametersList');
                modalList.empty();
           });


            function modalParameters() {
                var container2 = $('#parametersSelectContainer2');
                container2.empty();
                console.log("caqadawe", createForData);

                if (Array.isArray(createForData.parameters) && createForData.parameters.length > 0) {
                    var addedParameters = {};

                    createForData.parameters.forEach(function (parameterArray) {
                        if (Array.isArray(parameterArray)) {
                            parameterArray.forEach(function (parameter) {
                                if (parameter && parameter.name) {
                                    if (!addedParameters[parameter.name]) {
                                        addedParameters[parameter.name] = true;

                                        var parameterDiv = `
                                <div class="form-group d-flex me-3" id="parameterContainer2_${parameter.name}">
                                    <label class="me-2">${parameter.name}</label>
                                    <div class="select-wrapper">
                                        <input
                                            class="form-control select-like"
                                            id="parameter2_${parameter.key}"
                                            name="parameters2[${parameter.name}]"
                                            list="parameterOptions_${parameter.key}"
                                            placeholder="${parameter.name} Seçiniz"
                                            autocomplete="off">
                                        <datalist id="parameterOptions_${parameter.key}">

                                            <option value="${parameter.value}"></option>
                                        </datalist>
                                    </div>
                                </div>`;
                                        container2.append(parameterDiv);
                                    } else {
                                        var datalist = $('#parameterOptions_' + parameter.key);
                                        if (datalist.length > 0) {
                                            var existingOptions = datalist.find('option').map(function () {
                                                return $(this).val();
                                            }).get();

                                            if (parameter.value && !existingOptions.includes(parameter.value)) {
                                                datalist.append(`<option value="${parameter.value}"></option>`);
                                            }
                                        }
                                    }
                                }
                            });
                        }
                        updateModalList();

                        $('#showCarsModal').modal('show');
                    });
                }
            }


            function updateModalList() {
                var modalList = $('#modalParametersList');
                modalList.empty();

                selectedCarData.forEach(function (car) {
                    var ul = $('<ul class="p-0 col-12 ul-list-group-item_' + car.car_id + '" id="' + car.car_id + '"></ul>');
                    modalList.append(ul);

                    if (car.Name) {
                        ul.append('<li class="list-group-item"><strong>Name:</strong> ' + car.Name + '</li>');
                    }
                    if (car.Brand) {
                        ul.append('<li class="list-group-item"><strong>Brand:</strong> ' + car.Brand + '</li>');
                    }

                    Object.keys(car).forEach(function (key) {
                        if (key !== 'Name' && key !== 'Brand' && key !== 'car_id' && key !== 'ModelImage') {
                            ul.append('<li class="list-group-item">' + car[key].key + ': ' + car[key].value + '</li>');
                        }
                    });

                    if (car.ModelImage) {
                        var imagePath = car.ModelImage;
                        if (!imagePath.startsWith('//')) {
                            imagePath = 'https://your-default-base-url.com/' + imagePath;
                        }

                        ul.append('<li class="list-group-item"><img src="' + imagePath + '" alt="Car Image" class="img-fluid" style="max-width: 100%; height: auto;" /></li>');
                    }

                });



        }

             response1 = [];
            function listCarPartsCatalog(response) {
                var modalList = $('#modalParametersList');
                var container2 = $('#parametersSelectContainer2');
                container2.empty();
                modalList.empty();
               response1 = response;
                response.forEach(function (car) {
                    var ul = $('<ul class="p-0 col-12 ul-list-group-item1_' + car.car_id + '" id="' + car.car_id + `"></ul>`);
                    modalList.append(ul);

                    if (car.groupName) {
                        var groupItem = $('<li class="list-group-item1"> ' + car.groupName + '</li>');
                        ul.append(groupItem);



                    }
                });
            }

            $(document).on('click', '.list-group-item1', function (event) {
                event.preventDefault();

                var modalList = $('#modalParametersList');
                var container2 = $('#parametersSelectContainer2');
                container2.empty();
                modalList.empty();
                var groupItem = $(this);
                var ul = groupItem.closest('ul');
                ul.empty();
                response1.forEach(function (car) {
                    var ul = $('<ul class="p-0 col-12 ul-list-group-item1_' + car.car_id + '" id="' + car.car_id + `"></ul>`);
                    modalList.append(ul);

                    if (car.groupName) {
                        var groupItem = $('<li class="list-group-item1"> ' + car.groupName + '</li>');
                        ul.append(groupItem);

                        car.subGroupNames.forEach(function(subGroup) {
                            var subGroupItem = $('<li class="list-group-item1"><strong>SubGroup:</strong> ' + subGroup.subGroupName + '</li>');
                            ul.append(subGroupItem);
                        });

                        car.PartInformations.forEach(function(partInfo) {
                            var partItem = $('<li class="list-group-item">');
                            partItem.append('<strong>Part Name:</strong> ' + partInfo.partName);

                            var imagePath = partInfo.img.startsWith('//') ? 'https:' + partInfo.img : partInfo.img;
                            partItem.append('<br><img src="' + imagePath + '" alt="' + partInfo.partName + '" class="img-fluid" style="max-width: 100%; height: auto;" />');

                            ul.append(partItem);
                        });


                    }});






            });




            $(document).on('click', '.list-group-item', function () {
                var car_id = $(this).closest('ul').attr('id');
                console.log('Tıkla2112:', car_id);
           $.ajax({
               url: '/cars/car_id/' + car_id + '/parameters',
               method: 'GET',
               data: {
                   car_id,
               },
               traditional: true,
               success: function (response) {
                   console.log('Sunucudan gelen yanıt:', response);
                   listCarPartsCatalog(response);
               },
               error: function (xhr, status, error) {
                   console.error('AJAX hatası:', status, error);
                   alert('Bir hata oluştu!');
               }
           });




       });


        });


    </script>



@endsection
