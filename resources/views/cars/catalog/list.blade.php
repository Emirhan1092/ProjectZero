@extends('layouts.user_type.auth')

@section("title", "Catalog List")

@section('css')
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


@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#catalogSelect').on('change', function() {
                var catalogName = $(this).val();

                if (catalogName) {
                    $.ajax({
                        url: '/cars/catalog/' + catalogName + '/models',
                        method: 'GET',
                        success: function(data) {
                            console.log("Veri geldi:", data);

                            if (Array.isArray(data.models) && data.models.length > 0) {
                                $('#modelSelect').empty().append('<option value="">Model Seçiniz</option>');
                                data.models.forEach(function(model) {
                                    $('#modelSelect').append('<option value="' + model + '">' + model + '</option>');
                                });
                            } else {
                                $('#modelSelect').empty().append('<option value="">Model bulunamadı</option>');
                            }
                        },
                        error: function() {
                            alert("Bir hata oluştu!");
                        }
                    });
                } else {
                    $('#modelSelect').empty().append('<option value="">Model Seçiniz</option>');
                }
            });

            $('#modelSelect').on('change', function() {
                var modelName = $(this).val();
                var catalogName = $('#catalogSelect').val();

                if (modelName && catalogName) {
                    $.ajax({
                        url: '/cars/catalog/' + catalogName + '/models/' + modelName + '/parameters',
                        method: 'GET',
                        success: function(data) {

                            $('#parametersSelectContainer').remove();

                            var container = $('<div id="parametersSelectContainer"></div>');
                            $('main').append(container);

                            if (Array.isArray(data.parameters) && data.parameters.length > 0) {
                                var addedParameters = {};

                                // Parametreleri ekle
                                data.parameters.forEach(function(parameterArray) {
                                    if (Array.isArray(parameterArray)) {
                                        parameterArray.forEach(function(parameter) {
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
                                                        var existingOptions = select.find('option').map(function() {
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

                                $('#parameterModal').fadeIn();
                            } else {
                                container.append('<p>Parametre bulunamadı</p>');
                            }
                        },
                        error: function() {
                            alert("Bir hata oluştu!");
                        }
                    });
                } else {
                    $('#parametersSelectContainer').remove();
                }
            });

            $('#parameterModal .btn-close, #parameterModal .btn-secondary').on('click', function() {
                $('#parameterModal').fadeOut();
            });

            var selectedCarData = [];  // İlk başta boş bir dizi

            $(document).on('change', '[id^="parameter_"]', function() {
                var modelName = $('#modelSelect').val();
                var selectedValues = [];

                // Seçilen parametreleri alıyoruz
                $('[id^="parameter_"]').each(function() {
                    var selectedValue = $(this).val();
                    var key = $(this).attr('id').replace('parameter_', ''); // Parametre key'ini alıyoruz
                    if (selectedValue) {
                        selectedValues.push({ key: key, value: selectedValue }); // key ve value'yu gönderiyoruz
                    }
                });

                console.log('Seçilen Değerler:', selectedValues);

                $.ajax({
                    url: '/cars/models/' + modelName + '/parameters',
                    method: 'GET',
                    data: {
                        selectedValues: JSON.stringify(selectedValues),  // JSON string formatında gönderiyoruz
                    },
                    traditional: true,
                    success: function(response) {
                        console.log('Sunucudan gelen yanıt:', response);

                        if (response.length > 0) {
                            // İlk defa gelen sonuçları seçilen araç verileri olarak saklıyoruz
                            if (selectedCarData.length === 0) {
                                selectedCarData = response;
                            } else {
                                // Mevcut verilerle gelen yeni verileri birleştiriyoruz
                                selectedCarData = selectedCarData.filter(function(car) {
                                    return response.some(function(updatedCar) {
                                        return updatedCar.car_id === car.car_id; // Aynı car_id'ye sahip olanları tutuyoruz
                                    });
                                });
                            }
                            // Filtrelenmiş parametreleri listeye ekliyoruz
                            $('#parametersList').empty();
                            selectedCarData.forEach(function(parameter) {
                                $('#parametersList').append(
                                    '<li>' + parameter.name + ': ' + parameter.value + '</li>'
                                );
                            });
                        } else {
                            console.log('Herhangi bir parametre bulunamadı');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX hatası:', status, error);
                        alert('Bir hata oluştu!');
                    }
                });
            });



        });


    </script>
@endsection
