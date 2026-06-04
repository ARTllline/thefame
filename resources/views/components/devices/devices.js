import { initDeviceSlider } from "../swiper/swiper";
import GLightbox from 'glightbox';

const classPrefix = 'devices';
const dataPrefix  = 'data-devices';

const $container = document.querySelector(`[${dataPrefix}]`);
if ($container) {
    devices();
}

export function devices() {
    // Инициализируем lightbox один раз
    GLightbox({
        selector: '.glightbox',
        openEffect: 'fade',
        closeEffect: 'fade'
    });

    // Берём все карточки и инициализируем каждую
    const $cards = $container.querySelectorAll(`[${dataPrefix}-card]`);
    $cards.forEach(initCard);

    function initCard($card) {
        // === Слайдер ===
        const index     = $card.dataset.devicesCardIndex;
        const imgClass  = `${classPrefix}__swiper-image-${index}`;
        const prevClass = `${classPrefix}__swiper-${index}`;
        initDeviceSlider(imgClass, prevClass);

        // === Read more / Read less ===
        const $text    = $card.querySelector(`.${classPrefix}__card-content-text`);
        const $btnMore = $card.querySelector(`[${dataPrefix}-read-more]`);
        const $btnLess = $card.querySelector(`[${dataPrefix}-read-less]`);
        if (!$text || !$btnMore || !$btnLess) return;

        // считаем изначальный max-height из CSS
        const initialMax = parseFloat(getComputedStyle($text).maxHeight);

        // Если текст помещается — прячем «читать больше» и выходим
        if ($text.scrollHeight <= initialMax) {
            $btnMore.style.display = 'none';
            return;
        }
        // Иначе сразу прячем «меньше»
        $btnLess.style.display = 'none';

        // Плавный переход (не забудьте в CSS добавить transition для max-height)
        $text.style.transition = 'max-height 0.4s ease';

        $btnMore.addEventListener('click', () => {
            $text.style.maxHeight = $text.scrollHeight + 'px';
            $btnMore.style.display = 'none';
            $btnLess.style.display = 'flex';
        });

        $btnLess.addEventListener('click', () => {
            $text.style.maxHeight = initialMax + 'px';
            $btnMore.style.display = 'flex';
            $btnLess.style.display = 'none';
        });
    }
}
