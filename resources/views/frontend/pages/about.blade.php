@extends('layouts.app')

@section('content')
    <nav class="container mt-3" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('frontend::pages.index', ['lang'=>app()->getLocale()]) }}">Головна</a></li>
            <li class="breadcrumb-item active" aria-current="page">Про нас</li>
        </ol>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>Про нас</h3>
                <p style="color: #868686"><i>Декілька слів про нас і проект</i></p>

                <p>Ми команда ентузіастів, нашою метою є цифровий розвиток української сфери будівництва. Розробка сервісів та платформ для покращення та полегшення роботи будівництва, відновлення української інфраструктури. Наші проекти беруть свій початок з 2020 року та сьогодні як ніколи стають актуальними. Цифровий розвиток будівництва автоматизовує та пришвидшує всі процеси, що збільшує обороти та коефіцієнт виробничої здатності, а це в свою чергу зміцнює бізнес та економіку України.</p>
                <p>Betonko - це інформаційний портал для купівлі/продажу бетону в межах цілої країни. Покупець отримує найкращу пропозицію відносно ціни та відстані бетонного заводу. Продавець отримує можливості показати повний асортимент, продавати більше, запропонувати свої продукти більшій кількості потенційних клієнтів. Це в першу чергу про більшу доступність інформації та полегшення процедури пошуку необхідних ресурсів, контакту та самого замовлення.</p>
                <p>Маємо надію що користувачі знайдуть для себе наш проект корисним і разом ми зможемо відбудувати нашу країну!</p>
                <p>Слава Україні! ❤️🇺🇦</p>

                <div class="about-page">
                    @if(Auth::guard('client')->check())
                        <a href="{{ route('customer::pages.index', ['lang'=>app()->getLocale()]) }}">
                            @include('frontend._modules.logo')
                        </a>
                    @elseif(Auth::guard('business')->check())
                        <a href="{{ route('business::pages.index', ['lang'=>app()->getLocale()]) }}">
                            @include('frontend._modules.logo')
                        </a>
                    @else
                        <a href="{{ route('frontend::pages.index', ['lang'=>app()->getLocale()]) }}">
                            @include('frontend._modules.logo')
                        </a>
                    @endif
                </div>
            </div>
        </div>

    </div>
@stop
