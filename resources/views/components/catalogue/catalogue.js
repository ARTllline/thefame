import {catalogueCardTemplate} from "./catalogue-card-template/catalogue-card-template";
import axios from "axios";

const classPrefix = 'catalogue'
const dataPrefix = 'data-catalogue'

const $container = document.querySelector(`[${dataPrefix}]`)
if ($container) {
    catalogue();
}
export function catalogue() {
    const $viewStyleButtons = document.querySelectorAll(`[${dataPrefix}-view-btn]`)
    const $productList = document.querySelector(`[${dataPrefix}-list]`)
    const $sortSelect = document.querySelector(`[${dataPrefix}-sort-select]`)
    const $showMoreBtn = document.querySelector(`[${dataPrefix}-show-more]`)
    const $showFilterBtn = document.querySelector(`[${dataPrefix}-filter-btn]`)
    const $filterCloseBtn = document.querySelector(`[${dataPrefix}-filter-close]`)
    const $filterContainer = document.querySelector(`[${dataPrefix}-filters]`)
    const $loader = document.querySelector(`[${dataPrefix}-loader]`)

    const locale = window.appLocale || 'en';
    let isLoading = false;
    let currentSort = null;
    let filters = {};
    let meta = {
        total: 0,
        take: 0,
        taken: 0,
        skip: 0,
    };

    let filterDebounceTimer = null

    const filterParamMap = {
        'Brand': 'brand_id',
        'Category': 'category_id',
        'Color': 'color',
        'Size': 'size',
        'brand': 'brand_id',
        'category': 'category_id'
    }

    init();

    function init() {
        if (window.CATALOGUE_META){
            meta = window.CATALOGUE_META;
        }

        console.log('window.CURRENT_FILTER)', window.CURRENT_FILTER)
        if (window.CURRENT_FILTER) {
            // window.CURRENT_FILTER format expected: { for: 'brand'|'category'|'ingredient'|'variant', value: 123 | [1,2] }
            const cf = window.CURRENT_FILTER;
            // map server 'for' to param key used by API
            const paramMap = {
                brand: 'brand_id',
                category: 'category_id',
                ingredient: 'ingredient_id', // договоритесь с бэком / API
                variant: 'variants' // если ваш API ожидает variants=123
            };
            const paramKey = paramMap[cf.for] || (cf.for ? cf.for : null);
            if (paramKey && typeof cf.value !== 'undefined' && cf.value !== null) {
                // normalize value to string (comma separated if array)
                const value = Array.isArray(cf.value) ? cf.value.join(',') : String(cf.value);
                // set filters localy but DON'T reset pagination / DON'T fetch again:
                setFilters({ [paramKey]: value }, { resetPagination: false });
            }
        }

        bindView();
        bindSort();
        bindShowMore();
        bindShowFilter();

        if ($container) {
            $container.addEventListener('catalogueFilters.change', function (e) {
                const { filterFor, selected } = e.detail || {}

                if (filterDebounceTimer) clearTimeout(filterDebounceTimer)
                filterDebounceTimer = setTimeout(() => {
                    handleFilterChange(filterFor, selected)
                }, 250) // 200-350ms — по вкусу
            })
        }

        $loader.style.display = 'none';
    }

    /* ---------------------- Filters ---------------------- */
    function mapFilterKey(filterFor) {
        if (!filterFor) return null
        if (filterParamMap[filterFor] ) return filterParamMap[filterFor]
        // fallback: snake_case of filterFor
        return filterFor.toString().trim().toLowerCase().replace(/\s+/g, '_')
    }



    function handleFilterChange(filterFor, selectedValues) {
        // Преобразуем выбранные значения в то, что ожидает бэкенд
        const paramKey = mapFilterKey(filterFor)
        if (!paramKey) return

        // Если выбранных нет — удалить ключ корректно
        if (!selectedValues || !selectedValues.length) {
            // Устанавливаем ключ в undefined — setFilters сделает merge, затем очистит ключ
            setFilters({ [paramKey]: undefined }, { resetPagination: true })
            return
        }

        // Попробуем привести элементы к числам, если это числа
        const normalized = selectedValues.map(v => {
            if (typeof v !== 'string') return v
            const n = Number(v)
            return (String(n) === v || !isNaN(n)) ? n : v
        })

        const valueToSend = normalized.join(',')

        setFilters({ [paramKey]: valueToSend }, { resetPagination: true })
    }

    /* ---------------------- Fetching ---------------------- */
    async function fetchProducts({ reset = false } = {}) {
        if (isLoading) return;
        $loader.style.display = '';
        isLoading = true;
        updateShowMoreButton();

        if (reset) {
            // очистить контейнер (если нужно) и стартовать с 0
            meta.skip = 0
        }

        // show loading state on button
        if ($showMoreBtn) {
            $showMoreBtn.disabled = true;
            $showMoreBtn.setAttribute('aria-busy', 'true');
        }

        const params = {
            locale,
            take: meta.take,
            skip: meta.skip,
            sort: currentSort,
            ...filters
        };

        try {
            const response = await axios.get('/api/products', { params });
            const body = response.data;

            if (!body || body.status !== 'OK') {
                console.error('Unexpected response', body);
                return;
            }

            const items = body.data ?? [];
            const respMeta = body.meta ?? {};
            meta.total = typeof respMeta.total === 'number' ? respMeta.total : meta.total;
            const count = typeof respMeta.count === 'number' ? respMeta.count : items.length;

            if (reset) {
                // если это reset — полностью перезаписываем список
                if ($productList) $productList.innerHTML = ''
                renderProducts(items)
            } else {
                appendProducts(items)
            }

            // update skip for next page
            meta.skip = (respMeta.skip ?? meta.skip) + (respMeta.count ?? items.length);

            updateShowMoreButton();

        } catch (err) {
            console.error('Error fetching products:', err);
        } finally {
            isLoading = false;
            $loader.style.display = 'none';
            if ($showMoreBtn) {
                $showMoreBtn.disabled = false;
                $showMoreBtn.removeAttribute('aria-busy');
            }
        }
    }
    /* ---------------------- Render helpers ---------------------- */

    function renderProducts(productsData) {
        //$productList.innerHTML = '';
        productsData.forEach(product => catalogueCardTemplate($productList, product));
        const currentView = $productList.classList.contains('flex') ? 'flex' : 'grid';
        updateCardsView(currentView);
    }

    function appendProducts(productsData) {
        productsData.forEach(product => catalogueCardTemplate($productList, product));
        const currentView = $productList.classList.contains('flex') ? 'flex' : 'grid';
        updateCardsView(currentView);
    }

    function updateCardsView(view) {
        const $cards = $productList.querySelectorAll('.catalogue-card');
        $cards.forEach(card => {
            card.classList.remove('catalogue-card--grid', 'catalogue-card--flex');
            if (view === 'grid') card.classList.add('catalogue-card--grid');
            else card.classList.add('catalogue-card--flex');
        });
    }

    /* ---------------------- UI bindings ---------------------- */

    function bindView() {
        $viewStyleButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                // снять active
                $viewStyleButtons.forEach(b => b.classList.remove('active'));

                const view = btn.getAttribute('data-view');

                // переключаем classes на контейнере
                $productList.classList.remove('grid', 'flex');
                $productList.classList.add(view);
                btn.classList.add('active');

                // обновляем карточки
                updateCardsView(view);
            });
        });
    }

    function bindShowFilter() {
        if (!$showFilterBtn) return;
        $showFilterBtn.addEventListener('click', function () {
            document.body.classList.toggle('filter-active');
            $filterContainer.classList.toggle('active');
        });
        $filterCloseBtn.addEventListener('click', function () {
            document.body.classList.remove('filter-active');
            $filterContainer.classList.remove('active');
        });
    }
    function bindSort() {
        if (!$sortSelect) return;
        // если хотите — выставить текущий selected при инициализации
        if (currentSort === null) {
            $sortSelect.value = 'default';
        }
        $sortSelect.addEventListener('change', function () {
            const val = this.value || null;
            applySort(val);
        });
    }
    function mapSort(mode) {
        // mode: 'default' | 'price_desc' | 'price_asc' | 'date_desc' | 'title_asc' | 'title_desc'
        if (!mode || mode === 'default') return null;

        // Выбираем поле цены в зависимости от locale
        // Подстройте маппинг локалей под ваш проект
        let priceField = 'price_eu';
        const l = (locale || '').toLowerCase();
        if (l === 'uk' || l === 'uk-ua' || l === 'ua' || l === 'ukrainian') {
            priceField = 'price_ua';
        } else {
            priceField = 'price_eu';
        }

        switch (mode) {
            case 'price_desc': return `${priceField}:desc`;
            case 'price_asc':  return `${priceField}:asc`;
            case 'date_desc':  return `created_at:desc`;
            case 'title_asc':  return `name:asc`;
            case 'title_desc': return `name:desc`;
            default: return null;
        }
    }


    function applySort(mode) {
        // server-side sort: set currentSort (in backend format) and refetch from start
        const mapped = mapSort(mode);
        currentSort = mapped; // e.g. "price_ua:desc" or null
        // сбрасываем и подгружаем с новыми параметрами
        fetchProducts({ reset: true });
    }

    function bindShowMore() {
        if (!$showMoreBtn) return;
        $showMoreBtn.addEventListener('click', function () {
            // when clicking, load next chunk
            if (isLoading) return;
            fetchProducts({ reset: false });
        });
        updateShowMoreButton();
    }

    function updateShowMoreButton() {
        if (!$showMoreBtn) return;

        // if server didn't return total yet, show generic button
        if (meta.total === null) {
            $showMoreBtn.style.display = 'none';
            $showMoreBtn.disabled = !!isLoading;
            return;
        }

        const loaded = meta.skip; // note: skip is already the number of loaded items after last fetch
        const remaining = Math.max(0, meta.total - loaded);

        if (remaining <= 0) {
            // no more items
            $showMoreBtn.style.display = 'none';
            return;
        }

        // show button with remaining count
        $showMoreBtn.style.display = '';
        $showMoreBtn.disabled = !!isLoading;
    }

    /* ---------------------- Public helpers (optional) ---------------------- */

    // Функция для установки/сброса фильтров (brand_id, category_id, q и т.д.)
    // Пример использования: setFilters({ brand_id: 5, q: 'yoga' })
    function setFilters(newFilters = {}, { resetPagination = true } = {}) {


        // newFilters может быть либо { key: value } либо полное замещение, поэтому:
        // если передали null/undefined — ничего
        if (newFilters === null) return

        // Если newFilters — это "полное" заданное состояние (спорный момент),
        // оставлю поведение как merge (как у вас было). Если нужно — поменяйте.
        filters = { ...filters, ...newFilters }

        // если передали значение undefined в key (например delete через setFilters({ key: undefined })),
        // то удалим ключы с undefined
        Object.keys(filters).forEach(k => {
            if (typeof filters[k] === 'undefined' || filters[k] === null || filters[k] === '') {
                delete filters[k]
            }
        })

        if (resetPagination) {
            // Сбрасываем список и пагинацию
            meta.skip = 0
            // при сбросе мы хотим очистить DOM и начать сначала
            if ($productList) $productList.innerHTML = ''
            fetchProducts({ reset: true })
        }
    }

}
