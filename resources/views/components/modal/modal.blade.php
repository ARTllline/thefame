@php
    $classPrefix ='modal';
    $dataPrefix ='data-modal';
    $currentRegionName = 'Київ';

    if ($currentRegion == 'dubai')
        {
            $currentRegionName = 'Dubai';
        }

@endphp

<div {{$dataPrefix}} class="{{$classPrefix}}">
    <div {{$dataPrefix}}-form class="{{$classPrefix}}__form">
        <div class="{{$classPrefix}}__container">
            <div {{$dataPrefix}}-close class="{{$classPrefix}}__container-close"></div>

            <h3 class="{{$classPrefix}}__container-title">{{__('static.appointment')}}</h3>

            <div {{$dataPrefix}}-name class="{{$classPrefix}}__container-input">
                <input placeholder="{{__('static.appointment_name')}}" name="name" type="text">
                <span class="{{$classPrefix}}__container-input-err-message">
                    {{__('static.appointment_error_name')}}
                </span>
            </div>

            <div {{$dataPrefix}}-phone
                 class="{{$classPrefix}}__container-input {{$classPrefix}}__container-input--phone">
                <input placeholder="{{__('static.appointment_phone')}}" name="phone" class="tel-input" type="tel">
                <span class="{{$classPrefix}}__container-input-err-message">
                    {{__('static.appointment_error_phone')}}
                </span>
            </div>

            <input {{$dataPrefix}}-region type="hidden" name="region" value="{{$currentRegionName}}">

            <!-- Кнопка отправки -->
            <button {{$dataPrefix}}-submit class="button button-clip {{$classPrefix}}__container-button">
                <span class="clip">
                    <span>{{__('static.sign_up')}}</span>
                    <span>{{__('static.sign_up')}}</span>
                </span>
            </button>

            <p class="{{$classPrefix}}__container-subtitle">
                {{__('static.appointment_call')}}
                <a href="tel:+380739119111" class="link">+38 073 911 9111</a>
            </p>
        </div>
    </div>

    <div {{$dataPrefix}}-popup class="{{$classPrefix}}__success-popup" style="display: none;">
        <div class="{{$classPrefix}}__success-popup-inner">
            <p>{{__('static.appointment_success')}}</p>
            <div {{$dataPrefix}}-popup-close class="{{$classPrefix}}__success-popup-close"></div>
        </div>
    </div>
</div>
