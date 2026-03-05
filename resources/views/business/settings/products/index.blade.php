@extends('layouts.app')

@section('content')
    <main class="main page">
        <div class="container">
            <section>
                <div class="row">
                    <div class="col-12 col-sm-12 col-lg-12">
                        @include('business.settings._partials.navbar')
                    </div>
                </div>
            </section>

            <section class="seller_cabinet-settings-persons">
                <h2 class="title text-center">Налаштування продуктів</h2>

                <div class="row justify-content-center">
                    <div class="col-lg-6 d-flex">
                        <a class="seller_cabinet-selection" href="{{ route('business::setting.product.create', ['lang'=>app()->getLocale()]) }}">
                            <svg class="icon">
                                <use xlink:href="#icon-plus"></use>
                            </svg>
                            <span>
                                Додати
                            </span> </a>
                    </div>

                    @foreach($products as $product)
                        <div class="col-lg-6">
                            <div class="parameters">
                                <div class="row" style="min-height: 165px;">
                                    <div class="col-sm-6 col-md-4">
                                        <div class="parameters-item">
                                            <svg class="icon icon-type icon-model">
                                                <use xlink:href="#icon-15"></use>
                                            </svg>
                                            <span><b>{{ Config::get('product.mark.' . $product->mark) }}</b></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="parameters-item">
                                            <svg class="icon icon-type icon-class">
                                                <use xlink:href="#icon-16"></use>
                                            </svg>
                                            <span><b>{{ Config::get('product.class.' . $product->class) }}</b></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="parameters-item">
                                            <svg class="icon icon-type icon-frost">
                                                <use xlink:href="#icon-17"></use>
                                            </svg>
                                            <span><b>{{ Config::get('product.frost_resistance.' . $product->frost_resistance) }}</b></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="parameters-item">
                                            <svg class="icon icon-type icon-water">
                                                <use xlink:href="#icon-18"></use>
                                            </svg>
                                            <span><b>{{ Config::get('product.water_resistance.' . $product->water_resistance) }}</b></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="parameters-item">
                                            <svg class="icon icon-type icon-mobility">
                                                <use xlink:href="#icon-19"></use>
                                            </svg>
                                            <span><b>{{ Config::get('product.mixture_mobility.' . $product->mixture_mobility) }}</b></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="parameters-item">
                                            <svg class="icon icon-type icon-winter">
                                                <use xlink:href="#icon-20"></use>
                                            </svg>
                                            <span><b>{{ Config::get('product.winter_supplement.' . $product->winter_supplement) }}</b></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="parameters-item">
                                            <svg class="icon icon-type icon-money">
                                                <use xlink:href="#icon-26"></use>
                                            </svg>
                                            <span><b>{{ ($product->price) }} грн/м3</b></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 d-flex align-items-center justify-content-end">
                                        <a class="edit" href="{{ route('business::setting.product.edit', ['lang'=>app()->getLocale(), 'product_id'=>$product->id]) }}">
                                            <svg class="icon">
                                                <use xlink:href="#icon-edit"></use>
                                            </svg>
                                        </a>

                                        <a class="delete" href="#" data-href="{{ route('business::setting.product.destroy', ['lang'=>app()->getLocale(), 'product_id'=>$product->id]) }}" data-toggle="modal" data-target="#confirm-delete">
                                            <svg class="icon">
                                                <use xlink:href="#icon-clear"></use>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

                {{ $products->withQueryString()->links('pagination/default') }}

            </section>

        </div>
    </main>

@endsection
