<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Laravel Add To Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css"  />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/themes/bootstrap.min.css"  />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js" ></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-12 main-section">



              <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> Sepet <span class="badge badge-pill badge-danger cartCount">{{ count((array) session('cart')) }}</span>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <div class="row total-header-section">
                        <div class="col-lg-6 col-sm-6 col-6">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="badge badge-pill badge-danger cartCount">{{ count((array) session('cart')) }}</span>

                            <button class="btn btn-danger btn-sm  remove-all-cart "><i class="fa fa-trash-o"></i> Sepeti Boşalt</button>
                        </div>

                        @php $total = 0 @endphp
                        @foreach((array) session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                        @endforeach
                        <div class="col-lg-6 col-sm-6 col-6 total-section text-right">
                            <p>Toplam: <span class="text-info totalPrice">{{ $total }}</span> ₺</p>
                        </div>
                    </div>

                    <div class="cartContent">
                        @if(session('cart'))
                        @foreach(session('cart') as $id => $details)
                            <div class="row cart-detail">
                                <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                                    <img src="{{ $details['image'] }}" />
                                </div>
                                <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                                    <p>{{ $details['name'] }}</p>
                                    <span class="price text-info"> ${{ $details['price'] }}</span> <span class="count"> Adet:{{ $details['quantity'] }}</span>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
                            <a href="{{ route('cart') }}" class="btn btn-primary btn-lg btn-block w-">Sepete Git</a>
                        </div>
                    </div>
                </div>

              </div>
        </div>
    </div>
</div>

<br/>
<div class="container">

    @if(session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
    @endif

    @yield('content')
</div>

@yield('customjs')




<script>
      $(document).on('click', '.remove-all-cart', function(e) {
        e.preventDefault();

        alertify.confirm('Sepetten Kaldırmak İstediğine Eminmisin?!', 'Bu işlem geri alınamaz',
        function () {
            $.ajax({
                url: '{{ route("remove.all.cart") }}',
                method: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('.cartContent').html('');
                    $('.totalPrice').html(response.totalprice);
                    $('.cartCount').text(response.cartcount);
                    alertify.success(response.message);
                }
            });
        },
        function () {
            alertify.error('İşlem iptal edildi')
        })
    });
</script>

</body>
</html>
