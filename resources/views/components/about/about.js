import GLightbox from "glightbox";
import { initAboutSlider } from "../swiper/swiper";

const classPrefix = 'about';
const dataPrefix = 'data-about';
const $container = document.querySelector(`[${dataPrefix}]`);
if ($container) about();

export function about() {
    init();

    // Инициализируем lightbox (после init, но не обязательно после swiper.init — ниже есть вариант)
    const lightbox = GLightbox({
        selector: '.glightbox',
        openEffect: 'fade',
        closeEffect: 'fade'
    });

    // Перехват клика на этапе capture — это ранний этап, до обычных bubble-обработчиков.
    // Останавливаем дальнейшую обработку (чтобы убрать переход по href и избежать дублирования)
    document.addEventListener('click', (e) => {
        const a = e.target.closest('.glightbox');
        if (!a) return;

        // Разрешаем Ctrl/Cmd + клик и среднюю кнопку — если пользователь сознательно хочет открыть в новой вкладке
        if (e.ctrlKey || e.metaKey || e.button === 1) return;

        // Предотвращаем переход по ссылке и останавливаем другие обработчики (включая возможный обработчик glightbox)
        e.preventDefault();
        e.stopImmediatePropagation();

        // Собираем все ссылки в той же галерее и вычисляем индекс нажатого элемента
        const gallery = a.getAttribute('data-gallery') || '';
        const selector = gallery
            ? `.glightbox[data-gallery="${gallery}"]`
            : '.glightbox';
        const group = Array.from(document.querySelectorAll(selector));
        const index = group.indexOf(a);

        // Открываем lightbox на нужном индексе (openAt поддерживается в GLightbox)
        if (typeof lightbox.openAt === 'function') {
            lightbox.openAt(index >= 0 ? index : 0);
        } else if (typeof lightbox.open === 'function') {
            // fallback: open() без индекса (или можно реализовать подбор через sources)
            lightbox.open();
        }
    }, true); // <- capture = true

    function init(){
        const sliderImageClass = `${classPrefix}__swiper-image`;
        // Желательно, чтобы initAboutSlider возвращал экземпляр swiper,
        // тогда можно инициализировать lightbox внутри swiper.on('init', ...)
        initAboutSlider(sliderImageClass);
    }
}
