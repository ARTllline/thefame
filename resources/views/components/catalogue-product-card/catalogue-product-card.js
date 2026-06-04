import {initProductSwiper} from "../swiper/swiper";
import GLightbox from 'glightbox';

const classPrefix = 'catalogue-product-card';
const dataPrefix = 'data-catalogue-product-card';

const $container = document.querySelector(`[${dataPrefix}]`);

if ($container) {
    catalogueProductCard($container);
}

function catalogueProductCard(container) {
    const descriptionText = container.querySelector(`[${dataPrefix}-description-text]`);
    const toggleButton = container.querySelector(`[${dataPrefix}-description-wrap]`);
    const $addToCartButton = container.querySelector(`[${dataPrefix}-add-to-cart]`);
    const $buyNowButton = container.querySelector(`[${dataPrefix}-buy-now]`);

    const $detailsHeader = container.querySelector(`[${dataPrefix}-main-details-header]`);
    const $detailsBody = container.querySelector(`[${dataPrefix}-main-details-body]`);

    const $productCount = container.querySelector(`[${dataPrefix}-count]`);
    const $productCountMinus = container.querySelector(`[${dataPrefix}-count-minus]`);
    const $productCountPlus = container.querySelector(`[${dataPrefix}-count-plus]`);

    const imgClass = `${classPrefix}__swiper-image`;
    const prevClass = `${classPrefix}__swiper-prev`;

    const productId = container.dataset.productId;

    GLightbox({
        selector: '.glightbox',
        openEffect: 'fade',
        closeEffect: 'fade'
    });

    let productCount = 1;

    init();

    function init() {
        handleDescriptionWrap();
        initProductSlider();
        handleDetails();
        handleProductCount();
        $addToCartButton.addEventListener('click', () => {
            window.CartWidget.addAndOpen({product_id: productId, quantity: productCount});
            //window.CartWidget.open();
        });
        $buyNowButton.addEventListener('click', () => {
            window.CartWidget.addAndCheckout({product_id: productId, quantity: productCount});
            //window.CartWidget.open();
        });
    }

    function handleProductCount() {
        $productCountMinus.addEventListener('click', () => {
            if (productCount > 1) {
                productCount--;
                $productCount.innerText = productCount;
            }
        });
        $productCountPlus.addEventListener('click', () => {
            productCount++;
            $productCount.innerText = productCount;
        });
    }

    function handleDetails() {
        if ($detailsHeader && $detailsBody) {
            $detailsHeader.addEventListener('click', () => {
                $detailsBody.classList.toggle('is-open');
            });
        }
    }

    function handleDescriptionWrap() {
        if (descriptionText && toggleButton) {
            const lineHeight = parseFloat(getComputedStyle(descriptionText).lineHeight);
            const collapsedLines = 4;
            const collapsedHeight = lineHeight * collapsedLines;
            const fullHeight = descriptionText.scrollHeight;

            descriptionText.style.maxHeight = `${collapsedHeight}px`;
            descriptionText.style.overflow = 'hidden';
            descriptionText.style.transition = 'max-height 0.5s ease';

            let isExpanded = false;
            toggleButton.addEventListener('click', () => {
                isExpanded = !isExpanded;
                if (isExpanded) {
                    descriptionText.style.maxHeight = `${fullHeight}px`;
                    toggleButton.textContent = 'Сховати';
                } else {
                    descriptionText.style.maxHeight = `${collapsedHeight}px`;
                    toggleButton.textContent = 'Читати далі...';
                }
            });
        }
    }

    function initProductSlider() {
        initProductSwiper(imgClass, prevClass);
    }
}
