@extends('layouts.amicms.app')

@section('content')

    <div class="card">
        <div class="container-fluid">
            <div class="row content-min-height">
                <div class="p-0 column-panel border-end" style="max-width: 230px; min-width: 230px; left: -230px;">
                    <h4 class="mb-3 ms-3 mt-3">Підприємства</h4>
                    @include('amicms.business._partial.navbar', ['business_id'=>$business->id])

                </div>
                <div class="col">
                    <div class="card-body">
                        <form action="{{ route('amicms::business.update', ['business_id'=>$business->id]) }}" method="post" enctype="multipart/form-data">
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
                                            <th class="py-3">Назва</th>
                                            <td class="py-3">
                                                <input name="name" type="text" placeholder=""
                                                       class="form-control @if($errors->has('name')) noty_type_error @endif"
                                                       value="{{ old('name', $business->name) }}"
                                                >
                                                @if($errors->has('name'))
                                                    @foreach($errors->get('name') as $error)
                                                        <div class="invalid-feedback" style="margin-left: 10px;display: block">{{ $error }}</div>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="py-3">Телефон</th>
                                            <td class="py-3">
                                                <input name="phone" type="text" placeholder=""
                                                       class="form-control @if($errors->has('phone')) noty_type_error @endif"
                                                       value="{{ old('phone', $business->phone) }}"
                                                >
                                                @if($errors->has('phone'))
                                                    @foreach($errors->get('phone') as $error)
                                                        <div class="invalid-feedback" style="margin-left: 10px;display: block">{{ $error }}</div>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="py-3">Email</th>
                                            <td class="py-3">
                                                <input name="email" type="text" placeholder=""
                                                       class="form-control @if($errors->has('email')) noty_type_error @endif"
                                                       value="{{ old('email', $business->email) }}"
                                                >
                                                @if($errors->has('email'))
                                                    @foreach($errors->get('email') as $error)
                                                        <div class="invalid-feedback" style="margin-left: 10px;display: block">{{ $error }}</div>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="py-3">Опис</th>
                                            <td class="py-3">
                                                <textarea class="form-control editor" name="description" id="description">{{ old('description', $business->description) }}</textarea>

                                                @if($errors->has('description'))
                                                    @foreach($errors->get('description') as $error)
                                                        <div class="invalid-feedback" style="margin-bottom: 30px;display: block">{{ $error }}</div>
                                                    @endforeach
                                                @endif

                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="py-3">Адреса</th>
                                            <td class="py-3">
                                                <input name="address" type="text" placeholder=""
                                                       class="form-control autocomplete @if($errors->has('address')) noty_type_error @endif"
                                                       value="{{ old('address', $business->address) }}">
                                                @if($errors->has('address'))
                                                    @foreach($errors->get('address') as $error)
                                                        <div class="invalid-feedback" style="margin-left: 10px;display: block">{{ $error }}</div>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="py-3">
                                                @include('frontend._modules.map-form', ['objects'=>$business, 'target'=>'form input[name=address]'])
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
    <script src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script>

    <script>
        $(function () {
            $('textarea.editor').each(function (e) {
                CKEDITOR.replace(this.id, {'allowedContent': true});
            });
        });
    </script>
@endsection

@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?language=uk-UK&key={{ (env('APP_DEBUG') == true) ? env('GOOGLE_API_KEY_TEST') : env('GOOGLE_API_KEY_PRODUCTION') }}&libraries=places"></script>

    <script>
        jQuery(function($) {
            google.maps.event.addDomListener(window, 'load', buildAutocomplete());
        });
    </script>

@endsection
