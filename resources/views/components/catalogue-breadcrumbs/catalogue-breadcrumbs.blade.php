@php
    $classPrefix = 'catalogue-breadcrumbs';
    $dataPrefix = 'data-catalogue-breadcrumbs';



@endphp

<section {{$dataPrefix}} class="{{$classPrefix}}">
    <div class="{{$classPrefix}}__header">
        <img src="{{ asset('img/Treatments_Blog.webp') }}" alt="banner" class="{{$classPrefix}}__header-banner">

        <div class="{{$classPrefix}}__breadcrumbs">
            @foreach($catalogueData['breadcrumbs'] as $breadcrumb)
                <a href="{{$breadcrumb['url']}}" class="{{$classPrefix}}__breadcrumbs-item">
                    {{$breadcrumb['title']}}
                </a>
                @if(!$loop->last)
                    <div class="{{$classPrefix}}__breadcrumbs-dot"></div>
                @endif
            @endforeach
        </div>

        <h1 class="{{$classPrefix}}__title">
            {{$catalogueData['pageTitle'] }}
        </h1>
        <div class="{{$classPrefix}}__subtitle">
            {{$catalogueData['pageSubtitle'] }}
        </div>
    </div>
</section>





