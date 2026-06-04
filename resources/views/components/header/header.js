import {initBannerSlider} from "../swiper/swiper";

const classPrefix = 'header'
const dataPrefix = 'data-header'
const $container = document.querySelector(`[${dataPrefix}]`)

if ($container) {
    header()
}
export function header() {



    const $mobileMenuOpen = $container.querySelector(`[${dataPrefix}-menu-open]`)
    const menuList = $container.querySelector(`.${classPrefix}__menu-list`);
    const menuItems = Array.from($container.querySelectorAll(`.${classPrefix}__menu-list-item`));
    const closeBtns = Array.from($container.querySelectorAll(`[${dataPrefix}-body-menu-close]`));

    const threshold = $container.offsetHeight;
    let lastScrollTop = window.pageYOffset || document.documentElement.scrollTop;
    const breakpoint = window.matchMedia('(max-width: 767px)');

    init()
    function init(){
        window.addEventListener('scroll', handleHeader);


        $mobileMenuOpen.addEventListener('click', handleMenuOpen)
    }

    function closeAllSubmenus() {
        menuItems.forEach(item => {
            item.querySelector(`.${classPrefix}__menu-list-item-body--active`)?.classList.remove(`${classPrefix}__menu-list-item-body--active`);
            item.querySelector(`.${classPrefix}__menu-list-item-title--active`)?.classList.remove(`${classPrefix}__menu-list-item-title--active`);
        });
    }
    menuItems.forEach(item => {
        const title = item.querySelector(`.${classPrefix}__menu-list-item-title`);
        const submenu = item.querySelector(`.${classPrefix}__menu-list-item-body`);
        if (!title || !submenu) return;
        const id = title.getAttribute(`${dataPrefix}-body-menu-open`);

        title.addEventListener('click', e => {
            e.stopPropagation();
            if (!submenu) return;

            const isActive = submenu.classList.contains(`${classPrefix}__menu-list-item-body--active`);
            closeAllSubmenus();

            if (!isActive) {
                title.classList.add(`${classPrefix}__menu-list-item-title--active`);
                submenu.classList.add(`${classPrefix}__menu-list-item-body--active`);
            }
        });
    });
    closeBtns.forEach(btn => {
        btn.addEventListener('click', e => {
            e.stopPropagation();
            const id = btn.getAttribute(`${dataPrefix}-body-menu-close`);
            const parentSub = $container.querySelector(`[${dataPrefix}-body-menu="${id}"]`);
            const parentTitle = $container.querySelector(`[${dataPrefix}-body-menu-open="${id}"]`);
            parentSub.classList.remove(`${classPrefix}__menu-list-item-body--active`);
            parentTitle.classList.remove(`${classPrefix}__menu-list-item-title--active`);
        });
    });
    document.addEventListener('click', e => {
        if (!$container.contains(e.target)) {
            // моб. меню
            menuList.classList.remove(`${classPrefix}__menu-list--open`);
            // подменю
            closeAllSubmenus();
        }
    });
    // Сбрасываем состояние при ресайзе
    window.addEventListener('resize', () => {
        menuList.classList.remove(`${classPrefix}__menu-list--open`);
        closeAllSubmenus();
    });




    function handleMenuOpen(){
        if ($container.classList.contains(`${classPrefix}--open`)){
            $container.classList.remove(`${classPrefix}--open`)
            document.documentElement.classList.remove('no-scroll');
        }
        else {
            $container.classList.add(`${classPrefix}--open`)
            document.documentElement.classList.add('no-scroll');
        }
    }

    function handleHeader(){
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        // Логика показа/скрытия в зависимости от направления скролла
        if (scrollTop > threshold && scrollTop > lastScrollTop) {
            $container.classList.add(`${classPrefix}--hidden`);
        } else if (scrollTop < lastScrollTop) {
            $container.classList.remove(`${classPrefix}--hidden`);
        }

        // Если мы не на самом верху, добавляем белый фон, иначе прозрачный
        if (scrollTop > 0) {
            $container.classList.add(`${classPrefix}--scrolled`);
        } else {
            $container.classList.remove(`${classPrefix}--scrolled`);
        }

        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    }






}
