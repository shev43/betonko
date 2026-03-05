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
                <h2 class="title text-center">Налаштування заводів</h2>
                <div class="row justify-content-center">

                    <div class="col-md-12 col-lg-6">
                        <div class="seller_profile-persons-item">
                            <div class="seller_cabinet-selection">
                                <svg class="icon">
                                    <use xlink:href="#icon-plus"></use>
                                </svg>
                                    <a class="stretched-link" style="margin-left: 12px;" href="{{ route('business::setting.factories.create', ['lang'=>app()->getLocale()]) }}"><span>Додати</span></a>
                            </div>


                        </div>
                    </div>

                    @foreach($factories as $factory)
                        <div class="col-md-12 col-lg-6">
                            <div class="seller_profile-persons-item seller_profile-persons-item--edit">
                                <div class="seller_profile-persons-img">
                                    @if(!empty($factory->photo))
                                        <img src="{{ asset('storage/factory/' . $factory->photo) }}" alt="">
                                    @else
                                        <img src="{{ asset('img/layout/profile-logo.jpg') }}" alt="">
                                    @endif
                                </div>
                                <div>
                                    <div class="seller_profile-persons-name">{{ $factory->name }}</div>
                                    <div class="seller_profile-persons-post">{{ $factory->address }}</div>
                                </div>

                                <a class="edit" href="{{ route('business::setting.factories.edit', ['lang'=>app()->getLocale(), 'factory_id'=>$factory->id]) }}">
                                    <svg class="icon">
                                        <use xlink:href="#icon-edit"></use>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{ $factories->withQueryString()->links('pagination/default') }}

            </section>

        </div>
    </main>

@endsection
