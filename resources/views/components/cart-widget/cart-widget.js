// resources/js/cart-widget.js
import axios from "axios";
import Notification from '../notification/notification-es';

const classPrefix = 'cart-widget';
const dataPrefix = 'data-cart-widget';
const selector = `[${dataPrefix}]`;
const $container = document.querySelector(selector);

if ($container) cartWidget($container);

export function cartWidget($container) {
    if (!$container) return;

    const $close = $container.querySelector(`[${dataPrefix}-close]`);
    const $listWrapper = $container.querySelector(`[${dataPrefix}-list]`);
    const $template = document.querySelector(`template[${dataPrefix}-item-template]`);
    const $total = $container.querySelector(`[${dataPrefix}-total]`);
    const $empty = $container.querySelector(`[${dataPrefix}-empty]`);

    const popup = Notification({
        position: 'top-left',
        duration: 2500,
        isHidePrev: false,
        isHideTitle: true,
        maxOpened: 3,
    });

    const api = {
        get: '/api/cart',
        update: '/api/cart/update',
        remove: (id) => `/api/cart/remove/${id}`,
    };

    // CSRF
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (token) axios.defaults.headers.common['X-CSRF-TOKEN'] = token;

    const currencyFormatter = new Intl.NumberFormat('uk-UA', {
        style: 'currency',
        currency: 'UAH',
        maximumFractionDigits: 0
    });

    function formatPrice(n) {
        if (n === 0) return '-';
        return currencyFormatter.format(Math.round(n || 0));
    }
    function parseNumber(v) { const n = Number(v); return Number.isFinite(n) ? n : 0; }

    // open/close
    function open() {
        $container.classList.add(`${classPrefix}--active`);
        $container.setAttribute('aria-hidden', 'false');
    }
    function close() {
        $container.classList.remove(`${classPrefix}--active`);
        $container.setAttribute('aria-hidden', 'true');
    }

    // bindings
    if ($close) $close.addEventListener('click', close);
    $container.addEventListener('click', (e) => { if (e.target === $container) close(); });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && $container.classList.contains(`${classPrefix}--active`)) close(); });

    // open buttons (global)
    const openButtons = document.querySelectorAll('[data-cart-widget-open]');
    openButtons.forEach(btn => btn.addEventListener('click', (e) => { e.preventDefault(); open(); }));

    // --- NEW: update global cart count in header/buttons ---
    function updateGlobalCount(count) {
        const counters = document.querySelectorAll('[data-cart-count]');

        counters.forEach(el => {
            if (!el) return;

            const btn = el.closest('[data-cart-widget-open]'); // кнопка

            if (!count || count <= 0) {
                // скрываем отображение
                el.textContent = '';
                el.setAttribute('aria-hidden', 'true');
                el.classList.add(`hint-hidden`);

                // добавляем класс пустой корзины
                if (btn) btn.classList.add('is-empty');

            } else {
                // показываем число
                el.textContent = String(count);
                el.setAttribute('aria-hidden', 'false');
                el.classList.remove(`hint-hidden`);

                // убираем класс пустой корзины
                if (btn) btn.classList.remove('is-empty');
            }
        });
    }

    // debounce
    function debounce(fn, wait = 600) {
        let t;
        return function (...args) {
            clearTimeout(t);
            t = setTimeout(() => fn.apply(this, args), wait);
        };
    }

    // render single item
    function renderItem(item) {
        const node = $template.content.cloneNode(true).querySelector(`.${classPrefix}__item`);
        if (!node) return null;

        node.dataset.itemId = item.id;

        const $img = node.querySelector('img');
        const $title = node.querySelector(`[${dataPrefix}-item-title]`);
        const $price = node.querySelector(`[${dataPrefix}-item-price]`);
        const $qtyInput = node.querySelector(`[${dataPrefix}-item-quantity]`);
        const $btnInc = node.querySelector(`[${dataPrefix}-qty-increase]`);
        const $btnDec = node.querySelector(`[${dataPrefix}-qty-decrease]`);
        const $remove = node.querySelector(`[${dataPrefix}-item-remove]`);

        if ($img && item.image) { $img.src = item.image; $img.alt = item.title || ''; }
        if ($title) $title.textContent = item.title || 'Product';
        if ($price) $price.textContent = (item.price * item.qty) + ' ₴';
        if ($qtyInput) {
            // qty stored as text inside element (you used innerText in code)
            $qtyInput.innerText = String(item.qty);
            $qtyInput.dataset.unitPrice = item.price;
        }

        // local subtotal — widget shows single-line items, total is global
        function localRecalc() {
            recalcTotalLocal();
        }

        const debouncedUpdate = debounce(async (newQty) => {
            await updateQty(item.id, newQty);
        }, 200);

        if ($btnInc) $btnInc.addEventListener('click', () => {
            const v = parseNumber($qtyInput.innerText) + 1;
            $qtyInput.innerText = v;
            localRecalc();
            debouncedUpdate(v);
        });

        if ($btnDec) $btnDec.addEventListener('click', () => {
            const v = Math.max(1, parseNumber($qtyInput.innerText) - 1);
            $qtyInput.innerText = v;
            localRecalc();
            debouncedUpdate(v);
        });

        if ($remove) $remove.addEventListener('click', async () => {
            await removeItem(item.id);
        });

        return node;
    }

    // render whole cart
    function renderCart(data) {
        $listWrapper.innerHTML = ''; // clear
        if (!data || !data.items || data.items.length === 0) {
            if ($empty) $empty.hidden = false;
            if ($total) $total.textContent = formatPrice(0);
            updateGlobalCount(0);
            return;
        }
        if ($empty) $empty.hidden = true;

        data.items.forEach(item => {
            const n = renderItem(item);
            if (n) $listWrapper.appendChild(n);
        });

        if (data.totals && $total) {
            $total.textContent = formatPrice(data.totals.total ?? data.totals.products ?? 0);
        } else {
            recalcTotalLocal();
        }

        // compute count: prefer server-provided count (data.totals.count), otherwise sum quantities
        let count = 0;
        if (data.totals && typeof data.totals.count !== 'undefined') {
            count = parseNumber(data.totals.count);
        } else {
            // sum items qty
            count = data.items.reduce((acc, it) => acc + (parseNumber(it.qty) || 0), 0);
        }
        updateGlobalCount(count);
    }

    // recalc total based on nodes (local optimistic)
    function recalcTotalLocal() {
        let sum = 0;
        let count = 0;
        const items = Array.from($listWrapper.querySelectorAll(`.${classPrefix}__item`));
        items.forEach(node => {
            const $qty = node.querySelector(`[${dataPrefix}-item-quantity]`);
            const unit = parseNumber($qty?.dataset.unitPrice) || 0;
            // **IMPORTANT**: your qty is stored in innerText, not in value
            const qty = parseNumber($qty?.innerText) || 0;
            sum += unit * qty;
            count += qty;
        });
        if ($total) $total.textContent = formatPrice(sum);

        // update header count optimistically
        updateGlobalCount(count);
    }

    // API: fetch
    async function fetchCart() {
        try {
            const res = await axios.get(api.get);
            // assume server returns { data: { items: [...], totals: { total:..., count:... } } }
            renderCart(res.data.data);
        } catch (err) {
            console.error('Cart widget: fetch error', err);
            popup.error({ message: 'Не удалось загрузить корзину' });
        }
    }

    // API: update quantity
    async function updateQty(product_id, quantity) {
        try {
            await axios.post(api.update, { product_id, quantity });
            // получить обновлённую корзину
            await fetchCart();
            //popup.success({ message: 'Корзина обновлена' });
        } catch (err) {
            console.error('Cart widget: update error', err);
            popup.error({ message: 'Ошибка при обновлении' });
            await fetchCart();
        }
    }

    // API: remove
    async function removeItem(id) {
        try {
            await axios.delete(api.remove(id));
            //popup.info({ message: 'Товар удалён' });
            await fetchCart();
        } catch (err) {
            console.error('Cart widget: remove error', err);
            popup.error({ message: 'Ошибка при удалении' });
            await fetchCart();
        }
    }

    // публичный метод для добавления товара и открытия виджета (можно вызвать глобально)
    async function addAndOpen(product) {
        try {
            await axios.post('/api/cart/add', product);
            await fetchCart();
            open();
        } catch (err) {
            console.error('Cart widget: add error', err);
            popup.error({ message: 'Не удалось добавить товар' });
        }
    }

    async function addAndCheckout(product) {
        try {
            await axios.post('/api/cart/add', product);
            await fetchCart();
            window.location.href = '/cart';
        } catch (err) {
            console.error('Cart widget: add error', err);
            popup.error({ message: 'Не удалось добавить товар' });
        }
    }
    // инициализация
    function init() {
        fetchCart();
        // expose for debugging/global usage
        window.CartWidget = window.CartWidget || {};
        window.CartWidget.open = open;
        window.CartWidget.close = close;
        window.CartWidget.addAndOpen = addAndOpen;
        window.CartWidget.addAndCheckout = addAndCheckout;
        window.CartWidget.fetch = fetchCart;


        window.addEventListener('pageshow', (ev) => {
            // if page was persisted in bfcache OR we always want to ensure fresh data on pageshow
            // do a quick fetch to update UI (server-side result will be idempotent)
            fetchCart();
        });

        // popstate also fires on history navigation — extra safety
        window.addEventListener('popstate', () => {
            fetchCart();
        });

        // if tab was hidden and then shown again, refetch to avoid stale counters
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'visible') fetchCart();
        });
    }

    init();
}
