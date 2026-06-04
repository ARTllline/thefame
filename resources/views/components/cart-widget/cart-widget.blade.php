@php
    $classPrefix ='cart-widget';
    $dataPrefix ='data-cart-widget';
@endphp

<div {{$dataPrefix}} class="{{$classPrefix}}" aria-hidden="true" aria-label="{{ __('cart.title') }}">
    <div class="{{$classPrefix}}__container" role="dialog" aria-modal="true" aria-labelledby="cart-widget-heading">
        <div class="{{$classPrefix}}__header">
            <div id="cart-widget-heading" class="{{$classPrefix}}__header-title">
                {{__('catalogue.cart_title')}}
            </div>
            <button type="button" {{$dataPrefix}}-close class="{{$classPrefix}}__container-close"
                    aria-label="Close cart">×
            </button>
        </div>

        <div class="{{$classPrefix}}__list" role="region" aria-live="polite" aria-label="Cart items">
            <div class="{{$classPrefix}}__list-wrapper" {{$dataPrefix}}-list>

                <div {{$dataPrefix}}-empty class="{{$classPrefix}}__empty" hidden>
                    {{  __('catalogue.cart_empty') ?? 'Your cart is empty.' }}
                </div>
            </div>
        </div>

        <div class="{{$classPrefix}}__footer">
            <div class="{{$classPrefix}}__footer-total">
                <div class="{{$classPrefix}}__footer-total-label">
                    {{__('catalogue.cart_total')}}
                </div>
                <div {{$dataPrefix}}-total class="{{$classPrefix}}__footer-total-value">
                    0 ₴
                </div>
            </div>
            <div class="{{$classPrefix}}__footer-control">
                <a href="{{route('cart')}}" class="button {{$classPrefix}}__footer-button">
                    {{__('catalogue.cart_checkout')}}
                </a>
            </div>
        </div>
    </div>
</div>

<template {{$dataPrefix}}-item-template>
    <div class="{{$classPrefix}}__item" data-item-id="">
        <div class="{{$classPrefix}}__item-image">
            <img src="" alt=""/>
        </div>
        <div class="{{$classPrefix}}__item-content">
            <div {{$dataPrefix}}-item-title class="{{$classPrefix}}__item-content-title">Product</div>
            <div {{$dataPrefix}}-item-price class="{{$classPrefix}}__item-content-price">0 ₴</div>
            <div class="{{$classPrefix}}__quantity-control">
                <button type="button" {{$dataPrefix}}-qty-decrease class="{{$classPrefix}}__qty-btn"
                        aria-label="Decrease">−
                </button>
                <div {{$dataPrefix}}-item-quantity class="{{$classPrefix}}__qty-input" aria-label="Quantity"></div>
                <button type="button" {{$dataPrefix}}-qty-increase class="{{$classPrefix}}__qty-btn"
                        aria-label="Increase">+
                </button>
            </div>
        </div>
        <div class="{{$classPrefix}}__item-control">
            <button type="button" {{$dataPrefix}}-item-remove class="{{$classPrefix}}__item-control-close" aria-label="Remove item">×</button>
        </div>
    </div>
</template>
