@extends('layouts.user_type.auth')

@section("title", "Catalog List")

@section('css')
    <style>
        .d-flex {
            display: block !important;
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
                    <h5 class="modal-title" id="showCarsModalLabel">Selected Cars</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="parametersSelectContainer2" class="d-flex flex-wrap">
                    </div>
                    <ul id="modalParametersList" class="list-group mt-3">
                    </ul>
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
                            console.log("createfordata", createForData);
                            $('#parametersSelectContainer').remove();
                            $('#dynamicShowCarsButton').remove();

                            var container = $('<div id="parametersSelectContainer"></div>');
                            $('main').append(container);

                            if (Array.isArray(data.parameters) && data.parameters.length > 0) {
                                var addedParameters = {};

                                data.parameters.forEach(function (parameterArray) {
                                    if (Array.isArray(parameterArray)) {
                                        parameterArray.forEach(function (parameter) {
                                            if (parameter && parameter.name) {
                                                if (!addedParameters[parameter.name]) {
                                                    addedParameters[parameter.name] = true;

                                                    var parameterDiv = '<div class="form-group" id="parameterContainer_' + parameter.name + '" class="parameter-container">';
                                                    parameterDiv += '<label>' + parameter.name + '</label>';
                                                    parameterDiv += '<select class="form-control" id="parameter_' + parameter.key + '" name="parameters[' + parameter.name + ']">';
                                                    parameterDiv += '<option value="">Parametre Seçiniz</option>';
                                                    parameterDiv += '<option value="' + parameter.value + '">' + parameter.value + '</option>';
                                                    parameterDiv += '</select></div>';

                                                    container.append(parameterDiv);
                                                } else {
                                                    var select = $('#parameter_' + parameter.key);
                                                    if (select.length > 0) {
                                                        var existingOptions = select.find('option').map(function () {
                                                            return $(this).val();
                                                        }).get();

                                                        if (parameter.value && !existingOptions.includes(parameter.value)) {
                                                            select.append('<option value="' + parameter.value + '">' + parameter.value + '</option>');
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
                var showCarsButton = $('<button id="dynamicShowCarsButton" class="btn btn-primary mt-3">Show Cars</button>');
                $('body').append(showCarsButton);

            }
            $(document).on('click', '#dynamicShowCarsButton', function () {
                modalParameters();
            });


            $(document).on('change', '[id^="parameter2_"]', function () {
                var modalList = $('#modalParametersList');
                modalList.empty();
           });


            function modalParameters(){
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
                                                        <select class="form-control" id="parameter2_${parameter.key}" name="parameters2[${parameter.name}]">
                                                            <option value="">Parametre Seçiniz</option>
                                                            <option value="${parameter.value}">${parameter.value}</option>
                                                        </select>
                                                    </div>`;
                                        container2.append(parameterDiv);
                                    } else {
                                        var select = $('#parameter2_' + parameter.key);
                                        if (select.length > 0) {
                                            var existingOptions = select.find('option').map(function () {
                                                return $(this).val();
                                            }).get();

                                            if (parameter.value && !existingOptions.includes(parameter.value)) {
                                                select.append(`<option value="${parameter.value}">${parameter.value}</option>`);

                                            }
                                        }
                                    }

                                }
                            });
                        }
                        updateModalList()

                        $('#showCarsModal').modal('show');



                    });



                }
            }

            function updateModalList() {

                var modalList = $('#modalParametersList');
                modalList.empty();

                selectedCarData.forEach(function (car) {
                    if (car.Name) {
                        modalList.append(`<li class="list-group-item"><strong>Name:</strong> ${car.Name}</li>`);
                    }
                    if (car.Brand) {
                        modalList.append(`<li class="list-group-item"><strong>Brand:</strong> ${car.Brand}</li>`);
                    }
                    Object.keys(car).forEach(function (key) {
                        if (key !== 'Name' && key !== 'Brand' && key !== 'car_id') {
                            modalList.append(`<li class="list-group-item">${car[key].key}: ${car[key].value}</li>`);
                        }
                    });
                });
            }


        });


    </script>


@endsection
