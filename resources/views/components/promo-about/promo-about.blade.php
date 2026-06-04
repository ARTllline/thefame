@php
    $classPrefix ='promo-about';
    $dataPrefix ='data-promo-about';
@endphp


<div {{$dataPrefix}} class="{{$classPrefix}}">
    <div class="{{$classPrefix}}__header">
        <div class="{{$classPrefix}}__label">
            {{__('promo.why_us_label')}}
        </div>
        <div class="{{$classPrefix}}__title">
            {!! nl2br(__('promo.why_us_title')) !!}
        </div>
    </div>
    <div class="{{$classPrefix}}__content">
        <div class="{{$classPrefix}}__list">
            @foreach(__('promo.why_us_list') as $title => $item)
                <div class="{{$classPrefix}}__list-item">
                    <div class="{{$classPrefix}}__list-item-num">
                        {{ sprintf('%02d', $loop->iteration) }}
                    </div>
                    <div class="{{$classPrefix}}__list-container">
                        <div class="{{$classPrefix}}__list-item-title">
                            {{$title}}
                        </div>
                        <div class="{{$classPrefix}}__list-item-text">
                            {{$item}}
                        </div>
                    </div>
                </div>

            @endforeach
            <div class="{{$classPrefix}}__media m-show">
                <img src="{{ asset('img/promo-about.webp') }}" alt="promo-about">
            </div>
            <div class="{{$classPrefix}}__list-subtitle">
                {{__('promo.why_us_conclusion')}}
            </div>
        </div>
        <div class="{{$classPrefix}}__media m-hide">
            <img src="{{ asset('img/promo-about.webp') }}" alt="promo-about">
        </div>
    </div>
    <div class="{{$classPrefix}}__footer">
        <button data-modal-open="" class="button button-clip button-primary {{$classPrefix}}__button">
            	<span class="clip">
					<span>{{__('promo.promo_checkout_form.button')}}</span>
					<span>{{__('promo.promo_checkout_form.button')}}</span>
				</span>
        </button>
    </div>
</div>

