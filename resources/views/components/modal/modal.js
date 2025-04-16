const classPrefix = 'modal';
const dataPrefix = 'data-modal';
const $container = document.querySelector(`[${dataPrefix}]`);
import axios from "axios";
import Notification from '../notification/notification-es';
if ($container) {
    modal();
}

export function modal() {
    if (!$container) return;

    const $form = $container.querySelector(`[${dataPrefix}-form]`);
    const $nameContainer = $form.querySelector(`[${dataPrefix}-name]`);
    const $phoneContainer = $form.querySelector(`[${dataPrefix}-phone]`);
    const $closeButton = $container.querySelector(`[${dataPrefix}-close]`);
    const $submitButton = $form.querySelector(`[${dataPrefix}-submit]`);

    // Поиск полей ввода внутри контейнеров
    const $nameInput = $nameContainer.querySelector('input[name="name"]');
    const $phoneInput = $phoneContainer.querySelector('input[name="phone"]');
    const $regionInput = $container.querySelector(`[${dataPrefix}-region]`);

    // Ошибочные сообщения
    const $nameErr = $nameContainer.querySelector(`.${classPrefix}__container-input-err-message`);
    const $phoneErr = $phoneContainer.querySelector(`.${classPrefix}__container-input-err-message`);

    const popup = Notification({
        position: 'top-left',
        duration: 2000,
        isHidePrev: false,
        isHideTitle: true,
        maxOpened: 3,
    });

    // Закрытие модального окна
    const closeModal = () => {
        $container.classList.remove(`${classPrefix}--active`);
    };

    const openModal = () => {
        $container.classList.add(`${classPrefix}--active`);
    };

    if ($closeButton) {
        $closeButton.addEventListener('click', closeModal);
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

    // Привязка открытия модального окна к элементам с data-modal-open
    const openButtons = document.querySelectorAll('[data-modal-open]');
    openButtons.forEach((button) => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            openModal();
        });
    });



    // Обработчик клика по кнопке отправки
    $submitButton.addEventListener('click', async (e) => {
        e.preventDefault();

        // Сброс предыдущих ошибок
        $nameErr.style.opacity = '0';
        $phoneErr.style.opacity = '0';




        const name = $nameInput.value.trim();
        const phone = $phoneInput.value.trim();
        const region = $regionInput.value.trim();

        console.log($regionInput)
        console.log(region)
        let hasError = false;

        // Простая валидация поля "Имя" — должно быть не пустым
        if (!name) {
            $nameErr.style.opacity = '1';
            hasError = true;
        }

        // Простая валидация поля "Телефон" — можно добавить регулярное выражение, здесь просто проверка на непустоту
        if (!phone) {
            $phoneErr.style.opacity = '1';
            hasError = true;
        }
        // Пример дополнительной проверки (если нужно, раскомментируйте и отредактируйте)
        const phonePattern = /^\+?\d{10,15}$/;
        if (!phonePattern.test(phone)) {
            $phoneErr.style.opacity = '1';
            hasError = true;
        }

        // Если есть ошибка, не отправляем запрос
        if (hasError) {
            return;
        }

        // Выполнение запроса
        try {
            const response = await axios.post('/appointment', { name, phone, region });

            if (response.status === 200) {
                // Показываем попап успеха (можно изменить логику показа через добавление/удаление классов)
                popup.success({
                    message: `Success`
                });
                // Очищаем поля
                $nameInput.value = '';
                $phoneInput.value = '';
                closeModal();
            }
        } catch (error) {
            if (error.response?.status === 422) {
                // Если пришли ошибки валидации с сервера, можно пройтись по ним и отобразить
                const errors = error.response.data.errors;
                if (errors.name) {
                    $nameErr.textContent = errors.name[0];
                    $nameErr.style.opacity = '1';
                }
                if (errors.phone) {
                    $phoneErr.textContent = errors.phone[0];
                    $phoneErr.style.opacity = '1';
                }
            } else {
                popup.error({
                    message: `An error has occurred"`,
                });
            }
        }
    });
}
