@php
     $classPrefix ='about';
     $dataPrefix ='data-about';
     $mediaDir = 'main-ua';
        if ( $currentRegion == 'dubai'){
                $mediaDir = 'main-dubai';
        }
@endphp


<div {{$dataPrefix}} class="{{$classPrefix}}">

    <h2 class="{{$classPrefix}}__title">
        Бьюти-клиника <br>
        The Fame
    </h2>
    <div class="{{$classPrefix}}__description">
        <p class="{{$classPrefix}}__description-text">
            @if($about)
                {!! nl2br(e($about->text)) !!}
            @else
                The Fame – это когда вам делают не просто стрижку, а выстраивают целостный образ, основанный на
                детальной
                консультации, который раскрывает вас и заставляет чувствовать себя превосходно. В котором вы будете
                выглядеть максимально ярко и уверенно в себе.
            @endif

        </p>
        <p class="{{$classPrefix}}__description-accent">
            @if($about)
                {!! nl2br(e($about->accent)) !!}
            @else
                ЭТО НЕ ПРОСТО САЛОН КРАСОТЫ, ЭТО ОБЩЕСТВО КРАСИВЫХ И УВЕРЕННЫХ В СЕБЕ ЛЮДЕЙ.
            @endif
        </p>
    </div>
    <div class="{{$classPrefix}}__image">
        <div {{$dataPrefix}}-image class="swiper swiper--hidden swiper--padding {{$classPrefix}}__swiper-image">
            <div {{$dataPrefix}}-image-wrapper class="swiper-wrapper">
                @foreach($about->getMedia($mediaDir) as $media)
                    <div class="swiper-slide {{$classPrefix}}__swiper-image-slide">
                        <img src="{{ $media->getUrl('webp') }}" class="{{$classPrefix}}__swiper-image-bg"
                             alt=" {{__('static.about_us')}}"
                             decoding="async"
                             fetchpriority="high"/>
                        <div class="{{$classPrefix}}__swiper-image-bg-fade">

                        </div>
                        <a href="{{ $media->getUrl() }}" class="glightbox {{$classPrefix}}__swiper-image-link"
                           data-gallery="gallery{{ $about->id }}">
                            <img src="{{ $media->getUrl('webp') }}"
                                 alt=" {{__('static.about_us')}}"
                                 decoding="async"
                                 fetchpriority="high"/>
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
    </div>
</div>
