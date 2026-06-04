@php
    $classPrefix = 'locale-selector';
    $dataPrefix = 'data-locale-selector';

@endphp

<div {{$dataPrefix}} class="{{$classPrefix}}">
    <div class="{{$classPrefix}}__content">
        <!-- Заголовок модального окна -->
        <h2 class="{{$classPrefix}}__title">{{__('static.select_locale')}}</h2>
        <div {{$dataPrefix}}-locales class="{{$classPrefix}}__locales">
            <div  {{$dataPrefix}}-locale class="{{$classPrefix}}__locale" data-locale="uk">
                Українська
            </div>
            @if($currentRegion !== 'ua')
                <div {{$dataPrefix}}-locale class="{{ $classPrefix }}__locale" data-locale="ru">
                    Русский
                </div>
            @endif
            <div {{$dataPrefix}}-locale class="{{$classPrefix}}__locale" data-locale="en">
                English
            </div>
        </div>
    </div>

    <form action="{{ route('locale.set') }}" method="POST" {{$dataPrefix}}-form id="localeSelectorForm"
          style="display: none;">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="redirect_to" value="{{ url()->current() }}">
        <input type="hidden" name="locale" {{$dataPrefix}}-input id="localeInput">
    </form>
</div>
