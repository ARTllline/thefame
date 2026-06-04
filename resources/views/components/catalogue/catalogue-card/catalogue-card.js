const classPrefix = 'catalogue-card'
const dataPrefix = 'data-catalogue-card'

export function catalogueCard($container, productData) {
    const $template = document.querySelector(`[${dataPrefix}-template]`)

    init();

    function init() {
        render()
    }

    function render() {
        const $clone = $template.content.cloneNode(true)
        const $card = $clone.querySelector(`[${dataPrefix}]`)
        const $title = $clone.querySelector(`[${dataPrefix}-title]`)
        const $price = $clone.querySelector(`[${dataPrefix}-price]`)
        const $subtitle = $clone.querySelector(`[${dataPrefix}-subtitle]`)
        const $imageMain = $clone.querySelector(`[${dataPrefix}-image-main]`)
        const $imageCover = $clone.querySelector(`[${dataPrefix}-image-cover]`)

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
        $price.textContent = productData.price_eu + '€'

        if (productData.subtitle) {
            $subtitle.textContent = productData.subtitle
        } else {
            $subtitle.style.display = 'none'
        }


        $container.append($clone)
    }


}
