import { initBannerSlider } from "../swiper/swiper";
import { persistUtmFromUrl, readUtmCookies } from "../utils/utm"; // путь может отличаться

const classPrefix = 'main-banner'
const dataPrefix = 'data-main-banner'
const $container = document.querySelector(`[${dataPrefix}]`)

// Сохраняем UTM при первом заходе
persistUtmFromUrl();

if ($container) {
    mainBanner()
}

export function mainBanner() {

    const $background = $container.querySelector(`[${dataPrefix}-background]`)
    const $backgroundVideo = $container.querySelector(`[${dataPrefix}-background-video]`)
    const $backgroundLoader = $container.querySelector(`[${dataPrefix}-background-loader]`)

    const region = $container.getAttribute('data-region');
    const mediaQuery = window.matchMedia('(max-width: 767px)');
    let currentMode = mediaQuery.matches ? 'mobile' : 'desktop';


    const $beautyProButton = $container.querySelector(`[${dataPrefix}-beautypro]`)
    let beautyProLink = 'https://beautyprosoftware.com/b/997907'

    if ($beautyProButton) {
        // Защита от двойного клика
        let isClicking = false;

        $beautyProButton.addEventListener('click', async (e) => {
            e.preventDefault();
            if (isClicking) return;
            isClicking = true;
            $beautyProButton.setAttribute('aria-disabled', 'true');

            // Берём UTM сначала из URL (если есть), иначе из cookie
            const urlParams = new URLSearchParams(window.location.search);
            const cookieUtm = readUtmCookies();

            const utm_source = urlParams.get('utm_source') || cookieUtm.utm_source || '';
            const utm_medium = urlParams.get('utm_medium') || cookieUtm.utm_medium || '';
            const utm_campaign = urlParams.get('utm_campaign') || cookieUtm.utm_campaign || '';
            const utm_term = urlParams.get('utm_term') || cookieUtm.utm_term || '';
            const utm_content = urlParams.get('utm_content') || cookieUtm.utm_content || '';
            const referrer = document.referrer || cookieUtm.referrer || '';
            const landing_page = window.location.href || cookieUtm.landing_page || '';

            // Тело запроса
            const payload = {
                target: beautyProLink,
                utm_source, utm_medium, utm_campaign, utm_term, utm_content,
                referrer, landing_page
            };

            // CSRF токен из meta (убедитесь, что в layout/meta есть <meta name="csrf-token" content="{{ csrf_token() }}">)
            const tokenMeta = document.querySelector('meta[name="csrf-token"]');
            const csrf = tokenMeta ? tokenMeta.getAttribute('content') : '';

            // Попробуем записать на сервер, но не будем задерживать редирект слишком долго
            try {
                // Устанавливаем таймаут fallback (1.2 сек)
                const controller = new AbortController();
                const signal = controller.signal;
                const fetchPromise = fetch('/track-beautypro-click', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload),
                    signal
                }).then(r => r.ok ? r.json().catch(()=>null) : null);

                // ждем либо fetch, либо таймаут
                const timeoutMs = 1200;
                const timeoutPromise = new Promise(resolve => setTimeout(() => resolve(null), timeoutMs));

                const result = await Promise.race([fetchPromise, timeoutPromise]);

                // Если fetch завершился раньше таймаута и вернул uuid — добавим в ссылку
                let destination = beautyProLink;
                if (result && result.success && result.uuid) {
                    // корректно добавляем параметр
                    const sep = destination.includes('?') ? '&' : '?';
                    destination = `${destination}${sep}ref_uuid=${encodeURIComponent(result.uuid)}`;
                }

                // Редиректим
                window.location.href = destination;

            } catch (err) {
                // В любом случае редиректим, чтобы не портить UX
                window.location.href = beautyProLink;
            } finally {
                // (редирект произойдёт и страница перезагрузится — эти строки для порядка)
                isClicking = false;
                $beautyProButton.removeAttribute('aria-disabled');
            }
        });
    }


    if ($backgroundVideo)
    {
        init();
    }
    function init(){
        setVideoSource(currentMode);

        mediaQuery.addEventListener('change', (e) => {
            const newMode = e.matches ? 'mobile' : 'desktop';
            if (newMode !== currentMode) {
                currentMode = newMode;
                setVideoSource(currentMode);
            }
        });

        $backgroundVideo.addEventListener('loadeddata', hideLoader);
    }

    function getVideoUrl(mode) {
        if (region === 'dubai') {
            return mode === 'mobile'
                ? $container.getAttribute('data-dubai-mobile')
                : $container.getAttribute('data-dubai-desktop');
        } else {
            return mode === 'mobile'
                ? $container.getAttribute('data-kyiv-mobile')
                : $container.getAttribute('data-kyiv-desktop');
        }
    }

    function setVideoSource(mode) {
        const videoUrl = getVideoUrl(mode);

        if ($backgroundVideo.getAttribute('src') !== videoUrl) {
            $backgroundVideo.src = videoUrl;
            $backgroundVideo.load(); // Перезагрузить видео с новым источником
        }
    }
    function hideLoader() {
        if ($backgroundLoader) {
            $backgroundLoader.style.display = 'none';
        }
    }
}
