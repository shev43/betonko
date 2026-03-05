@extends('layouts.app')

@section('content')
    <nav class="container mt-3" aria-label="breadcrumb">
        <ol class="breadcrumb">
            @if(Auth::guard('client')->check())
                <li class="breadcrumb-item"><a href="{{ route('customer::pages.index', ['lang'=>app()->getLocale()]) }}">Головна</a></li>
            @elseif(Auth::guard('business')->check())
                <li class="breadcrumb-item"><a href="{{ route('business::pages.index', ['lang'=>app()->getLocale()]) }}">Головна</a></li>
            @else
                <li class="breadcrumb-item"><a href="{{ route('frontend::pages.index', ['lang'=>app()->getLocale()]) }}">Головна</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">Тендери</li>
        </ol>
    </nav>

    <main class="main page">
        <div class="container">


            @if(Session::has( 'offer_details_status_accepted' ) || Session::has( 'offer_details_status_new' ))
                <div id="offer_details_status" class="offer_details-status">
                    <div class="offer_details-status-icon">
                        <svg class="icon">
                            <use xlink:href="#icon-clock"></use>
                        </svg>
                    </div>
                    <div class="offer_details-status-body">
                        <h3 class="heading">Продавець отримав ваше замовлення</h3>
                        <div class="offer_details-status-text">Скоро з вами зв’яжуться для уточнення деталей замовлення та доставки, очікуйте</div>
                    </div>
                </div>
            @endif


            @if(Session::has( 'offer_details_status_canceled' ))
                <div id="offer_details_status" class="offer_details-status">
                    <div class="offer_details-status-icon">
                        <svg class="icon">
                            <use xlink:href="#icon-clear"></use>
                        </svg>
                    </div>
                    <div class="offer_details-status-body">
                        <h3 class="heading">Вашу заявку успішно скасовано</h3>
                    </div>
                </div>
            @endif

            <section>
                <div class="row">
                    <div class="col-lg-9">
                        <h2 class="title">Створені тендери:</h2>
                    </div>

                    <div class="col-12 col-lg-3 text-right">
                        <div class="form-group">
                            <svg class="form-icon">
                                <use xlink:href="#icon-filter"></use>
                            </svg>

                            <form class="orderType" action="{{ route('customer::tender.index', ['lang'=>app()->getLocale()]) }}" method="get">
                                <select class="selectpicker" name="order" data-style="form-control" onchange="this.submit()">
                                    <option value="newer" @if(request()->get('order') == 'newer') selected @endif>Спочатку новіші</option>
                                    <option value="older" @if(request()->get('order') == 'older') selected @endif>Спочатку старіші</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-right">
                        <a class="btn btn-default" href="{{ route('customer::tender.create', ['lang'=>app()->getLocale()]) }}">Створити тендер</a>
                    </div>
                </div>
                <div class="customer_cabinet-list">

                    @forelse($orders as $order_key =>$order)
                        <div class="customer_cabinet-item @if($order->status == 'canceled' || $order->end_date_of_delivery < \Carbon\Carbon::now()) disabled @endif">
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="row customer_cabinet-item-info">
                                        <div class="col-sm-6">
                                            <b>@if($order->is_tender == 1) Тендер @else Заявка @endif #{{ $order->order_number }}</b>
                                        </div>
                                        <div class="col-sm-6"><b>{{ $order->count }} м3</b></div>
                                        <div class="col-sm-6">
                                            @if($order->start_date_of_delivery == $order->end_date_of_delivery)
                                                {{ \Carbon\Carbon::parse($order->start_date_of_delivery)->format('d.m.Y') }}
                                            @else
                                                {{ \Carbon\Carbon::parse($order->start_date_of_delivery)->format('d.m.Y') }} - {{ \Carbon\Carbon::parse($order->end_date_of_delivery)->format('d.m.Y') }}

                                            @endif
                                        </div>
                                        <div class="col-sm-6">@if($order->type_of_delivery == 'business') Доставка @else Самовивіз @endif</div>
                                    </div>

{{--{{ dd($order->offers[0]) }}--}}
                                    @if($order->is_tender == 1 && $order->status == 'new' && $order->end_date_of_delivery >= \Carbon\Carbon::now())

                                        <div class="seller_cabinet-timer-small">
                                            <div class="timer">
                                                <div class="timer__items">
                                                    <div id="timer__days{{ $order->id }}" class="timer__item timer__days">00</div>
                                                    <div id="timer__hours{{ $order->id }}" class="timer__item timer__hours">00</div>
                                                    <div id="timer__minutes{{ $order->id }}" class="timer__item timer__minutes">00</div>
                                                    <div id="timer__seconds{{ $order->id }}" class="timer__item timer__seconds">00</div>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function () {
                                                // конечная дата
                                                let timestamp{{ $order->id }} = Date.parse('{{ $order->end_date_of_delivery }}');
                                                const deadline{{ $order->id }} = new Date(timestamp{{ $order->id }});

                                                // id таймера
                                                let timerId{{ $order->id }} = null;

                                                // склонение числительных
                                                function declensionNum{{ $order->id }}(num{{ $order->id }}, words{{ $order->id }}) {
                                                    return words{{ $order->id }}[(num{{ $order->id }} % 100 > 4 && num{{ $order->id }} % 100 < 20) ? 2 : [2, 0, 1, 1, 1, 2][(num{{ $order->id }} % 10 < 5) ? num{{ $order->id }} % 10 : 5]];
                                                }

                                                // вычисляем разницу дат и устанавливаем оставшееся времени в качестве содержимого элементов
                                                function countdownTimer{{ $order->id }}() {
                                                    const diff{{ $order->id }} = deadline{{ $order->id }} - new Date();
                                                    if (diff{{ $order->id }} <= 0) {
                                                        clearInterval(timerId{{ $order->id }});
                                                    }
                                                    const days{{ $order->id }} = diff{{ $order->id }} > 0 ? Math.floor(diff{{ $order->id }} / 1000 / 60 / 60 / 24) : 0;
                                                    const hours{{ $order->id }} = diff{{ $order->id }} > 0 ? Math.floor(diff{{ $order->id }} / 1000 / 60 / 60) % 24 : 0;
                                                    const minutes{{ $order->id }} = diff{{ $order->id }} > 0 ? Math.floor(diff{{ $order->id }} / 1000 / 60) % 60 : 0;
                                                    const seconds{{ $order->id }} = diff{{ $order->id }} > 0 ? Math.floor(diff{{ $order->id }} / 1000) % 60 : 0;
                                                    $days{{ $order->id }}.textContent = days{{ $order->id }} < 10 ? '0' + days{{ $order->id }} : days{{ $order->id }};
                                                    $hours{{ $order->id }}.textContent = hours{{ $order->id }} < 10 ? '0' + hours{{ $order->id }} : hours{{ $order->id }};
                                                    $minutes{{ $order->id }}.textContent = minutes{{ $order->id }} < 10 ? '0' + minutes{{ $order->id }} : minutes{{ $order->id }};
                                                    $seconds{{ $order->id }}.textContent = seconds{{ $order->id }} < 10 ? '0' + seconds{{ $order->id }} : seconds{{ $order->id }};
                                                    $days{{ $order->id }}.dataset.title = declensionNum{{ $order->id }}(days{{ $order->id }}, ['день', 'дня', 'дней']);
                                                    $hours{{ $order->id }}.dataset.title = declensionNum{{ $order->id }}(hours{{ $order->id }}, ['час', 'часа', 'часов']);
                                                    $minutes{{ $order->id }}.dataset.title = declensionNum{{ $order->id }}(minutes{{ $order->id }}, ['минута', 'минуты', 'минут']);
                                                    $seconds{{ $order->id }}.dataset.title = declensionNum{{ $order->id }}(seconds{{ $order->id }}, ['секунда', 'секунды', 'секунд']);
                                                }

                                                // получаем элементы, содержащие компоненты даты
                                                const $days{{ $order->id }} = document.querySelector('#timer__days{{ $order->id }}');
                                                const $hours{{ $order->id }} = document.querySelector('#timer__hours{{ $order->id }}');
                                                const $minutes{{ $order->id }} = document.querySelector('#timer__minutes{{ $order->id }}');
                                                const $seconds{{ $order->id }} = document.querySelector('#timer__seconds{{ $order->id }}');
                                                // вызываем функцию countdownTimer
                                                countdownTimer{{ $order->id }}();
                                                // вызываем функцию countdownTimer каждую секунду
                                                timerId{{ $order->id }} = setInterval(countdownTimer{{ $order->id }}, 1000);
                                            });
                                        </script>

                                    @endif


                                    @if($order->end_date_of_delivery >= \Carbon\Carbon::now())


                                        @if(count($order->offers) > 0)
                                                @if($order->status == 'accepted')
                                                    <div class="customer_cabinet-item-status" style="height: 36px;">
                                                        <svg class="icon">
                                                            <use xlink:href="#icon-clock"></use>
                                                        </svg>
                                                        <b>Заявка подана</b>
                                                    </div>
                                                @elseif($order->status == 'executed')
                                                    <div class="customer_cabinet-item-status" style="height: 36px;">
                                                        <svg class="icon">
                                                            <use xlink:href="#icon-25"></use>
                                                        </svg>
                                                        <b>Виконується</b>
                                                    </div>
                                                @elseif($order->status == 'done')
                                                    <div class="customer_cabinet-item-status" style="height: 36px;">
                                                        <svg class="icon">
                                                            <use xlink:href="#icon-check"></use>
                                                        </svg>
                                                        <b>Виконано</b>
                                                    </div>
                                                @elseif($order->status == 'canceled')
                                                    <div class="customer_cabinet-item-status" style="height: 36px;">
                                                        <svg class="icon icon-clear">
                                                            <use xlink:href="#icon-clear"></use>
                                                        </svg>
                                                        <b>Покупець відмінив заявку</b>
                                                    </div>
                                                @endif
                                        @else
                                            @if($order->status == 'new')
                                                <div class="customer_cabinet-item-status" style="height: 36px;">
                                                    <svg class="icon">
                                                        <use xlink:href="#icon-clock"></use>
                                                    </svg>
                                                    <b>Очікується підтвердження</b>
                                                </div>
                                            @else
                                                <div class="customer_cabinet-item-status" style="height: 36px;">
                                                    <svg class="icon icon-clear">
                                                        <use xlink:href="#icon-clear"></use>
                                                    </svg>
                                                    <b>Відмінено</b>
                                                </div>
                                            @endif

                                        @endif

                                    @else
                                        <div class="customer_cabinet-item-status" style="height: 36px;">
                                            <svg class="icon icon-clear">
                                                <use xlink:href="#icon-clear"></use>
                                            </svg>
                                            <strong>Вийшов час підтвердження</strong>
                                        </div>
                                    @endif

                                    @if($order->status !== 'canceled' && count($order->offers) > 0)
                                        <div class="customer_cabinet-item-status mt-4">
                                            @if($order->status == 'new' && $order->offers_id == null && count($order->active_offers) > 0)
                                                <a href="{{ route('customer::tender.offers.index', ['lang'=>app()->getLocale(), 'order_id'=>$order->id ]) }}" class="btn btn-default customer_cabinet-item-btn">
                                                    <span>{{ count($order->active_offers) }} пропозицій</span>
                                                </a>
                                            @else
{{--                                                @if($order->status == 'new')--}}
                                                    <a href="{{ route('customer::tender.offers.index', ['lang'=>app()->getLocale(), 'order_id'=>$order->id ]) }}" class="btn btn-default customer_cabinet-item-btn">
                                                        <span>Детальніше</span>
                                                    </a>
{{--                                                @else--}}
{{--                                                    <a href="{{ route('customer::tender.offer.view', ['lang'=>app()->getLocale(), 'offer_id'=>$order->offers_id ]) }}" class="btn btn-default customer_cabinet-item-btn">--}}
{{--                                                        <span>Детальніше</span>--}}
{{--                                                    </a>--}}
{{--                                                @endif--}}

                                            @endif

                                        </div>
                                    @endif


                                </div>
                                <div class="col-lg-7">
                                    <div class="parameters">
                                        <div class="row">
                                            @include('frontend.catalog._partials.parameters', ['product'=>$order])
                                        </div>

                                        <div class="position-absolute" style="bottom: 15px;left: 35px;">
                                            <div class="mt-2 mb-2"><a class="" href="{{ route('customer::tender.create-duplicate', ['lang'=>app()->getLocale(), 'order_id'=>$order->id]) }}">
                                                    <svg class="icon">
                                                        <use xlink:href="#icon-25"></use>
                                                    </svg>
                                                    <span class="ml-2"><strong>Замовити знову</strong></span>
                                                </a>
                                            </div>
                                        </div>
                                        @if($order->status == 'new')
                                            <div class="position-absolute" style="bottom: 15px;right: 15px;">
                                                <button class="btn btn-line btn-fill" href="#" data-href="{{ route('customer::tender.canceled', ['lang'=>app()->getLocale(), 'order_id'=>$order->id]) }}" data-toggle="modal" data-target="#confirm-canceled">
                                                    <svg class="icon">
                                                        <use xlink:href="#icon-clear"></use>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="row justify-content-center" style="margin-top: 60px;">
                            <div class="col-md-8">
                                <div class="offer-empty">
                                    <svg class="offer-empty-icon">
                                        <use xlink:href="#icon-noresult"></use>
                                    </svg>
                                    <div>
                                        <p>Заявок які би задовільняли критерії Вашої продукції не знайдено</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforelse

                </div>

                {{ $orders->withQueryString()->links('pagination/default') }}

            </section>
        </div>
    </main>
@endsection
