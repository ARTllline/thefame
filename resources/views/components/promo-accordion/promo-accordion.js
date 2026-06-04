const classPrefix = 'promo-accordion';
const dataPrefix = 'data-promo-accordion';
const $container = document.querySelector(`[${dataPrefix}]`);

if ($container) {
    promoAccordion();
}

export function promoAccordion() {
    const items = $container.querySelectorAll(`[${dataPrefix}-item]`);

    items.forEach(item => {
        const header = item.querySelector(`[${dataPrefix}-header]`);
        const body = item.querySelector(`[${dataPrefix}-body]`);
        const btn = item.querySelector(`[${dataPrefix}-header-btn]`);

        if (!header || !body) return;

        body.style.maxHeight = '0px';
        body.style.overflow = 'hidden';
        body.style.transition = 'max-height 0.3s ease';

        header.addEventListener('click', () => {
            const isOpen = item.classList.contains('is-open');

            closeAll(items);

            if (!isOpen) {
                openItem(item, body, btn);
            }
        });
    });


    function openItem(item, body, btn) {
        item.classList.add('is-open');
        body.style.maxHeight = body.scrollHeight + 'px';

        if (btn) {
            btn.textContent = '−';
        }
    }

    function closeAll(items) {
        items.forEach(item => {
            const body = item.querySelector('[data-promo-accordion-body]');
            const btn = item.querySelector('[data-promo-accordion-header-btn]');

            item.classList.remove('is-open');

            if (body) {
                body.style.maxHeight = '0px';
            }

            if (btn) {
                btn.textContent = '+';
            }
        });
    }
}


