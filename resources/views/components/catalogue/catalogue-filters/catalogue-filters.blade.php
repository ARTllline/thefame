@php
    $classPrefix = 'catalogue-filters';
    $dataPrefix = 'data-catalogue-filters';
@endphp

<section {{$dataPrefix}} class="{{$classPrefix}}">
    @foreach($filtersData as $filterData)
        @include('components.filter.filter', ['filterData' => $filterData] )
    @endforeach
</section>





