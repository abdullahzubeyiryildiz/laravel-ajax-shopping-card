@extends('layout')

@section('content')

<div class="row">
    @foreach($products as $product)
        <div class="col-xs-18 col-sm-6 col-md-3">
            <div class="thumbnail">
                <img src="{{ $product->image }}" alt="">
                <div class="caption">
                    <h4>{{ $product->name }}</h4>
                    <p>{{ $product->description }}</p>
                    <p><strong>Fiyat: </strong> {{ $product->price }} ₺</p>
                    <p class="btn-holder"><button data-id="{{$product->id}}" class="btn btn-warning btn-block addToCard text-center" role="button">Sepete Ekle</button> </p>
                </div>
            </div>
        </div>
    @endforeach
</div>

@endsection

@section('customjs')
<script>
         $(document).on('click', '.addToCard', function(e) {

        e.preventDefault();

        var ele = $(this).attr("data-id");

        $.ajax({
            url: '{{ route("add.to.cart") }}',
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: ele,
            },
            success: function (response) {
                $('.cartContent').html('');
                $('.totalPrice').html(response.totalprice);

                $('.cartCount').text(response.cartcount);

                alertify.success(response.message);

                $.each(response.cart, function(k, item) {
                    $('.cartContent').append(`<div class="row cart-detail">
                        <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                            <img src="${item.image}" />
                        </div>
                        <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                            <p>${item.name}</p>
                            <span class="price text-info">${item.price} ₺</span> <span class="count"> Adet:${item.quantity}</span>
                        </div>
                    </div>`);
                });

            }
        });
        });
</script>
@endsection
