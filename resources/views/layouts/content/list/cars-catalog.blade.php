@extends('layouts.user_type.auth')

@section("title", "Catalog List")

@section('css')
    <style>
        .cards-scroll-container {
            max-height: 800px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #f9f9f9;
        }
        .cards-scroll-container2 {
            max-height: 1000px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #f9f9f9;
        }

        .card {
            margin-bottom: 15px;
        }

        .part-item {
            display: block;
            margin-bottom: 20px;
            width: 100%;
            text-align: center;
        }

        .part-name {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .custom-img1 {
            display: block;
            margin: 0 auto;
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
            display: flex;
            gap: 10px;
            padding: 20px;
        }

        .float-child {
            flex: 1;
            padding: 20px;
            box-sizing: border-box;
        }


        .datalist-wrapper{


            display: inline-block;
            width: 100%;
        }
        .float-column {
            height: 100%;
        }

        .float-child3 {
            display: flex;
            justify-content: space-between;
        }


        .custom-img {
            max-width: 100%;
            height: 600px;
            object-fit: contain;
        }
        .custom-img3 {
            max-width: 100%;
            height: 550px;
            object-fit: contain;
        }


        .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }

        .float-container {
            display: flex;
            overflow: hidden;
        }

        .float-child1, .float-child2 {
            flex: 1;
            overflow-y: auto;
            max-height: 100%;
        }

        li.btn {
            border-radius: 0.5rem 0.5rem 0  0 !important;
            margin-bottom: 0 !important;
        }

        ul {
            list-style: none;
            margin-bottom: 0 ; !important;
        }

        .center-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }



        .list-group-item1 {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            font-weight: bold;
        }

        .sub-group-list {
            margin-left: 20px;
            padding-left: 0;
        }

        .child-list {
            margin-left: 30px;
            padding-left: 0;
        }

        .child-list3 {
            margin-left: 40px;
            padding-left: 0;

        }


        .sub-group-list li,
        .child-list li,
        .child-list3 li {
            margin: 3px 0;
            padding: 5px 15px;
        }

        .list-group-item1,
        .sub-group-list li,
        .child-list li,
        .child-list3 li {
            padding-left: 20px;
        }



        #parametersSelectContainer {
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            padding: 20px 0;
        }

        .form-group {
            width: 100%;
            max-width: 400px;
            margin: 10px auto;
            box-sizing: border-box;
        }

        .form-control {
            width: 100%;
            box-sizing: border-box;
        }


        .outer-container {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .table-container {
            border: 2px solid #9933ff;
            padding: 10px;
            border-radius : 25px ;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f0f8ff;
        }

        .table tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        .table th {
            background-color: #923dfa;
            color: #000000;
        }

        .table th, .table td {
            font-weight: bold;
        }
        table tbody tr {
            cursor: pointer;
        }

        table tbody tr:hover {
            background-color: #9933ff;

        }

        #allCarsTable_wrapper {
            position: relative;
            padding-bottom: 50px;
        }
        #exampleModal .modal-dialog {
            max-width: 50%;
            width: 50%;
        }

        #exampleModal .modal-content {
            height: auto;
        }


    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

@endsection

@section("content")
    <div class="row justify-content-center" id="catalogDom">

    <div class="form-group col-md-6">
        <label for="catalogSelect">Car Katalog</label>
        <select class="form-control" id="catalogSelect">
            <option value="">Catalog Seçiniz</option>
            @foreach($catalogs as $catalog)
                <option value="{{$catalog->catalog_id}}">{{$catalog->brand_name}}</option>
            @endforeach
        </select>
    </div>
    </div>

<div id="modalParametersList"></div>




@endsection

@section('js')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>



        $(document).ready(function () {
            $('#catalogSelect').on('change', function () {
                var catalogName = $(this).val();
                var catalogSelectElement = $(this);
                var modalList = $('#parametersSelectContainer2');
                var container2 = $('#parametersSelectContainer3');
                modalList.empty();
                container2.empty();
                if (catalogName) {
                    $.ajax({
                        url: '/cars/catalog/' + catalogName + '/models',
                        method: 'GET',
                        success: function (data) {
                            console.log("Veri geldi:", data);
                            var modalContainer = $('#modelContainer')
                            modalContainer.remove();
                            var modalDiv = $(`
                        <div id="modelContainer" class="form-group col-md-6 mt-3">
                            <label for="modelSelect">Models</label>
                            <select class="form-control" id="modelSelect">
                                <option value="">Model Seçiniz</option>
                            </select>
                        </div>
                    `);

                            catalogSelectElement.after(modalDiv);

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
                }


            });


            let addCarsPartsList = [];

            function addOrUpdateCustomerCar(addCarsPartsList, selectedCustomerId, selectedCarId, partId = null, groupId = null) {
                // İlk başta sadece customerId ve customerCarId ile arama yap
                let existingEntry = addCarsPartsList.find(item =>
                    item.customerId === selectedCustomerId && item.customerCarId === selectedCarId
                );

                if (!existingEntry) {
                    // Eğer yoksa sadece customerId ve customerCarId ile ekle
                    addCarsPartsList.push({
                        'customerId': selectedCustomerId,
                        'customerCarId': selectedCarId,
                    });
                }

                // Eğer partId ve groupId varsa, ekle veya güncelle
                if (partId && groupId) {
                    let partEntry = addCarsPartsList.find(item =>
                        item.customerId === selectedCustomerId &&
                        item.customerCarId === selectedCarId &&
                        item.partId === partId &&
                        item.groupId === groupId
                    );

                    if (!partEntry) {
                        addCarsPartsList.push({
                            'customerId': selectedCustomerId,
                            'customerCarId': selectedCarId,
                            'partId': partId,
                            'groupId': groupId,
                            'count': 0  // Başlangıçta count 0 olabilir
                        });
                    } else {
                        partEntry.count = partEntry.count || 0; // mevcut count varsa, yoksa 0 olarak başlat
                    }
                }

                console.log('addCarsPartsList:', addCarsPartsList);
            }


            function justShowCarsButton() {
                var buttonsDiv =   $('<div class="buttons d-flex justify-content-between" id="dynamicShowCarsButtons"> </div>');
                var justShowCarsButton = $('<button id="justShowCarsButton" class="btn btn-primary mt-3 mx-auto d-grid col-4 mx-auto" >Show Cars</button>');
                buttonsDiv.append(justShowCarsButton);
                buttonsDiv.insertBefore('#footer');

            }
            function addCarsPartButton(){
                var buttonsDiv = $('#dynamicShowCarsButtons')
                var addCarsButton = $('<button id="addCarsPartButton" class="btn btn-primary mt-3 mx-auto d-grid col-4 mx-auto" >Add Cars Part</button>');
                buttonsDiv.append(addCarsButton);
            }

            $(document).on('click', '#addCarsPartButton, #justShowCarsButton', function () {
                var Id = $(this).attr('id');

                if (Id === 'addCarsPartButton') {
                    parametersChange ();
                    updateModalList();
                    $.ajax({
                        url: '/addAndSelectUser',
                        method: 'GET',
                        success: function (data) {
                            var nameOptions = data.users.map(function(user) {
                                return `<option value="${user.name}" data-id="${user.id}">`;
                            }).join('');

                            var modalHtml = $(`
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header justify-content-between">
                                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Müşteri Araç Seçimi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    <button class="btn btn-info m-1" id="createUserButton">Müşteri Oluştur</button>
                                    <button class="btn btn-info m-1" id="createVehicleButton">Araç Oluştur</button>

                                </div>

                                <div class="modal-body">
                                    <label for="nameSelect">Select Name:</label>
                                    <input list="nameList" id="nameSelect" class="form-control" placeholder="Search by name">
                                    <datalist id="nameList">
                                        ${nameOptions}
                                    </datalist>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" id="selectCustomerAndCar" class="btn btn-primary">Seçimi Onayla</button>

</div>
                            </div>
                        </div>
                    </div>
                `);

                            $('body').append(modalHtml);
                            $('#exampleModal').modal('show');
                        },
                        error: function (xhr, status, error) {
                            console.log("Error fetching user data: ", error);
                        }
                    });
                } else if (Id === 'justShowCarsButton') {
                    parametersChange ();
                    updateModalList();
                }
            });

            $(document).on('click', '#createUserButton', function() {
                window.open("{{ route('users.create') }}", "_blank");
            });

            $(document).on('click', '#createVehicleButton', function() {
                window.open("{{ route('vehicles.create') }}", "_blank");
            });

            $(document).on('change', '#nameSelect', function () {
                var selectedName = $(this).val();
                var carSelect = $('#carSelect2');
                if (carSelect.length > 0) {
                    carSelect.remove();
                }
                var carInfo = `
        <div id="carSelect2">
            <label for="carSelect" id="carSelectLabel">Select Car:</label>
            <input list="carList" id="carSelect" class="form-control" placeholder="Search by VIN">
            <datalist id="carList">
                <option value="" id="defaultOption" disabled selected>Seçim Yapın</option>
            </datalist>
        </div>
    `;
                $('.modal-body').append(carInfo);

                var selectedOption = $('#nameList option[value="' + selectedName + '"]');

                if (selectedOption.length > 0) {
                    var selectedId = selectedOption.data('id');
                    console.log("selectedId", selectedId);

                    $.ajax({
                        url: '/carIdSelected/' + selectedId + '/parameters',
                        method: 'GET',
                        success: function (data) {
                            if (data && data.cars && data.cars.length > 0) {
                                var carOptions = data.cars.map(function (car) {
                                    return `<option value="${car.VIN}" data-id="${car.id}">${car.VIN}</option>`;
                                }).join('');

                                $('#carList').append(carOptions);
                            } else {
                                console.log("Araç bilgisi bulunamadı.");
                                var carSelect = $('#carSelect2');
                                if (carSelect.length > 0) {
                                    carSelect.remove();
                                }
                                var carInfo = `
                        <div id="carSelect2">
                            <label for="carSelect" id="carSelectLabel">Select Car:</label>
                            <input list="carList" id="carSelect" class="form-control" placeholder="Herhangi Bir Araç Bulunamadı">
                        </div>
                    `;
                                $('.modal-body').append(carInfo);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log("Error fetching car data: ", error);
                        }
                    });
                } else {
                    console.log('Geçerli bir seçenek seçilmedi');
                }
            });

            $(document).on('click', '#selectCustomerAndCar', function () {
                var selectedName = $('#nameSelect').val();
                var selectedCarVIN = $('#carSelect').val();

                var selectedCustomer = $('#nameList option[value="' + selectedName + '"]');
                var selectedCar = $('#carList option').filter(function () {
                    return $(this).val() === selectedCarVIN;
                });




                if (selectedCar.length > 0 && selectedCustomer.length > 0 ) {
                    var selectedCustomerId = selectedCustomer.data('id');
                    var selectedCarId = selectedCar.data('id');
                    if (selectedCustomerId && selectedCarId) {
                        console.log("selectedCustomerId:", selectedCustomerId, "selectedCarId:", selectedCarId);
                        addOrUpdateCustomerCar(addCarsPartsList , selectedCustomerId , selectedCarId);
                        console.log(addCarsPartsList);

                    } else {
                        console.error("Seçim yapılmadı veya geçersiz değer.");
                    }
                }
            });
            var createForData = [];
            $(document).on('change', '#modelSelect', function () {
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
                            var outerContainer = $('.outer-container');
                            var outerContainer2 = $('<div class="outer-container"></div>');

                            if (outerContainer.length === 0) {
                                var container = $('<div id="parametersSelectContainer"></div>');
                                var catalogDom = $('#catalogDom')
                                container.insertAfter(catalogDom);


                                if (Array.isArray(data.parameters) && data.parameters.length > 0) {
                                    addParameters(data, container, selectedValues);
                                }
                            } else {
                                outerContainer.remove();
                                var catalogDom2 = $('#catalogDom')

                                outerContainer2.insertAfter(catalogDom2);

                                selectedValues2 = [];
                                addParameters(createForData, outerContainer2, selectedValues2);
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

            function addParameters(data, container, existingValues) {
                var button = $('#dynamicShowCarsButtons');
                if (button.length) {
                    button.remove();
                    justShowCarsButton();
                    addCarsPartButton();
                } else {
                    justShowCarsButton();
                    addCarsPartButton();
                }

                console.log("1", existingValues);
                var addedParameters = {};

                data.parameters.forEach(function (parameterArray) {
                    if (Array.isArray(parameterArray)) {
                        parameterArray.forEach(function (parameter) {
                            if (parameter && parameter.name) {
                                if (!addedParameters[parameter.name]) {
                                    addedParameters[parameter.name] = true;

                                    var selectedValue = existingValues.find(v => v.key === parameter.key)?.value || '';

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
                                        value="${selectedValue}"
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

            }


            var selectedValues = [];

            var selectedCarData = [];
            $(document).on('change', '[id^="parameter_"], #modelContainer', function () {
                selectedValues = [];
                console.log('Değişiklik tespit edildi:', $(this).attr('id'));

                $('[id^="parameter_"]').each(function () {
                    var selectedValue = $(this).val();
                    var key = $(this).attr('id').replace('parameter_', '');
                    if (selectedValue) {
                        selectedValues.push({key: key, value: selectedValue});
                    }
                });

                console.log("Güncel seçili değerler:", selectedValues);


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


                            console.log("selectedCarData, response ile güncellendi:", selectedCarData);
                        } else {
                            selectedCarData = response;
                            console.log('Herhangi bir parametre bulunamadı');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX hatası:', status, error);
                        alert('Bir hata oluştu!');
                    }
                });

            });


            function updateModalList() {


                var modalList = $('#modalParametersList');
                var modalChild2 = $('#parametersSelectContainer2');
                var floatChild = $('.float-child1');
                var container2 = $('#modal-body');
                container2.empty();

                modalList.empty();
                modalChild2.remove();
                floatChild.remove();

                var tableContainer = $('<div class="table-container mb-5"></div>');
                var table = $('<table class="table table-bordered" id="allCarsTable"></table>');
                tableContainer.append(table);
                modalList.append(tableContainer);

                var columnSet = new Set();
                var tableData = [];

                selectedCarData.forEach(function (car) {
                    var carName = car.Name;
                    var carBrand = car.Brand;
                    var carId = car.car_id;
                    var rowData = {
                        car: carName,
                        brand: carBrand,
                        car_id: carId
                    };

                    Object.keys(car).forEach(function (key) {
                        if (key !== 'Name' && key !== 'Brand' && key !== 'car_id' && key !== 'ModelImage') {
                            var paramKey = car[key].key;
                            var paramValue = car[key].value;

                            columnSet.add(paramKey);

                            rowData[paramKey] = paramValue;
                        }
                    });

                    tableData.push(rowData);
                });

                var columns = [
                    {title: "Car", data: "car"},
                    {title: "Brand", data: "brand"}
                ];

                columnSet.forEach(function (paramKey) {
                    columns.push({title: paramKey, data: paramKey});
                });

                var dataTable = table.DataTable({
                    paging: true,
                    scrollY: false,
                    scrollCollapse: false,
                    searching: true,
                    responsive: true,
                    pageLength: 10,
                    data: tableData,
                    columns: columns,
                    language: {
                        paginate: {
                            previous: "Previous",
                            next: "Next"
                        },
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        lengthMenu: "Show _MENU_ entries",
                        search: "Search:"
                    },
                    createdRow: function (row, data) {
                        $(row).attr('data-car-id', data.car_id);
                    }
                });
            }


            parametersRemoved = false;
           function parametersChange () {

                updateModalList();
                if (!parametersRemoved) {
                    $('#parametersSelectContainer').remove();
                    var container = $('<div class="outer-container"></div>');
                    var catalogDom = $('#catalogDom')
                    container.insertAfter(catalogDom);

                    addParameters(createForData, container, selectedValues);
                    parametersRemoved = true;
                }

                if ($.fn.dataTable) {
                    $('#myTable').DataTable({
                        paging: true,
                        searching: true,
                        responsive: true
                    });
                } else {
                    console.error('DataTable kütüphanesi yüklenemedi!');
                }
            }


            response1 = [];

            function listCarPartsCatalog(response) {
                var dataTable = $('#modalParametersList');
                var container = $('#parametersSelectContainer3');
                container.empty();
                var container2 = $('#modal-body');
                container2.empty();
                dataTable.empty();
                var modalHeader = $('<div class="row" id="modal-body"></div>');
                modalHeader.insertBefore('#footer')

                var newFloatChild = $('<div class="cards-scroll-container2 col-md-6" id="parametersSelectContainer2"></div>');
                modalHeader.append(newFloatChild);
                var newFloatChild2 = $('<div class="col-md-6" id="parametersSelectContainer3"></div>');
                modalHeader.append(newFloatChild2);


                response1 = response;

                if (!$('#group-header').length) {
                    var groupItem1 = $('<ul class="list-group-item5 pb-0 ml-0" id="group-header"><strong> Categories </strong></ul>');
                    newFloatChild.append(groupItem1);
                }

                response.forEach(function (car) {
                    if (car.groupName) {
                        var groupItem = $('<ul class="list-group-item1 border p-2" id="group-' + car.part_id + '">' + car.groupName + '</ul>');
                        newFloatChild.append(groupItem);

                        var subGroupList = $('<ul class="sub-group-list"></ul>');
                        groupItem.after(subGroupList);

                        groupItem.on('click', function (event) {
                            event.preventDefault();
                            var dataTable = $('#parametersSelectContainer3');
                            dataTable.empty();
                            car.subGroupNames.forEach(function (subname) {
                                showpartsChild(subname);
                                showpartsSubname(subname);

                                if (subname.children && subname.children.length > 0) {
                                    subname.children.forEach(function (child) {
                                        showpartsChild(child);
                                        showpartsSubname(child);
                                    });
                                }
                            });


                            if (!groupItem.data('subGroupsAdded')) {
                                if (car.subGroupNames && car.subGroupNames.length > 0) {
                                    car.subGroupNames.forEach(function (subname) {
                                        var subnameItem = $('<li class="list-group-item-sub subname-item pl-2 border" id="subgroup-' + subname.subGroupName + '">' + subname.subGroupName + '</li>');
                                        subGroupList.append(subnameItem);

                                        subnameItem.on('click', function (event) {
                                            event.preventDefault();
                                            var dataTable = $('#parametersSelectContainer3');
                                            dataTable.empty();

                                            var childList2 = $('#child-list-' + subname.group_id);

                                            if (childList2.length > 0) {
                                                childList2.toggle();
                                            }
                                            showpartsChild(subname);
                                            showpartsSubname(subname);

                                            if (!subnameItem.data('clickAdded')) {
                                                if (subname.children && subname.children.length > 0) {
                                                    var childList = $('<ul class="child-list" id="child-list-' + subname.group_id + '"></ul>');
                                                    subname.children.forEach(function (child) {
                                                        var childItem = $('<li class="child-item pl-3 border" id="' + child.group_id + '">' + child.subGroupName + '</li>');
                                                        childList.append(childItem);
                                                    });
                                                    subnameItem.after(childList);
                                                    var foundChild = null;
                                                    $(document).on('click', '.child-item', function (event) {

                                                        event.preventDefault();
                                                        var dataTable = $('#parametersSelectContainer3');
                                                        dataTable.empty();
                                                        var childId = $(this).attr('id');
                                                        console.log('Tıklanan Child ID: ', childId);
                                                        var existingChildList2 = $('#child-list2-' + childId);

                                                        if (existingChildList2.length > 0) {
                                                            existingChildList2.toggle();
                                                        } else {


                                                            response1.forEach(function (car) {
                                                                car.subGroupNames.forEach(function (subname) {
                                                                    subname.children.forEach(function (child) {
                                                                        if (child.group_id === childId) {
                                                                            foundChild = child;
                                                                        }
                                                                    });
                                                                });
                                                            });

                                                            if (!foundChild) {
                                                                console.error("Çocuk öğesi bulunamadı: " + childId);
                                                                return;
                                                            }

                                                            showpartsChild(foundChild);
                                                            showpartsSubname(foundChild);

                                                            if (foundChild.children && foundChild.children.length > 0) {
                                                                var childList2 = $('<ul class="child-list2" id="child-list2-' + foundChild.group_id + '"></ul>');
                                                                foundChild.children.forEach(function (partInfo) {
                                                                    var childItem2 = $('<li class="child-item2 pl-4 border" id="' + partInfo.group_id + '">' + partInfo.subGroupName + '</li>');
                                                                    childList2.append(childItem2);
                                                                });


                                                                $('#' + childId).after(childList2);
                                                            }
                                                        }
                                                    });
                                                    $(document).on('click', '.child-item2', function (event) {
                                                        event.preventDefault();
                                                        var dataTable = $('#parametersSelectContainer3');
                                                        dataTable.empty();
                                                        var childId = $(this).attr('id');
                                                        console.log("asdfdsa", childId);

                                                        response1.forEach(function (car) {
                                                            car.subGroupNames.forEach(function (subname) {
                                                                subname.children.forEach(function (child2) {
                                                                    child2.children.forEach(function (child) {
                                                                        if (child.group_id === childId) {
                                                                            foundedChild2 = child;
                                                                            showpartsSubname(child)


                                                                        }
                                                                    });
                                                                });
                                                            });

                                                        });
                                                    })
                                                }
                                                subnameItem.data('clickAdded', true);
                                            }
                                        });
                                    });
                                }
                                groupItem.data('subGroupsAdded', true);
                            }

                            subGroupList.toggle();
                        });
                    }
                });


                function initializeDataTable() {
                    if ($.fn.DataTable.isDataTable('#parametersTable')) {
                        $('#parametersTable').DataTable().destroy();
                    }

                    $('#parametersTable').DataTable({
                        responsive: true,
                        pageLength: 2
                    });
                }

                function createTable() {
                    var container = $('#parametersSelectContainer3');

                    if (!$('#parametersTable').length) {
                        var parametersTable = $(`
            <table id="parametersTable" class="display">
                <thead>
                    <tr>
                        <th>Part Name</th>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        `);
                        container.append(parametersTable);
                    }
                }

                function addDataToTable(data) {

                    var tableBody = $('#parametersTable tbody');
                    tableBody.empty();

                    data.forEach(function (item) {

                        var row = `
            <tr>
                <td>${item.partName}</td>
                <td><img src="${item.imagePath}" alt="${item.partName}" class="custom-img1"  id="${item.group_id}" style="border: 1px solid black; border-radius: 10px; width: 300px;" /></td>
            </tr>
        `;
                        tableBody.append(row);
                    });

                    initializeDataTable();
                }

                function showpartsSubname(subname) {

                    if (subname.partInformations && subname.partInformations.length > 0) {
                        var data = subname.partInformations.map(function (partInforma) {
                            console.log("data", data);
                            return {

                                partName: partInforma.partName,
                                imagePath: partInforma.img.split('/r\/250x250').join(''),
                                group_id: partInforma.part_group_id,
                            };
                        });
                        createTable();

                        addDataToTable(data);

                    }
                }

                function showpartsChild(subname) {
                    if (subname.children && subname.children.length > 0) {
                        var data = [];
                        subname.children.forEach(function (partInfo) {
                            partInfo.partInformations.forEach(function (partInfor) {
                                console.log("data", data);

                                data.push({
                                    partName: partInfor.partName,
                                    imagePath: partInfor.img.split('/r\/250x250').join(''),
                                    group_id: partInfor.part_group_id,

                                });
                            });
                        });
                        createTable();

                        addDataToTable(data);
                    }
                }

                $(document).on('click', 'list-group', function () {
                    var container = $('#parametersSelectContainer3');
                    container.empty();
                    if (container.length) {
                        createTable();
                        initializeDataTable();
                    } else {
                        console.error("parametersSelectContainer3 bulunamadı.");
                    }
                });
            }


            $(document).on('click', 'img.custom-img1', function () {
                var partGroupId = $(this).attr('id');
                console.log("part_id1", partGroupId);

                var url = window.location.origin + '/car/catalog/' + partGroupId + '/parameters';
                console.log(url);
                $.ajax({
                    url: '/car/catalog/' + partGroupId + '/parameters',
                    method: 'GET',
                    data: {partGroupId},
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


            $(document).on('click', '#allCarsTable tbody tr', function () {
                var carId = $(this).data('car-id');
                console.log('Tıklanan car_id: ' + carId);

                $.ajax({
                    url: '/cars/car_id/' + carId + '/parameters',
                    method: 'GET',
                    data: {car_id: carId},
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
                var modalHeader = $('#modal-header');
                var modalList = $('#parametersSelectContainer2');
                var container2 = $('#parametersSelectContainer3');
                container2.empty();
                modalList.empty();
                modalHeader.empty();

                var groupItem = $('<ul class="list-group-item22 text-align:left" id="group-' + response[0].brand_name + '" style="text-align:left;">' +
                    '<br><strong>' + response[0].brand_name + '</strong> ' +
                    '<strong>' + response[0].name + '</strong></br>' +
                    '</ul>');
                modalList.append(groupItem);

                var imagePath = response[0].schema_img;
                imagePath = imagePath.split('/r\/250x250').join('');
                console.log("imagepath", imagePath);
                modalList.append('<img src="' + imagePath + '" alt="' + response[0].brand_name + '" class="custom-img" id="' + response[0].brand_name + '" style="border: 1px solid black; border-radius: 10px; display: block; margin: 0 auto; "/>');

                var cardsContainer = $('<div class="cards-scroll-container"></div>');
                container2.append(cardsContainer);

                response.forEach(function (parts) {


                    var card = $(`
        <div class="card shadow-sm mb-3" style="cursor: pointer;">
            <div class="card-body position-relative">
                <span class="text-muted position-absolute top-0 end-0 me-3 mt-2">${parts.position_number}</span>
                <h5 class="card-title text-primary">${parts.name}</h5>
                <p class="card-text text-muted">${parts.number}</p>
            </div>
        </div>
        `);

                    cardsContainer.append(card);

                    card.on('click', function () {
                        if (card.find('.card-footer').length) {
                            card.find('.card-footer').toggle();
                        } else {
                            var cardFooter = $(`
            <div class="card-footer bg-light border-top">
                <ul class="sub-group-list">
                    <li class="p-0 col-12 ul-list-group-item_${parts.part_id.replace(/\s+/g, '-')}" id="${parts.part_id.replace(/\s+/g, '-')}" style="display: flex; align-items: center; justify-content: space-between;">
                        <span class="d-flex flex-column">
                            <span>${parts.brand_name}</span>
                            <span>${parts.part_id.replace(/\s+/g, '-')}</span>
                        </span>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-link p-0 ms-3 decrement" id="decrement_${parts.part_id.replace(/\s+/g, '-')}-${parts.group_id}-${parts.car_id}" style="font-size: 20px; cursor: pointer;">
                                <i class="fa-solid fa-minus" style="color:black"></i>
                            </button>
                            <span class="part-count mx-2" id="count_${parts.part_id.replace(/\s+/g, '-')}" style="font-size: 16px;">0</span>
                            <button class="btn btn-link p-0 ms-3 increment" id="increment_${parts.part_id}-${parts.group_id}-${parts.car_id}" style="font-size: 20px; cursor: pointer;">
                                <i class="fa-solid fa-plus" style="color:black"></i>
                            </button>
                        </div>
                    </li>
                </ul>
            </div>
        `);
                            card.append(cardFooter);
                        }



                    });

                });
            }

            $(document).on('click', '[id^="increment_"], [id^="decrement_"]', function () {
                var id = $(this).attr('id');
                var action = id.startsWith('increment_') ? 'increment' : 'decrement';
                var parts = id.replace(/(increment_|decrement_)/, '').split('-');
                var part_id = parts[0].replace(/\s+/g, '-');
                var group_id = parts[1];
                var car_id = parts[2];


                var countSpan = $(`#count_${part_id}`);
                console.log("countSpan" , countSpan.attr('id'));

                var currentCount = countSpan.text();


                if (action === 'increment') {
                    currentCount++;
                } else if (action === 'decrement' && currentCount > 0) {
                    currentCount--;
                }

                countSpan.text(currentCount);

                let existingEntry = addCarsPartsList.find(item => item.part_id === part_id && item.group_id === group_id && item.car_id === car_id);

                if (existingEntry) {
                    existingEntry.count = currentCount;
                } else {
                    addCarsPartsList.push({
                        part_id: part_id,
                        group_id: group_id,
                        car_id: car_id,
                        count: currentCount
                    });
                }

                console.log('addCarsPartsList:', addCarsPartsList);
            });
            });



    </script>



@endsection
