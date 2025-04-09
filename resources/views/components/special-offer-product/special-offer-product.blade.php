@php
    $classPrefix = 'service-card';
    $dataPrefix = 'data-service-card';
@endphp


<div {{$dataPrefix}} class="{{$classPrefix}}">
    @include('components.product.product', ['product' => $offer])
</div>



