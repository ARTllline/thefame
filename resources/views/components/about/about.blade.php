@php($classPrefix ='about')
@php($dataPrefix ='data-about')


<div {{$dataPrefix}} class="{{$classPrefix}}">

    <h2 class="{{$classPrefix}}__title">
        Бьюти-клиника <br>
        The Fame
    </h2>
    <div class="{{$classPrefix}}__description">
        <p class="{{$classPrefix}}__description-text">
            The Fame – это когда вам делают не просто стрижку, а выстраивают целостный образ, основанный на детальной
            консультации, который раскрывает вас и заставляет чувствовать себя превосходно. В котором вы будете
            выглядеть максимально ярко и уверенно в себе.
        </p>
        <p class="{{$classPrefix}}__description-accent">
            ЭТО НЕ ПРОСТО САЛОН КРАСОТЫ, ЭТО ОБЩЕСТВО КРАСИВЫХ И УВЕРЕННЫХ В СЕБЕ ЛЮДЕЙ.
        </p>
    </div>
    <div class="{{$classPrefix}}__image">
        <img src="{{ asset('img/xabout-img-1.jpg.webp.pagespeed.ic.VEqjki6pUh.webp')}}" alt="about us">
        <div class="{{$classPrefix}}__image-shape">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="ezo87kswz9yn1"
                 viewBox="0 0 758 803" shape-rendering="geometricPrecision" text-rendering="geometricPrecision">
                <path id="ezo87kswz9yn2"
                      d="M 457.523 76.0347 C 363.095 40.2644 341.6402011839996 101.761723718 265.12620118399997 167.70272371800002 C 195.425201184 227.77172371799995 116.475678676 228.10958526800002 93.121768114 317.090140902 C 59.95821292 399.272196624 58.36341745399999 525.333469454 130.660473 590.472525 C 202.36047299999993 654.6815250000001 321.082498 755.331346072 415.733498 737.885346072 C 512.238498 720.096346072 597.7231969999999 723.86925 629.471197 630.97425 C 657.7801969999999 548.1432500000001 681.662715912 430.002806922 649.0527159119999 348.783806922 C 612.9997159119999 258.989806922 547.982 110.301 457.523 76.0347 Z"
                      clip-rule="evenodd" fill-rule="evenodd" stroke="none" stroke-width="1"></path>
            </svg>
        </div>
    </div>
</div>
