@php
    $classPrefix = 'promo-bar';
    $dataPrefix = 'data-promo-bar';
    $banner = \App\Models\PromoBanner::where('is_active', 1)->first();
    $content = $banner ? $banner->getTranslation('content', app()->getLocale()) : null;
@endphp

@if($banner && $content)
    <div {{$dataPrefix}} class="{{$classPrefix}}" style="display: none;">
        <div class="{{$classPrefix}}__wrapper">
            <button data-modal-open="promo" class="{{$classPrefix}}__link">
                {{ $content }}
            </button>
            <button data-promo-close class="{{$classPrefix}}__close">×</button>
        </div>
    </div>
@endif
