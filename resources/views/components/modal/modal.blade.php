@php
    $classPrefix ='modal';
    $dataPrefix ='data-modal';
    $currentRegionName = 'Київ';
    $callUs = \App\Models\CallUs::first();
    $location = \App\Models\Location::first();
    $socialLinks = \App\Models\SocialLink::where(function ($query) {
        $query->whereHas('region', fn ($regionQuery) => $regionQuery->where('code', 'ua'))
            ->orWhereDoesntHave('region');
    })->get();
    $whatsApp = $socialLinks->first(fn ($link) => strcasecmp((string) $link->platform, 'WhatsApp') === 0);
    $instagram = $socialLinks->first(fn ($link) => strcasecmp((string) $link->platform, 'Instagram') === 0);
    $phone = $callUs?->phone_ua ?: $location?->phone;
    $email = $callUs?->email_ua ?: $location?->email;
    $phoneHref = $phone ? preg_replace('/[^\d+]/', '', $phone) : null;
@endphp

<div {{$dataPrefix}}
     data-modal-request-error="{{ __('static.appointment_request_error') }}"
     class="{{$classPrefix}}">
    <form {{$dataPrefix}}-form class="{{$classPrefix}}__form" novalidate>
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

            <button type="submit" {{$dataPrefix}}-submit class="button button-clip {{$classPrefix}}__container-button">
                <span class="clip">
                    <span>{{__('static.sign_up')}}</span>
                    <span>{{__('static.sign_up')}}</span>
                </span>
            </button>
        </div>
    </form>

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
                @if($phone)
                    <a href="tel:{{ $phoneHref }}" class="contact-link">📞 {{ $phone }}</a>
                @endif
                @if($email)
                    <a href="mailto:{{ $email }}" class="contact-link">✉️ {{ $email }}</a>
                @endif
                @if($location)
                    <span class="contact-link">📍 {{ $location->title }}</span>
                @endif

                @if($whatsApp)
                    <a href="{{ $whatsApp->url }}" target="_blank" rel="noopener noreferrer" class="button {{$classPrefix}}__success-wa-btn">{{__('static.modal_success_wa_btn')}}</a>
                @endif
            </div>

            @if($instagram)
              <div class="{{$classPrefix}}__success-social">
                <p>{{__('static.modal_success_social_title')}}</p>
                <a href="{{ $instagram->url }}" target="_blank" rel="noopener noreferrer" class="social-link">Instagram</a>
              </div>
            @endif
        </div>
    </div>
</div>
