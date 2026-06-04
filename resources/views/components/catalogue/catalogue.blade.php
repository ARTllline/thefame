@php
    $classPrefix = 'catalogue';
    $dataPrefix = 'data-catalogue';
@endphp
<script>
    window.appLocale = "{{ app()->getLocale() }}";

    window.CATALOGUE_META = @json($catalogueData['meta']);
    window.CURRENT_FILTER = @json($catalogueData['currentFilter']);
</script>

<section {{$dataPrefix}} class="{{$classPrefix}}">

    <div class="{{$classPrefix}}__container">
        <div {{$dataPrefix}}-filters class="{{$classPrefix}}__filter-container">
            <div {{$dataPrefix}}-filter-close class="{{$classPrefix}}__filter-close">x</div>
            <div class="{{$classPrefix}}__filters">
                @include('components.catalogue.catalogue-filters.catalogue-filters', ['filtersData' => $catalogueData['filters']])
            </div>
        </div>

        <div class="{{$classPrefix}}__content">
            <div class="{{$classPrefix}}__content-header">
                <div class="{{$classPrefix}}__content-header-panel">
                    <div {{$dataPrefix}}-filter-btn class="{{$classPrefix}}__filter-btn">
                        <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="0" y="1" width="16" height="1.5" rx="1" fill="#1a1a1a"/>
                            <rect x="2" y="5" width="12" height="1.5" rx="1" fill="#1a1a1a"/>
                            <rect x="4" y="9" width="8" height="1.5" rx="1" fill="#1a1a1a"/>
                            <rect x="6" y="13" width="4" height="1.5" rx="1" fill="#1a1a1a"/>
                        </svg>

                    </div>
                    <span class="{{$classPrefix}}__content-header-label">{{ __('catalogue.showing_results', ['count' => $catalogueData['meta']['total']]) }}</span>
                </div>
                <div class="{{$classPrefix}}__sort m-hide">
                    <select {{$dataPrefix}}-sort-select class="{{$classPrefix}}__sort-select">
                        <option value="default">{{ __('catalogue.default_sort') }}</option>
                        <option value="price_desc"> {{__('catalogue.sort_by_price_desc')}} </option>
                        <option value="price_asc"> {{__('catalogue.sort_by_price_asc')}}  </option>
                        <option value="title_asc"> {{__('catalogue.sort_by_name_asc')}} </option>
                        <option value="title_desc"> {{__('catalogue.sort_by_name_desc')}}  </option>
                    </select>
                    <div {{$dataPrefix}}-view-btn data-view="grid" class="{{$classPrefix}}__sort-btn active m-hide">
                        <svg class="base-svg-icon base-grid-svg" fill="currentColor" version="1.1"
                             xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><title>
                                Grid</title>
                            <rect x="3.25" y="1.75" width="1.5" height="12.5" rx="0.75" fill="currentColor"></rect>
                            <rect x="7.25" y="1.75" width="1.5" height="12.5" rx="0.75" fill="currentColor"></rect>
                            <rect x="11.25" y="1.75" width="1.5" height="12.5" rx="0.75" fill="currentColor"></rect>
                        </svg>
                    </div>
                </div>
            </div>

            <div {{$dataPrefix}}-list class="{{$classPrefix}}__content-list">
                @foreach($catalogueData['products'] as $product)
                    @include('components.catalogue.catalogue-card.catalogue-card', ['productData' => $product])
                @endforeach
            </div>
            <div {{$dataPrefix}}-loader class="{{$classPrefix}}__loader">
                @include('components.catalogue-loader.catalogue-loader')
            </div>
            <div style="display: none;" {{$dataPrefix}}-show-more class="button {{$classPrefix}}__show-more-button">
                {{ __('catalogue.show_more') }}
            </div>

            <div class="{{$classPrefix}}__content-text">
                {{$catalogueData['seoText']}}
            </div>
        </div>
    </div>

    @include('components.catalogue.catalogue-card-template.catalogue-card-template')
</section>





