@php
    $classPrefix = 'promo-accordion';
    $dataPrefix = 'data-promo-accordion';

    $promo = __('promo');
    $items = $promo['accordion_items'];
@endphp

<div {{ $dataPrefix }} class="{{ $classPrefix }}">
    <div class="{{ $classPrefix }}__header">

        <div class="{{ $classPrefix }}__title">
            {{ __('promo.accordion_title') }}
        </div>

        <div class="{{ $classPrefix }}__label">
            {{ __('promo.accordion_label') }}
        </div>
    </div>

    <div class="{{ $classPrefix }}__container">

        @foreach($items as $i => $item)
            <div data-promo-accordion-item="{{ $i }}" class="{{ $classPrefix }}__item">

                <div data-promo-accordion-header class="{{ $classPrefix }}__item-header">
                    <div class="{{ $classPrefix }}__item-header-num">
                        {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                    </div>

                    <div class="{{ $classPrefix }}__item-header-title">
                        {{ $item['title'] }}
                    </div>

                    <div class="{{ $classPrefix }}__item-header-text">
                        {{ $item['text'] }}
                    </div>

                    <div data-promo-accordion-header-btn class="{{ $classPrefix }}__item-header-btn">+</div>
                </div>

                <div data-promo-accordion-body class="{{ $classPrefix }}__item-body">
                    <div class="{{ $classPrefix }}__item-body-inner">

                        @foreach($item['prices'] as $price)
                            <div class="{{ $classPrefix }}__item-body-item">
                                <div class="{{ $classPrefix }}__item-body-item-title">
                                    {{ $price['label'] }}
                                </div>

                                <div class="{{ $classPrefix }}__item-body-item-price">
                                    {{ $price['value'] }}
                                </div>

                                <div class="link {{ $classPrefix }}__item-body-item-link m-hide">
                                    {{ __('promo.accordion.choose') }}
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        @endforeach

    </div>

    <div class="{{ $classPrefix }}__footer">

        <div class="{{ $classPrefix }}__subtitle m-hide">
            {{ __('promo.accordion.footer_full') }}
        </div>

        <div class="{{ $classPrefix }}__subtitle m-show">
            {{ __('promo.accordion.footer_short') }}
        </div>

        <div data-modal-open class="button button-clip button-primary {{ $classPrefix }}__button">
            <span class="clip">
                <span>{{ __('promo.accordion.button') }}</span>
                <span>{{ __('promo.accordion.button') }}</span>
            </span>
        </div>
    </div>
</div>
