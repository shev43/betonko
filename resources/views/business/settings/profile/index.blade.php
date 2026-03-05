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

            <section id="businessSettingsProfilePhoto" class="seller_cabinet-settings-profile">
                <h2 class="title text-center">Налаштування профілю</h2>
                <div class="row justify-content-center">
                    <div class="col-lg-3 col-md-4">
                        <div class="form-group text-center">
                            <img class="seller_cabinet-settings-logo" src="@if(!empty($profile->photo)){{ asset('storage/users/' . $profile->photo) }}@else{{ asset('img/layout/profile-logo.jpg') }}@endif" data-empty="{{ asset('img/layout/profile-logo.jpg') }}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-8 d-flex align-items-center justify-content-center">
                        <div class="seller_cabinet-settings-logo_btns">
                            <div>
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label for="business-image-loader" class="btn btn-default">Завантажити фото</label>
                                    <input type="file" class="form-control-file" id="business-image-loader" data-upload="{{ route('setting.profile.upload-logo') }}" style="display: none;">
                                </div>
                            </div>

                            <div class="text-center {{ empty($profile->photo) ? 'd-none' : '' }}" >
                                <div class="form-group" style="margin: auto">
                                    <a class="btn btn-delete p-0">
                                        <span>Видалити</span>
                                        <svg class="icon">
                                            <use xlink:href="#icon-clear"></use>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <form id="businessSetting" action="{{ route('business::setting.profile.update', ['lang'=>app()->getLocale()]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="photo" value="{{$profile->photo ?? ''}}">

                    <div class="row justify-content-center">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="first_name">Ваше ім’я:</label>
                                <input name="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" placeholder="" value="{{ $profile->first_name }}">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="last_name">Ваше прізвище:</label>
                                <input name="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" placeholder="" value="{{ $profile->last_name }}">
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="email">Електронна пошта</label>
                                <input name="email" type="text" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="" value="{{ $profile->email }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="phone">Номер телефону</label>
                                <input name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="" value="{{ $profile->phone }}">
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="password">Пароль:</label>
                                <div class="form-pass">
                                    <input class="form-pass-checkbox" type="checkbox" id="exampleCheckbox">
                                    <label class="form-pass-label" for="exampleCheckbox">
                                        <svg>
                                            <use xlink:href="#icon-14"></use>
                                        </svg>
                                    </label>
                                    <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="мінімум 8 символів">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="password_confirmation">Пароль ще раз:</label>
                                <div class="form-pass">
                                    <input class="form-pass-checkbox" type="checkbox" id="exampleCheckbox2">
                                    <label class="form-pass-label" for="exampleCheckbox2">
                                        <svg>
                                            <use xlink:href="#icon-14"></use>
                                        </svg>
                                    </label>
                                    <input name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="мінімум 8 символів">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col-lg-8 text-center text-lg-right">
                            <button class="btn btn-default" type="submit">Зберегти</button>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </main>
@endsection
