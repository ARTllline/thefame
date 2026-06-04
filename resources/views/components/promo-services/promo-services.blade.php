@php
    $classPrefix ='promo-services';
    $dataPrefix ='data-promo-services';

    $services = [
        'Омоложение /  Антивозрастные процедуры  ',
        'Лечение шрамов /  Постакне  ',
        'Удаление пигментации',
        'Безоперационная подтяжка ',
        'Удаление волос ',
        'Лечение выпадения волос',
        'Лечение выпадения волос',
    ];

@endphp


<div {{$dataPrefix}} class="{{$classPrefix}}">
    <div class="{{$classPrefix}}__header">
        <div class="{{$classPrefix}}__title">
            {{__('promo.services_title')}}
        </div>
        <div class="{{$classPrefix}}__subtitle">
            {{__('promo.services_intro')}}
        </div>

    </div>
    <div class="{{$classPrefix}}__list">
        @foreach(__('promo.services_categories') as $service)
            <div class="{{$classPrefix}}__list-item">
                <div class="{{$classPrefix}}__list-item-clip-path"></div>
                <div class="{{$classPrefix}}__list-item-border"></div>
                <div class="{{$classPrefix}}__list-item-text">
                    {{$service}}
                </div>
            </div>
        @endforeach
            <a data-modal-open class="{{$classPrefix}}__list-item {{$classPrefix}}__list-item--link ">
                <div class="{{$classPrefix}}__list-item-border"></div>
                <div class="{{$classPrefix}}__list-item-text">
                    {{__('promo.services_cta')}}
                    <svg viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.5 22.5L22.5 7.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10.3125 7.5H22.5V19.6875" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </a>
    </div>
</div>

