@php
    $classPrefix = 'catalogue-product-card';
    $dataPrefix = 'data-catalogue-product-card';
@endphp
<section {{$dataPrefix}} data-product-id="{{$productData['product']['id']}}" class="{{$classPrefix}}">
    <div class="{{$classPrefix}}__header">
        <div class="{{$classPrefix}}__breadcrumbs">
            @foreach($productData['breadcrumbs'] as $breadcrumb)
                <a href="{{$breadcrumb['url']}}" class="{{$classPrefix}}__breadcrumbs-item">
                    {{$breadcrumb['title']}}
                </a>
                @if(!$loop->last)
                    <div class="{{$classPrefix}}__breadcrumbs-dot"></div>
                @endif
            @endforeach
        </div>
    </div>

    <div class="{{$classPrefix}}__main">
        <div class="{{$classPrefix}}__main-media">
            <div class="{{$classPrefix}}__media-img">
                <div class="{{$classPrefix}}__media-img-main">
                    <div {{$dataPrefix}}-image
                         class="swiper swiper--hidden {{$classPrefix}}__swiper-image">
                        <div {{$dataPrefix}}-image-wrapper class="swiper-wrapper">
                            @foreach($productData['product']['images'] as $image)
                                <div class="swiper-slide">
                                    <div class="{{$classPrefix}}__media-container">
                                        <a href="{{ $image['url'] }}" class="glightbox" data-gallery="gallery">
                                            <img
                                                src="{{ $image['url'] }}"
                                                alt="image"
                                                decoding="async"
                                                fetchpriority="high"/>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="{{$classPrefix}}__media-img-prev">
                    <div {{$dataPrefix}}-slider
                         class="swiper swiper--hidden {{$classPrefix}}__swiper-prev {{$classPrefix}}__swiper">
                        <div {{$dataPrefix}}-slider-wrapper class="swiper-wrapper">
                            @foreach($productData['product']['images'] as $image)
                                <div class="swiper-slide">
                                    <div class="{{$classPrefix}}__media-img-nav-item">
                                        <img
                                            src="{{ $image['url']  }}"
                                            alt="product">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="{{$classPrefix}}__main-info">
            <div class="{{$classPrefix}}__main-label">
                {{$productData['product']['brand']['name'] ?? ''}}
            </div>
            <div class="{{$classPrefix}}__main-title">
                {{$productData['product']['name']}}
            </div>
            <div class="{{$classPrefix}}__main-subtitle">
                {{$productData['product']['subtitle']}}
            </div>
            <div class="{{$classPrefix}}__main-prices">
                <div class="{{$classPrefix}}__main-price">
                    {{$productData['product']['price_ua']}} ₴
                </div>
                <div class="{{$classPrefix}}__main-price {{$classPrefix}}__main-price--light">
                    {{$productData['product']['price_eu']}} €
                </div>

            </div>

            @if($productData['product']['description'])
                <div class="{{$classPrefix}}__main-description">
                    <div {{$dataPrefix}}-description-text class="{{$classPrefix}}__main-description-text">
                        <div class="{{$classPrefix}}__main-description-content">
                            {!! $productData['product']['description'] !!}
                        </div>

                    </div>
                    <div {{$dataPrefix}}-description-wrap
                         class="{{$classPrefix}}__main-description-wrap">{{__('catalogue.card_read_more')}}
                    </div>
                </div>
            @endif


            <div class="{{$classPrefix}}__main-control">
                <div class="{{$classPrefix}}__main-count-value">
                    <div {{$dataPrefix}}-count-minus class="{{$classPrefix}}__main-count-value-minus">-</div>
                    <div {{$dataPrefix}}-count class="{{$classPrefix}}__main-count-value-current">1</div>
                    <div {{$dataPrefix}}-count-plus class="{{$classPrefix}}__main-count-value-plus">+</div>
                </div>
                <button {{$dataPrefix}}-add-to-cart
                        class="button button-clip {{$classPrefix}}__button {{$classPrefix}}__button--opposite">
             	<span class="clip">
					<span>{{__('catalogue.add_to_cart')}}</span>
                    <span>{{__('catalogue.add_to_cart')}}</span>
				</span>
                </button>
                <button {{$dataPrefix}}-buy-now class="button button-clip {{$classPrefix}}__button">
             	<span class="clip">
					<span>{{__('catalogue.buy_now')}}</span>
					<span>{{__('catalogue.buy_now')}}</span>
				</span>
                </button>
            </div>

            <div class="{{$classPrefix}}__main-details">
                <div {{$dataPrefix}}-main-details-header class="{{$classPrefix}}__main-details-header">
                    <div class="{{$classPrefix}}__main-details-title">{{__('catalogue.details')}}</div>
                    <div class="{{$classPrefix}}__main-details-header-icon">
                        -
                    </div>
                </div>
                <div {{$dataPrefix}}-main-details-body class="{{$classPrefix}}__main-details-body is-open">
                    @if($productData['product']['category'] && count($productData['product']['category']) > 0)
                        <div class="{{$classPrefix}}__main-detail">
                            <div class="{{$classPrefix}}__main-detail-title">{{__('catalogue.card_category')}}</div>
                            <div class="{{$classPrefix}}__main-detail-value">

                                <span>{{$productData['product']['category']['name']}}</span> <br>

                            </div>
                        </div>
                    @endif
                    <div class="{{$classPrefix}}__main-detail">
                        <div class="{{$classPrefix}}__main-detail-title">{{__('catalogue.card_volume')}}</div>
                        <div class="{{$classPrefix}}__main-detail-value">{{$productData['product']['volume']}}</div>
                    </div>
                    @if($productData['product']['ingredients'] && count($productData['product']['ingredients']) > 0)
                        <div class="{{$classPrefix}}__main-detail">
                            <div class="{{$classPrefix}}__main-detail-title">{{__('catalogue.card_ingredients')}}</div>
                            <div class="{{$classPrefix}}__main-detail-value">
                                @foreach($productData['product']['ingredients'] as $ingredient)
                                    <span>{{$ingredient['name']}}</span> <br>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

</section>
