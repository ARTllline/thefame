@php
    use Illuminate\Support\Facades\Storage;
    $classPrefix ='contact';
    $dataPrefix ='data-contact';
  $links = \App\Models\SocialLink::where(function ($query) {
                $query->whereHas('region', function ($query)  {
                    $query->where('code', 'ua');
                })->orWhereDoesntHave('region');
            })->get();
   $callUs = \App\Models\CallUs::first();
@endphp

<div {{$dataPrefix}} class="{{$classPrefix}}">
    <h1 class="{{$classPrefix}}__title">
        <span class="{{$classPrefix}}__title-row {{$classPrefix}}__title-left"> {{__('static.call_1')}}</span>
        <span class="{{$classPrefix}}__title-row {{$classPrefix}}__title-right"> {{__('static.call_2')}}</span>
    </h1>
    <div class="{{$classPrefix}}__container">
        <div class="{{$classPrefix}}__container-top">
            <div class="{{$classPrefix}}__container-phone">
                <a class="link link--hover " href="tel:{{$callUs->phone_ua}}">
                    {{$callUs->phone_ua}}
                </a>
            </div>
            <div class="{{$classPrefix}}__container-mail">
                <a class="link link--anim" href="#">
                    {{$callUs->email_ua}}
                </a>
            </div>
        </div>
        <div class="{{ $classPrefix }}__container-bot">
            @foreach($links as $link)
                @php
                    $parts = explode(' ', $link->icon);
$style = $parts[0] ?? 'default';
$icon  = $parts[1] ?? null;
           $svg = Storage::disk('nova-icon-field')
                          ->get("{$style}/{$icon}.svg");
                @endphp

                <a class="link link--anim {{ $classPrefix }}__container-social"
                   href="{{ $link->url }}"
                   rel="nofollow noindex"
                   target="_blank">
                    {{$link->platform}}
                    {!! $svg !!}
                </a>
            @endforeach
        </div>
    </div>

</div>
