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
                <h2 class="title text-center">Налаштування контактних осіб</h2>
                <div class="row justify-content-center">
                    <div class="col-md-12 col-lg-6">
                        <div class="seller_profile-persons-item">
                            <div class="seller_cabinet-selection">
                                <svg class="icon">
                                    <use xlink:href="#icon-plus"></use>
                                </svg>
                                <a class="stretched-link" style="margin-left: 12px;" href="{{ route('business::setting.contacts.create', ['lang'=>app()->getLocale()]) }}"><span>Додати</span></a>
                            </div>
                        </div>
                    </div>
                    @foreach($contacts as $contact)
                        <div class="col-md-12 col-lg-6">
                            <div class="seller_profile-persons-item seller_profile-persons-item--edit">
                                <div class="seller_profile-persons-img">
                                    @if(!empty($contact->photo))
                                        <img src="{{ asset('storage/users/' . $contact->photo) }}" alt="">
                                    @else
                                        <img src="{{ asset('img/layout/profile-logo.jpg') }}" alt="">
                                    @endif
                                </div>
                                <div>
                                    <div class="seller_profile-persons-name">{{ $contact->name }}</div>
                                    <div class="seller_profile-persons-post">{{ $contact->position }}</div>
                                    <div class="seller_profile-persons-phone">+{{ $contact->phone }}</div>
                                </div>

                                <a class="delete" href="#" data-href="{{ route('business::setting.contacts.destroy', ['lang'=>app()->getLocale(), 'contact_id'=>$contact->id]) }}" data-toggle="modal" data-target="#confirm-delete">
                                    <svg class="icon">
                                        <use xlink:href="#icon-clear"></use>
                                    </svg>
                                </a>

                                <a class="edit" href="{{ route('business::setting.contacts.edit', ['lang'=>app()->getLocale(), 'contact_id'=>$contact->id]) }}">
                                    <svg class="icon">
                                        <use xlink:href="#icon-edit"></use>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{ $contacts->withQueryString()->links('pagination/default') }}

            </section>

        </div>
    </main>

@endsection
