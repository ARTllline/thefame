@php($classPrefix ='contact')
@php($dataPrefix ='data-contact')

<div {{$dataPrefix}} class="{{$classPrefix}}">
    <h1 class="{{$classPrefix}}__title">
        <span class="{{$classPrefix}}__title-row {{$classPrefix}}__title-left"> {{__('static.call_1')}}</span>
        <span class="{{$classPrefix}}__title-row {{$classPrefix}}__title-right"> {{__('static.call_2')}}</span>
    </h1>
    <div class="{{$classPrefix}}__container">
        <div class="{{$classPrefix}}__container-top">
            <div class="{{$classPrefix}}__container-phone">
                <a class="link link--anim"  href="#">+38 073 911 9111</a>
            </div>
            <div class="{{$classPrefix}}__container-mail">
                <a class="link link--anim" href="#">stalingrada@thefame.ua</a>
            </div>
        </div>
        <div class="{{$classPrefix}}__container-bot">
            <a class="link link--anim {{$classPrefix}}__container-social" href="https://t.me/kulbachny" rel="nofollow, noindex" target="_blank">
                Telegram</a>
            <a class="link link--anim {{$classPrefix}}__container-social" href="https://www.instagram.com/" rel="nofollow, noindex" target="_blank">
                Instagram</a>
            <a class="link link--anim {{$classPrefix}}__container-social" href="https://www.facebook.com/" rel="nofollow, noindex" target="_blank">
                Facebook</a>
            <a class="link link--anim {{$classPrefix}}__container-social" href="https://www.whatsapp.com/" rel="nofollow, noindex" target="_blank">
                WhatsApp</a>
            <a class="link link--anim {{$classPrefix}}__container-social" href="https://www.viber.com/" rel="nofollow, noindex" target="_blank">
                Viber</a>
        </div>
    </div>

</div>
