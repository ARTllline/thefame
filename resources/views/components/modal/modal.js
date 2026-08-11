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

    const $formWrapper = $container.querySelector(`[${dataPrefix}-form]`);
    const $successPage = $container.querySelector(`[${dataPrefix}-success]`);

    const $nameContainer = $formWrapper.querySelector(`[${dataPrefix}-name]`);
    const $phoneContainer = $formWrapper.querySelector(`[${dataPrefix}-phone]`);
    const $treatmentContainer = $formWrapper.querySelector(`[${dataPrefix}-treatment]`);

    const $closeButtons = $container.querySelectorAll(`[${dataPrefix}-close], [${dataPrefix}-success-close]`);
    const $submitButton = $formWrapper.querySelector(`[${dataPrefix}-submit]`);

    // Поля ввода
    const $nameInput = $nameContainer.querySelector('input[name="name"]');
    const $phoneInput = $phoneContainer.querySelector('input[name="phone"]');
    const $treatmentInput = $treatmentContainer.querySelector('textarea[name="treatment"]');
    const $regionInput = $container.querySelector(`[${dataPrefix}-region]`);

    // Ошибочные сообщения
    const $nameErr = $nameContainer.querySelector(`.${classPrefix}__container-input-err-message`);
    const $phoneErr = $phoneContainer.querySelector(`.${classPrefix}__container-input-err-message`);

    const $promoSubtitle = $container.querySelector(`[${dataPrefix}-promo-subtitle]`);
    const $formTypeInput = $container.querySelector(`[${dataPrefix}-form-type]`);

    // Сброс модалки в исходное состояние
    const resetModalState = () => {
        $formWrapper.style.display = '';
        $formWrapper.style.opacity = '';
        $formWrapper.style.transform = '';
        $formWrapper.style.transition = '';

        $successPage.style.display = 'none';
        $successPage.classList.remove(`${classPrefix}__success-page--active`);

        $nameInput.value = '';
        $phoneInput.value = '';
        if ($treatmentInput) $treatmentInput.value = '';

        // Прячем промо-заголовок и возвращаем тип формы по умолчанию
        if ($promoSubtitle) $promoSubtitle.style.display = 'none';
        if ($formTypeInput) $formTypeInput.value = 'standard';
    };

    const closeModal = () => {
        $container.classList.remove(`${classPrefix}--active`);
        // Даем время на анимацию закрытия перед сбросом контента
        setTimeout(resetModalState, 400);
    };

    const openModal = (isPromo = false) => {
        if (isPromo) {
            if ($promoSubtitle) $promoSubtitle.style.display = 'block';
            if ($formTypeInput) $formTypeInput.value = 'promo_appointment';
        }
        $container.classList.add(`${classPrefix}--active`);
    };

    $closeButtons.forEach(btn => btn.addEventListener('click', closeModal));

    $container.addEventListener('click', (e) => {
        if (e.target === $container) {
            closeModal();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && $container.classList.contains(`${classPrefix}--active`)) {
            closeModal();
        }
    });

    const openButtons = document.querySelectorAll('[data-modal-open]');
    openButtons.forEach((button) => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            // Проверяем, нажата ли именно плашка
            const isPromo = button.getAttribute('data-modal-open') === 'promo';
            openModal(isPromo);
        });
    });

    if (!$submitButton || $submitButton.dataset.listenerAdded === 'true') return;
    $submitButton.dataset.listenerAdded = 'true';

    let isSubmitting = false;

    $submitButton.addEventListener('click', async (e) => {
        e.preventDefault();
        await send();
    });

    async function send() {
        if (isSubmitting) return;

        $nameErr.style.opacity = '0';
        $phoneErr.style.opacity = '0';

        const name = $nameInput.value.trim();
        const phone = $phoneInput.value.trim();
        const treatment = $treatmentInput ? $treatmentInput.value.trim() : '';
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

        if (hasError) return;

        const utm = readUtmCookies();

        isSubmitting = true;
        $submitButton.disabled = true;

        const from_page_value = $formTypeInput ? $formTypeInput.value : 'standard';

        try {
            const payload = {
                name,
                phone,
                treatment,
                region,
                from_page: from_page_value,
                utm_source: utm.utm_source || null,
                utm_medium: utm.utm_medium || null,
                utm_campaign: utm.utm_campaign || null,
                utm_term: utm.utm_term || null,
                utm_content: utm.utm_content || null,
                referrer: utm.referrer || null,
                landing_page: utm.landing_page || null,
            };

            $nameInput.value = '';
            $phoneInput.value = '';

            $formWrapper.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            $formWrapper.style.opacity = '0';
            $formWrapper.style.transform = 'scale(0.95)';
            setTimeout(() => {
                $formWrapper.style.display = 'none';
                $successPage.style.display = 'block';

                void $successPage.offsetWidth;

                $successPage.classList.add(`${classPrefix}__success-page--active`);
            }, 300);


            const response = await axios.post('/appointment', payload);

            if (response.data.success) {
                $nameInput.value = '';
                $phoneInput.value = '';

                $formWrapper.style.display = 'none';
                $successPage.style.display = 'block';

                window.dataLayer = window.dataLayer || [];
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
