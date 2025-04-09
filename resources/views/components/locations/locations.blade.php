@php($classPrefix ='locations')
@php($dataPrefix ='data-locations')


<div {{$dataPrefix}} class="{{$classPrefix}}">
    <h4 class="{{$classPrefix}}__title">
        {{__('static.locations')}}
    </h4>

    <div class="{{$classPrefix}}__list">
        @for ($i = 0; $i < 4; $i++)
            <div class="{{$classPrefix}}__list-item">
                <div class="{{$classPrefix}}__list-item-num">
                    0{{$i + 1}}
                </div>
                <div class="{{$classPrefix}}__list-item-content">
                    <div class="{{$classPrefix}}__list-item-content-street">
                        Киев, пр-т Героев Сталинграда, 2ГК2
                    </div>
                    <div class="{{$classPrefix}}__list-item-content-district">
                        Оболонский район
                    </div>
                    <div class="{{$classPrefix}}__list-item-content-phone">
                        <a class="link link--anim"  href="#">+38 073 911 9111</a>
                    </div>
                    <div class="{{$classPrefix}}__list-item-content-mail">
                        <a class="link link--anim" href="#">stalingrada@thefame.ua</a>
                    </div>
                </div>

                <div class="{{$classPrefix}}__list-item-map">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1269.1367511801755!2d30.52504979262804!3d50.49186726842287!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40d4d1fcf06e7c61%3A0xe9249814e15601cb!2zItCQ0KDQntCc0JDQoiIg0JrQsmnRgtC4!5e0!3m2!1suk!2sua!4v1598093890905!5m2!1suk!2sua"
                        height="450" style="border:0;" allowfullscreen="" aria-hidden="false"
                        tabindex="0"></iframe>
                </div>
            </div>
        @endfor
    </div>

</div>
