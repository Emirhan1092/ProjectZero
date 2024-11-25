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
        #showCarsModal .modal-dialog {
            max-width: 75%;
        }
        .float-container {
            display: flex; /* Sütunları hizalamak için flex düzeni */
            gap: 10px; /* Aradaki boşluk */
            padding: 20px;
        }

        .float-child {
            flex: 1; /* Tüm sütunlar eşit genişlikte */
            padding: 20px;
            box-sizing: border-box; /* Padding dahil */
        }

        .float-column {
            height: 100%; /* Yüksekliği tam yapar */
        }

        .float-child3 {
            display: flex;
            justify-content: space-between;
        }


        /* Resimlerin boyutlarını büyütmek için stil */
        .custom-img {
            max-width: 100%;   /* Resim genişliği %100 olacak şekilde */
            height: 400px;     /* Yüksekliği 400px olarak ayarlayabilirsiniz */
            object-fit: contain;  /* Resmin boyutunu bozmadan sığdırır */
        }
        /* Modal body'sinin kaydırılabilir yapıldığı ve kaydırma çubuğunun eklenmesi */
        .modal-body {
            max-height: 70vh;   /* Modal body'nin maksimum yüksekliği */
            overflow-y: auto;   /* Yalnızca dikey kaydırma çubuğu ekler */
        }

        /* Yalnızca modal içinde değil, diğer içeriklerin de kaydırılabilir olması */
        .float-container {
            display: flex;
            overflow: hidden;
        }

        .float-child1, .float-child2 {
            flex: 1;
            overflow-y: auto; /* Yalnızca y ekseninde kaydırma çubuğu */
            max-height: 100%;  /* Yükseklik sınırlaması */
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
        <div class="modal-dialog w-50">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body float-container">
                    <div class="float-child1">
                        <div id="parametersSelectContainer2" class="float-column green ">
                        </div>
                    </div>
                    <div class="float-child2">
                        <div id="modalParametersList" class="float-column yellow">
                        </div>
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
                var float1 = $('#float-child1');
                float1.empty();
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
            response2 = [];
            function listCarPartsCatalog(response) {
                var modalList = $('#modalParametersList');
                var container2 = $('#parametersSelectContainer2');
                container2.empty();
                modalList.empty();

                response1 = response;

                response.forEach(function (car) {
                    var ul = $('<ul class="p-0 col-12 ul-list-group1-item1_' + car.part_id + '" id="list_group1_item1' + car.part_id + `"></ul>`);
                    container2.append(ul);

                    if (car.groupName) {
                        var groupItem = $('<li class="list-group-item1" id="group-' + car.part_id + '">' + car.groupName + '</li>');
                        ul.append(groupItem);

                        var subGroupList = $('<ul class="sub-group-list" style="display: none;"></ul>');

                        groupItem.on('click', function (event) {
                            event.preventDefault();

                            if (subGroupList.children().length === 0) {
                                if (car.subGroupNames && car.subGroupNames.length > 0) {
                                    car.subGroupNames.forEach(function (subname) {
                                        var subnameItem = $('<li class="list-group-item31 subname-item" id="subgroup-' + subname.subGroupName + '">' + subname.subGroupName + '</li>');
                                        subGroupList.append(subnameItem);
                                    });
                                }
                                groupItem.append(subGroupList);
                            }

                            subGroupList.toggle();

                            var rightPane = $('#modalParametersList');
                            rightPane.empty();

                            console.log("Tıklanan Part ID:", car.part_id);
                            console.log("Part Informations:", car.PartInformations);

                            car.PartInformations.forEach(function (partInfo) {
                                var partItem = $('<div class="part-item mb-3">');
                                partItem.append('<strong>Part Name:</strong> ' + partInfo.partName);

                                var imagePath = partInfo.img.startsWith('//') ? 'https:' + partInfo.img : partInfo.img;
                                partItem.append('<br><img src="' + imagePath + '" alt="' + partInfo.partName + '" class="custom-img" id="' + partInfo.part_group_id + '" style="border: 1px solid black;  border-radius: 10px;"/>');

                                rightPane.append(partItem);

                            });
                            $(document).on('click',  'img', function(){
                               var partGroupId= $(this).attr('id');
                               console.log("part group ıd 31 " , partGroupId);
                                $.ajax({
                                    url: '/car/catalog/'+  partGroupId +'/parameters',
                                    method: 'GET',
                                    data: {  partGroupId },
                                    traditional: true,
                                    success: function (response) {
                                        console.log('Sunucudan gelen yanıt Part Group Id:', response);
                                        partsView(response);
                                    },
                                    error: function (xhr, status, error) {
                                        console.error('AJAX hatası:', status, error);
                                        alert('Bir hata oluştu!');
                                    }
                                });
                            });

                        });
                    }
                });
            }







            $(document).on('click', '.list-group-item', function () {
                var car_id = $(this).closest('ul').attr('id');
                console.log('Tıkla2112:', car_id);

                $.ajax({
                    url: '/cars/car_id/' + car_id + '/parameters',
                    method: 'GET',
                    data: { car_id },
                    traditional: true,
                    success: function (response2) {
                        console.log('Sunucudan gelen yanıt:', response2);
                        listCarPartsCatalog(response2);
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX hatası:', status, error);
                        alert('Bir hata oluştu!');
                    }
                });
            });
            function partsView(response) {
                var modalList = $('#modalParametersList');
                var container2 = $('#parametersSelectContainer2');
                container2.empty();
                modalList.empty();

                var groupItem = $('<ul class="list-group-item22 text-align:left" id="group-' + response[0].brand_name + '" style="text-align: center;">' +
                    '<br><strong>' + response[0].brand_name + '</strong> ' +
                    '<strong>' + response[0].name + '</strong></br>' +
                    '</ul>');
                container2.append(groupItem);

                var imagePath = response[0].schema_img.startsWith('//') ? 'https:' + response[0].schema_img : response[0].schema_img;
                container2.append('<br><img src="' + imagePath + '" alt="' + response[0].brand_name + '" class="custom-img" id="'+ response[0].brand_name+ '" style="border: 1px solid black; border-radius: 10px; display: block; margin: 0 auto; "/>');


                response.forEach(function (parts) {
                    var element = $('<div class="container mt-5"></div>');
                    modalList.append(element);

                    var card = $(`
            <div class="card shadow-sm" style="cursor: pointer;">
                <div class="card-body position-relative">
                    <span class="text-muted position-absolute top-0 end-0 me-3 mt-2">${parts.position_number}</span>
                    <h5 class="card-title text-primary">${parts.name}</h5>
                    <p class="card-text text-muted">${parts.number}</p>
                </div>
            </div>
        `);

                    element.append(card);

                    card.on('click', function () {
                        var cardFooter = $(`
        <div class="card-footer bg-light border-top">
            <ul class="sub-group-list">
                <li class="p-0 col-12 ul-list-group-item_${parts.part_id}" id="${parts.part_id}" style="display: flex; align-items: center; justify-content: space-between;">
                    <span>${parts.brand_name}&nbsp;&nbsp;&nbsp;&nbsp;${parts.part_id}</span>
                    <button class="btn btn-link p-0 ms-3" style="font-size: 20px; cursor: pointer; display: flex; align-items: center;">
                        <span class="material-symbols-outlined" style="line-height: 1;">
                            shopping_cart
                        </span>
                    </button>
                </li>
            </ul>
        </div>
    `);
                        if (card.find('.card-footer').length > 0) {
                            card.find('.card-footer').toggle();
                        } else {
                            card.append(cardFooter);
                        }


                    });

                });


            }

        });


    </script>



@endsection
