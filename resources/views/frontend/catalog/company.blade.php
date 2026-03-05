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
                <li class="breadcrumb-item"><a href="{{ route('customer::catalog.index', ['lang'=>app()->getLocale()]) }}">Каталог</a></li>
            @else
                <li class="breadcrumb-item"><a href="{{ route('frontend::catalog.index', ['lang'=>app()->getLocale()]) }}">Каталог</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{$business->name}}</li>
        </ol>
    </nav>

    <div class="container">
        <section class="seller_profile-info">
            <div class="row justify-content-between align-items-center">
                <div class="col-12 col-lg-6">
                    <div class="row align-items-center seller_profile-info-top">
                        <div class="col-4 col-md-3">
                            <div class="seller_profile-logo-1">
                                <img src="@if(!empty($business->photo)){{ asset('storage/business/'.$business->photo) }}@else{{ asset('img/layout/profile-logo.jpg') }}@endif" alt="">
                            </div>
                        </div>
                        <div class="col-8 col-md-9">
                            <h2 class="title">{{ $business->name }}</h2>
                        </div>

                        <div class="col-12 seller_profile-contact">{{ $business->address }}</div>

                    </div>

                </div>
                <div class="col-12 col-lg-6 contact-info align-self-start justify-content-end">
                    @if(!empty($business->email))
                        <div>
                            <a class="btn-action-email" href="mailto:{{$business->email}}">
                                <svg class="icon icon-email technic_item-icon">
                                    <use xlink:href="#icon-11"></use>
                                </svg>
                            </a>
                        </div>
                    @endif

                    @if(!empty($business->phone))
                        <div>
                            <a class="btn-action-phone" href="tel:{{ $business->phone }}">
                                <svg class="icon technic_item-icon icon-phone">
                                    <use xlink:href="#icon-phone"></use>
                                </svg>
                            </a>
                        </div>
                    @endif

                    @if(!empty($business->www))
                        <div>
                            <a class="btn-action-www" href="{{ $business->www }}" target="_blank">
                                <svg class="icon technic_item-icon icon-www">
                                    <use xlink:href="#icon-language-box"></use>
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        @if(!empty($business->factories))
            <section class="seller_profile-factories">
                <h2 class="title">Заводи:</h2>
                <div class="row">
                    @forelse($business->factories as $factory)
                        <div class="col-12 col-lg-6">
                            @include('frontend.catalog._partials.factories', ['factory'=>$factory])
                        </div>
                    @empty
                        <p>Не вказано</p>
                    @endforelse
                </div>
            </section>
        @endif

        @if(!empty($business->contacts))
            <section class="seller_profile-persons">
                <h2 class="title">Контактні особи:</h2>
                <div class="row">

                    @forelse($business->contacts as $contact)
                        <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                            @include('frontend.catalog._partials.contacts', ['contact1'=>$contact])
                        </div>
                    @empty
                        <p>Не вказано</p>
                    @endforelse
                </div>
            </section>
        @endif

        @if(!empty($business->products))
            <section class="seller_profile-products">
                <h2 class="title">Продукція:</h2>
                <div class="row">
                    @forelse($business->products as $product)
                        <div class="col-lg-6">
                            <div class="parameters">
                                <div class="row" style="min-height: 165px">
                                    @include('frontend.catalog._partials.parameters', ['product'=>$product])

                                </div>

                                <div class="row align-items-center">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="parameters-item">
                                            <svg class="icon icon-type icon-money">
                                                <use xlink:href="#icon-26"></use>
                                            </svg>
                                            <span><b>{{ ($product->price) }} грн/м3</b></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>Не вказано</p>
                    @endforelse
                </div>
            </section>
        @endif


    </div>
@endsection


@section('scripts')
    <script>
        $('.contact-info .btn-action-email').click(function() {
            $.get('/{{ app()->getLocale() }}/report/email_views/{{ $business->id }}')
        })

        $('.contact-info .btn-action-phone').click(function() {
            $.get('/{{ app()->getLocale() }}/report/phone_views/{{ $business->id }}')
        })

        $('.contact-info .btn-action-www').click(function() {
            $.get('/{{ app()->getLocale() }}/report/www_views/{{ $business->id }}')
        })

        $('.seller_profile-persons-item .btn-action-contact-person-phone').click(function(e) {
            e.preventDefault();
            $.get('/{{ app()->getLocale() }}/report/contact_person_phone_views/{{ $business->id }}')
        })


    </script>
@endsection
