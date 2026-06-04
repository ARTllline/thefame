@php
    $classPrefix = 'region-selector';
    $dataPrefix = 'data-region-selector';

    $regions = \App\Models\Region::all();
@endphp

<div {{$dataPrefix}} class="{{$classPrefix}}  @if(isset($showRegionModal) && $showRegionModal) {{$classPrefix}}--active  @endif">
    <div class="{{$classPrefix}}__content">
{{--        <h2 class="{{$classPrefix}}__title">{{__('static.select_region')}}</h2>--}}
        <div class="{{$classPrefix}}__flags">
            @foreach($regions as  $region)
                <div class="{{$classPrefix}}__flag" data-region="{{$region->code}}">
                    <img
                        src="{{ $region->getFirstMediaUrl('main', 'webp')}}"
                        alt="{{$region->name}}">
                    <span class="{{$classPrefix}}__name">{{$region->name}}</span>
                </div>
            @endforeach
        </div>
    </div>
    <form action="{{ route('region.set') }}" method="POST" id="regionSelectorForm" style="display: none;">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="redirect_to" value="{{ url()->current() }}">
        <input type="hidden" name="region" id="regionInput">
    </form>
</div>
