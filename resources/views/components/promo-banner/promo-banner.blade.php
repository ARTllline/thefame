@php
    $classPrefix ='promo-banner';
    $dataPrefix ='data-promo-banner';
@endphp


<div {{$dataPrefix}} class="{{$classPrefix}}">

    <div class="{{$classPrefix}}__content">
        <h1 class="{{$classPrefix}}__title @if($isFace) {{$classPrefix}}__title--small @endif ">
            @if($isFace)
                {{__('promo.banner_title_face')}}
            @else
                {{__('promo.banner_title')}}
            @endif

            <button data-modal-open class="button button-clip button-primary {{ $classPrefix }}__button m-hide">
            	<span class="clip">
					<span>  {{__('promo.banner_button_face')}}</span>
					<span>{{__('promo.banner_button_face')}}</span>
				</span>
            </button>
        </h1>
        <div class="{{$classPrefix}}__info">
            <div class="{{$classPrefix}}__info-title">
                The Fame
            </div>
            <div class="{{$classPrefix}}__info-line">
            </div>
            <div class="{{$classPrefix}}__info-text">

                @if($isFace)
                    {{__('promo.banner_text_face')}}
                @else
                    {{__('promo.banner_text')}}
                @endif
            </div>
            <button data-modal-open class="button button-clip button-primary {{ $classPrefix }}__button m-show">
            	<span class="clip">
					<span>{{__('promo.banner_button_face')}}</span>
					<span>{{__('promo.banner_button_face')}}</span>
				</span>
            </button>
        </div>
    </div>
    <div class="{{$classPrefix}}__media">
        <img src="{{ asset('img/promo-banner.webp') }}" alt="Promo banner">
    </div>
</div>

