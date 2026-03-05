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
            <li class="breadcrumb-item active" aria-current="page">Зустрічні пропозиції</li>
        </ol>
    </nav>


    <main class="main page">
        <div class="container">
            <section>
                <div class="row">
                    <div class="col-lg-8">
                        <h2 class="title">Зустрічні пропозиції: <span>{{ count($offers) }}</span></h2>
                    </div>
                    <div class="col-10 offset-2 col-sm-11 offset-sm-1 offset-md-7 col-md-5 offset-lg-1 col-lg-3">
                        <div class="form-group">
                            <svg class="form-icon">
                                <use xlink:href="#icon-filter"></use>
                            </svg>

                            <form class="orderType" action="{{ route('customer::tender.offers.index', ['lang'=>app()->getLocale(), 'order_id'=>$offers[0]->order->id]) }}" method="get">
                                <select class="selectpicker" name="order" data-style="form-control" onchange="this.submit()">
                                    <option value="newer" @if(request()->get('order') == 'newer') selected @endif>Спочатку новіші</option>
                                    <option value="older" @if(request()->get('order') == 'older') selected @endif>Спочатку старіші</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>

                @forelse($offers as $offer)
                    <div class="offer-item @if($offer->status == 'canceled' || (!empty($offer->order->offers_id) && $offer->order->offers_id !== $offer->id)) disabled @endif">
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="offer-plant">
                                    <img class="offer-plant-logo" src="@if(!empty($offer->factory->photo)){{ asset('storage/factory/'.$offer->factory->photo) }}@else{{ asset('img/layout/profile-logo.jpg') }}@endif" alt="">

                                    <div>
                                        <h3 class="heading offer-plant-info">{{ $offer->factory->name }}</h3>
                                        <div class="offer-plant-info"><b>{{ $offer->factory->address }}</b></div>
                                    </div>
                                </div>

                                @if($offer->status == 'canceled' && $offer->canceled_by == 'seller')
                                    <div class="customer_cabinet-item-status" style="height: 36px;">
                                        <svg class="icon">
                                            <use xlink:href="#icon-clock"></use>
                                        </svg>
                                        <b>Продавець відмінив заявку</b>
                                    </div>
                                @elseif($offer->status == 'canceled' && $offer->canceled_by == 'client')
                                    <div class="customer_cabinet-item-status" style="height: 36px;">
                                        <svg class="icon icon-clear">
                                            <use xlink:href="#icon-clear"></use>
                                        </svg>
                                        <b>Покупець відмінив заявку</b>
                                    </div>
                                @elseif($offer->order->status == 'new' && $offer->status == 'new')
                                    <div class="customer_cabinet-item-status" style="height: 36px;">
                                        <svg class="icon">
                                            <use xlink:href="#icon-clock"></use>
                                        </svg>
                                        <b>Очікується підтвердження</b>
                                    </div>
                                @endif
                            </div>
                            <div class="col-sm-6 col-lg-3 order-lg-2 mt-3">
                                <div class="offer-item-option">
                                    <svg class="icon icon-money">
                                        <use xlink:href="#icon-26"></use>
                                    </svg>
                                    <span><b>{{ $offer->price }}</b> грн/м3</span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3 order-lg-2 mt-3">
                                <div class="offer-item-option">
                                    <svg class="icon icon-car">
                                        <use xlink:href="#icon-25"></use>
                                    </svg>
                                    <span>доставка <b class="text-nowrap">{{ $offer->delivery }} грн</b></span>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="parameters" style="min-height: 180px;">
                                    <div class="row">
                                        @include('frontend.catalog._partials.parameters', ['product'=>$offer])
                                    </div>
                                </div>

                            </div>
                            @if($offer->status !== 'canceled')
                                <div class="col-sm-6 order-lg-2  @if($offer->order->status !== 'new' && $offer->order->status !== 'accepted') col-lg-3 offset-lg-3 @else col-lg-6 @endif">
                                    <div class="row">
                                        <div class="@if($offer->order->status == 'new' || $offer->order->status == 'accepted') col-6 @else col-12 @endif">
                                            @if($offer->order->status == 'new')
                                                <a class="btn btn-default" href="#" data-toggle="modal" data-target="#modalOffer{{ $offer->id }}">Переглянути</a>
                                            @else
                                                <a class="btn btn-default" href="{{ route('customer::tender.offer.view', ['lang'=>app()->getLocale(), 'offer_id'=>$offer->id]) }}">Переглянути</a>
                                            @endif
                                        </div>
                                        @if($offer->order->status == 'new' || $offer->order->status == 'accepted')
                                            <div class="col-6">
                                                @if($offer->order->is_tender == 0)
                                                    <a class="btn btn-border_dark" href="#" data-href="{{ route('customer::tender.offer.canceled', ['lang'=>app()->getLocale(), 'offer_id'=>$offer->id, 'is_tender'=>0]) }}" data-toggle="modal" data-target="#confirm-canceled">Скасувати</a>
                                                @else
                                                    <a class="btn btn-border_dark" href="#" data-href="{{ route('customer::tender.offer.canceled', ['lang'=>app()->getLocale(), 'offer_id'=>$offer->id, 'is_tender'=>1]) }}" data-toggle="modal" data-target="#confirm-canceled">Скасувати</a>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal fade modal" tabindex="-1" id="modalOffer{{ $offer->id }}">
                        <div class="modal-dialog modal-dialog-centered modal-offer">
                            <div class="modal-content">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <svg>
                                        <use xlink:href="#icon-5"></use>
                                    </svg>
                                </button>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="leftside">
                                            <div class="offer-plant">
                                                <img class="offer-plant-logo offer-plant-logo--small" src="@if(!empty($offer->factory->photo)){{ asset('storage/factory/'.$offer->factory->photo) }}@else{{ asset('img/layout/profile-logo.jpg') }}@endif" alt="">

                                                <div>
                                                    <h3 class="heading offer-plant-info">{{ $offer->factory->name }}</h3>
                                                    <div class="offer-plant-info"><b>{{ $offer->factory->arrdess }}</b>
                                                    </div>
                                                    @if(Auth::guard('client')->check())
                                                        <a href="{{ route('customer::catalog.view', ['lang'=>app()->getLocale(), 'factory_id'=>$offer->factory->id]) }}" class="btn btn-icon btn-line">
                                                    @else
                                                        <a href="{{ route('frontend::catalog.view', ['lang'=>app()->getLocale(), 'factory_id'=>$offer->factory->id]) }}" class="btn btn-icon btn-line">
                                                    @endif
                                                        <span>Профіль</span>
                                                        <svg class="icon">
                                                            <use xlink:href="#icon-28-t"></use>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                            <h3 class="heading heading-price">Вартість:</h3>
                                            <div class="modal-offer-pricelist">
                                                <div class="row">
                                                    <div class="col-6">Вартість за м3:</div>
                                                    </b>
                                                    <div class="col-6 text-right"><b>{{ $offer->price }} грн</b></div>
                                                    <div class="col-6">Количество:</div>
                                                    <div class="col-6 text-right"><b>{{ $offer->order->count }} м3</b>
                                                    </div>
                                                    <div class="col-6">Замовлення:</div>
                                                    <div class="col-6 text-right">
                                                        <b>{{ $offer->price * $offer->order->count }} грн</b></div>
                                                    <div class="col-6">Доставка:</div>
                                                    <div class="col-6 text-right"><b>{{ $offer->delivery }} грн</b>
                                                    </div>
                                                    <div class="col-6"><b>Разом:</b></div>
                                                    <div class="col-6 text-right">
                                                        <b>{{ ($offer->price * $offer->order->count) + $offer->delivery }} грн</b>
                                                    </div>
                                                </div>
                                            </div>
                                            <a class="btn btn-default" href="{{ route('customer::tender.offer.view', ['lang'=>app()->getLocale(), 'offer_id'=>$offer->id]) }}">@if($offer->order->status == 'new') Мені підходить @else Переглянути @endif</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <h3 class="heading">Усі властивості бетону:</h3>
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
                                                        <span><b>{{ Config::get('product.mark.' . $offer->mark) ?? 'н/в' }}</b></span>
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
                                                        <span><b>{{ Config::get('product.class.' . $offer->class) ?? 'н/в' }}</b></span>
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
                                                        <span><b>{{ Config::get('product.frost_resistance.' . $offer->frost_resistance) ?? 'н/в' }}</b></span>
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
                                                        <span><b>{{ Config::get('product.water_resistance.' . $offer->water_resistance) ?? 'н/в' }}</b></span>
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
                                                        <span><b>{{ Config::get('product.mixture_mobility.' . $offer->mixture_mobility) ?? 'н/в' }}</b></span>
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
                                                        <span><b>{{ Config::get('product.winter_supplement.' . $offer->winter_supplement) ?? 'н/в' }}</b></span>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @empty

                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="offer-empty">
                                <svg class="offer-empty-icon">
                                    <use xlink:href="#icon-noresult"></use>
                                </svg>
                                <div>
                                    <b>Поки жоден продавець не відгукнувся</b>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforelse


                {{ $offers->withQueryString()->links('pagination/default') }}

            </section>
        </div>
    </main>



@endsection
