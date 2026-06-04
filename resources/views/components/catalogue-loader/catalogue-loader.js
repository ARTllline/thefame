
const classPrefix = 'catalogue-loader'
const dataPrefix = 'data-catalogue-loader'
const $container = document.querySelector(`[${dataPrefix}]`)

export function createCatalogueLoader({ container, className = '', size = 48, color = '#FFF' }) {
    if (!container) return;

    // Создание элемента лоадера
    const loader = document.createElement('div');
    loader.className = `loader ${className}`;
    loader.style.width = `${size}px`;
    loader.style.height = `${size}px`;
    loader.style.borderTopColor = color;

    // Добавление лоадера в контейнер
    container.appendChild(loader);

    // Возвращаем функции для управления лоадером
    return {
        remove: () => loader.remove(),
    };
}

