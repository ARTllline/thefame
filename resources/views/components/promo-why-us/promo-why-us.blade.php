@php
    $classPrefix ='promo-why-us';
    $dataPrefix ='data-promo-why-us';
@endphp

<div {{$dataPrefix}} class="{{$classPrefix}}">
    <div class="{{$classPrefix}}__media">
        <img src="{{ asset('img/promo-why-us.webp') }}" alt="promo-why-us">
        <div class="{{$classPrefix}}__subtitle">
            Clinic in Dubai
        </div>
    </div>
    <div class="{{$classPrefix}}__content">
        <div class="{{$classPrefix}}__title">
            {{__('promo.about_title')}}
        </div>
        <div class="{{$classPrefix}}__line"></div>
        <div class="{{$classPrefix}}__text">
            {{__('promo.about_text_1')}}
        </div>
        <div class="{{$classPrefix}}__text">
            {{__('promo.about_text_2')}}
        </div>
    </div>


</div>

