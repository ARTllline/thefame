@php($classPrefix ='main-banner')
@php($dataPrefix ='data-main-banner')


<div {{$dataPrefix}} class="{{$classPrefix}}">
    <div {{$dataPrefix}}-background-slider class="{{$classPrefix}}__background-slider">
        <div class="{{$classPrefix}}__background-slider-item">
            <img decoding="async" loading="lazy" alt="Slide 2" class="{{$classPrefix}}__background-slider-item-img" src="https://thefame.ua/wp-content/webp-express/webp-images/uploads/2020/09/3.jpg.webp"/>
        </div>
        <div class="{{$classPrefix}}__background-slider-item {{$classPrefix}}__background-slider-item--active">
            <img decoding="async" loading="lazy" alt="Slide 2" class="{{$classPrefix}}__background-slider-item-img" src="https://thefame.ua/wp-content/webp-express/webp-images/uploads/2020/09/image-21-scaled.jpg.webp"/>
        </div>
        <div class="{{$classPrefix}}__background-slider-item">
            <img decoding="async" loading="lazy" alt="Slide 2" class="{{$classPrefix}}__background-slider-item-img" src="https://thefame.ua/wp-content/webp-express/webp-images/uploads/2020/09/image-17.jpg.webp"/>
        </div>
        <div class="{{$classPrefix}}__background-slider-item">
            <img decoding="async" loading="lazy" alt="Slide 2" class="{{$classPrefix}}__background-slider-item-img" src="https://thefame.ua/wp-content/webp-express/webp-images/uploads/2020/09/image-21-scaled.jpg.webp"/>
        </div>
    </div>


    <div class="{{$classPrefix}}__content">
        <div class="{{$classPrefix}}__content-logo">
            <img src="{{ asset('svg/logo.svg')}}" alt="Logo">
        </div>
        <h2 class="{{$classPrefix}}__content-title">Beauty salon</h2>
        <div data-modal-open class="button button-clip {{$classPrefix}}__content-button">
            	<span class="clip">
					<span>{{ __('static.sign_up') }}</span>
					<span>{{ __('static.sign_up') }}</span>
				</span>
        </div>
    </div>

    <span class="{{$classPrefix}}__hashtag">#РемонтуюПринцес</span>

</div>
