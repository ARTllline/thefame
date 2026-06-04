const classPrefix = 'catalogue-card-template'
const dataPrefix = 'data-catalogue-card-template'

export function catalogueCardTemplate($container, productData) {
    const $template = document.querySelector(`[${dataPrefix}-template]`)

    init();

    function init() {
        render()
    }

    function render() {
        const $clone = $template.content.cloneNode(true)
        const $card = $clone.querySelector(`[${dataPrefix}]`)
        const $title = $clone.querySelector(`[${dataPrefix}-title]`)
        const $subtitle = $clone.querySelector(`[${dataPrefix}-subtitle]`)
        const $imageMain = $clone.querySelector(`[${dataPrefix}-image-main]`)
        const $imageCover = $clone.querySelector(`[${dataPrefix}-image-cover]`)

        const $price = $clone.querySelector(`[${dataPrefix}-price]`)
        const $priceUa = $clone.querySelector(`[${dataPrefix}-price-ua]`)
        const $priceEu = $clone.querySelector(`[${dataPrefix}-price-eu]`)

        const $links = $clone.querySelectorAll(`[${dataPrefix}-link]`)


        $links.forEach((link) => {
            link.setAttribute('href', window.location.origin + '/product/' + productData.slug)
        })

        if (productData.images.length > 0) {
            $imageMain.src = productData.images[0].url
            if (productData.images.length > 1) {
                $imageCover.src = productData.images[1].url
            }
        }

        if (productData.position) {
            $card.classList.add(`${classPrefix}--${productData.position}`)
        }
        $title.textContent = productData.name


        if (!productData.price_ua) {
            $priceUa.style.display = 'none'
        }
        if (!productData.price_eu) {
            $priceEu.style.display = 'none'
        }
        $priceUa.textContent = Intl.NumberFormat('ru-RU').format(productData.price_ua)  + '₴'
        $priceEu.textContent = productData.price_eu + '€'

        if (productData.subtitle) {
            $subtitle.textContent = productData.subtitle
        } else {
            $subtitle.style.display = 'none'
        }


        $container.append($clone)
    }


}
