@php
    $classPrefix = 'cart-result';
    $dataPrefix = 'data-cart-result';

    // Надежный расчет продуктового итога (если в БД есть поле products_total, он будет использован)
    $productsTotal = $order->products_total ?? $order->items->sum(function($it) {
        return ($it->price ?? 0) * ($it->quantity ?? 0);
    });

    // Количество товаров (если есть поле total_items — оно будет использовано, иначе суммируем qty)
    $totalItems = $order->total_items ?? $order->items->sum('quantity');

    // Общая сумма заказа (fallback на productsTotal если total отсутствует)
    $orderTotal = $order->total ?? $productsTotal;

    // Валюта (fallback на пустую строку)
    $currency = $order->currency ?? '';
@endphp

<section {{$dataPrefix}} class="{{$classPrefix}}">
    <div class="{{$classPrefix}}__main">
        <div class="{{$classPrefix}}__title">Спасибо за ваш заказ</div>
        <div class="{{$classPrefix}}__subtitle">Мы скоро свяжемся с вами</div>

        <div class="{{$classPrefix}}__meta">
            <p><strong>Номер заказа:</strong> {{ $order->order_number ?? $order->id }}</p>
            @if($order->created_at)
                <p><strong>Дата:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
            @endif
            @if(isset($order->status))
                <p><strong>Статус:</strong> {{ ucfirst($order->status) }}</p>
            @endif
        </div>

        <div class="{{$classPrefix}}__container">
            <h2 id="cart-result-heading" class="{{$classPrefix}}__container-title">Детали заказа</h2>

            <table class="{{$classPrefix}}__table" aria-labelledby="cart-result-heading">
                <thead>
                <tr>
                    <th>Товар</th>
                    <th style="text-align: right">Итого</th>
                </tr>
                </thead>

                <tbody>
                @forelse($order->items as $item)
                    @php
                        $itemTitle = $item->title ?? ($item->product->title ?? 'Товар');
                        $itemQty = $item->quantity ?? 1;
                        $itemPrice = $item->price ?? 0;
                        $itemSubtotal = $itemPrice * $itemQty;
                    @endphp
                    <tr>
                        <td>
                            @if(isset($item->product) && $item->product)
                                <span>
                                    {{ $itemTitle }}
                                </span>
                            @else
                                <span>{{ $itemTitle }}</span>
                            @endif
                            <div><small>× {{ $itemQty }}</small></div>
                        </td>
                        <td class="text-right">
                            <bdi>{{ number_format($itemSubtotal, 2, '.', ' ') }} {{ $currency }}</bdi>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">В заказе нет позиций.</td>
                    </tr>
                @endforelse
                </tbody>

                <tfoot>
                <tr>
                    <th scope="row">Товаров:</th>
                    <td class="text-right">{{ $totalItems }}</td>
                </tr>
                <tr>
                    <th scope="row">Сумма по товарам:</th>
                    <td class="text-right"><span>{{ number_format($productsTotal, 2, '.', ' ') }} {{ $currency }}</span></td>
                </tr>
                @if(isset($order->shipping) && $order->shipping > 0)
                    <tr>
                        <th scope="row">Доставка:</th>
                        <td class="text-right">{{ number_format($order->shipping, 2, '.', ' ') }} {{ $currency }}</td>
                    </tr>
                @endif
                <tr>
                    <th scope="row">Итого:</th>
                    <td class="text-right">
                        <strong>{{ number_format($orderTotal, 2, '.', ' ') }} {{ $currency }}</strong>
                    </td>
                </tr>
                </tfoot>
            </table>

            <div class="{{$classPrefix}}__customer">
                <h3>Контактные данные</h3>
                <p><strong>Имя:</strong> {{ trim(($order->fname ?? '') . ' ' . ($order->lname ?? '')) ?: '-' }}</p>
                <p><strong>Телефон:</strong> {{ $order->phone ?? '-' }}</p>
                <p><strong>Email:</strong> {{ $order->email ?? '-' }}</p>
            </div>

            <div class="{{$classPrefix}}__actions">
                <a class="btn" href="{{ route('home') }}">Продолжить покупки</a>
            </div>
        </div>
    </div>
</section>
