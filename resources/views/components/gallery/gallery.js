import { initGallerySlider } from "../swiper/swiper";
import GLightbox from "glightbox";

const classPrefix = 'gallery';
const dataPrefix = 'data-gallery';
const $container = document.querySelector(`[${dataPrefix}]`);

// Защита: не вешаем capture-обработчик больше одного раза
const CAPTURE_FLAG = '__glightbox_gallery_capture_attached';

if ($container) {
    gallery();
}

export function gallery() {
    let lightbox = null;

    // Инициализация слайдера. Если initGallerySlider возвращает swiper, используем событие init,
    // иначе делаем fallback — инициализируем lightbox через небольшой таймаут.
    const swiperOrNothing = init();

    // Установка обработчика клика в режиме capture (вешаем один раз глобально)
    attachCaptureClickHandler();

    // ---- helpers ----
    function init() {
        const swiperClass = `${classPrefix}__swiper`;
        try {
            const maybeSwiper = initGallerySlider(swiperClass);

            // Если вернулся экземпляр swiper — подписываемся на событие init
            if (maybeSwiper && typeof maybeSwiper.on === 'function') {
                // Если swiper уже инициализирован — сразу инициализируем lightbox
                if (maybeSwiper.initialized) {
                    setupLightbox();
                } else {
                    maybeSwiper.on('init', () => {
                        setupLightbox();
                    });
                    // Некоторые обёртки возвращают swiper, но не вызывают init автоматически,
                    // поэтому важно попытаться вызвать init если это требуется.
                    if (typeof maybeSwiper.init === 'function' && !maybeSwiper.initialized) {
                        try { maybeSwiper.init(); } catch (err) { /* ignore */ }
                    }
                }
                return maybeSwiper;
            } else {
                // fallback: если swiper не возвращён — инициализируем lightbox через setTimeout
                setTimeout(setupLightbox, 50);
                return null;
            }
        } catch (err) {
            // на случай ошибок — всё равно пробуем создать lightbox
            setTimeout(setupLightbox, 50);
            return null;
        }
    }

    function setupLightbox() {
        // Если lightbox уже инициализирован — не инициализируем снова
        if (lightbox) return;

        lightbox = GLightbox({
            selector: '.glightbox',
            openEffect: 'fade',
            closeEffect: 'fade'
        });
    }

    function attachCaptureClickHandler() {
        if (document[CAPTURE_FLAG]) return;
        document[CAPTURE_FLAG] = true;

        document.addEventListener('click', (e) => {
            const a = e.target.closest('.glightbox');
            if (!a) return;

            // Разрешаем специально запрошенное открытие в новой вкладке/окне:
            // Ctrl/Cmd + click или средняя кнопка
            if (e.ctrlKey || e.metaKey || e.button === 1) return;

            // Блокируем переход по href и другие обработчики
            e.preventDefault();
            e.stopImmediatePropagation();

            // Если lightbox ещё не инициализирован, попробуем инициализировать прямо сейчас
            if (!lightbox) {
                setupLightbox();
            }

            // Собираем элементы той же галереи (поддержка data-gallery)
            const gallery = a.getAttribute('data-gallery') || '';
            const selector = gallery
                ? `.glightbox[data-gallery="${gallery}"]`
                : '.glightbox';
            const group = Array.from(document.querySelectorAll(selector));
            const index = group.indexOf(a);

            // Открываем в нужном индексе
            if (lightbox && typeof lightbox.openAt === 'function') {
                lightbox.openAt(index >= 0 ? index : 0);
            } else if (lightbox && typeof lightbox.open === 'function') {
                lightbox.open();
            } else {
                // если GLightbox по какой-то причине не доступен — сделаем fallback: открыть href в этом окне
                const href = a.getAttribute('href');
                if (href) window.location.href = href;
            }
        }, true); // capture = true
    }
}
