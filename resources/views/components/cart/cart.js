// resources/js/cart.js
import axios from "axios";
import {globalLoader} from "../global-loader/global-loader";
import Notification from "../notification/notification-es";

const classPrefix = 'cart';
const dataPrefix = 'data-cart';
const containerSelector = `[${dataPrefix}]`;

const $container = document.querySelector(containerSelector);
if ($container) cart($container);

export function cart($container) {
    // элементы корзины
    const $cartList = $container.querySelector(`[${dataPrefix}-cart-list]`);
    const $totalsTotal = $container.querySelector(`[${dataPrefix}-totals-total]`);
    const $totalsProducts = $container.querySelector(`[${dataPrefix}-totals-products]`);
    const $checkoutButton = $container.querySelector(`[${dataPrefix}-button-checkout]`);
    // элементы шаблона, пустая корзина и пр.
    const $empty = $container.querySelector(`[${dataPrefix}-empty]`);
    const $itemTemplate = $container.querySelector(`[${dataPrefix}-item-template]`);
    const $loader = $container.querySelector(`[${dataPrefix}-loader]`);

    // billing form elements (новое)
    const $form = $container.querySelector('form') || null;
    const $fname = $container.querySelector(`[${dataPrefix}-form-fname]`);
    const $lname = $container.querySelector(`[${dataPrefix}-form-lname]`);
    const $phone = $container.querySelector(`[${dataPrefix}-form-phone]`);
    const $email = $container.querySelector(`[${dataPrefix}-form-email]`);

    // внутреннее состояние
    let lastCartData = { items: [], totals: { products: 0, total: 0 } };

    // настройки API (добавлен checkout)
    const api = {
        get: '/api/cart',
        add: '/api/cart/add',
        update: '/api/cart/update',
        remove: (id) => `/api/cart/remove/${id}`,
        clear: '/api/cart/clear',
        checkout: '/api/orders' // ожидание: реализовать на бэке
    };

    const popup = Notification({
        position: 'top-left',
        duration: 2500,
        isHidePrev: false,
        isHideTitle: true,
        maxOpened: 3,
    });

    // CSRF
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (token) axios.defaults.headers.common['X-CSRF-TOKEN'] = token;

    // Валютный формат (UAH)
    const currencyFormatter = new Intl.NumberFormat('uk-UA', {
        style: 'currency',
        currency: 'UAH',
        maximumFractionDigits: 0
    });

    let isCheckout = false;

    // Debounce
    function debounce(fn, wait = 200) {
        let t;
        return function (...args) {
            clearTimeout(t);
            t = setTimeout(() => fn.apply(this, args), wait);
        };
    }

    function formatPrice(value) {
        return currencyFormatter.format(Math.round(value));
    }

    function parseNumber(value) {
        const n = Number(value);
        return Number.isFinite(n) ? n : 0;
    }

    function setLoading(state) {
        $container.classList.toggle(`${classPrefix}--loading`, state);
    }

    // ------------- Billing utilities -------------
    const STORAGE_KEY = 'cart_billing';

    function saveBillingToStorage(obj) {
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(obj));
        } catch (e) {
            console.warn('Cannot save billing to storage', e);
        }
    }

    function loadBillingFromStorage() {
        try {
            const s = localStorage.getItem(STORAGE_KEY);
            return s ? JSON.parse(s) : null;
        } catch (e) {
            return null;
        }
    }

    function populateBillingForm(data = {}) {
        if (!$form) return;
        if ($fname) $fname.value = data.fname ?? '';
        if ($lname) $lname.value = data.lname ?? '';
        if ($phone) $phone.value = data.phone ?? '';
        if ($email) $email.value = data.email ?? '';
    }

    function getBillingDataFromForm() {
        return {
            fname: $fname ? $fname.value.trim() : '',
            lname: $lname ? $lname.value.trim() : '',
            phone: $phone ? $phone.value.trim() : '',
            email: $email ? $email.value.trim() : ''
        };
    }

    function showFieldError($el, msg) {
        if (!$el) return;
        $el.classList.add(`${classPrefix}__input--error`);
        $el.setAttribute('aria-invalid', 'true');
        const described = $el.getAttribute('aria-describedby');
        if (described) {
            const $err = document.getElementById(described);
            if ($err) $err.textContent = msg;
        }
    }

    function clearFieldError($el) {
        if (!$el) return;
        $el.classList.remove(`${classPrefix}__input--error`);
        $el.removeAttribute('aria-invalid');
        const described = $el.getAttribute('aria-describedby');
        if (described) {
            const $err = document.getElementById(described);
            if ($err) $err.textContent = '';
        }
    }

    function validateEmail(email) {
        // простая проверка — безопасная, не сверхстрогая
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function validatePhone(phone) {
        // допускаем + и цифры, длина 7-15
        const cleaned = phone.replace(/\s+/g, '');
        return /^\+?\d{7,15}$/.test(cleaned);
    }

    function validateBilling() {

        const data = getBillingDataFromForm();
        let valid = true;

        // First name
        if (!$fname || !data.fname) {
            valid = false;
            showFieldError($fname, 'First name is required');
        } else {
            clearFieldError($fname);
        }

        // Last name
        if (!$lname || !data.lname) {
            valid = false;
            showFieldError($lname, 'Last name is required');
        } else {
            clearFieldError($lname);
        }

        // Phone
        if (!$phone || !data.phone) {
            valid = false;
            showFieldError($phone, 'Phone is required');
        } else if (!validatePhone(data.phone)) {
            valid = false;
            showFieldError($phone, 'Invalid phone format (digits only, allow leading +)');
        } else {
            clearFieldError($phone);
        }

        return { valid, data };
    }

    function updateCheckoutButtonState() {
        const data = getBillingDataFromForm();
        const hasItems = Array.isArray(lastCartData.items) && lastCartData.items.length > 0;

        // Проверяем валидность только при blur / сабмите, иначе разрешаем кнопку
        const billingValid =
            data.fname.trim() !== '' &&
            data.lname.trim() !== '' &&
            validatePhone(data.phone);

        if (billingValid && hasItems) {
            $checkoutButton.classList.remove(`${classPrefix}__totals-control-button--disabled`);
            $checkoutButton.disabled = false;
        } else {
            $checkoutButton.classList.add(`${classPrefix}__totals-control-button--disabled`);
            $checkoutButton.disabled = true;
        }


    }

    // Debounced save of billing
    const debouncedSaveBilling = debounce(() => {
        const { data } = validateBilling(); // also clears/sets field errors
        saveBillingToStorage(data);
        updateCheckoutButtonState();
    }, 500);

    // Hook inputs
    function attachBillingHandlers() {
        if (!$form) return;
        [$fname, $lname, $phone, $email].forEach($el => {
            if (!$el) return;

            // На input — только сохраняем данные, не валидируем
            $el.addEventListener('input', () => {
                clearFieldError($el); // убираем старую ошибку, если была
                const data = getBillingDataFromForm();
                saveBillingToStorage(data); // сразу сохраняем, без проверки
                updateCheckoutButtonState(); // обновляем кнопку
            });

            // На blur — валидируем поле
            $el.addEventListener('blur', () => {
                validateBilling();
                updateCheckoutButtonState();
            });
        });
    }

    // ------------- Cart rendering / totals -------------
    function renderCart(data) {
        lastCartData = data || { items: [], totals: { products: 0, total: 0 } };
        $cartList.innerHTML = '';
        if (!data || !data.items || data.items.length === 0) {
            if ($empty) $empty.classList.remove('hidden');
            if ($totalsProducts) $totalsProducts.textContent = formatPrice(data?.totals?.products ?? 0);
            if ($totalsTotal) $totalsTotal.textContent = formatPrice(data?.totals?.total ?? 0);
            if ($checkoutButton) $checkoutButton.disabled = true;
            updateCheckoutButtonState();
            return;
        }

        if ($empty) $empty.classList.add('hidden');

        data.items.forEach(item => {
            const $clone = $itemTemplate ? $itemTemplate.content.cloneNode(true) : null;
            const $node = $clone ? $clone.querySelector(`[${dataPrefix}-item]`) : null;
            if (!$node) return;

            $node.dataset.cartItemId = item.id;

            const $remove = $node.querySelector(`[${dataPrefix}-item-remove]`);
            const $image = $node.querySelector(`[${dataPrefix}-item-image] img`);
            const $title = $node.querySelector(`[${dataPrefix}-item-title]`);
            const $price = $node.querySelector(`[${dataPrefix}-item-price]`);
            const $qty = $node.querySelector(`[${dataPrefix}-item-quantity]`);
            const $subtotal = $node.querySelector(`[${dataPrefix}-item-price-total]`);

            if ($image && item.image) {
                $image.src = item.image;
                $image.alt = item.title || '';
            }
            if ($title) $title.textContent = item.title || 'Product';
            if ($price) $price.textContent = formatPrice(item.price);

            function getQtyElValue($el) {
                if (!$el) return 0;
                if ('value' in $el) return parseNumber($el.value);
                return parseNumber($el.textContent || $el.innerText);
            }
            function setQtyElValue($el, val) {
                if (!$el) return;
                if ('value' in $el) $el.value = val;
                else $el.textContent = val;
            }

            if ($qty) {
                $qty.dataset.unitPrice = item.price;
                const debouncedUpdate = debounce((newQty) => {
                    onUpdateQuantity(item.id, newQty, $node);
                }, 700);

                const $qtyDecrese = $node.querySelector(`[${dataPrefix}-item-quantity-decrease]`);
                const $qtyIncrease = $node.querySelector(`[${dataPrefix}-item-quantity-increase]`);

                setQtyElValue($qty, item.qty);

                if ($qtyDecrese) {
                    $qtyDecrese.addEventListener('click', () => {
                        const current = getQtyElValue($qty);
                        const newQty = Math.max(1, current - 1);
                        setQtyElValue($qty, newQty);
                        if ($subtotal) $subtotal.textContent = formatPrice(parseNumber($qty.dataset.unitPrice) * newQty);
                        recalcTotalsLocal();
                        debouncedUpdate(newQty);
                    });
                }

                if ($qtyIncrease) {
                    $qtyIncrease.addEventListener('click', () => {
                        const current = getQtyElValue($qty);
                        const newQty = current + 1;
                        setQtyElValue($qty, newQty);
                        if ($subtotal) $subtotal.textContent = formatPrice(parseNumber($qty.dataset.unitPrice) * newQty);
                        recalcTotalsLocal();
                        debouncedUpdate(newQty);
                    });
                }

                $qty.addEventListener('input', (e) => {
                    const newQty = getQtyElValue($qty);
                    if (newQty <= 0) {
                        if (confirm('Количество равно 0 — удалить товар из корзины?')) {
                            onRemove(item.id, $node);
                        } else {
                            setQtyElValue($qty, Math.max(1, item.qty));
                        }
                        return;
                    }
                    const unit = parseNumber($qty.dataset.unitPrice);
                    if ($subtotal) $subtotal.textContent = formatPrice(unit * newQty);
                    recalcTotalsLocal();
                    debouncedUpdate(newQty);
                });
            }

            if ($subtotal) $subtotal.textContent = formatPrice(item.price * item.qty);

            if ($remove) {
                $remove.addEventListener('click', () => onRemove(item.id, $node));
            }

            $cartList.appendChild($node);
        });

        if (data.totals) {
            if ($totalsProducts) $totalsProducts.textContent = formatPrice(data.totals.products ?? 0);
            if ($totalsTotal) $totalsTotal.textContent = formatPrice(data.totals.total ?? 0);
        } else {
            recalcTotalsLocal();
        }

        if ($checkoutButton) $checkoutButton.disabled = false;
        updateCheckoutButtonState();
    }

    function recalcTotalsLocal() {
        let productsSum = 0;
        let total = 0;
        const $items = Array.from($cartList.querySelectorAll(`.${classPrefix}__table-list-item`));
        $items.forEach($item => {
            const $qty = $item.querySelector(`[${dataPrefix}-item-quantity]`);
            const $unitEl = $item.querySelector(`[${dataPrefix}-item-price]`);
            const $subtotalEl = $item.querySelector(`[${dataPrefix}-item-price-total]`);

            let qty = 0;
            if ($qty) {
                if ('value' in $qty) qty = parseNumber($qty.value);
                else qty = parseNumber($qty.textContent || $qty.innerText);
            }

            let unit = parseNumber($qty?.dataset.unitPrice);
            if ((!unit || unit === 0) && $unitEl) {
                const raw = $unitEl.textContent.replace(/[^\d.,-]/g, '').replace(',', '.');
                unit = parseNumber(raw);
            }

            const subtotal = qty * unit;
            productsSum += subtotal;
            if ($subtotalEl) $subtotalEl.textContent = formatPrice(subtotal);
        });
        total = productsSum;
        if ($totalsProducts) $totalsProducts.textContent = formatPrice(productsSum);
        if ($totalsTotal) $totalsTotal.textContent = formatPrice(total);
    }

    // ------------- Network actions -------------
    async function fetchCart() {
        setLoading(true);
        try {
            const res = await axios.get(api.get);
            const data = res.data?.data ?? { items: [], totals: { products: 0, total: 0 } };
            renderCart(data);
        } catch (err) {
            console.error('Cart load error', err);
            renderCart({ items: [] });
        } finally {
            setLoading(false);
            if ($loader) $loader.style.display = 'none';
        }
    }

    async function onUpdateQuantity(id, qty, $node = null) {
        qty = Math.max(0, parseNumber(qty));
        if (qty === 0) {
            return onRemove(id, $node);
        }

        try {
            setLoading(true);
            const res = await axios.post(api.update, { product_id: id, quantity: qty });
            if (res.data) {
                renderCart(res.data.data);
            } else {
                fetchCart();
            }
        } catch (err) {
            console.error('Update error', err);
            popup.error({ message: 'Не удалось обновить корзину. Попробуйте ещё раз' });
            fetchCart();
        } finally {
            setLoading(false);
        }
    }

    async function onRemove(id, $node = null) {
        try {
            setLoading(true);
            await axios.delete(api.remove(id));
            if ($node && $node.parentNode) $node.parentNode.removeChild($node);
            recalcTotalsLocal();
            fetchCart();
        } catch (err) {
            console.error('Remove error', err);
            popup.error({ message: 'Не удалось удалить товар. Попробуйте ещё раз.' });
            fetchCart();
        } finally {
            setLoading(false);
        }
    }

    async function onClear() {
        try {
            setLoading(true);
            const res = await axios.post(api.clear);
            if (res.data) renderCart(res.data.data);
            else fetchCart();
        } catch (err) {
            console.error('Clear error', err);
            popup.error({ message: 'Не удалось очистить корзину.' });
        } finally {
            setLoading(false);
        }
    }

    // ------------- Checkout -------------
    async function onCheckout() {
        if(isCheckout) return;
        isCheckout = true;
        globalLoader.show();

        const { valid, data } = validateBilling();
        if (!valid) {
            updateCheckoutButtonState();
            const firstInvalid = $container.querySelector('[aria-invalid="true"]');
            if (firstInvalid) firstInvalid.focus();
            return;
        }

        // prepare payload
        const payload = {
            billing: data,
            cart: lastCartData // ожидается { items: [...], totals: {...}, currency: 'UAH' }
        };

        console.log('payload', payload);


        try {
            setLoading(true);
            $checkoutButton.disabled = true;
            const response = await axios.post(api.checkout, payload);

            if (response && response.data && response.data.success) {
                // Успешно создали заказ — можно редиректнуть на страницу оплаты или показать success
                const orderId = response.data.order_id;
                const orderNumber = response.data.order_number;
                console.log('Order saved', orderId, orderNumber);

                // Пример: редирект на страницу благодарности
                window.location.href = `/checkout/success?order_id=${orderId}&order_number=${encodeURIComponent(orderNumber)}`;
                globalLoader.hide();
                return;
            } else {
                console.error('Order save failed', response);
                popup.error({ message: 'Не удалось оформить заказ. Попробуйте ещё раз.' });
                isCheckout = false;
                fetchCart();
                globalLoader.hide();
            }
        } catch (err) {
            console.error('Checkout error', err);
            // если ответ пришёл с ошибками валидации - можно показать
            if (err.response && err.response.data) {
                const data = err.response.data;
                if (data.errors) {
                    // показать ошибки формы
                    console.warn('validation errors', data.errors);
                    popup.error({ message: 'Проверьте введённые данные.' });
                } else if (data.message) {
                    popup.error({ message: data.message });
                }
            } else {
                popup.error({ message: 'Не удалось оформить заказ. Попробуйте ещё раз.' });
            }
            isCheckout = false;
            fetchCart();
            globalLoader.hide();
        } finally {
            setLoading(false);
            updateCheckoutButtonState();
            globalLoader.hide();
        }
    }

    // ------------- Init -------------
    function initBilling() {
        // populate from storage
        const stored = loadBillingFromStorage();
        if (stored) populateBillingForm(stored);
        attachBillingHandlers();
        updateCheckoutButtonState();
    }

    function init() {
        if ($checkoutButton) $checkoutButton.addEventListener('click', (e)=>{
            e.preventDefault();
            onCheckout();
        });
        initBilling();
        // первичная загрузка корзины
        fetchCart();

        // also make sure button state updates when cart changes (we update lastCartData in renderCart)
    }

    init();
}
