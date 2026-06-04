@php
    $classPrefix = 'promo-result';
    $dataPrefix = 'data-promo-result';

    $t = __('promo')['promo_result'];

    $images = [
        'img/e7c2eb544b15cdd611f5c70d2c46d14ea471e194.png',
        'img/6ad2db755ed7fbabba1f9f74e6fa4d4c9d51aed4.png',
        'img/09989448ea47add7e1453cd3596fc85f4d0233b6.png',
    ];
@endphp

<div {{ $dataPrefix }} class="{{ $classPrefix }}">
    <div class="{{ $classPrefix }}__header">
        <div class="{{ $classPrefix }}__title">
            {{ $t['title'] }}
        </div>
        <div class="{{ $classPrefix }}__label">
            {{ $t['label'] }}
        </div>
    </div>

    <div class="{{ $classPrefix }}__content">
        <div class="{{ $classPrefix }}__list">

            @foreach($t['items'] as $i => $item)
                <div class="{{ $classPrefix }}__item">
                    <div class="{{ $classPrefix }}__item-img">
                        <div class="{{ $classPrefix }}__item-img-clip-path"></div>
                        <div class="{{ $classPrefix }}__item-img-border"></div>

                        <img src="{{ asset($images[$i]) }}" alt="result">

                        <div class="{{ $classPrefix }}__item-img-icon">
                            {{-- SVG оставляем без изменений --}}
                            <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M32.1135 14.0295C32.8339 14.4126 33.4366 14.9845 33.8568 15.684C34.2771 16.3834 34.4991 17.184 34.4991 18C34.4991 18.816 34.2771 19.6166 33.8568 20.316C33.4366 21.0154 32.8339 21.5874 32.1135 21.9705L12.8955 32.421C9.801 34.1055 6 31.9155 6 28.452V7.54947C6 4.08447 9.801 1.89597 12.8955 3.57747L32.1135 14.0295Z"
                                    fill="#F4EEEB"/>
                            </svg>
                        </div>
                    </div>

                    <div class="{{ $classPrefix }}__item-title">
                        {{ $item['title'] }}
                    </div>

                    <div class="{{ $classPrefix }}__item-subtitle">
                        {{ $item['subtitle'] }}
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <div class="{{ $classPrefix }}__footer">
        <div class="{{ $classPrefix }}__footer-link">
            {{-- SVG Instagram --}}
            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M25.1863 46.5156L25.1643 46.5196L25.0223 46.5896L24.9823 46.5976L24.9543 46.5896L24.8123 46.5196C24.791 46.513 24.775 46.5163 24.7643 46.5296L24.7563 46.5496L24.7223 47.4056L24.7323 47.4456L24.7523 47.4716L24.9603 47.6196L24.9903 47.6276L25.0143 47.6196L25.2223 47.4716L25.2463 47.4396L25.2543 47.4056L25.2203 46.5516C25.215 46.5303 25.2037 46.5183 25.1863 46.5156ZM25.7163 46.2896L25.6903 46.2936L25.3203 46.4796L25.3003 46.4996L25.2943 46.5216L25.3303 47.3816L25.3403 47.4056L25.3563 47.4196L25.7583 47.6056C25.7837 47.6123 25.803 47.607 25.8163 47.5896L25.8243 47.5616L25.7563 46.3336C25.7497 46.3096 25.7363 46.295 25.7163 46.2896ZM24.2863 46.2936C24.2775 46.2883 24.267 46.2866 24.2569 46.2888C24.2469 46.291 24.2381 46.2971 24.2323 46.3056L24.2203 46.3336L24.1523 47.5616C24.1537 47.5856 24.165 47.6016 24.1863 47.6096L24.2163 47.6056L24.6183 47.4196L24.6383 47.4036L24.6463 47.3816L24.6803 46.5216L24.6743 46.4976L24.6543 46.4776L24.2863 46.2936Z"
                    fill="url(#paint0_linear_204_513)"/>
                <path
                    d="M32 6C34.6522 6 37.1957 7.05357 39.0711 8.92893C40.9464 10.8043 42 13.3478 42 16V32C42 34.6522 40.9464 37.1957 39.0711 39.0711C37.1957 40.9464 34.6522 42 32 42H16C13.3478 42 10.8043 40.9464 8.92893 39.0711C7.05357 37.1957 6 34.6522 6 32V16C6 13.3478 7.05357 10.8043 8.92893 8.92893C10.8043 7.05357 13.3478 6 16 6H32ZM24 16C21.8783 16 19.8434 16.8429 18.3431 18.3431C16.8429 19.8434 16 21.8783 16 24C16 26.1217 16.8429 28.1566 18.3431 29.6569C19.8434 31.1571 21.8783 32 24 32C26.1217 32 28.1566 31.1571 29.6569 29.6569C31.1571 28.1566 32 26.1217 32 24C32 21.8783 31.1571 19.8434 29.6569 18.3431C28.1566 16.8429 26.1217 16 24 16ZM24 20C25.0609 20 26.0783 20.4214 26.8284 21.1716C27.5786 21.9217 28 22.9391 28 24C28 25.0609 27.5786 26.0783 26.8284 26.8284C26.0783 27.5786 25.0609 28 24 28C22.9391 28 21.9217 27.5786 21.1716 26.8284C20.4214 26.0783 20 25.0609 20 24C20 22.9391 20.4214 21.9217 21.1716 21.1716C21.9217 20.4214 22.9391 20 24 20ZM33 13C32.4696 13 31.9609 13.2107 31.5858 13.5858C31.2107 13.9609 31 14.4696 31 15C31 15.5304 31.2107 16.0391 31.5858 16.4142C31.9609 16.7893 32.4696 17 33 17C33.5304 17 34.0391 16.7893 34.4142 16.4142C34.7893 16.0391 35 15.5304 35 15C35 14.4696 34.7893 13.9609 34.4142 13.5858C34.0391 13.2107 33.5304 13 33 13Z"
                    fill="url(#paint1_linear_204_513)"/>
                <defs>
                    <linearGradient id="paint0_linear_204_513" x1="24.1523" y1="46.9577" x2="25.8243" y2="46.9577"
                                    gradientUnits="userSpaceOnUse">
                        <stop stop-color="#E37DBA"/>
                        <stop offset="1" stop-color="#BE5293"/>
                    </linearGradient>
                    <linearGradient id="paint1_linear_204_513" x1="6" y1="24" x2="42" y2="24"
                                    gradientUnits="userSpaceOnUse">
                        <stop stop-color="#E37DBA"/>
                        <stop offset="1" stop-color="#BE5293"/>
                    </linearGradient>
                </defs>
            </svg>

            {{ $t['footer']['question'] }}
        </div>

        <a
            href="https://www.instagram.com/the.fame.dubai?igsh=MXhoNHprNDd1b2lhMA=="
            class="button {{ $classPrefix }}__footer-button"
        >
            {{ $t['footer']['button'] }}
        </a>
    </div>
</div>

