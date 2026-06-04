@php
    $classPrefix ='promo-procedures';
    $dataPrefix ='data-promo-procedures';
@endphp


<div {{$dataPrefix}} class="{{$classPrefix}}">
    <div class="{{$classPrefix}}__header">
        <div class="{{$classPrefix}}__title">
            <span>{{__('promo.technologies_title_1')}}</span>
            <span>{{__('promo.technologies_title_2')}}</span>
        </div>
        <div class="{{$classPrefix}}__subtitle">
            {{__('promo.technologies_intro')}}
        </div>

    </div>
    <div class="{{$classPrefix}}__list">
        @foreach(__('promo.technologies_list') as $title => $procedure)
            <div class="{{ $classPrefix }}__list-item">
                <div class="{{ $classPrefix }}__list-item-num">
                    {{ sprintf('%02d', $loop->iteration) }}
                </div>
                <div class="{{ $classPrefix }}__list-item-title">
                    {{ $title }}
                </div>
                <div class="{{ $classPrefix }}__list-item-text">
                    {{$procedure}}
                </div>

                <a href="{{ url(route('devices')) }}" class="{{ $classPrefix }}__list-item-link">
                    {{__('promo.technologies_button_link')}}

                    <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M10.6871 21.7315C10.2078 22.2108 9.43072 22.2108 8.95143 21.7315C8.47216 21.2523 8.47216 20.4752 8.95143 19.9959L15.4473 13.5001L8.95143 7.00427C8.47216 6.52498 8.47216 5.74792 8.95143 5.26864C9.43072 4.78936 10.2078 4.78936 10.6871 5.26864L18.0507 12.6323C18.53 13.1116 18.53 13.8886 18.0507 14.3679L10.6871 21.7315Z"
                              fill="#BE5293"/>
                    </svg>
                </a>
            </div>
        @endforeach
    </div>
    <div class="{{$classPrefix}}__footer">
        <div class="{{$classPrefix}}__footer-text">
            <span class="m-show">{{__('promo.technologies_cta')}}</span>
            <span class="m-hide">{{__('promo.technologies_help')}}</span>

        </div>
        <div data-modal-open class="button {{$classPrefix}}__footer-link">
            <span class="m-show">{{__('promo.technologies_button_1')}}</span>
            <span class="m-hide">{{__('promo.technologies_button_2')}}</span>
        </div>
    </div>
</div>

