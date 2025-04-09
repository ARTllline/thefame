@php($classPrefix = 'region-selector')
@php($dataPrefix = 'data-region-selector')

<div {{$dataPrefix}} class="{{$classPrefix}}">
    <div class="{{$classPrefix}}__content">
        <!-- Заголовок модального окна -->
        <h2 class="{{$classPrefix}}__title">Выберите регион</h2>
        <div class="{{$classPrefix}}__flags">
            <div class="{{$classPrefix}}__flag" data-region="ua">
                <img src="/img/ua-flag.png" alt="Украина">
            </div>
            <div class="{{$classPrefix}}__flag" data-region="dubai">
                <img src="/img/dubai-flag.png" alt="Дубай">
            </div>
        </div>
    </div>
    <!-- Скрытая форма для отправки выбранного региона -->
    <form action="{{ route('region.set') }}" method="POST" id="regionSelectorForm" style="display: none;">
        @csrf
        <input type="hidden" name="redirect_to" value="{{ url()->current() }}">
        <input type="hidden" name="region" id="regionInput">
    </form>
</div>
