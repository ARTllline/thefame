@php
    $classPrefix ='services';
    $dataPrefix ='data-services';
@endphp

<div data-region="{{$currentRegion}}" {{$dataPrefix}} class="{{$classPrefix}}">
    <h2 class="{{$classPrefix}}__title">
        {{__('static.services')}}
    </h2>

    @foreach($categories as $category)
        <div {{$dataPrefix}}-category class="{{$classPrefix}}__category">
            <div
                {{$dataPrefix}}-category-title
                class="{{ $classPrefix }}__category-title"
                aria-expanded="false"
                aria-controls="list-{{ $category->id }}">
                {{ $category->title }}
                <span class="{{ $classPrefix }}__chevron"></span>
            </div>

            <div
                id="list-{{ $category->id }}"
                {{$dataPrefix}}-list
                class="{{ $classPrefix }}__list"
                role="region"
                aria-hidden="true">
                @foreach($category->services as $service)
                    <div class="{{$classPrefix}}__card">
                        <a href="/services/{{$service->id}}" class="{{$classPrefix}}__card-fade">
                            <div class="{{$classPrefix}}__card-img">
                                <svg class="{{$classPrefix}}__card-moving-svg" viewBox="0 0 249 315" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M113.725 0.0576457C155.841 1.85016 179.188 51.3647 204.077 89.9486C227.04 125.548 257.806 163.848 246.633 206.101C235.819 247 189.999 252.949 156.08 271.462C122.19 289.959 89.304 327.417 54.631 310.893C19.1847 294.001 13.0187 242.483 5.51397 199.706C-1.62244 159.029 -4.69707 117.208 14.4524 81.8779C36.9922 40.292 70.7221 -1.77262 113.725 0.0576457Z"
                                          fill="#f4e4e8"></path>
                                </svg>
                                <div class="{{$classPrefix}}__card-clip-path">
                                    <img fetchpriority="high" decoding="async"
                                         src="{{ $service->getFirstMediaUrl('main', 'webp') ?: asset('img/default.webp') }}"
                                         alt="{{ $service->title }}"/>
                                </div>
                            </div>
                            <div class="{{$classPrefix}}__card-name">
                                {{$service->title}}
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

    @endforeach
</div>



