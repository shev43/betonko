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
                <h2 class="title text-center">Додати продукт</h2>

                <form action="{{ route('business::setting.product.store', ['lang'=>app()->getLocale()]) }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="form-group ">
                                <label>
                                    <svg class="icon icon-type icon-model">
                                        <use xlink:href="#icon-15"></use>
                                    </svg>
                                    <span>Марка</span> </label>
                                <div class="">
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
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group ">
                                <label>
                                    <svg class="icon icon-type icon-class">
                                        <use xlink:href="#icon-16"></use>
                                    </svg>
                                    <span>Клас</span> </label>
                                <div class="">
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
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group ">
                                <label>
                                    <svg class="icon icon-type icon-water">
                                        <use xlink:href="#icon-18"></use>
                                    </svg>
                                    <span>Водостійкість</span> </label>
                                <div class="">
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
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group ">
                                <label>
                                    <svg class="icon icon-type icon-winter">
                                        <use xlink:href="#icon-20"></use>
                                    </svg>
                                    <span>Зимові добавки</span> </label>
                                <div class="">
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
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group ">
                                <label>
                                    <svg class="icon icon-type icon-mobility">
                                        <use xlink:href="#icon-19"></use>
                                    </svg>
                                    <span>Рухливість суміші</span> </label>
                                <div class="">
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
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group ">
                                <label>
                                    <svg class="icon icon-type icon-frost">
                                        <use xlink:href="#icon-17"></use>
                                    </svg>
                                    <span>Морозостійкість</span> </label>
                                <div class="">
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
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group ">
                                <label>
                                    <svg class="icon icon-type icon-money">
                                        <use xlink:href="#icon-26"></use>
                                    </svg>
                                    <span>Ціна за м3</span> </label>
                                <input type="number" class="form-control {{$errors->has('price') ? 'is-invalid' : ''}}" name="price" min="1" max="9999" maxlength="4" step="1" value="{{ old('price') }}" placeholder="Виберіть ціну" autocomplete="off" oninput="if(value.length>4)value=value.slice(0,4)">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group ">
                                <label> <span>Виберіть завод постачальника</span> </label>

                                <select class="selectpicker @error('factories') is-invalid @enderror" id="factories" name="factories" data-style="form-control" title="Виберіть завод">
                                    @foreach($business->factories as $factory_key=>$factory)
                                        <option value="{{ $factory->id }}"
                                            {{old('factories.'.$factory_key.'') == $factory->id ?'selected="selected"' :''}}>
                                            {{ $factory->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12 text-center text-lg-right">
                            <button class="btn btn-default" type="submit">Зберегти</button>
                        </div>

                    </div>
                </form>


            </section>

        </div>
    </main>

@endsection
