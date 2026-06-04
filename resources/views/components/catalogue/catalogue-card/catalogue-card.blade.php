@php
    $classPrefix = 'catalogue-card';
    $dataPrefix = 'data-catalogue-card';

    $productPosition = $productData['position'];
@endphp


<div {{$dataPrefix}} class="{{$classPrefix}} @if($productPosition) {{$classPrefix}}--{{$productPosition}} @endif">

    <a href="/product/{{ $productData['slug'] }}" class="{{$classPrefix}}__image-container-wrapper">
        <div class="{{$classPrefix}}__image-container">
            @if($productData['images'])
                @if(count($productData['images']) > 1)
                    <img {{$dataPrefix}}-image-main src="{{ $productData['images'][0]['url'] }}"
                         class="{{$classPrefix}}__image-main" alt="catalogue-card">
                    <img {{$dataPrefix}}-image-cover src="{{ $productData['images'][1]['url'] }}"
                         class="{{$classPrefix}}__image-cover" alt="catalogue-card-cover">
                @elseif(count($productData['images']) == 1)
                    <img {{$dataPrefix}}-image-main src="{{ $productData['images'][0]['url'] }}"
                         class="{{$classPrefix}}__image-main" alt="catalogue-card">
                    <img {{$dataPrefix}}-image-cover src="{{ asset('img/test_product_2.jpg') }}"
                         class="{{$classPrefix}}__image-cover" alt="catalogue-card-cover">
                @else
                    <img {{$dataPrefix}}-image-main src="{{ asset('img/test_product_1.jpg') }}"
                         class="{{$classPrefix}}__image-main" alt="catalogue-card">
                    <img {{$dataPrefix}}-image-cover src="{{ asset('img/test_product_2.jpg') }}"
                         class="{{$classPrefix}}__image-cover" alt="catalogue-card-cover">
                @endif
            @endif
        </div>
    </a>

    <div class="{{$classPrefix}}__content">
        <a {{$dataPrefix}}-title href="/product/{{ $productData['slug'] }}" class="{{$classPrefix}}__title">
            {{$productData['name']}}
        </a>
        <div @if(!$productData['subtitle']) style="display: none" @endif  {{$dataPrefix}}-subtitle class="{{$classPrefix}}__subtitle">{{$productData['subtitle']}}
        </div>
        <div {{$dataPrefix}}-price class="{{$classPrefix}}__price">

            @if($productData['price_ua'])
                <span class="{{$classPrefix}}__price-ua">{{  number_format(round($productData['price_ua'], 0), 0, '', ' ')}}₴</span>
            @endif
            @if($productData['price_eu'])
                    <span class="{{$classPrefix}}__price-eu">{{$productData['price_eu']}}€</span>
            @endif

        </div>
        <div {{$dataPrefix}}-description class="{{$classPrefix}}__text ">
        </div>

    </div>
</div>






