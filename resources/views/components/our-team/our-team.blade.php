@php($classPrefix ='our-team')
@php($dataPrefix ='data-our-team')


<div {{$dataPrefix}} class="{{$classPrefix}}">

    <div class="{{$classPrefix}}__title">{{__('static.team')}}</div>

    <div class="{{$classPrefix}}__list">
        @foreach($team as $member)
            <div class="{{$classPrefix}}__card">
                <div class="{{$classPrefix}}__card-fade">
                    <div class="{{$classPrefix}}__card-img">
                        <svg class="{{$classPrefix}}__card-moving-svg" viewBox="0 0 249 315" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M113.725 0.0576457C155.841 1.85016 179.188 51.3647 204.077 89.9486C227.04 125.548 257.806 163.848 246.633 206.101C235.819 247 189.999 252.949 156.08 271.462C122.19 289.959 89.304 327.417 54.631 310.893C19.1847 294.001 13.0187 242.483 5.51397 199.706C-1.62244 159.029 -4.69707 117.208 14.4524 81.8779C36.9922 40.292 70.7221 -1.77262 113.725 0.0576457Z"
                                  fill="#f4e4e8"></path>
                        </svg>
                        <div class="{{$classPrefix}}__card-clip-path">
                            <img fetchpriority="high" decoding="async"
                                 src="{{ $member->getFirstMediaUrl('main', 'webp') }}"
                                 alt=" {{$member->name}}"/>
                        </div>
                    </div>

                    <div class="{{$classPrefix}}__card-name">
                        {{$member->name}}
                    </div>
                    <div class="{{$classPrefix}}__card-role">
                        {{$member->position}}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
