@php
    $classPrefix = 'call-us';
    $dataPrefix = 'data-call-us';
    $links = \App\Models\SocialLink::where(function ($query) use ($currentRegion) {
                $query->whereHas('region', function ($query) use ($currentRegion) {
                    $query->where('code', $currentRegion);
                })->orWhereDoesntHave('region');
            })->get();

    $callUs = \App\Models\CallUs::first();

@endphp

<div {{$dataPrefix}} class="{{$classPrefix}}">
    <div class="{{$classPrefix}}__container">
        <h2 class="{{$classPrefix}}__container-title">
            {{$callUs->text}}
        </h2>
        <div data-modal-open class="button button-clip {{$classPrefix}}__container-button">
            	<span class="clip">
					<span>{{__('static.sign_up')}}</span>
					<span>{{__('static.sign_up')}}</span>
				</span>
        </div>

        <div class="{{$classPrefix}}__container-phone">
            @if($currentRegion == 'dubai')
                {{$callUs->phone_dubai}}
            @else
                {{$callUs->phone_ua}}
            @endif

        </div>
        <div class="{{$classPrefix}}__container-list">
            @foreach($links as $link)
                <a target="_blank" href="{{$link->url}}" class="{{$classPrefix}}__container-list-item">
                    {{$link->platform}}
                </a>
            @if(!$loop->last)
                    <div class="{{$classPrefix}}__container-list-dot">

                    </div>
            @endif

            @endforeach
        </div>
    </div>
    <div class="{{$classPrefix}}__moving-shape">

    </div>
</div>
