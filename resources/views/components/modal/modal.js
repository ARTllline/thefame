import axios from "axios";
import Notification from '../notification/notification-es';
import { readUtmCookies } from '../utils/utm';

const classPrefix = 'modal';
const dataPrefix = 'data-modal';
const $container = document.querySelector(`[${dataPrefix}]`);

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


    // перед добавлением слушателя (внутри modal())
    if (!$submitButton) return;

// Защита от многократной привязки обработчика
    if ($submitButton.dataset.listenerAdded === 'true') {
        return;
    }
    $submitButton.dataset.listenerAdded = 'true';

    let isSubmitting = false;

    // Обработчик клика по кнопке отправки
    $submitButton.addEventListener('click', async (e) => {
        e.preventDefault();
        await send();
    });


    async function send(){
        if (isSubmitting) return; // уже отправляется

        // Сброс предыдущих ошибок
        $nameErr.style.opacity = '0';
        $phoneErr.style.opacity = '0';

        const name = $nameInput.value.trim();
        const phone = $phoneInput.value.trim();
        const region = $regionInput ? $regionInput.value.trim() : '';

        let hasError = false;

        if (!name) {
            $nameErr.style.opacity = '1';
            hasError = true;
        }

        const phonePattern = /^\+?\d{10,15}$/;
        if (!phone || !phonePattern.test(phone)) {
            $phoneErr.style.opacity = '1';
            hasError = true;
        }

        if (hasError) {
            return;
        }

        const utm = readUtmCookies();

        // Блокировка кнопки и защита от дублей
        isSubmitting = true;
        $submitButton.disabled = true;

        try {
            const payload = {
                name,
                phone,
                region,
                // додаємо UTM поля (порожні рядки без значення)
                utm_source: utm.utm_source || null,
                utm_medium: utm.utm_medium || null,
                utm_campaign: utm.utm_campaign || null,
                utm_term: utm.utm_term || null,
                utm_content: utm.utm_content || null,
                referrer: utm.referrer || null,
                landing_page: utm.landing_page || null,
            };

            const response = await axios.post('/appointment', payload);

            if (response.data.success) {
                popup.success({ message: `Success` });
                $nameInput.value = '';
                $phoneInput.value = '';

                window.dataLayer = window.dataLayer || [];

                window.dataLayer.push({
                    event: 'form_submit_new',
                    form: 'modal_appointment',
                    region: region,
                    appointment_id: response.data.appointment_id,
                    timestamp: Date.now(),
                    utm_source: payload.utm_source,
                    utm_medium: payload.utm_medium,
                    utm_campaign: payload.utm_campaign,
                    utm_term: payload.utm_term,
                    utm_content: payload.utm_content,
                    referrer: payload.referrer,
                    landing_page: payload.landing_page
                });

                window.dataLayer.push({
                    event: 'form_submit',
                    form: 'modal_appointment',
                    region: region,
                    appointment_id: response.data.appointment_id,
                    timestamp: Date.now(),
                    utm_source: payload.utm_source,
                    utm_medium: payload.utm_medium,
                    utm_campaign: payload.utm_campaign,
                    utm_term: payload.utm_term,
                    utm_content: payload.utm_content,
                    referrer: payload.referrer,
                    landing_page: payload.landing_page
                });


                closeModal();
            } else {
                popup.error({ message: `Unexpected response: ${response.status}` });
            }
        } catch (error) {
            if (error.response?.status === 422) {
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
                popup.error({ message: `An error has occurred` });
            }
        } finally {
            isSubmitting = false;
            $submitButton.disabled = false;
        }
    }
}
