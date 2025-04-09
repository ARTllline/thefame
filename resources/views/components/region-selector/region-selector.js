const dataPrefix = 'data-region-selector';
const container = document.querySelector(`[${dataPrefix}]`);

if (container) {
    regionSelector();
}

export function regionSelector() {
    const flags = container.querySelectorAll('.region-selector__flag');
    const form = document.getElementById('regionSelectorForm');
    const regionInput = document.getElementById('regionInput');

    flags.forEach(flag => {
        flag.addEventListener('click', function() {
            const selectedRegion = flag.getAttribute('data-region');
            regionInput.value = selectedRegion;
            form.submit();
        });
    });
}
