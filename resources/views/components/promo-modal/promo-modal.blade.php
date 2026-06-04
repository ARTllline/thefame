@php
    $classPrefix ='promo-modal';
    $dataPrefix ='data-promo-modal';
    $currentRegionName = 'Київ';

    if ($currentRegion == 'dubai')
        {
            $currentRegionName = 'Dubai';
        }
@endphp
@if($currentRegion == 'dubai')
    <div {{$dataPrefix}} class="{{$classPrefix}}">
        <div {{$dataPrefix}}-form class="{{$classPrefix}}__form">
            <div class="{{$classPrefix}}__container">
                <div {{$dataPrefix}}-close class="{{$classPrefix}}__container-close"></div>
                <img {{$dataPrefix}}-close data-modal-open class="{{$classPrefix}}__container-img" src="{{ asset('img/promo-popup.webp') }}" alt="Promo">
            </div>
        </div>
    </div>

@endif

