@extends('templates.main')

@section('meta_title')
    The Fame
@endsection

@section('meta_description')
    The Fame — клініка сучасної естетики. Ми поєднуємо медичний підхід із турботою про комфорт та естетику.
@endsection

@section('content')
    @include('components.main-banner.main-banner')

    @include('components.special-offer.special-offer', ['specialOffers' => $specialOffers])
    @include('components.main-about.main-about', ['about'=>$about])
{{--    @include('components.certificates.certificates')--}}
{{--    @include('components.review.review')--}}

    @include('components.call-us.call-us')



@endsection
