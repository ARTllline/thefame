@php
    $classPrefix ='locations';
    $dataPrefix ='data-locations';
    $locations = \App\Models\Location::all();
@endphp

<div {{$dataPrefix}} class="{{$classPrefix}}">
    <h4 class="{{$classPrefix}}__title">
        {{__('static.locations')}}
    </h4>

    <div class="{{$classPrefix}}__list">
        @foreach($locations as $location)
            <div class="{{$classPrefix}}__list-item">
                <div class="{{$classPrefix}}__list-item-num">
                    0{{ $loop->index + 1 }}
                </div>
                <div class="{{$classPrefix}}__list-item-content">
                    <div class="{{$classPrefix}}__list-item-content-street">
                        {{$location->title}}
                    </div>
                    <div class="{{$classPrefix}}__list-item-content-district">
                        {{$location->subtitle}}
                    </div>
                    <div class="{{$classPrefix}}__list-item-content-phone">
                        <a class="link link--anim"  href="#">{{$location->phone}}</a>
                    </div>
                    <div class="{{$classPrefix}}__list-item-content-mail">
                        <a class="link link--anim" href="#">{{$location->email}}</a>
                    </div>
                </div>

                <div class="{{$classPrefix}}__list-item-map">
                    <iframe
                        src="{{$location->map}}"
                        height="450" style="border:0;" allowfullscreen="" aria-hidden="false"
                        tabindex="0"></iframe>
                </div>
            </div>
        @endforeach
    </div>

</div>
