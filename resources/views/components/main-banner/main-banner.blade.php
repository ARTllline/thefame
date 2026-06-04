@php
    $classPrefix ='main-banner';
    $dataPrefix ='data-main-banner';

    $banner = \App\Models\Banner::where('is_show', true)->first();

    $dubaiDesktop = $banner ? $banner->getFirstMediaUrl('dubai_desktop') : null;
    $dubaiMobile  = $banner ? $banner->getFirstMediaUrl('dubai_mobile') : null;
    $kyivDesktop  = $banner ? $banner->getFirstMediaUrl('kyiv_desktop') : null;
    $kyivMobile   = $banner ? $banner->getFirstMediaUrl('kyiv_mobile') : null;
@endphp


<div {{$dataPrefix}} class="{{$classPrefix}}"
     data-region="{{ $currentRegion }}"
     data-dubai-desktop="{{ $dubaiDesktop }}"
     data-dubai-mobile="{{ $dubaiMobile }}"
     data-kyiv-desktop="{{ $kyivDesktop }}"
     data-kyiv-mobile="{{ $kyivMobile }}">

    <div {{$dataPrefix}}-background class="{{$classPrefix}}__background">
        <div {{$dataPrefix}}-background-loader class="{{$classPrefix}}__background-loader">
            @include('components.loader.loader')
        </div>

        <video {{$dataPrefix}}-background-video  id="banner-video" class="{{$classPrefix}}__background-video"
               autoplay loop muted playsinline></video>
    </div>

    <div class="{{$classPrefix}}__content">
        <div class="{{$classPrefix}}__content-logo">
            @if($currentRegion == 'dubai')
                <img src="{{ asset('img/logo-dubai.png')}}" alt="Logo">
            @else
                <img src="{{ asset('svg/logo.svg')}}" alt="Logo">
            @endif

        </div>
        @if($currentRegion == 'ua')
            <h2 class="{{$classPrefix}}__content-title">Beauty salon</h2>
        @endif

        @if($currentRegion == 'ua')
            <div data-modal-open class="button button-clip {{$classPrefix}}__content-button">
            	<span class="clip">
					<span>{{ __('static.sign_up_site') }}</span>
					<span>{{ __('static.sign_up_site') }}</span>
				</span>
            </div>
            <a href="https://beautyprosoftware.com/b/997907" {{$dataPrefix}}-beautypro
            class="button button-clip {{$classPrefix}}__content-button">
            	<span class="clip">
					<span>{{ __('static.sign_up_online') }}</span>
					<span>{{ __('static.sign_up_online') }}</span>
				</span>
            </a>
        @else
            <div data-modal-open class="button button-clip {{$classPrefix}}__content-button">
            	<span class="clip">
					<span>{{ __('static.sign_up') }}</span>
					<span>{{ __('static.sign_up') }}</span>
				</span>
            </div>

        @endif

    </div>

    @if($currentRegion == 'ua')
        <span class="{{$classPrefix}}__hashtag">#РемонтуюПринцес</span>
    @endif

</div>


{{--<div {{$dataPrefix}}-background-slider class="{{$classPrefix}}__background-slider">--}}
{{--    <div class="{{$classPrefix}}__background-slider-item">--}}
{{--        <img decoding="async" loading="lazy" alt="Slide 2" class="{{$classPrefix}}__background-slider-item-img"--}}
{{--             src="https://thefame.ua/wp-content/webp-express/webp-images/uploads/2020/09/3.jpg.webp"/>--}}
{{--    </div>--}}
{{--    <div class="{{$classPrefix}}__background-slider-item {{$classPrefix}}__background-slider-item--active">--}}
{{--        <img decoding="async" loading="lazy" alt="Slide 2" class="{{$classPrefix}}__background-slider-item-img"--}}
{{--             src="https://thefame.ua/wp-content/webp-express/webp-images/uploads/2020/09/image-21-scaled.jpg.webp"/>--}}
{{--    </div>--}}
{{--    <div class="{{$classPrefix}}__background-slider-item">--}}
{{--        <img decoding="async" loading="lazy" alt="Slide 2" class="{{$classPrefix}}__background-slider-item-img"--}}
{{--             src="https://thefame.ua/wp-content/webp-express/webp-images/uploads/2020/09/image-17.jpg.webp"/>--}}
{{--    </div>--}}
{{--    <div class="{{$classPrefix}}__background-slider-item">--}}
{{--        <img decoding="async" loading="lazy" alt="Slide 2" class="{{$classPrefix}}__background-slider-item-img"--}}
{{--             src="https://thefame.ua/wp-content/webp-express/webp-images/uploads/2020/09/image-21-scaled.jpg.webp"/>--}}
{{--    </div>--}}
{{--</div>--}}
