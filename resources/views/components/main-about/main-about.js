import {initAboutSlider} from "../swiper/swiper";
import GLightbox from "glightbox";

const classPrefix = 'main-about'
const dataPrefix = 'data-main-about'
const $container = document.querySelector(`[${dataPrefix}]`)

if ($container) {
    mainAbout()
}
export function mainAbout() {


    const $imageSelector = $container.querySelector(`[${dataPrefix}-image]`)

    init();

    const lightbox = GLightbox({
        selector: '.glightbox',
        openEffect: 'fade',
        closeEffect: 'fade'
    });

    function init(){
        const sliderImageClass = `${classPrefix}__swiper-image`
        initAboutSlider(sliderImageClass)
    }



}
