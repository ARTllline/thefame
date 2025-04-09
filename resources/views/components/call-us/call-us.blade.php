@php($classPrefix ='call-us')
@php($dataPrefix ='data-call-us')


<div {{$dataPrefix}} class="{{$classPrefix}}">
    <div class="{{$classPrefix}}__container">
        <h2 class="{{$classPrefix}}__container-title">
            {{__('static.call_us')}}
        </h2>
        <div data-modal-open class="button button-clip {{$classPrefix}}__container-button">
            	<span class="clip">
					<span>{{__('static.sign_up')}}</span>
					<span>{{__('static.sign_up')}}</span>
				</span>
        </div>
        <div class="{{$classPrefix}}__container-phone">
            +38 073 911 9111
        </div>
        <div class="{{$classPrefix}}__container-list">
            <a href="#" class="{{$classPrefix}}__container-list-item">
                viber
            </a>
            <div class="{{$classPrefix}}__container-list-dot">

            </div>
            <a href="#" class="{{$classPrefix}}__container-list-item">
                telegram
            </a>
            <div class="{{$classPrefix}}__container-list-dot">

            </div>
            <a href="#" class="{{$classPrefix}}__container-list-item">
                whatsapp
            </a>
        </div>
    </div>
    <div class="{{$classPrefix}}__moving-shape">

    </div>
</div>
