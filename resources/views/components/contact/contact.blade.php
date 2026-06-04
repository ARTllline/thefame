@php
    use Illuminate\Support\Facades\Storage;
    $classPrefix ='contact';
    $dataPrefix ='data-contact';
  $links = \App\Models\SocialLink::where(function ($query) use ($currentRegion) {
                $query->whereHas('region', function ($query) use ($currentRegion) {
                    $query->where('code', $currentRegion);
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
                <a class="link link--anim" href="#">
                    @if($currentRegion == 'dubai')
                        {{$callUs->phone_dubai}}
                    @else
                        {{$callUs->phone_ua}}
                    @endif
                </a>
            </div>
            <div class="{{$classPrefix}}__container-mail">
                <a class="link link--anim" href="#">
                    @if($currentRegion == 'dubai')
                        {{$callUs->email_dubai}}
                    @else
                        {{$callUs->email_ua}}
                    @endif
                </a>
            </div>
        </div>
        <div class="{{ $classPrefix }}__container-bot">
            @foreach($links as $link)
                @php
                    $parts = explode(' ', $link->icon);
$style = $parts[0] ?? 'default'; // или null
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
