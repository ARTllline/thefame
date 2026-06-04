@php
    $classPrefix = 'catalogue-card-template';
    $dataPrefix = 'data-catalogue-card-template';
@endphp


<template {{$dataPrefix}}-template >
    <div {{$dataPrefix}} class="{{$classPrefix}}">

        <a {{$dataPrefix}}-link class="{{$classPrefix}}__image-container-wrapper">
            <div class="{{$classPrefix}}__image-container">
                <img {{$dataPrefix}}-image-main src="{{ asset('img/test_product_1.jpg') }}" class="{{$classPrefix}}__image-main" alt="catalogue-card-template">
                <img {{$dataPrefix}}-image-cover src="{{ asset('img/test_product_2.jpg') }}" class="{{$classPrefix}}__image-cover" alt="catalogue-card-template-cover">
            </div>
        </a>

        <div class="{{$classPrefix}}__content">
            <a {{$dataPrefix}}-link {{$dataPrefix}}-title href="#" class="{{$classPrefix}}__title">
                Dermablate MCL
            </a>
            <div {{$dataPrefix}}-subtitle class="{{$classPrefix}}__subtitle">
          fdgdfgdfgdfg fdg d
            </div>
            <div {{$dataPrefix}}-price class="{{$classPrefix}}__price">
                <span {{$dataPrefix}}-price-ua class="{{$classPrefix}}__price-ua"></span>
                <span {{$dataPrefix}}-price-eu class="{{$classPrefix}}__price-eu"></span>
            </div>
            <div {{$dataPrefix}}-description class="{{$classPrefix}}__text ">
                - Certified original devices and products (DHA-approved) ensuring safety, precision, and proven effectiveness.
                <br>
                - Experienced doctors with over 10 years of hands-on practice.
                <br>
                - Premium service, with every treatment tailored to your goals and skin needs.
            </div>

        </div>
    </div>
</template>





