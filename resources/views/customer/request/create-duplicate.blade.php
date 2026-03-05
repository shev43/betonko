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

            @if(Auth::guard('client')->check())
                <li class="breadcrumb-item"><a href="{{ route('customer::request.index', ['lang'=>app()->getLocale()]) }}">Заявки</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">Створення дубліката заявки</li>
        </ol>
    </nav>
    <main class="main page">
        <div class="container">
            <form id="customerRequest" action="{{ route('customer::request.store', ['lang'=>app()->getLocale()]) }}" method="post" class="order-form">
                @csrf
                <input name="is_tender" type="hidden" value="0">
                <input name="seller_id" type="hidden" value="{{ $order->seller_id ?? null }}">
                <input name="factory_id" type="hidden" value="{{ $order->factory_id ?? null }}">
                <input name="mark" type="hidden" value="{{ $order->mark ?? null }}">
                <input name="class" type="hidden" value="{{ $order->class ?? null }}">
                <input name="frost_resistance" type="hidden" value="{{ $order->frost_resistance ?? null }}">
                <input name="water_resistance" type="hidden" value="{{ $order->water_resistance ??  null }}">
                <input name="mixture_mobility" type="hidden" value="{{ $order->mixture_mobility ?? null }}">
                <input name="winter_supplement" type="hidden" value="{{ $order->winter_supplement ?? null }}">

                <section class="order-detail">
                    <div class="row justify-content-between">
                        <div class="col-md-7 col-lg-6">
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
                                            <span><b>{{ Config::get('product.mark.' . $order->mark) }}</b></span>
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
                                            <span><b>{{ Config::get('product.class.' . $order->class) }}</b></span>
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
                                            <span><b>{{ Config::get('product.frost_resistance.' . $order->frost_resistance) }}</b></span>
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
                                            <span><b>{{ Config::get('product.water_resistance.' . $order->water_resistance) }}</b></span>
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
                                            <span><b>{{ Config::get('product.mixture_mobility.' . $order->mixture_mobility) }}</b></span>
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
                                            <span><b>{{ Config::get('product.winter_supplement.' . $order->winter_supplement) }}</b></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="3">
                                            @if($errors->has('mark') || $errors->has('class') || $errors->has('frost_resistance') || $errors->has('water_resistance') || $errors->has('mixture_mobility') || $errors->has('winter_supplement') || $errors->has('brand'))
                                                <div class="error">Параметри містять помилкові дані</div>
                                            @endif
                                                @if(Auth::guard('client')->check())
                                                    <a href="{{route('customer::catalog.index', ['lang'=>app()->getLocale()])}}"
                                                @else
                                                    <a href="{{route('frontend::catalog.index', ['lang'=>app()->getLocale()])}}"
                                                @endif
                                               class="order-edit">
                                                <svg>
                                                    <use xlink:href="#icon-22"></use>
                                                </svg>
                                                <span>Назад</span> </a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <h2 class="title">Деталі заявки:</h2>
                            <div class="order-price">
                                <div class="heading">Ціна за м3:</div>
                                @if (!empty($order))
                                    <div class="title"><span>{{ (int)$order->min_price }}</span> грн.</div>
                                    <input type="hidden" name="min_price" value="{{ intval($order->min_price) }}">
                                    <input type="hidden" name="max_price" value="{{ intval($order->min_price) }}">
                                @else
                                    <div class="range">
                                        <div class="range-slider" data-min="1" data-max="9999"
                                             data-start="100"
                                             data-end="2000"
                                             data-step="1"></div>
                                        <div class="order-price-range">
                                            <input type="text" class="form-control start" id="start" name="min_price"
                                                   value="1"> <span>—</span>
                                            <input type="text" class="form-control end" id="end" name="max_price"
                                                   value="9999">
                                        </div>
                                        @if($errors->has('min_price') || $errors->has('max_price'))
                                            <small class="invalid-feedback d-block">Помилка в числовому діапазоні цін</small>
                                        @endif
                                    </div>
                                @endif
                                <div class="order-price-count">
                                    <div class="heading">Кількість:</div>
                                    <input type="number"
                                           class="form-control"
                                           value="{{old('count', $order->count)}}"
                                           name="count"
                                           min="1"
                                    >
                                    <div class="heading">м3</div>
                                    @if(!$errors->has('count'))
                                        <small class="invalid-feedback d-block"></small>
                                    @endif
                                    @foreach($errors->get('count') as $error)
                                        <small class="invalid-feedback d-block">{!! $error !!}</small>
                                    @endforeach
                                </div>
                                <div class="order-price-total">
                                    <div class="heading">Орієнтовна вартість:</div>
                                    <div class="title">
                                        @if (!empty($order))
                                            <span class="title"
                                                  id="estimated-product-price"
                                                  data-price="{{ $order->min_price }}"
                                            >{{ (int)$order->min_price }}</span> грн.
                                        @else
                                            <span id="price-min"></span> - <span id="price-max"></span> грн
                                        @endif
                                    </div>
                                    *без врахування доставки
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="order-contact">
                    <h2 class="title">Контактні дані:</h2>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="first_name">Ім’я</label>
                                <input type="text" class="form-control" id="first_name" name="contact_first_name"
                                       placeholder="Ім’я"

                                       value="{{old('contact_first_name', (request()->user()->first_name ?? ''))}}">
                                @if(!$errors->has('contact_first_name'))
                                    <small class="invalid-feedback d-block"></small>
                                @endif
                                @foreach($errors->get('first_name') as $error)
                                    <small class="invalid-feedback d-block">{!! $error !!}</small>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="last_name">Прізвище</label>
                                <input type="text" class="form-control" id="last_name" name="contact_last_name"
                                       placeholder="Прізвище"
                                       value="{{old('contact_last_name', (request()->user()->last_name ?? ''))}}">
                                @foreach($errors->get('last_name') as $error)
                                    <small class="invalid-feedback d-block">{!! $error !!}</small>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone">Номер телефону:</label>
                                <input type="text" class="form-control bfh-phone" id="phone"
                                       name="contact_phone" placeholder="+38 xxx xxx-xx-xx"
                                       value="{{old('contact_phone', (request()->user()->phone ?? ''))}}">
                                @if(!$errors->has('contact_phone'))
                                    <small class="invalid-feedback d-block"></small>
                                @endif
                                @foreach($errors->get('contact_phone') as $error)
                                    <small class="invalid-feedback d-block">{!! $error !!}</small>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
                <section class="order-delivery">
                    <h2 class="title">Деталі доставки:</h2>
                    <div class="row">
                        <div class="col-md-6">
                            @include('frontend._modules.map-form', ['objects'=>$order, 'target'=>'form#customerRequest input[name=address]'])
                        </div>
                        <div class="col-lg-4 offset-lg-1 col-md-6">
                            <div class="form-group">
                                <div class="row one-active-checkbox">
                                    <div class="col-6 col-md-12 col-lg-6">
                                        <div class="form-check">
                                            <input class="d-none"
                                                   type="checkbox"
                                                   id="type-self"
                                                   value="self"
                                                   data-field="type_of_delivery"
                                                {{ old('type_of_delivery', $order->type_of_delivery) == 'self' ? 'checked' : '' }}
                                            >
                                            <div class="form-check">
                                                <label for="type-self">
                                                    <svg>
                                                        <use xlink:href="#icon-9"></use>
                                                    </svg>
                                                    <span><b>Самовивіз</b></span> </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-12 col-lg-6">
                                        <input class="d-none"
                                               type="checkbox"
                                               id="type-business"
                                               value="business"
                                               data-field="type_of_delivery"
                                            {{old('type_of_delivery', $order->type_of_delivery) == 'business' ? 'checked' : ''}}
                                        >
                                        <div class="form-check">
                                            <label for="type-business">
                                                <svg>
                                                    <use xlink:href="#icon-9"></use>
                                                </svg>
                                                <span><b>Доставка</b></span> </label>
                                        </div>
                                    </div>
                                    <input type="hidden" name="type_of_delivery" id="type_of_delivery"
                                           value="{{old('type_of_delivery', $order->type_of_delivery)}}">

                                    @foreach($errors->get('type_of_delivery') as $error)
                                        <small class="invalid-feedback d-block">{!! $error !!}</small>
                                    @endforeach
                                </div>
                                <div class="form-help">*у випадку самовивозу необхідно мати власний транспорт</div>
                            </div>
                            <div class="form-group address-block {{old('type_of_delivery', $order->type_of_delivery) == 'self' ? 'disabled' : ''}}">
                                <label for="address">Адреса доставки</label>
                                <input type="text" class="form-control autocomplete {{$errors->has('address') ? 'alert-danger' : ''}}"
                                       id="address" name="address" placeholder="Адрес доставки продукції"
                                       value="{{ old('address', $order->address) ?? request()->user()->address }}"
                                    {{old('type_of_delivery', $order->type_of_delivery) == 'self' ? 'disabled' : ''}}
                                    {{old('type_of_delivery', $order->type_of_delivery) == 'self' ? '' : ' required'}}
                                >

                                @if(!$errors->has('address'))
                                    <small class="invalid-feedback d-block"></small>
                                @endif

                                @foreach($errors->get('address') as $error)
                                    <small class="invalid-feedback d-block">{!! $error !!}</small>
                                @endforeach

                            </div>
                            <div class="form-group">
                                <label for="exampleOrder7">Бажана дата доставки</label>
                                <div class="form-date" data-toggle="modal" data-target="#dataModal">
                                    <input type="text" class="form-control" id="exampleOrder7" name="date_of_delivery"
                                           value="{{old('date_of_delivery', \Carbon\Carbon::now()->addDays(7)->format('d.m.Y'))}}" readonly required>
                                    <svg>
                                        <use xlink:href="#icon-23"></use>
                                    </svg>
                                </div>
                                @foreach($errors->get('date_of_delivery') as $error)
                                    <small class="invalid-feedback d-block">{!! $error !!}</small>
                                @endforeach
                                @foreach($errors->get('start_date_of_delivery') as $error)
                                    <small class="invalid-feedback d-block">{!! $error !!}</small>
                                @endforeach
                                @foreach($errors->get('end_date_of_delivery') as $error)
                                    <small class="invalid-feedback d-block">{!! $error !!}</small>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Коментар до замовлення:</label>
                        <input type="text" class="form-control" value="{{old('comment', '')}}" name="comment">
                        @foreach($errors->get('comment') as $error)
                            <small class="invalid-feedback d-block">{!! $error !!}</small>
                        @endforeach

                    </div>
                </section>
                <div class="text-center">
                    <button type="submit" class="btn btn-default">Оформити заявку
                    </button>
                </div>
            </form>
        </div>
    </main>

    <div class="modal auth fade" tabindex="-1" id="dataModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg>
                        <use xlink:href="#icon-5"></use>
                    </svg>
                </button>
                <h3 class="heading">Дата доставки</h3>
                <div class="datepickerStatic">
                    <div class="datepickerStaticBody"></div>
                    <input type="hidden" class="datepickerStaticValue" value="{{ \Carbon\Carbon::now()->addDays(7)->format('d.m.Y') }}">
                </div>
                <div class="modal-inner auth-inner">
                    <div class="form-group">
                        <a href="#" class="btn btn-default select-date" data-dismiss="modal"
                           aria-label="Close">Вибрати</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .mapboxgl-marker {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            border: 1px solid gray;
            background-color: lightblue;
        }
    </style>
@stop

@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?language=uk-UK&key={{ (env('APP_DEBUG') == true) ? env('GOOGLE_API_KEY_TEST') : env('GOOGLE_API_KEY_PRODUCTION') }}&libraries=places"></script>

    <script>
        jQuery(function($) {
            google.maps.event.addDomListener(window, 'load', buildAutocomplete());
        });
    </script>

@endsection
