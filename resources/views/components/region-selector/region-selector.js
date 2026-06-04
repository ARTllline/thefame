const dataPrefix = 'data-region-selector';
const classPrefix = 'region-selector';
const $container = document.querySelector(`[${dataPrefix}]`);

if ($container) {
    regionSelector();
}

export function regionSelector() {
    const flags = $container.querySelectorAll('.region-selector__flag');
    const form = document.getElementById('regionSelectorForm');
    const regionInput = document.getElementById('regionInput');

    flags.forEach(flag => {
        flag.addEventListener('click', function() {
            const selectedRegion = flag.getAttribute('data-region');
            regionInput.value = selectedRegion;

            function getCookie(name) {
                const v = document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)');
                return v ? v.pop() : '';
            }

            flags.forEach(flag => {
                flag.addEventListener('click', function() {
                    const selectedRegion = flag.getAttribute('data-region');
                    regionInput.value = selectedRegion;

                    // Попробуем взять токен из meta
                    const meta = document.querySelector('meta[name="csrf-token"]');
                    if (meta) {
                        const tokenInput = document.querySelector('input[name="_token"]');
                        if (tokenInput) tokenInput.value = meta.getAttribute('content');
                    } else {
                        // fallback: взять из cookie XSRF-TOKEN (Laravel ставит его URL-encoded)
                        const xsrf = getCookie('XSRF-TOKEN');
                        if (xsrf) {
                            const tokenInput = document.querySelector('input[name="_token"]');
                            if (tokenInput) tokenInput.value = decodeURIComponent(xsrf);
                        }
                    }

                    form.submit();
                });
            });


            form.submit();
        });
    });

    const $openButtons = document.querySelectorAll('[data-region-open]');
    $openButtons.forEach((button) => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            openModal();
        });
    });


    function openModal() {
        $container.classList.add(`${classPrefix}--active`);
    }

    function closeModal() {
        $container.classList.remove(`${classPrefix}--active`);
    }
}
