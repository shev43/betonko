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
            <li class="breadcrumb-item"><a href="{{ route('customer::request.index', ['lang'=>app()->getLocale()]) }}">Заявки</a></li>
            <li class="breadcrumb-item active" aria-current="page">Замовлення</li>
        </ol>
    </nav>

    <main class="main page">
        <div class="container">
            <section class="offer_details">
                @if($offer->order->status == 'accepted')
                    <div class="offer_details-status">
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

                @if($offer->order->status == 'executed')
                    <div class="offer_details-status">
                        <div class="offer_details-status-icon">
                            <svg class="icon icon-car">
                                <use xlink:href="#icon-25"></use>
                            </svg>
                        </div>
                        <div class="offer_details-status-body">
                            <h3 class="heading">Замовлення доставляється</h3>
                            <div class="offer_details-status-text">Водій зв’яжеться з вами коли буде на місці, очікуйте. Його контакти ви можете отримати у продавця</div>
                        </div>
                    </div>
                @endif

                @if($offer->order->status == 'done')
                    <div class="offer_details-status">
                        <div class="offer_details-status-icon">
                            <svg class="icon">
                                <use xlink:href="#icon-check"></use>
                            </svg>
                        </div>
                        <div class="offer_details-status-body">
                            <h3 class="heading">Замовлення виконано</h3>
                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="col-12 col-lg-5">
                        <h2 class="title">Продавець:</h2>
                        <div class="row offer-plant">
                            <div class="col-4">
                                <img class="offer-plant-logo offer-plant-logo--small" src="@if(!empty($offer->product->factory->photo)){{ asset('storage/factory/'.$offer->product->factory->photo) }}@else{{ asset('img/layout/profile-logo.jpg') }}@endif" alt="">
                            </div>
                            <div class="col-8">
                                <h3 class="title offer-plant-info">{{ $offer->factory->name }}</h3>
                            </div>
                            <div class="col-12 mt-3 ">
                                <div class="offer-plant-info">
                                    <strong>{{ $offer->factory->address }}</strong>
                                </div>
                                <div class="offer-plant-info">
                                    <strong>Підприємство:</strong>
                                    @if(Auth::guard('client')->check())
                                        <a href="{{ route('customer::company.view', ['lang'=>app()->getLocale(), 'company_id'=>$offer->factory->business->id]) }}">{{ $offer->factory->business->name }}</a>
                                    @else
                                        <a href="{{ route('frontend::company.view', ['lang'=>app()->getLocale(), 'company_id'=>$offer->factory->business->id]) }}">{{ $offer->factory->business->name }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-7">
                        <h2 class="title">Статус замовлення:</h2>
                        @if($offer->status !== 'canceled')
                            @if($offer->order->end_date_of_delivery >= \Carbon\Carbon::now())
                                <div class="seller_cabinet-status">
                                    <div @if($offer->order->status == 'accepted' || $offer->order->status == 'executed' || $offer->order->status == 'done') class="ready" @endif>Прийнято</div>
                                    <div @if($offer->order->status == 'executed' || $offer->order->status == 'done') class="ready" @endif>Виконується</div>
                                    <div @if($offer->order->status == 'done') class="ready" @endif>Виконано</div>
                                </div>

                                @if($offer->order->is_tender == 1 && $offer->order->status == 'new')
                                    <div class="seller_cabinet-timer">
                                        <div class="timer">
                                            <div class="timer__items">
                                                <div class="timer__item timer__days">00</div>
                                                <div class="timer__item timer__hours">00</div>
                                                <div class="timer__item timer__minutes">00</div>
                                                <div class="timer__item timer__seconds">00</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="seller_cabinet-status_canceled">
                                    <strong>Скасовано</strong> (вийшов час підтвердження)
                                </div>
                            @endif
                        @else
                            @if($offer->canceled_by == 'client')
                                <div class="seller_cabinet-status_canceled">
                                    <strong>Скасована покупцем</strong> ({{ $offer->canceled_comment }})
                                </div>

                            @elseif($offer->canceled_by == 'seller')
                                <div class="seller_cabinet-status_canceled">
                                    <strong>Скасована продавцем</strong> ({{ $offer->canceled_comment }})
                                </div>
                            @else
                                <div class="seller_cabinet-status_canceled">
                                    <strong>Скасована</strong> (вийшов час підтвердження)
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                <h2 class="title mt-5">Контактна особа:</h2>
                <div class="row">
                    @php($expFactoryContacts = explode(',', $offer->factory->contacts_id))
                    @foreach($offer->factory->contacts as $contact)
                        @foreach($expFactoryContacts as $factoryContacts)
                            @if($contact->id == $factoryContacts)
                                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                    @include('frontend.catalog._partials.contacts', ['contact'=>$contact])
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                </div>
                <hr class="divider">
                <div class="row">
                    <div class="col-md-6 col-xl-4">
                        <h2 class="title">Властивості бетону:</h2>
                        <div class="properties">
                            <table>
                                <tbody>
                                <tr>
                                    <td>
                                        <svg class="icon icon-type icon-model">
                                            <use xlink:href="#icon-15"></use>
                                        </svg>
                                    </td>
                                    <td>Марка</td>
                                    <td>
                                        <span><b>{{ Config::get('product.mark.' . $offer->order->mark) ?? 'н/в' }}</b></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <svg class="icon icon-type icon-class">
                                            <use xlink:href="#icon-16"></use>
                                        </svg>
                                    </td>
                                    <td>Клас</td>
                                    <td>
                                        <span><b>{{ Config::get('product.class.' . $offer->order->class) ?? 'н/в' }}</b></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <svg class="icon icon-type icon-frost">
                                            <use xlink:href="#icon-17"></use>
                                        </svg>
                                    </td>
                                    <td>Морозостійкість</td>
                                    <td>
                                        <span><b>{{ Config::get('product.frost_resistance.' . $offer->order->frost_resistance) ?? 'н/в' }}</b></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <svg class="icon icon-type icon-water">
                                            <use xlink:href="#icon-18"></use>
                                        </svg>
                                    </td>
                                    <td>Водостійкість</td>
                                    <td>
                                        <span><b>{{ Config::get('product.water_resistance.' . $offer->order->water_resistance) ?? 'н/в' }}</b></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <svg class="icon icon-type icon-mobility">
                                            <use xlink:href="#icon-19"></use>
                                        </svg>
                                    </td>
                                    <td>Рухливість суміші</td>
                                    <td>
                                        <span><b>{{ Config::get('product.mixture_mobility.' . $offer->order->mixture_mobility) ?? 'н/в' }}</b></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <svg class="icon icon-type icon-winter">
                                            <use xlink:href="#icon-20"></use>
                                        </svg>
                                    </td>
                                    <td>Зимові добавки</td>
                                    <td>
                                        <span><b>{{ Config::get('product.winter_supplement.' . $offer->order->winter_supplement) ?? 'н/в' }}</b></span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6 offset-xl-2">
                        <h2 class="title">Доставка:</h2>
                        <div class="seller_cabinet-addr">
                            <div><b>{{ $offer->order->address }}</b></div>
                            <div>
                                @if($offer->order->start_date_of_delivery == $offer->order->end_date_of_delivery)
                                    <b>{{ \Carbon\Carbon::parse($offer->order->start_date_of_delivery)->format('d.m.Y') }}</b>
                                @else
                                    <b>{{ \Carbon\Carbon::parse($offer->order->start_date_of_delivery)->format('d.m.Y') }}</b> -
                                    <b>{{ \Carbon\Carbon::parse($offer->order->end_date_of_delivery)->format('d.m.Y') }}</b>
                                @endif
                            </div>
                        </div>
                        @include('frontend._modules.map-view', ['objects'=>[$offer->order]])

                    </div>
                </div>

                @if($offer->order->comment)
                    <section>
                        <h2 class="title">Коментар до замовлення:</h2>
                        <div>
                            {{ $offer->order->comment }}
                        </div>
                    </section>
                @endif

                <section>
                    <h2 class="title">Вартість:</h2>
                    <div class="row">
                        <div class="col-6 col-sm-6 col-md-3 col-lg-2">
                            <div class="offer_details-price">
                                <div class="offer_details-price-title">Вартість за м3:</div>
                                <div class="offer_details-price-number">{{ ($offer->price) }} грн</div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-6 col-md-3 col-lg-2">
                            <div class="offer_details-price">
                                <div class="offer_details-price-title">Кількість м3:</div>
                                <div class="offer_details-price-number">{{ $offer->order->count }}</div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-6 col-md-3 col-lg-2">
                            <div class="offer_details-price">
                                <div class="offer_details-price-title">Замовлення:</div>
                                <div class="offer_details-price-number">{{ ($offer->price * $offer->order->count) }} грн</div>
                            </div>
                        </div>
                        <div class="col-6 ol-sm-6 col-md-3 col-lg-2">
                            <div class="offer_details-price">
                                <div class="offer_details-price-title">Доставка:</div>
                                <div class="offer_details-price-number">{{ ($offer->delivery) }} грн</div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-6 col-md-3 col-lg-3">
                            <div class="offer_details-price">
                                <div class="offer_details-price-title">Разом:</div>
                                <div class="offer_details-price-number">
                                    <span>{{ (($offer->price * $offer->order->count) + $offer->delivery) }} грн</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row text-right">
                        <div class="col-6 @if($offer->order->status !== 'new') offset-lg-3 col-lg-6 @else offset-lg-6 col-lg-3 @endif text-right">
                            @if($offer->order->status == 'new')
                                @if($offer->order->is_tender == 0)
                                    <a class="btn btn-default" href="{{ route('customer::request.offer.accept', ['lang'=>app()->getLocale(), 'offer_id'=>$offer->id, 'is_tender'=>0]) }}">Підтвердити</a>
                                @else
                                    <a class="btn btn-default" href="{{ route('customer::tender.offer.accept', ['lang'=>app()->getLocale(), 'offer_id'=>$offer->id, 'is_tender'=>1]) }}">Підтвердити</a>
                                @endif
                            @endif
                        </div>

                        @if($offer->order->status == 'new' || $offer->order->status == 'accepted')
                            <div class="col-6 col-lg-3 text-right">
                                @if($offer->order->is_tender == 0)
                                    <a class="btn btn-border_dark" href="{{ route('customer::request.offer.canceled', ['lang'=>app()->getLocale(), 'offer_id'=>$offer->id, 'is_tender'=>0]) }}">Скасувати</a>
                                @else
                                    <a class="btn btn-border_dark" href="{{ route('customer::tender.offer.canceled', ['lang'=>app()->getLocale(), 'offer_id'=>$offer->id, 'is_tender'=>1]) }}">Скасувати</a>
                                @endif
                            </div>
                        @endif

                    </div>
                </section>

            </section>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // конечная дата
            let timestamp = Date.parse('{{ $offer->order->end_date_of_delivery }}');
            const deadline = new Date(timestamp);
            // id таймера
            let timerId = null;

            // склонение числительных
            function declensionNum(num, words) {
                return words[(num % 100 > 4 && num % 100 < 20) ? 2 : [2, 0, 1, 1, 1, 2][(num % 10 < 5) ? num % 10 : 5]];
            }

            // вычисляем разницу дат и устанавливаем оставшееся времени в качестве содержимого элементов
            function countdownTimer() {
                const diff = deadline - new Date();
                if (diff <= 0) {
                    clearInterval(timerId);
                }
                const days = diff > 0 ? Math.floor(diff / 1000 / 60 / 60 / 24) : 0;
                const hours = diff > 0 ? Math.floor(diff / 1000 / 60 / 60) % 24 : 0;
                const minutes = diff > 0 ? Math.floor(diff / 1000 / 60) % 60 : 0;
                const seconds = diff > 0 ? Math.floor(diff / 1000) % 60 : 0;
                $days.textContent = days < 10 ? '0' + days : days;
                $hours.textContent = hours < 10 ? '0' + hours : hours;
                $minutes.textContent = minutes < 10 ? '0' + minutes : minutes;
                $seconds.textContent = seconds < 10 ? '0' + seconds : seconds;
                $days.dataset.title = declensionNum(days, ['день', 'дня', 'дней']);
                $hours.dataset.title = declensionNum(hours, ['час', 'часа', 'часов']);
                $minutes.dataset.title = declensionNum(minutes, ['минута', 'минуты', 'минут']);
                $seconds.dataset.title = declensionNum(seconds, ['секунда', 'секунды', 'секунд']);
            }

            // получаем элементы, содержащие компоненты даты
            const $days = document.querySelector('.timer__days');
            const $hours = document.querySelector('.timer__hours');
            const $minutes = document.querySelector('.timer__minutes');
            const $seconds = document.querySelector('.timer__seconds');
            // вызываем функцию countdownTimer
            countdownTimer();
            // вызываем функцию countdownTimer каждую секунду
            timerId = setInterval(countdownTimer, 1000);
        });
    </script>
@endsection
