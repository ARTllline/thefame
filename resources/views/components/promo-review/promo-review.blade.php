@php
    $classPrefix ='promo-review';
    $dataPrefix ='data-promo-review';


    $avatarColors = [
        '#5F6368', // серый
        '#6D4C41', // мягкий коричневый
        '#8E24AA', // приглушенный фиолет
        '#3949AB', // глубокий синий
        '#1E88E5', // спокойный голубой
        '#00897B', // тёмная бирюза
        '#43A047', // мягкий зелёный
        '#F4511E', // приглушенный оранжевый
        '#757575', // нейтральный серый
        '#546E7A', // серо-синий
    ];

    $reviews = [

                [
            'name' => 'Marin Hako',
            'img_name' => 'M',
            'date' => '26.06.2025',
            'text' => 'After two years of living in Asia — with sun, humidity, and constant change leaving their mark on my skin — I finally found a place where I feel truly cared for.
This clinic is helping me restore my skin’s health and my inner peace.
Alina, my cosmetologist, is a true magician. With her gentle touch, deep understanding, and professional care, she listens to my skin better than I ever could.
After every session, I leave feeling refreshed, renewed — my skin clearer, brighter, more alive.
I’m genuinely impressed and grateful for the warmth, attentiveness, and visible results.
Thank you, Alina, for bringing back not just beauty, but confidence.',
        ],

                   [
            'name' => 'Sofiya Poland',
            'img_name' => 'S',
            'date' => '17.09.2025',
            'text' => 'Fame Clinic is truly a jewel of Dubai, offering professional, precise, and customer-focused care. The doctors’ expertise and individual approach are remarkable, making every visit feel tailored and reassuring. They use only certified, high-quality products, which gives me complete confidence and peace of mind whenever I return to the clinic. The results speak for themselves—absolutely amazing.',
        ],

                   [
            'name' => 'Arina Yasm',
            'img_name' => 'A',
            'date' => '14.01.2026',
            'text' => 'Amazing experience at this cosmetology clinic in Dubai. Dr. Olga is truly professional and very attentive. I did the Lumecca laser treatment and I’m extremely happy with the results — my skin looks clearer and more even already. Highly recommend this clinic and Dr. Olga!',
        ],

                [
            'name' => 'Viktoria Dolzhenkova',
            'img_name' => 'V',
            'date' => '04.08.2025',
            'text' => 'A huge thank you to Andrii! I have been going to him for many years, and I couldn’t be happier with the care I receive. He is incredibly attentive, always polite, and takes the time to understand the specific needs of my skin. Every visit feels personalized and thoughtful, and I truly appreciate his professionalism and dedication. My skin has benefitted so much from his expertise, and I always leave feeling well taken care of.'
            ],

        [
            'name' => 'Анна Цвях',
            'img_name' => 'A',
            'date' => '11.01.2026',
            'text' => 'Косметолог Наталья Обрусник, провела процедуру морфеус 8 профессионально, относительно безболезненно, дала рекомендации после.
Довочки на ресепшен, как всегда угостили вкусным кофе и были предельно внимательны.Смело рекомендую Fame для эстетических услуг .',
        ],
        [
            'name' => 'Дарья',
            'img_name' => 'Д',
                   'date' => '05.12.2025',
            'text' => 'Я клиент The Fame с августа 2024. За это время я успела побывать у разных специалистов клиники и сделать множество разнообразных процедур от стрижки до сложных аппаратных косметологических комплексов, перманентный макияж и laser hair removal. Я фанат этого места. Здесь работают лучшие специалисты - администраторы на рецепции, медперсонал, парикмахеры, мастер PMU. Все работают на высшем уровне. Однозначно рекомендую The Fsme. Высокий уровень сервиса, грамотные специалисты, множество видов процедур не за все деньги мира. И есть кеш бек, что так же не может не радовать❤️🤝',
        ],
        [
            'name' => 'Валерия Володина',
            'img_name' => 'В',
            'date' => '18.12.2025',
            'text' =>'Давно искала такую клинику, Здесь Вас дружелюбно встретят, окутают заботой и проведут!!! Профессионализм врача- настоящий волшебник! Всё объяснила, показала, провела процедуру максимально бережно и комфортно! Хочу поблагодарить косметолога за волшебство! Клиника — это место, где заботятся о клиенте от входа до выхода. Рекомендую всем!!!',
        ],

        [
            'name' => 'Kateryna Nechay',
            'img_name' => 'K',
            'date' => '25.01.2025',
            'text' =>'Dr Julia Pahamova is truly a professional. She was able to formulate a reasonable treatment plan given my concerns and timeline. Absolutely beautiful work in an immaculately clean, modern clinic. Great product selection and recommendations. Most importantly, gently and kindly administered treatment. Thank you!!!',
        ],
             [
            'name' => 'Елена Еленовна',
            'img_name' => 'E',
            'date' => '07.02.2025',
            'text' =>'Хожу на процедуры к Дмитрию уже годы , ботокс, филлер местами ,
Особо хочу отметить что очень нравится что по делу процедуры и нет «впаривания» процедур и косметики «абы сделать» ( чем грешит один известный салон по Киеву куда я имела оплошность попасть и больше не хочу ), очень комфортно и качественно и по делу и очень приятные цены. Дмитрий самый лучший !',
        ],
             [
            'name' => 'Vitaliy Taran',
            'img_name' => 'V',
            'date' => '10.09.2025',
            'text' =>'Случайно попал на стрижку, даже не надеялся на такой неимоверный професионализм и обслуживание! Неодменно вернусь!',
        ],
             [
            'name' => 'Татьяна77i Белоножкина',
            'img_name' => 'Т',
            'date' => '02.02.2026',
            'text' =>'Удаление пигментации и сосудов, результат супер. Рекомендую.',
        ],
             [
            'name' => 'Елена Дмитрук',
            'img_name' => 'E',
            'date' => '20.01.2026',
            'text' =>'Спасибо , огромное Дмитрию . Уже 6 лет делаю ботокс . Профессионал своего дела . Дай , Бог Вам здоровья и благополучия .',
        ],
             [
            'name' => 'Карина Дерба',
            'img_name' => 'К',
            'date' => '12.01.2026',
            'text' =>'Неодноразово відвідувала салон . Сервіс на високому рівні ! Простір салону дуже стильний, продуманий до дрібниць, з цікавим естетичним дизайном . Смачна кава 🫶🏼, загальне відчуття турботи про клієнта .
Робила губи у лікаря-косметолога Анастасії — і я просто в захваті . Її професіоналізм, уважність, тонке відчуття форми та естетики вражають. Результат перевершив усі очікування — максимально природно, красиво й гармонійно.',
        ],
             [
            'name' => 'Ашурова Катерина',
            'img_name' => 'А',
            'date' => '06.01.2026',
            'text' =>'Уже несколько лет доверяю свою кожу только Виктории Шибинской☺️ я обратилась в салон с мелазмой, которая не убиралась обычными косметическими средствами и была очень заметна. Виктория подобрала комплекс процедур, благодаря которым я почти забыла, что имею пигментацию, к тому же состояние кожи значительно улучшилось, и сейчас мы только поддерживаем ее. В целом в салоне все очень внимательны и царит приятная атмосфера, самые искренние рекомендации!',
        ],
];

    $t = __('promo.review');
@endphp


<div {{$dataPrefix}} class="{{$classPrefix}}">
    <img src="{{ asset('img/review-banner.png') }}" class="{{$classPrefix}}__bg"/>
    <div class="{{$classPrefix}}__container">
        <div class="{{$classPrefix}}__header">
            <div class="{{$classPrefix}}__title">
                <span>{{ $t['title_1'] }}</span>
                <span>{{ $t['title_2'] }}</span>
            </div>
            <div class="{{$classPrefix}}__subtitle">
                {{ $t['subtitle'] }}
            </div>

        </div>

        <div class="{{$classPrefix}}__form">
            <div class="{{$classPrefix}}__form-head">
                <div class="{{$classPrefix}}__form-head-info">
                    <div class="{{$classPrefix}}__form-head-title">

                        <svg class="{{$classPrefix}}__form-head-logo">
                            <use href="{{asset('svg/Google_2015_logo.svg')}}"></use>
                        </svg>
                        The Fame Clinic
                    </div>
                    <div class="{{$classPrefix}}__form-head-rating">
                        <div class="{{$classPrefix}}__form-head-rating-num">
                            4.9
                        </div>
                        <div class="{{$classPrefix}}__form-head-stars">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="{{$classPrefix}}__form-head-star">
                                    <use href="{{asset('svg/star-symbol-icon.svg')}}"></use>
                                </svg>
                            @endfor
                        </div>
                    </div>
                </div>
                <a href="https://www.google.com/search?client=safari&hs=LgfU&sca_esv=a2c9e0ee7e7d62a7&rls=en&sxsrf=ANbL-n65jb6HppiVStZ2_Z8JozUUDrKGSg:1770895998569&kgmid=/g/11x8511p4l&q=The+Fame+Clinic+–+Cosmetology+Clinic+%26+Beauty+clinic+in+Dubai&source=sh/x/loc/uni/m1/1&kgs=857278dd0ceaf723&shndl=30&shem=sume,shrtsdl&utm_source=sume,shrtsdl,sh/x/loc/uni/m1/1#lrd=0x3e5f6cad3c42dc63:0x8f28bdab5b96c5e2,1,,,,"
                   class="{{$classPrefix}}__form-head-button">
                    {{ $t['google_button'] }}
                </a>
            </div>
            <div class="{{$classPrefix}}__form-list">
                <div {{$dataPrefix}}-slider class="swiper swiper--hidden {{$classPrefix}}__swiper">
                    <div {{$dataPrefix}}-slider-wrapper class="swiper-wrapper">
                        @foreach($reviews as $review)
                            @php
                                $colorIndex = crc32($review['name']) % count($avatarColors);
                                $avatarColor = $avatarColors[$colorIndex];
                            @endphp

                            <div class="swiper-slide {{$classPrefix}}__swiper-slide">
                                <div class="{{$classPrefix}}__form-item">
                                    <div class="{{$classPrefix}}__form-item-head">
                                        <div class="{{$classPrefix}}__form-item-head-img"
                                             style="background-color: {{ $avatarColor }}">
                                            {{ mb_substr($review['name'], 0, 1) }}
                                        </div>
                                        <div class="{{$classPrefix}}__form-item-head-info">
                                            <div class="{{$classPrefix}}__form-item-head-name">
                                                {{ $review['name'] }}
                                            </div>
                                            <div class="{{$classPrefix}}__form-item-head-date">
                                                {{ $review['date'] }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="{{$classPrefix}}__form-item-stars">
                                        @for($i = 0; $i < 5; $i++)
                                            <svg class="{{$classPrefix}}__form-item-star">
                                                <use href="{{asset('svg/star-symbol-icon.svg')}}"></use>
                                            </svg>
                                        @endfor
                                    </div>
                                    <div class="{{$classPrefix}}__form-item-text-wrapper">
                                        <div class="{{$classPrefix}}__form-item-text">
                                            {!! nl2br(e($review['text'])) !!}
                                        </div>

                                        <a href="https://www.google.com/search?client=opera-gx&q=the+fame&sourceid=opera&ie=UTF-8&oe=UTF-8#lrd=0x40d4cf00324f3a15:0x43c04d091a3d06fb,1,,,,"
                                           target="_blank"
                                           class="{{$classPrefix}}__form-item-more">
                                            {{ $t['more'] }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

