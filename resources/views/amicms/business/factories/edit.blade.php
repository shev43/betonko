@extends('layouts.amicms.app')

@section('content')

    <div class="card">
        <div class="container-fluid">
            <div class="row content-min-height">
                <div class="p-0 column-panel border-end" style="max-width: 230px; min-width: 230px; left: -230px;">
                    <h4 class="mb-3 ms-3 mt-3">Заводи</h4>
                    @include('amicms.business._partial.navbar', ['business_id'=>$business_id])

                </div>
                <div class="col">
                    <div class="card-body">
                        <form action="{{ route('amicms::business.factories.update', ['business_id'=>$business_id, 'factory_id'=>$factory->id]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4 d-md-flex align-items-center justify-content-between">
                                <div>
                                    <h4>Персональна інформація</h4>
                                    <p>Основна інформація в цьому обліковому записі.</p>
                                </div>
                                <button class="btn btn-outline-primary" type="submit">Зберегти зміни</button>
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <th class="py-3">Назва заводу</th>
                                            <td class="py-3">
                                                <input name="name" type="text" placeholder=""
                                                       class="form-control @if($errors->has('name')) noty_type_error @endif"
                                                       value="{{ old('name', $factory->name) }}"
                                                >
                                                @if($errors->has('name'))
                                                    @foreach($errors->get('name') as $error)
                                                        <div class="invalid-feedback" style="margin-left: 10px;display: block">{{ $error }}</div>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="py-3">Контактні особи</th>
                                            <td class="py-3">
                                                <select class="selectpicker" name="contacts[]" id="contacts" data-style="form-control @if($errors->has('contacts')) noty_type_error @endif" data-title="Виберіть контактну особу" multiple>
                                                    @foreach($contacts as $contact)
                                                        @php($selected = '')

                                                        @foreach(explode(',', $factory->contacts_id) as $factory_contact)
                                                            @if($contact->id == $factory_contact)
                                                                @php($selected = in_array($factory_contact, old("contacts", [$factory_contact]) ?: []) ? "selected": "")
                                                            @endif
                                                        @endforeach
                                                        <option value="{{ $contact->id }}" {{ $selected }}>{{ $contact->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('contacts'))
                                                    @foreach($errors->get('contacts') as $error)
                                                        <div class="invalid-feedback" style="margin-bottom: 30px;display: block">{{ $error }}</div>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>


                                        <tr>
                                            <th class="py-3">Адреса заводу</th>
                                            <td class="py-3">
                                                <input name="address" type="text" placeholder=""
                                                       class="form-control autocomplete @if($errors->has('address')) noty_type_error @endif"
                                                       value="{{ old('address', $factory->address) }}">
                                                @if($errors->has('address'))
                                                    @foreach($errors->get('address') as $error)
                                                        <div class="invalid-feedback" style="margin-left: 10px;display: block">{{ $error }}</div>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="py-3">
                                                @include('frontend._modules.map-form', ['objects'=>$factory, 'target'=>'form input[name=address]'])
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?language=uk-UK&key={{ (env('APP_DEBUG') == true) ? env('GOOGLE_API_KEY_TEST') : env('GOOGLE_API_KEY_PRODUCTION') }}&libraries=places"></script>

    <script>
        jQuery(function($) {
            google.maps.event.addDomListener(window, 'load', buildAutocomplete());
        });
    </script>

@endsection

