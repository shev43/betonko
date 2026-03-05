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
                <h2 class="title text-center">Редагувати завод</h2>
                <div id="businessSettingFactoryPhoto" class="row justify-content-center">
                    <div class="col-lg-3 col-md-4">
                        <div class="form-group text-center">
                            <img class="seller_cabinet-settings-logo" src="@if(!empty($factory->photo)){{ asset('storage/factory/'.$factory->photo) }}@else{{ asset('img/layout/profile-logo.jpg') }}@endif" data-empty="{{ asset('img/layout/profile-logo.jpg') }}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-8 d-flex align-items-center justify-content-center">
                        <div class="seller_cabinet-settings-logo_btns">
                            <div>
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label for="business-image-loader" class="btn btn-default">Завантажити лого</label>
                                    <input type="file" class="form-control-file" id="business-image-loader" data-upload="{{ route('setting.factory.upload-logo') }}" style="display: none;">
                                </div>
                            </div>
                            <div class="text-center {{ empty($factory->photo) ? 'd-none' : '' }}" >
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

                <form id="businessFactory" action="{{ route('business::setting.factories.update', ['lang'=>app()->getLocale(), 'factory_id'=>$factory->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="photo" value="">

                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="name">Назва заводу:</label>
                                <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Вкажіть назву заводу" value="{{ $factory->name }}">
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="contacts">Контактні особи:</label>
                                <select class="selectpicker @error('contacts') is-invalid @enderror" name="contacts[]" data-style="form-control" data-title="Оберіть контактних осіб" multiple>
                                    @foreach($factory->contacts as $contacts)
                                        @php($selected = '')

                                        @foreach(explode(',', $factory->contacts_id) as $factory_contact)
                                            @if($contacts->id == $factory_contact)
                                                @php($selected = 'selected')
                                            @endif
                                        @endforeach

                                        <option value="{{ $contacts->id }}" {{ $selected }}>{{ $contacts->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="address">Розташування:</label>
                                <input name="address" type="text" class="form-control autocomplete @error('address') is-invalid @enderror" id="position" placeholder="Вкажіть розташування заводу" value="{{ $factory->address }}">
                            </div>

                            @include('frontend._modules.map-form', ['objects'=>[$factory], 'target'=>'form#businessFactory input[name=address]'])

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

@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?language=uk-UK&key={{ (env('APP_DEBUG') == true) ? env('GOOGLE_API_KEY_TEST') : env('GOOGLE_API_KEY_PRODUCTION') }}&libraries=places"></script>

    <script>
        jQuery(function($) {
            google.maps.event.addDomListener(window, 'load', buildAutocomplete());
        });
    </script>

@endsection
