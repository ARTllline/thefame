import {initDeviceSlider} from "../swiper/swiper";
import GLightbox from 'glightbox';
const classPrefix = 'devices'
const dataPrefix = 'data-devices'

const $container = document.querySelector(`[${dataPrefix}]`)

if ($container) {
    devices();
}

export function devices() {

    const $cards = $container.querySelectorAll(`[${dataPrefix}-card]`)

    init();

    const lightbox = GLightbox({
        selector: '.glightbox',
        openEffect: 'fade',
        closeEffect: 'fade'
    });

    function init(){

        $cards.forEach($card =>{
            initCard($card)
        })


    }

    function initCard($card){
        const cardIndex = $card.dataset.devicesCardIndex
        console.log('cardIndex', cardIndex)
        const $sliderImage = $card.querySelector(`[${dataPrefix}-image]`)
        const $sliderPrev = $card.querySelector(`[${dataPrefix}-slider]`)
        const sliderImageClass = `${classPrefix}__swiper-image-${cardIndex}`
        const sliderPrevClass = `${classPrefix}__swiper-${cardIndex}`

        initDeviceSlider(sliderImageClass, sliderPrevClass)
    }

}
