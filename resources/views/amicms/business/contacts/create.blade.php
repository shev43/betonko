@extends('layouts.amicms.app')

@section('content')

    <div class="card">
        <div class="container-fluid">
            <div class="row content-min-height">
                <div class="p-0 column-panel border-end" style="max-width: 230px; min-width: 230px; left: -230px;">
                    <h4 class="mb-3 ms-3 mt-3">Контактні особи</h4>
                    @include('amicms.business._partial.navbar', ['business_id'=>$business_id])

                </div>
                <div class="col">
                    <div class="card-body">
                        <form action="{{ route('amicms::business.contacts.store', ['business_id'=>$business_id]) }}" method="post" enctype="multipart/form-data">
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
                                            <th class="py-3">Ім'я</th>
                                            <td class="py-3">
                                                <input name="name" type="text" placeholder=""
                                                       class="form-control @if($errors->has('name')) noty_type_error @endif"
                                                       value="{{ old('name') }}">
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
                                                       value="{{ old('phone') }}"
                                                >
                                                @if($errors->has('phone'))
                                                    @foreach($errors->get('phone') as $error)
                                                        <div class="invalid-feedback" style="margin-left: 10px;display: block">{{ $error }}</div>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="py-3">Посада</th>
                                            <td class="py-3">
                                                <input name="position" type="text" placeholder=""
                                                       class="form-control @if($errors->has('position')) noty_type_error @endif"
                                                       value="{{ old('position') }}"
                                                >
                                                @if($errors->has('position'))
                                                    @foreach($errors->get('position') as $error)
                                                        <div class="invalid-feedback" style="margin-left: 10px;display: block">{{ $error }}</div>
                                                    @endforeach
                                                @endif
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
