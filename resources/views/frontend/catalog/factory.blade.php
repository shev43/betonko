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

            @if(Auth::guard('client')->check())
                <li class="breadcrumb-item"><a href="{{ route('customer::company.view', ['lang'=>app()->getLocale(), 'company_id'=>$businessFactory->business->id]) }}">{{ $businessFactory->business->name }}</a></li>
            @else
                <li class="breadcrumb-item"><a href="{{ route('frontend::company.view', ['lang'=>app()->getLocale(), 'company_id'=>$businessFactory->business->id]) }}">{{ $businessFactory->business->name }}</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{$businessFactory->name}}</li>
        </ol>
    </nav>

    <div class="container">
        <section class="seller_profile-info">
            <div class="row justify-content-between align-items-center">
                <div class="col-12 col-lg-6">
                    <div class="row align-items-center seller_profile-info-top">
                        <div class="col-4 col-md-3">
                            <div class="seller_profile-logo">
                                <img src="@if(!empty($businessFactory->photo)){{ asset('storage/factory/'.$businessFactory->photo) }}@else{{ asset('img/layout/profile-logo.jpg') }}@endif" alt="">
                            </div>
                        </div>
                        <div class="col-8 col-md-9">
                            <h2 class="title">{{$businessFactory->name}}</h2>
                        </div>

                        <div class="col-12 mt-md-4 mt-4 seller_profile-contact">{{$businessFactory->address}}</div>

                        <div class="col-12 mt-md-0 mt-auto">
                            <strong>Підприємство:</strong>
                            @if(Auth::guard('client')->check())
                                <a href="{{ route('customer::company.view', ['lang'=>app()->getLocale(), 'company_id'=>$businessFactory->business->id]) }}">{{ $businessFactory->business->name }}</a>
                            @else
                                <a href="{{ route('frontend::company.view', ['lang'=>app()->getLocale(), 'company_id'=>$businessFactory->business->id]) }}">{{ $businessFactory->business->name }}</a>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="col-12 col-lg-6">
                    @include('frontend._modules.map-view', ['objects'=>[$businessFactory]])

                </div>
            </div>
        </section>

        @if(!empty($businessFactory->contacts) && count($businessFactory->contacts) > 0)
            <section class="seller_profile-persons">
                <h2 class="title">Контактні особи:</h2>
                <div class="row">

                    @forelse($businessFactory->contacts()->get() as $contact)
                        <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                            @include('frontend.catalog._partials.contacts', ['contact1'=>$contact])
                        </div>
                    @empty
                        <p>Не вказано</p>
                    @endforelse
                </div>
            </section>
        @endif

        @if(!empty($businessFactory->products) && count($businessFactory->products) > 0)
            <section class="seller_profile-products">
                <h2 class="title">Продукція:</h2>
                <div class="row">
                    @forelse($businessFactory->products as $product)
                        <div class="col-12 col-lg-6">
                            <div class="parameters">
                                <div class="row" style="min-height: 165px">
                                    @include('frontend.catalog._partials.parameters', ['product'=>$product])
                                </div>

                                <div class="row align-items-center">
                                    <div class="col-12 col-sm-12 col-md-6">
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
        $('.seller_profile-persons-item .btn-action-contact-person-phone').click(function(e) {
            e.preventDefault();
            $.get('/{{ app()->getLocale() }}/report/contact_person_phone_views/{{ $businessFactory->business->id }}/{{ $businessFactory->id }}')
        })


    </script>
@endsection
