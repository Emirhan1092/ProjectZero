@extends('layouts.user_type.auth')

@section("title", "User List")

@section('css')
<style>
    .card-group {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }

    .card {
        flex: 1 1 300px;
        max-width: 300px;
    }

    .card {
        width: 100%;
        max-width: 300px;
    }
    .btn {
        padding: 5px 10px;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #f0f0f0;
    }

</style>
@endsection
@section("content")

    <div class="card-group">
        @foreach($existingCartItem as $item)
            <div class="card" id="{{$item->group_id}}_{{$item->part_id}}">
                <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                    <a href="javascript:" class="d-block">
                        <img src="{{$item->part_img}}" class="img-fluid border-radius-lg">
                    </a>
                </div>

                <div class="card-body pt-2">
                    <span class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2">{{$item->brand_name}}</span>
                    <a href="javascript:;" class="card-title h5 d-block text-darker">
                        {{$item->car_name}}
                    </a>
                    <p class="card-description mb-4">
                        {{$item->part_name}}
                    </p>
                    <div class="author align-items-center">
                        <div class="name ps-3">
                            <span>{{$item->part_number}}</span>
                            <div class="stats">
                                <button class="btn btn-link text-secondary font-weight-normal text-xs m-3 decrease-quantity" data-user-id="{{$item->user_id}}" data-group-id="{{$item->group_id}}" data-part-id="{{$item->part_id}}">
                                    <span class="material-symbols-outlined">-</span>
                                </button>

                                <span class="quantity-value" id="quantity-{{$item->part_id}}">{{$item->quantity}}</span>

                                <button class="btn btn-link text-secondary font-weight-normal text-xs m-3 increase-quantity" data-user-id="{{$item->user_id}}" data-group-id="{{$item->group_id}}" data-part-id="{{$item->part_id}}">
                                    <span class="material-symbols-outlined">+</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach
    </div>



@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('.increase-quantity').click(function() {
            var userId = $(this).data('user-id');
            var groupId = $(this).data('group-id');
            var partId = $(this).data('part-id');

            $.ajax({
                url: '/shopping-cart/increase/' + userId + '/' + groupId + '/' + partId,
                method: 'GET',
                success: function(response) {
                    $('#quantity-' + partId).text(response.new_quantity);
                },
                error: function(error) {
                    console.log('Hata:', error);
                }
            });
        });

        $(document).on('click', '.decrease-quantity', function() {
            var userId = $(this).data('user-id');
            var groupId = $(this).data('group-id');
            var partId = $(this).data('part-id');

            $.ajax({
                url: '/cart/decrease-quantity/' + userId + '/' + groupId + '/' + partId,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.new_quantity === 0) {

                        var cardId = '#' + response.group_id + '_' + response.part_id;

                        $(cardId).fadeOut(300, function() {
                            $(this).remove();
                        });
                    } else {
                        $('#quantity-' + partId).text(response.new_quantity);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX hatası:', error);
                    alert('Bir hata oluştu, lütfen tekrar deneyin!');
                }
            });
        });


    </script>


@endsection
