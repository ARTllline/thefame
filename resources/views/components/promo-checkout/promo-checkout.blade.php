@php
    $classPrefix = 'promo-checkout';
    $dataPrefix = 'data-promo-checkout';

    $currentRegionName = 'Київ';

    if ($currentRegion == 'dubai') {
        $currentRegionName = 'Dubai';
    }

    $t = __('promo');
@endphp

<div {{ $dataPrefix }} class="{{ $classPrefix }}">
    <div class="{{ $classPrefix }}__content">

        {{-- MEDIA --}}
        <div class="{{ $classPrefix }}__media">
            <img src="{{ asset('img/promo-about.webp') }}" alt="promo-about">
            <div class="{{ $classPrefix }}__media-subtitle">
                {{ $t['promo_checkout_media']['subtitle'] }}
            </div>
        </div>

        {{-- FORM --}}
        <form
            class="{{ $classPrefix }}__form"
            {{ $dataPrefix }}-form
        >
            <div class="{{ $classPrefix }}__title">
                {{ $t['promo_checkout_form']['title'] }}
            </div>

            <div class="{{ $classPrefix }}__subtitle">
                {{ $t['promo_checkout_form']['subtitle'] }}
            </div>

            <input
                {{ $dataPrefix }}-input="region"
                type="hidden"
                name="region"
                value="{{ $currentRegionName }}"
            >

            {{-- SELECT --}}
            <div class="{{ $classPrefix }}__field">
                <select
                    class="{{ $classPrefix }}__select"
                    name="goal"
                    {{ $dataPrefix }}-select
                    required
                >
                    <option value="" disabled selected>
                        {{ $t['promo_checkout_form']['select']['placeholder'] }}
                    </option>

                    @foreach($t['promo_checkout_form']['select']['options'] as $option)
                        <option value="{{ $option }}">
                            {{ $option }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- NAME --}}
            <div class="{{ $classPrefix }}__field">
                <input
                    type="text"
                    class="{{ $classPrefix }}__input"
                    name="name"
                    {{ $dataPrefix }}-input="name"
                    placeholder="{{ $t['promo_checkout_form']['placeholders']['name'] }}"
                    required
                >
            </div>

            {{-- PHONE --}}
            <div class="{{ $classPrefix }}__field">
                <input
                    type="tel"
                    class="{{ $classPrefix }}__input"
                    name="phone"
                    {{ $dataPrefix }}-input="phone"
                    placeholder="{{ $t['promo_checkout_form']['placeholders']['phone'] }}"
                    required
                >
            </div>

            {{-- EMAIL --}}
            <div class="{{ $classPrefix }}__field">
                <input
                    type="email"
                    class="{{ $classPrefix }}__input"
                    name="email"
                    {{ $dataPrefix }}-input="email"
                    placeholder="{{ $t['promo_checkout_form']['placeholders']['email'] }}"
                >
            </div>

            {{-- BUTTON --}}
            <button class="button button-clip button-primary {{ $classPrefix }}__button">
                <span class="clip">
                    <span>{{ $t['promo_checkout_form']['button'] }}</span>
                    <span>{{ $t['promo_checkout_form']['button'] }}</span>
                </span>
            </button>

            {{-- SUBTEXT --}}
            <div class="{{ $classPrefix }}__subtext">
                {{ $t['promo_checkout_form']['subtext'] }}
            </div>
        </form>

    </div>
</div>
