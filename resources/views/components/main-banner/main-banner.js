import {initBannerSlider} from "../swiper/swiper";

const classPrefix = 'main-banner'
const dataPrefix = 'data-main-banner'
const $container = document.querySelector(`[${dataPrefix}]`)

if ($container) {
    mainBanner()
}
export function mainBanner() {
    const $sliderItems = document.querySelectorAll(`.${classPrefix}__background-slider-item`);
    let currentIndex = 0;
    const switchDelay = 10000; // Задержка между переключениями, например, 8 секунд

    function switchBanner() {
        // Рассчитываем индекс следующей картинки за циклом
        const nextIndex = (currentIndex + 1) % $sliderItems.length;
        const nextImgEl = $sliderItems[nextIndex].querySelector(`.${classPrefix}__background-slider-item-img`);

        // Функция обновления баннера
        function updateBanner() {
            // Убираем активный класс у текущего элемента
            $sliderItems[currentIndex].classList.remove(`${classPrefix}__background-slider-item--active`);
            // Добавляем активный класс следующему элементу (запускаются анимации, прописанные в CSS)
            $sliderItems[nextIndex].classList.add(`${classPrefix}__background-slider-item--active`);
            // Обновляем текущий индекс
            currentIndex = nextIndex;
            // Запускаем следующий цикл через заданную задержку
            setTimeout(switchBanner, switchDelay);
        }

        // Если следующая картинка уже загружена – сразу переключаем
        if (nextImgEl.complete) {
            updateBanner();
        } else {
            // Если ещё не загружена – назначаем обработчик, который переключит после загрузки
            nextImgEl.onload = updateBanner;
            // При желании можно добавить обработчик onerror, чтобы избежать «зависания»
            nextImgEl.onerror = function() {
                console.error('Ошибка загрузки картинки:', nextImgEl.src);
                // В случае ошибки можно всё равно переключить баннер или попробовать повторно загрузить
                updateBanner();
            }
        }
    }

    // Запускаем первый вызов через заданную задержку
    setTimeout(switchBanner, switchDelay);
}
