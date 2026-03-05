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
                <h2 class="title text-center">Редагувати контактну особу</h2>
                <div id="businessSettingContactsPhoto" class="row justify-content-center">
                    <div class="col-lg-3 col-md-4">
                        <div class="form-group text-center">
                            <img class="seller_cabinet-settings-logo" src="@if(!empty($contact->photo)){{ asset('storage/users/'.$contact->photo) }}@else{{ asset('img/layout/profile-logo.jpg') }}@endif" data-empty="{{ asset('img/layout/profile-logo.jpg') }}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-8 d-flex align-items-center justify-content-center">
                        <div class="seller_cabinet-settings-logo_btns">
                            <div>
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label for="business-image-loader" class="btn btn-default">Завантажити лого</label>
                                    <input type="file" class="form-control-file" id="business-image-loader" data-upload="{{ route('setting.contacts.upload-logo') }}" style="display: none;">
                                </div>
                            </div>
                            <div class="text-center {{ empty($contact->photo) ? 'd-none' : '' }}" >
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

                <form id="businessSetting" action="{{ route('business::setting.contacts.update', ['lang'=>app()->getLocale(), 'contact_id'=>$contact->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="photo" value="">

                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="name">Ім’я:</label>
                                <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Вкажіть Ім'я контактної особи" value="{{ $contact->name }}">
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="phone">Номер телефону:</label>
                                <input name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="Вкажіть телефон контактної особи" value="{{ $contact->phone }}">
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="position">Роль:</label>
                                <input name="position" type="text" class="form-control @error('position') is-invalid @enderror" id="position" placeholder="Вкажіть посаду контактної особи" value="{{ $contact->position }}">
                            </div>
                        </div>

                        <div class="col-lg-8 text-center text-lg-right">
                            <button class="btn btn-default" type="submit">Зберегти</button>
                        </div>

                    </div>

                </form>
            </section>

        </div>
    </main>
@endsection
