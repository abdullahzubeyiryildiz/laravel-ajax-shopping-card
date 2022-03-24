@extends('layout')

@section('content')
<table id="cart" class="table table-hover table-condensed">
    <thead>
        <tr>
            <th style="width:50%">Ürün</th>
            <th style="width:10%">Fiyat</th>
            <th style="width:8%">Adet</th>
            <th style="width:22%" class="text-center">Tutar</th>
            <th style="width:10%"></th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0 @endphp
        @if(session('cart'))
            @foreach(session('cart') as $id => $details)
                @php $total += $details['price'] * $details['quantity'] @endphp
                <tr data-id="{{ $id }}">
                    <td data-th="Product">
                        <div class="row">
                            <div class="col-sm-3 hidden-xs"><img src="{{ $details['image'] }}" width="100" height="100" class="img-responsive"/></div>
                            <div class="col-sm-9">
                                <h4 class="nomargin">{{ $details['name'] }}</h4>
                            </div>
                        </div>
                    </td>
                    <td data-th="Price">{{ $details['price'] }} ₺</td>
                    <td data-th="Quantity">
                        <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity update-cart" />
                    </td>
                    <td data-th="Subtotal" class="text-center">{{ $details['price'] * $details['quantity'] }} ₺</td>
                    <td class="actions" data-th="">
                        <button class="btn btn-danger btn-sm remove-from-cart"><i class="fa fa-trash-o"></i></button>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="text-right"><h3><strong>Toplam {{ $total }} ₺</strong></h3></td>
        </tr>
        <tr>
            <td colspan="5" class="text-right">
                <a href="{{ url('/') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Alışverişe Devam</a>
                <button class="btn btn-success">Ödemeye Geç</button>
            </td>
        </tr>
    </tfoot>
</table>
@endsection

@section('customjs')
<script type="text/javascript">

        $(document).on('change', '.update-cart', function(e) {
        e.preventDefault();

        var ele = $(this);

        $.ajax({
            url: '{{ route("update.cart") }}',
            method: "patch",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: ele.parents("tr").attr("data-id"),
                quantity: ele.parents("tr").find(".quantity").val()
            },
            success: function (response) {
               window.location.reload();
            }
        });
    });

    $(document).on('click', '.remove-from-cart', function(e) {
        e.preventDefault();

        var ele = $(this);

            alertify.confirm('Sepetten Kaldırmak İstediğine Eminmisin?', 'Bu işlem geri alınamaz',
            function () {
                $.ajax({
                url: '{{ route("remove.from.cart") }}',
                method: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: ele.parents("tr").attr("data-id")
                },
                success: function (response) {
                    window.location.reload();
                }
            });
            },
            function () {
                alertify.error('Silme işlemi iptal edildi')
            })
    });

</script>
@endsection
