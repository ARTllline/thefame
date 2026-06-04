@php
    $classPrefix ='main-about';
    $dataPrefix ='data-main-about';
    $mediaDir = 'main-ua';
       if ( $currentRegion == 'dubai'){
               $mediaDir = 'main-dubai';
       }
@endphp

<div {{$dataPrefix}} class="{{$classPrefix}}">

    <h2 class="{{$classPrefix}}__title">
        {{__('static.about_us')}}
    </h2>
    <div class="{{$classPrefix}}__description">
        <p class="{{$classPrefix}}__description-text">

            @if($currentRegion == 'dubai')
                {!! nl2br(e($about->text_dubai), false) !!}
            @else
                {!! nl2br(e($about->text_ua), false) !!}
            @endif
        </p>
        <p class="{{$classPrefix}}__description-accent">
            @if($currentRegion == 'dubai')
                {!! nl2br(e($about->accent_dubai), false) !!}
            @else
                {!! nl2br(e($about->accent_ua), false) !!}
            @endif
        </p>
    </div>
    <div class="{{$classPrefix}}__image">
        {{--        @if($about)--}}
        {{--            <img src="{{ $about->getFirstMediaUrl('main', 'webp') ?: asset('img/default.webp') }}" alt="about us">--}}
        {{--        @else--}}
        {{--            <img src="{{asset('img/default.webp') }}" alt="about us">--}}
        {{--        @endif--}}

        <div {{$dataPrefix}}-image class="swiper swiper--hidden {{$classPrefix}}__swiper-image">
            <div {{$dataPrefix}}-image-wrapper class="swiper-wrapper">
                @foreach($about->getMedia($mediaDir) as $media)
                    <div class="swiper-slide {{$classPrefix}}__swiper-image-slide">
                        <img src="{{ $media->getUrl('webp') }}" class="{{$classPrefix}}__swiper-image-bg"
                             alt=" {{__('static.about_us')}}"
                             decoding="async"
                             loading="lazy"
                             fetchpriority="high">
                        <div class="{{$classPrefix}}__swiper-image-bg-fade">

                        </div>
                        <a href="{{ $media->getUrl() }}" class="glightbox {{$classPrefix}}__swiper-image-link"
                           data-gallery="gallery{{ $about->id }}">
                            <img src="{{ $media->getUrl('webp') }}"
                                 alt=" {{__('static.about_us')}}"
                                 loading="lazy"
                                 decoding="async"
                                 fetchpriority="high">
                        </a>

                    </div>
                @endforeach
            </div>
            <div class="swiper-button-next slider-button-next {{$classPrefix}}__swiper-button-next">
                <svg width="26" height="27" viewBox="0 0 26 27" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.43594 5.56387L1.68611 13.3137M1.68611 13.3137L9.43594 21.0635M1.68611 13.3137H24.3135"
                          stroke-width="2" stroke-linecap="round"></path>
                </svg>
            </div>
            <div class="swiper-button-prev slider-button-prev {{$classPrefix}}__swiper-button-prev">
                <svg width="26" height="27" viewBox="0 0 26 27" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.43594 5.56387L1.68611 13.3137M1.68611 13.3137L9.43594 21.0635M1.68611 13.3137H24.3135"
                          stroke-width="2" stroke-linecap="round"></path>
                </svg>
            </div>
            <div class="swiper-pagination {{$classPrefix}}__swiper-pagination"></div>
        </div>
        {{--        <div class="{{$classPrefix}}__image-shape">--}}
        {{--            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="ezo87kswz9yn1"--}}
        {{--                 viewBox="0 0 758 803" shape-rendering="geometricPrecision" text-rendering="geometricPrecision">--}}
        {{--                <path id="ezo87kswz9yn2"--}}
        {{--                      d="M 457.523 76.0347 C 363.095 40.2644 341.6402011839996 101.761723718 265.12620118399997 167.70272371800002 C 195.425201184 227.77172371799995 116.475678676 228.10958526800002 93.121768114 317.090140902 C 59.95821292 399.272196624 58.36341745399999 525.333469454 130.660473 590.472525 C 202.36047299999993 654.6815250000001 321.082498 755.331346072 415.733498 737.885346072 C 512.238498 720.096346072 597.7231969999999 723.86925 629.471197 630.97425 C 657.7801969999999 548.1432500000001 681.662715912 430.002806922 649.0527159119999 348.783806922 C 612.9997159119999 258.989806922 547.982 110.301 457.523 76.0347 Z"--}}
        {{--                      clip-rule="evenodd" fill-rule="evenodd" stroke="none" stroke-width="1"></path>--}}
        {{--            </svg>--}}
        {{--        </div>--}}
    </div>
</div>
