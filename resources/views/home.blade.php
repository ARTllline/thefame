@extends('templates.main')

@section('meta_title')
    Главная
@endsection

@section('meta_description')
@endsection

@section('content')
    @include('components.main-banner.main-banner')

    @include('components.special-offer.special-offer', ['specialOffers' => $specialOffers])
    @include('components.main-about.main-about')
{{--    @include('components.certificates.certificates')--}}
{{--    @include('components.review.review')--}}

    @include('components.call-us.call-us')



@endsection
