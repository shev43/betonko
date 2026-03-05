@extends('layouts.amicms.app')

@section('content')

    <div class="card">
        <div class="container-fluid">
            <div class="row content-min-height">
                <div class="p-0 column-panel border-end" style="max-width: 230px; min-width: 230px; left: -230px;">
                    <h4 class="mb-3 ms-3 mt-3">Продукція</h4>
                    @include('amicms.business._partial.navbar', ['business_id'=>$business_id])

                </div>
                <div class="col">
                    <div class="card-body">
                        <form action="{{ route('amicms::business.products.store', ['business_id'=>$business_id]) }}" method="post">
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
                                            <th class="py-3">Виберіть завод постачальника</th>
                                            <td class="py-3">
                                                <select class="selectpicker @error('factories') is-invalid @enderror" id="factories" name="factories" data-style="form-control" title="Виберіть завод">
                                                    @foreach($factories_array as $factory_key=>$factory)
                                                        <option value="{{ $factory->id }}"
                                                            {{old('factories.'.$factory_key.'') == $factory->id ?'selected="selected"' :''}}>
                                                            {{ $factory->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('factories'))
                                                    @foreach($errors->get('factories') as $error)
                                                        <div class="invalid-feedback" style="margin-bottom: 30px;display: block">{{ $error }}</div>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                                <th class="py-3">Марка</th>
                                                <td class="py-3">
                                                    <select name="mark" id="mark"
                                                            class="selectpicker {{$errors->has('mark') ? 'is-invalid' : ''}}" title="Виберіть марку"
                                                            data-style="form-control">
                                                        @foreach(Config::get('product.mark') as $value => $mark)
                                                            <option value="{{$value}}"
                                                                {{old('mark') == $value || app('request')->input('mark') == $value ? 'selected="selected"' :''}}>
                                                                {{$mark}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('mark'))
                                                        @foreach($errors->get('mark') as $error)
                                                            <div class="invalid-feedback" style="margin-bottom: 30px;display: block">{{ $error }}</div>
                                                        @endforeach
                                                    @endif
                                                </td>
                                            </tr>

                                            <tr>
                                                <th class="py-3">Клас</th>
                                                <td class="py-3">
                                                    <select name="class" id="class"
                                                            class="selectpicker {{$errors->has('class') ? 'is-invalid' : ''}}"
                                                            title="Виберіть клас" data-style="form-control">
                                                        @foreach(Config::get('product.class') as $value => $class)
                                                            <option value="{{$value}}"
                                                                {{old('class') == $value || app('request')->input('class') == $value?'selected="selected"' :''}}>
                                                                {{$class}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('class'))
                                                        @foreach($errors->get('class') as $error)
                                                            <div class="invalid-feedback" style="margin-bottom: 30px;display: block">{{ $error }}</div>
                                                        @endforeach
                                                    @endif
                                                </td>
                                            </tr>

                                            <tr>
                                                <th class="py-3">Водостійкість</th>
                                                <td class="py-3">
                                                    <select name="water_resistance" id="water_resistance"
                                                            class="selectpicker {{$errors->has('water_resistance') ? 'is-invalid' : ''}}"
                                                            title="Виберіть водостійкість" data-style="form-control">
                                                        @foreach(Config::get('product.water_resistance') as $value => $waterResistance)
                                                            <option value="{{$value}}"
                                                                {{old('water_resistance') == $value || app('request')->input('water_resistance') == $value?'selected="selected"' :''}}>
                                                                {{$waterResistance}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('water_resistance'))
                                                        @foreach($errors->get('water_resistance') as $error)
                                                            <div class="invalid-feedback" style="margin-bottom: 30px;display: block">{{ $error }}</div>
                                                        @endforeach
                                                    @endif
                                                </td>
                                            </tr>

                                            <tr>
                                                <th class="py-3">Зимові добавки</th>
                                                <td class="py-3">
                                                    <select name="winter_supplement" id="winter_supplement"
                                                            class="selectpicker {{$errors->has('winter_supplement') ? 'is-invalid' : ''}}"
                                                            title="Виберіть зимові добавки" data-style="form-control">
                                                        @foreach(Config::get('product.winter_supplement') as $value => $winterSupplement)
                                                            <option value="{{$value}}"
                                                                {{old('winter_supplement') == $value || app('request')->input('winter_supplement') == $value ? 'selected="selected"' :''}}>
                                                                {{$winterSupplement}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('winter_supplement'))
                                                        @foreach($errors->get('winter_supplement') as $error)
                                                            <div class="invalid-feedback" style="margin-bottom: 30px;display: block">{{ $error }}</div>
                                                        @endforeach
                                                    @endif
                                                </td>
                                            </tr>

                                            <tr>
                                                <th class="py-3">Рухливість суміші</th>
                                                <td class="py-3">
                                                    <select name="mixture_mobility" id="mixture_mobility"
                                                            class="selectpicker {{$errors->has('mixture_mobility') ? 'is-invalid' : ''}}"
                                                            title="Виберіть рухливість суміші" data-style="form-control">
                                                        @foreach(Config::get('product.mixture_mobility') as $value => $mixtureMobility)
                                                            <option value="{{$value}}"
                                                                {{old('mixture_mobility') == $value || app('request')->input('mixture_mobility') == $value ? 'selected="selected"' :''}}>
                                                                {{$mixtureMobility}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('mixture_mobility'))
                                                        @foreach($errors->get('mixture_mobility') as $error)
                                                            <div class="invalid-feedback" style="margin-bottom: 30px;display: block">{{ $error }}</div>
                                                        @endforeach
                                                    @endif
                                                </td>
                                            </tr>

                                            <tr>
                                                <th class="py-3">Морозостійкість</th>
                                                <td class="py-3">
                                                    <select name="frost_resistance" id="frost_resistance"
                                                            class="selectpicker {{$errors->has('frost_resistance') ? 'is-invalid' : ''}}"
                                                            title="Виберіть морозостійкість" data-style="form-control">
                                                        @foreach(Config::get('product.frost_resistance') as $value => $frostResistance)
                                                            <option value="{{$value}}"
                                                                {{old('frost_resistance') == $value || app('request')->input('frost_resistance') == $value ?'selected="selected"' :''}}>
                                                                {{$frostResistance}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('frost_resistance'))
                                                        @foreach($errors->get('frost_resistance') as $error)
                                                            <div class="invalid-feedback" style="margin-bottom: 30px;display: block">{{ $error }}</div>
                                                        @endforeach
                                                    @endif
                                                </td>
                                            </tr>

                                            <tr>
                                                <th class="py-3">Ціна за м3</th>
                                                <td class="py-3">
                                                    <input type="number" class="form-control {{$errors->has('price') ? 'is-invalid' : ''}}" name="price" min="1" max="9999" step="1" value="{{ old('price') }}" placeholder="Виберіть ціну" autocomplete="off">
                                                    @if($errors->has('price'))
                                                        @foreach($errors->get('price') as $error)
                                                            <div class="invalid-feedback" style="margin-bottom: 30px;display: block">{{ $error }}</div>
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



