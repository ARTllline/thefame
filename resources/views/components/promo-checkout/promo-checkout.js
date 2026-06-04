import axios from "axios";
import Notification from '../notification/notification-es';
import { readUtmCookies } from '../utils/utm';

const dataPrefix = 'data-promo-checkout';
const $container = document.querySelector(`[${dataPrefix}]`);

if ($container) {
    promoCheckout();
}

export function promoCheckout() {
    const $form = $container.querySelector(`[${dataPrefix}-form]`);
    if (!$form) return;

    const popup = Notification({
        position: 'top-left',
        duration: 2000,
        isHidePrev: false,
        isHideTitle: true,
        maxOpened: 3,
    });

    $form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = {
            goal: $form.querySelector(`[${dataPrefix}-select]`)?.value || null,
            name: $form.querySelector(`[${dataPrefix}-input="name"]`)?.value.trim(),
            phone: $form.querySelector(`[${dataPrefix}-input="phone"]`)?.value.trim(),
            email: $form.querySelector(`[${dataPrefix}-input="email"]`)?.value.trim() || null,
            region: $form.querySelector(`[${dataPrefix}-input="region"]`)?.value || null,
            referrer: document.referrer || null,
            ...readUtmCookies(),
        };

        // базовая валидация
        if (!formData.name || !formData.phone || !formData.goal) {
            popup.error({ message: 'All required fields must be filled' });
            return;
        }

        try {
            await axios.post('/checkout', formData, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            popup.success({ message: 'Request sent successfully' });
            $form.reset();

        } catch (error) {
            if (error.response?.status === 422) {
                popup.error({ message: 'Validation error. Check the fields.' });
            } else {
                popup.error({ message: 'An error has occurred' });
            }
        }
    });
}
