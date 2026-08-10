@php
    $classPrefix ='modal';
    $dataPrefix ='data-modal';
    $currentRegionName = 'Київ';
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

            <div {{$dataPrefix}}-phone class="{{$classPrefix}}__container-input {{$classPrefix}}__container-input--phone">
                <input placeholder="{{__('static.appointment_phone')}}" name="phone" class="tel-input" type="tel">
                <span class="{{$classPrefix}}__container-input-err-message">
                    {{__('static.appointment_error_phone')}}
                </span>
            </div>

            <div {{$dataPrefix}}-treatment class="{{$classPrefix}}__container-input {{$classPrefix}}__container-input--textarea">
                <p class="{{$classPrefix}}__input-label">{{__('static.modal_treatment_label')}}</p>
                <textarea placeholder="{{__('static.modal_treatment_placeholder')}}" name="treatment" rows="3"></textarea>
            </div>

            <input {{$dataPrefix}}-region type="hidden" name="region" value="{{$currentRegionName}}">

            <button {{$dataPrefix}}-submit class="button button-clip {{$classPrefix}}__container-button">
                <span class="clip">
                    <span>{{__('static.sign_up')}}</span>
                    <span>{{__('static.sign_up')}}</span>
                </span>
            </button>
        </div>
    </div>

    <div {{$dataPrefix}}-success class="{{$classPrefix}}__success-page" style="display: none;">
        <div class="{{$classPrefix}}__container {{$classPrefix}}__container--success">
            <div {{$dataPrefix}}-success-close class="{{$classPrefix}}__container-close"></div>

            <h3 class="{{$classPrefix}}__success-title">{{__('static.modal_success_title')}}</h3>
            <p class="{{$classPrefix}}__success-subtitle">{{__('static.modal_success_subtitle')}}</p>

            <p class="{{$classPrefix}}__success-desc">
                {{__('static.modal_success_desc')}}
            </p>

            <div class="{{$classPrefix}}__success-contacts">
                <p class="{{$classPrefix}}__success-contacts-title">{{__('static.modal_success_contacts_title')}}</p>
                <a href="tel:+971525776016" class="contact-link">📞 +971 52 577 6016</a>
                <a href="mailto:thefameclinicdmcc@gmail.com" class="contact-link">✉️ thefameclinicdmcc@gmail.com</a>
                <span class="contact-link">📍 Україна, Київ, вул. Глибочицька,73, ЖК Podil Plaza</span>

                <a href="https://wa.me/971525776016" target="_blank" class="button {{$classPrefix}}__success-wa-btn">{{__('static.modal_success_wa_btn')}}</a>
            </div>

            <div class="{{$classPrefix}}__success-social">
                <p>{{__('static.modal_success_social_title')}}</p>
                <a href="https://instagram.com/the.fame.dubai" target="_blank" class="social-link">@the.fame</a>
            </div>
        </div>
    </div>
</div>
