import {initBannerSlider} from "../swiper/swiper";

const classPrefix = 'header'
const dataPrefix = 'data-header'
const $container = document.querySelector(`[${dataPrefix}]`)

if ($container) {
    header()
}
export function header() {

    let lastScrollTop = window.pageYOffset || document.documentElement.scrollTop;
    const threshold = $container.offsetHeight;

    const $mobileMenuOpen = $container.querySelector(`[${dataPrefix}-menu-open]`)

    init()
    function init(){
        window.addEventListener('scroll', handleHeader);


        $mobileMenuOpen.addEventListener('click', handleMenuOpen)
    }

    function handleMenuOpen(){
        if ($container.classList.contains(`${classPrefix}--open`)){
            $container.classList.remove(`${classPrefix}--open`)
            document.documentElement.classList.remove('no-scroll');
        }
        else {
            $container.classList.add(`${classPrefix}--open`)
            document.documentElement.classList.add('no-scroll');
        }
    }

    function handleHeader(){
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        // Логика показа/скрытия в зависимости от направления скролла
        if (scrollTop > threshold && scrollTop > lastScrollTop) {
            $container.classList.add(`${classPrefix}--hidden`);
        } else if (scrollTop < lastScrollTop) {
            $container.classList.remove(`${classPrefix}--hidden`);
        }

        // Если мы не на самом верху, добавляем белый фон, иначе прозрачный
        if (scrollTop > 0) {
            $container.classList.add(`${classPrefix}--scrolled`);
        } else {
            $container.classList.remove(`${classPrefix}--scrolled`);
        }

        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    }






}
