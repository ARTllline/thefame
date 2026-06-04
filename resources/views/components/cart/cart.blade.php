@php
    $classPrefix = 'cart';
    $dataPrefix = 'data-cart';
@endphp


<section {{$dataPrefix}} class="{{$classPrefix}}">
    <div class="{{$classPrefix}}__main">

        <div class="{{$classPrefix}}__container" data-cart>
            <h2 id="cart-heading" class="{{$classPrefix}}__container-title">{{__('catalogue.cart_checkout')}}</h2>

            <form class="{{$classPrefix}}__form" aria-labelledby="cart-heading" novalidate>
                <div class="{{$classPrefix}}__form-group-row">
                    <div class="{{$classPrefix}}__form-group">
                        <label for="fname" class="{{$classPrefix}}__form-label">{{__('catalogue.checkout_first_name')}} <span class="{{$classPrefix}}__form-required">*</span></label>
                        <input
                            data-cart-form-fname
                            id="fname"
                            name="fname"
                            type="text"
                            class="{{$classPrefix}}__form-input"
                            required
                            maxlength="60"
                            autocomplete="given-name"
                            placeholder=""
                            aria-describedby="fname-error"
                        >
                        <span id="fname-error" class="{{$classPrefix}}__form-error" aria-live="polite"></span>
                    </div>

                    <div class="{{$classPrefix}}__form-group">
                        <label for="lname" class="{{$classPrefix}}__form-label">{{__('catalogue.checkout_last_name')}} <span class="{{$classPrefix}}__form-required">*</span></label>
                        <input
                            data-cart-form-lname
                            id="lname"
                            name="lname"
                            type="text"
                            class="{{$classPrefix}}__form-input"
                            required
                            maxlength="60"
                            autocomplete="family-name"
                            placeholder=""
                            aria-describedby="lname-error"
                        >
                        <span id="lname-error" class="{{$classPrefix}}__form-error" aria-live="polite"></span>
                    </div>
                </div>

                <div class="{{$classPrefix}}__form-group-row">
                    <div class="{{$classPrefix}}__form-group">
                        <label for="phone" class="{{$classPrefix}}__form-label">{{__('catalogue.checkout_phone')}} <span class="{{$classPrefix}}__form-required">*</span></label>
                        <input
                            data-cart-form-phone
                            id="phone"
                            name="phone"
                            type="tel"
                            class="{{$classPrefix}}__form-input"
                            required
                            inputmode="tel"
                            autocomplete="tel"
                            placeholder="+380XXXXXXXXX"
                            aria-describedby="phone-error"
                        >
                        <span id="phone-error" class="{{$classPrefix}}__form-error" aria-live="polite"></span>
                    </div>

                    <div class="{{$classPrefix}}__form-group">
                        <label for="email" class="{{$classPrefix}}__form-label">{{__('catalogue.checkout_email')}}</label>
                        <input
                            data-cart-form-email
                            id="email"
                            name="email"
                            type="text"
                            class="{{$classPrefix}}__form-input"
                            required
                            maxlength="254"
                            autocomplete="email"
                            placeholder=""
                            aria-describedby="email-error"
                        >
                        <span id="email-error" class="{{$classPrefix}}__form-error" aria-live="polite"></span>
                    </div>
                </div>
            </form>
        </div>

        <div class="{{$classPrefix}}__container">
            <h2 id="cart-heading" class="{{$classPrefix}}__container-title">{{__('catalogue.checkout_cart')}}</h2>

            <div class="{{$classPrefix}}__table" role="table" aria-label="Cart items">
                <div class="{{$classPrefix}}__table-header" role="row">
                    <div class="{{$classPrefix}}__table-header-item" role="columnheader">{{__('catalogue.checkout_cart_product')}}</div>
                    <div class="{{$classPrefix}}__table-header-item" role="columnheader">{{__('catalogue.checkout_cart_price')}} </div>
                    <div class="{{$classPrefix}}__table-header-item" role="columnheader">{{__('catalogue.checkout_cart_quantity')}}</div>
                    <div class="{{$classPrefix}}__table-header-item" role="columnheader">{{__('catalogue.checkout_cart_subtotal')}}</div>
                </div>

                <div {{$dataPrefix}}-loader class="{{$classPrefix}}__loader">
                    @include('components.catalogue-loader.catalogue-loader', ['style' => 'black'])
                </div>

                <div {{$dataPrefix}}-cart-list class="{{$classPrefix}}__table-list" role="rowgroup">

                </div>

                <div {{$dataPrefix}}-empty class="{{$classPrefix}}__empty hidden" hidden>
                  {{  __('catalogue.checkout_empty') ?? 'Your cart is empty.' }}
                </div>
            </div>
        </div>
    </div>

    <div class="{{$classPrefix}}__totals">
        <div class="{{$classPrefix}}__totals-header">
            {{__('catalogue.checkout_total_title')}}
        </div>
        <div {{$dataPrefix}}-totals-list class="{{$classPrefix}}__totals-list">
            <div class="{{$classPrefix}}__totals-list-item">
                <div class="{{$classPrefix}}__totals-list-item-title">
                    {{__('catalogue.checkout_products')}}
                </div>
                <div {{$dataPrefix}}-totals-products class="{{$classPrefix}}__totals-list-item-value">
                    -
                </div>
            </div>
        </div>
        <div class="{{$classPrefix}}__totals-footer">
            <div class="{{$classPrefix}}__totals-total-item">
                <div class="{{$classPrefix}}__totals-total-item-title">
                    {{__('catalogue.checkout_total')}}
                </div>
                <div {{$dataPrefix}}-totals-total class="{{$classPrefix}}__totals-total-item-value">
                    -
                </div>
            </div>
        </div>
        <div class="{{$classPrefix}}__totals-control">
            <div {{$dataPrefix}}-button-checkout class="{{$classPrefix}}__totals-control-button">
                {{__('catalogue.checkout_checkout')}}
            </div>
        </div>
    </div>

    <template {{$dataPrefix}}-item-template>
        <div {{$dataPrefix}}-item class="{{$classPrefix}}__table-list-item">
            <div class="{{$classPrefix}}__table-list-item-info">
                <div {{$dataPrefix}}-item-remove class="{{$classPrefix}}__table-list-item-remove">
                    x
                </div>
                <div {{$dataPrefix}}-item-image class="{{$classPrefix}}__table-list-item-image">
                    <img src="{{asset('img/test_product_1.jpg')}}" alt="placeholder">
                </div>
                <div {{$dataPrefix}}-item-title class="{{$classPrefix}}__table-list-item-title">
                    Energizing Cleansing Gel
                </div>
            </div>
            <div {{$dataPrefix}}-item-price class="{{$classPrefix}}__table-list-item-price">
                2000 ₴
            </div>
            <div class="{{$classPrefix}}__table-list-item-quantity">
                <button type="button" {{$dataPrefix}}-item-quantity-decrease
                        class="{{$classPrefix}}__table-list-item-quantity-btn" aria-label="Decrease">−
                </button>
                <div {{$dataPrefix}}-item-quantity class="{{$classPrefix}}__table-list-item-quantity-input"
                     aria-label="Quantity"></div>
                <button type="button" {{$dataPrefix}}-item-quantity-increase
                        class="{{$classPrefix}}__table-list-item-quantity-btn" aria-label="Increase">+
                </button>
            </div>
            <div {{$dataPrefix}}-item-price-total class="{{$classPrefix}}__table-list-item-price">
                2000 ₴
            </div>
        </div>
    </template>
</section>





