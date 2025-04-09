@extends('templates.main')

@section('meta_title')
   Главная
@endsection

@section('meta_description')
@endsection

@section('content')

    @include('components.services.services', ['services' => $services])
  @include('components.call-us.call-us')

@endsection
