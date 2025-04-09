const classPrefix = 'modal';
const dataPrefix = 'data-modal';
const $container = document.querySelector(`[${dataPrefix}]`);

if ($container) {
    modal();
}


export function modal() {
    if (!$container) return;

    // Закрытие модального окна по клику на кнопку закрытия
    const closeButton = $container.querySelector(`.${classPrefix}__container-close`);
    if (closeButton) {
        closeButton.addEventListener('click', closeModal);
    }

    // Закрытие окна при клике вне контейнера формы
    $container.addEventListener('click', (e) => {
        if (e.target === $container) {
            closeModal();
        }
    });

    // Закрытие окна по нажатию клавиши Esc
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && $container.classList.contains(`${classPrefix}--active`)) {
            closeModal();
        }
    });

    // Привязка открытия модального окна по клику ко всем элементам с data-modal-open
    const openButtons = document.querySelectorAll('[data-modal-open]');
    openButtons.forEach((button) => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            openModal();
        });
    });

    function openModal() {
        $container.classList.add(`${classPrefix}--active`);
    }

    function closeModal() {
        $container.classList.remove(`${classPrefix}--active`);
    }

}
