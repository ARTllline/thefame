@php($classPrefix ='modal')
@php($dataPrefix ='data-modal')


<div {{$dataPrefix}} class="{{$classPrefix}}">
    <form class="{{$classPrefix}}__form">
        <div class="{{$classPrefix}}__container">
            <div class="{{$classPrefix}}__container-close"></div>

            <h3 class="{{$classPrefix}}__container-title">Запись онлайн</h3>

            <div class="{{$classPrefix}}__container-input">
                <input placeholder="Твое имя" name="name" type="text">
                <span class="{{$classPrefix}}__container-input-err-message">Поле не может быть пустым</span>
            </div>

            <div class="{{$classPrefix}}__container-input {{$classPrefix}}__container-input--phone">
                <input placeholder="Твой номер телефона" name="phone" class="tel-input" type="tel">
                <span class="{{$classPrefix}}__container-input-err-message">Неправильный номер телефона</span>
            </div>

            <button class="button button-clip {{$classPrefix}}__container-button">
				<span class="clip">
					<span>Заказать сейчас</span>
					<span>Заказать сейчас</span>
				</span>
            </button>


            <p class="{{$classPrefix}}__container-subtitle">
                Или позвони нам:
                <a href="tel:+380739119111" class="link">+38 073 911 9111</a>
            </p>
        </div>
    </form>
</div>
