import {initGoogleReviewSlider, initOfferSlider} from "../swiper/swiper";
const classPrefix = 'promo-review'
const dataPrefix = 'data-promo-review'

const $container = document.querySelector(`[${dataPrefix}]`)

if ($container) {
    promoReview()
}
export function promoReview() {
    init();

    function init(){

        initGoogleReviewSlider(`${classPrefix}__swiper`);
    }

}
