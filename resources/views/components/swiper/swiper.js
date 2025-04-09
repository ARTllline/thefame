import Swiper from 'swiper/bundle';

// export function initOfferSlider(swiperClass){
//     console.log('initOfferSlider swiperINIT')
//     let swiperContacts = new Swiper("." + swiperClass, {
//         spaceBetween: 30,
//         slidesPerView: '3',
//     });
// }

export function initOfferSlider(swiperClass) {
    console.log('initOfferSlider swiperINIT');
    const swiper = new Swiper("." + swiperClass, {
        slidesPerView: 1,
        spaceBetween: 15,
        watchSlidesProgress: true,
        freeMode: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,

        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        on: {
            progress: function () {
                this.slides.forEach(slide => {
                    // Если слайд полностью виден, оставляем opacity 1,
                    // иначе - задаём затемнение (например, 0.5)
                    if (slide.classList.contains('swiper-slide-visible')) {
                        slide.style.opacity = '1';
                    } else {
                        slide.style.opacity = '0.5';
                    }
                });
            },
            setTransition: function (duration) {
                this.slides.forEach(slide => {
                    slide.style.transitionDuration = duration + 'ms';
                });
            }
        },
        breakpoints: {
            // Если ширина экрана меньше 768px
            768: {
                spaceBetween: 60,
                slidesPerView: 3,
            }
        }
    });
}
export function initReviewSlider(swiperClass) {
    console.log('initOfferSlider swiperINIT');
    const swiper = new Swiper("." + swiperClass, {
        spaceBetween: 20,
        slidesPerView: 1.05,
        watchSlidesProgress: true,
        freeMode: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,

        },
        breakpoints: {
            // Если ширина экрана меньше 768px
            768: {
                spaceBetween: 60,
                slidesPerView: 1,
            }
        },
        on: {
            progress: function () {
                this.slides.forEach(slide => {
                    // Если слайд полностью виден, оставляем opacity 1,
                    // иначе - задаём затемнение (например, 0.5)
                    if (slide.classList.contains('swiper-slide-visible')) {
                        slide.style.opacity = '1';
                    } else {
                        slide.style.opacity = '0.5';
                    }
                });
            },
            setTransition: function (duration) {
                this.slides.forEach(slide => {
                    slide.style.transitionDuration = duration + 'ms';
                });
            }
        }
    });
}
export function initCertSlider(swiperClass) {
    console.log('initOfferSlider swiperINIT');
    const swiper = new Swiper("." + swiperClass, {
        spaceBetween: 15,
        slidesPerView: 1.05,
        watchSlidesProgress: true,
        freeMode: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,

        },
        breakpoints: {
            // Если ширина экрана меньше 768px
            768: {
                spaceBetween: 60,
                slidesPerView: 3,
            }
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        on: {
            progress: function () {
                this.slides.forEach(slide => {
                    // Если слайд полностью виден, оставляем opacity 1,
                    // иначе - задаём затемнение (например, 0.5)
                    if (slide.classList.contains('swiper-slide-visible')) {
                        slide.style.opacity = '1';
                    } else {
                        slide.style.opacity = '0.5';
                    }
                });
            },
            setTransition: function (duration) {
                this.slides.forEach(slide => {
                    slide.style.transitionDuration = duration + 'ms';
                });
            }
        }
    });
}

export function initBannerSlider(swiperClass){
    console.log('initBannerSliderINIT')

    console.log(swiperClass)

    let swiperBanner = new Swiper("." + swiperClass, {
        //direction: "vertical",
        effect: "creative",
        direction: "vertical",
        slidesPerView: 1,
        centeredSlides: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: true,
        },
        loop: true,
        creativeEffect: {
            prev: {
                shadow: true,
                translate: [0, -400, 0],
            },
            next: {
                translate: [0, "100%" , 0],
            },
        },
    });
}


