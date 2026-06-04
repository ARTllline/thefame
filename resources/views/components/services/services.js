const classPrefix = 'services';
const dataPrefix  = 'data-services';

const $container = document.querySelector(`[${dataPrefix}]`);
if ($container) {
    services();
}

export function services() {
    // Берём сразу все кнопки‑заголовки
    const buttons = $container.querySelectorAll(`[${dataPrefix}-category-title]`);
    const region = $container.dataset.region;

    if (!buttons.length) return;

    buttons.forEach(btn => {
        const listId = btn.getAttribute('aria-controls');
        const listEl = document.getElementById(listId);
        if (!listEl) return;

        // === Инициализация: сразу открываем ===

        if (region == 'dubai'){
            btn.setAttribute('aria-expanded', 'true');
            listEl.setAttribute('aria-hidden', 'false');
            listEl.classList.add('is-open');
            listEl.style.maxHeight = `${listEl.scrollHeight}px`;
        }


        // === Обработчик клика ===
        btn.addEventListener('click', () => {
            const expanded = btn.getAttribute('aria-expanded') === 'true';

            btn.setAttribute('aria-expanded', String(!expanded));
            listEl.setAttribute('aria-hidden', String(expanded));

            if (!expanded) {
                // открываем
                listEl.classList.add('is-open');
                // пересчитываем полную высоту, на случай динамического контента
                listEl.style.maxHeight = `${listEl.scrollHeight}px`;
            } else {
                // закрываем
                listEl.classList.remove('is-open');
                listEl.style.maxHeight = '0';
            }
        });
    });
}
