
const classPrefix = 'promo-modal';
const dataPrefix = 'data-promo-modal';
const $container = document.querySelector(`[${dataPrefix}]`);

if ($container) {
    promoModal();
}

export function promoModal() {
    console.log('IS PROMO MODAL');
    if (!$container) return;

    const $closeButtons = $container.querySelectorAll(`[${dataPrefix}-close]`);
    const closeModal = () => {
        $container.classList.remove(`${classPrefix}--active`);
    };
    const openModal = () => {
        $container.classList.add(`${classPrefix}--active`);
    };

    if ($closeButtons) {
        $closeButtons.forEach($closeButton => {
            $closeButton.addEventListener('click', closeModal);
        });
    }

    // Закрытие окна при клике вне контейнера формы
    $container.addEventListener('click', (e) => {
        if (e.target === $container) {
            closeModal();
        }
    });

    // Привязка открытия модального окна к элементам с data-modal-open
    const openButtons = document.querySelectorAll('[data-modal-promo-open]');
    openButtons.forEach((button) => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            openModal();
        });
    });

    setTimeout(() => {
        console.log('OPEN PROMO MODAL');
        openModal();
    }, 3000);
}
