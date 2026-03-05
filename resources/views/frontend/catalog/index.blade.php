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
            <li class="breadcrumb-item active" aria-current="page">Каталог</li>
        </ol>
    </nav>

    <main class="main page" style="padding-top: 10px;">
        <div class="container">
                <section>
                    <div class="row">
                        <div class="col-lg-4">
                            <h2 class="title">Список заводів:</h2>
                        </div>
                        <div class="col-lg-8 justify-content-end">

                        @if(Auth::guard('client')->check())
                            <form id="filterForm" action="{{ route('customer::catalog.index', ['lang'=>app()->getLocale()]) }}" method="get">
                        @elseif(Auth::guard('business')->check())
                            <form id="filterForm" action="{{ route('business::catalog.index', ['lang'=>app()->getLocale()]) }}" method="get">
                        @else
                            <form id="filterForm" action="{{ route('frontend::catalog.index', ['lang'=>app()->getLocale()]) }}" method="get">
                        @endif


                            @include('frontend.catalog.filter')
                            </form>

                        </div>
                    </div>



                    <div class="offer-item" style="border-top: 1px solid var(--color-gray); padding-top: 30px;">

                        <div class="row ml-0 mr-0 ml-md-auto mr-md-auto">

                @forelse($businessFactories as $factories)
                                @include('frontend.catalog.offer-item', ['factories'=>$factories, 'product'=>$factories->product])

                    @empty
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="offer-empty">
                                    <svg class="offer-empty-icon">
                                        <use xlink:href="#icon-noresult"></use>
                                    </svg>
                                    <div>
                                        <b>Не знайдено заводів які продають бажану Вами продукцію. Спробуйте обрати інші параметри бетону</b>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforelse

                        </div>
                    </div>

                    {{ $businessFactories->withQueryString()->links('pagination/default') }}

                </section>
        </div>
    </main>
@endsection
