@foreach ($lowstockproducts as $product)
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <span class="alert-icon"><i class="ti ti-alert-triangle"></i></span>
    <strong>{{ $product['name'] }}</strong><small> {{ $product['quantity'] . __(' items left)') }}</small>
</div>
@endforeach