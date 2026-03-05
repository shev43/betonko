<div class="card-body card-block">
    <div class="form-group">
        @csrf

        <h2 class="display-5 my-3">Замовлення</h2>
        <hr>
        <div class="row form-group">
            <div class="col col-md-4">
                <label for="end_date_of_delivery" class=" form-control-label">Дата доставки</label>
            </div>
            <div class="col-12 col-md-8">
                <input type="text" id="end_date_of_delivery" name="end_date_of_delivery"
                       value="{{\Carbon\Carbon::parse($order->end_date_of_delivery)->format('d.m.Y')  ?? old('end_date_of_delivery', '')}}"
                       class="form-control {{$errors->has('end_date_of_delivery') ? 'alert-danger' : ''}}">
                @foreach($errors->get('end_date_of_delivery') as $error)
                    <small class="form-text text-danger">{!! $error !!}</small>
                @endforeach
            </div>
        </div>
        <div class="row form-group">
            <div class="col col-md-4">
                <label for="count" class=" form-control-label">Кількість</label>
            </div>
            <div class="col-12 col-md-8">
                <input type="text" id="count" name="count" value="{{$order->count  ?? old('count', '')}}"
                       class="form-control {{$errors->has('count') ? 'alert-danger' : ''}}">
                @foreach($errors->get('count') as $error)
                    <small class="form-text text-danger">{!! $error !!}</small>
                @endforeach
            </div>
        </div>
        <div class="row form-group">
            <div class="col col-md-4">
                <label for="count" class=" form-control-label">Орієнтовна вартість (від - до)</label>
            </div>
            <div class="col-12 col-md-4">
                <input type="text" id="min_price" name="min_price"
                       value="{{$order->min_price  ?? old('min_price', '')}}"
                       class="form-control {{$errors->has('min_price') ? 'alert-danger' : ''}}">
                @foreach($errors->get('min_price') as $error)
                    <small class="form-text text-danger">{!! $error !!}</small>
                @endforeach
            </div>
            <div class="col-12 col-md-4">
                <input type="text" id="max_price" name="max_price"
                       value="{{$order->max_price  ?? old('max_price', '')}}"
                       class="form-control {{$errors->has('max_price') ? 'alert-danger' : ''}}">
                @foreach($errors->get('max_price') as $error)
                    <small class="form-text text-danger">{!! $error !!}</small>
                @endforeach
            </div>
        </div>
        <div class="row form-group">
            <div class="col col-md-4">
                <label for="type_of_delivery" class=" form-control-label">Тип доставки</label>
            </div>
            <div class="col-12 col-md-8">
                <select name="type_of_delivery" id="type_of_delivery"
                        class="form-control {{$errors->has('type_of_delivery') ? 'alert-danger' : ''}}">
                    <option value="self" {{$order->type_of_delivery == 'self' ? 'selected' : ''}}>Самовивіз</option>
                    <option value="business" {{$order->type_of_delivery == 'business' ? 'selected' : ''}}>Доставка
                        виробником
                    </option>
                </select>
                @foreach($errors->get('type_of_delivery') as $error)
                    <small class="form-text text-danger">{!! $error !!}</small>
                @endforeach
            </div>
        </div>


        <h2 class="display-5 my-3">Контактні дані</h2>
        <hr>
        <div class="row form-group">
            <div class="col col-md-4">
                <label for="contact_first_name" class=" form-control-label">Імя</label>
            </div>
            <div class="col-12 col-md-4">
                <input type="text" id="contact_first_name" name="contact_first_name"
                       value="{{$order->contact_first_name  ?? old('contact_first_name', '')}}"
                       class="form-control {{$errors->has('contact_first_name') ? 'alert-danger' : ''}}">
                @foreach($errors->get('contact_first_name') as $error)
                    <small class="form-text text-danger">{!! $error !!}</small>
                @endforeach
            </div>
            <div class="col-12 col-md-4">
                <input type="text" id="contact_last_name" name="contact_last_name"
                       value="{{$order->contact_last_name  ?? old('contact_last_name', '')}}"
                       class="form-control {{$errors->has('contact_last_name') ? 'alert-danger' : ''}}">
                @foreach($errors->get('contact_last_name') as $error)
                    <small class="form-text text-danger">{!! $error !!}</small>
                @endforeach
            </div>
        </div>
        <div class="row form-group">
            <div class="col col-md-4">
                <label for="contact_phone" class=" form-control-label">Контактний телефон</label>
            </div>
            <div class="col-12 col-md-8">
                <input type="text" id="contact_phone" name="contact_phone"
                       value="{{$order->contact_phone  ?? old('contact_phone', '')}}"
                       class="form-control {{$errors->has('contact_phone') ? 'alert-danger' : ''}}">
                @foreach($errors->get('contact_phone') as $error)
                    <small class="form-text text-danger">{!! $error !!}</small>
                @endforeach
            </div>
        </div>
        <div class="row form-group">
            <div class="col col-md-4">
                <label for="address" class=" form-control-label">Адреса</label>
            </div>
            <div class="col-12 col-md-8">
                <input type="text" id="address" class="autocomplete" name="address" value="{{$order->address  ?? old('address', '')}}"
                       class="form-control {{$errors->has('name') ? 'alert-danger' : ''}}">
                <div class="invalid-feedback"></div>

                @foreach($errors->get('address') as $error)
                    <small class="form-text text-danger">{!! $error !!}</small>
                @endforeach
            </div>
        </div>
        <div class="row form-group">
            <div class="col col-md-4">
                <label for="name" class=" form-control-label">Карта</label>
            </div>
            <div class="col-12 col-md-8">
                @include('frontend._modules.map-form', ['objects'=>$order, 'target'=>'form input[name=address]'])
            </div>
        </div>


        <h2 class="display-5 my-3">Параметри замовлення</h2>
        <hr>
        <div class="row form-group">
            <div class="col col-md-3">
                <label for="mark" class=" form-control-label">Марка</label>
            </div>
            <div class="col-12 col-md-9">
                <select name="mark" id="mark"
                        class="form-control {{$errors->has('mark') ? 'alert-danger' : ''}}">
                    <option value="">Не важливо</option>
                    @foreach(Config::get('product.mark') as $key => $mark)
                        <option value="{{$key}}"
                            {{(isset($order->mark) && $order->mark == $key ? 'selected="selected"' :old('mark') == $key)?'selected="selected"' :''}}>
                            {{$mark}}
                        </option>
                    @endforeach
                </select>
                @foreach($errors->get('mark') as $error)
                    <small class="form-text text-danger">{!! $error !!}</small>
                @endforeach
            </div>
        </div>

        <div class="row form-group">
            <div class="col col-md-3">
                <label for="frost_resistance" class=" form-control-label">Клас</label>
            </div>
            <div class="col-12 col-md-9">
                <select name="class" id="class"
                        class="form-control {{$errors->has('class') ? 'alert-danger' : ''}}">
                    <option value="">Не важливо</option>
                    @foreach(Config::get('product.class') as $key => $class)
                        <option value="{{$key}}"
                            {{(isset($order->class) && $order->class == $key ? 'selected="selected"' :old('class') == $key)?'selected="selected"' :''}}>
                            {{$class}}
                        </option>
                    @endforeach
                </select>
                @foreach($errors->get('class') as $error)
                    <small class="form-text text-danger">{!! $error !!}</small>
                @endforeach
            </div>
        </div>
        <div class="row form-group">
            <div class="col col-md-3">
                <label for="frost_resistance" class=" form-control-label">Морозостійкість</label>
            </div>
            <div class="col-12 col-md-9">
                <select name="frost_resistance" id="frost_resistance"
                        class="form-control {{$errors->has('frost_resistance') ? 'alert-danger' : ''}}">
                    <option value="">Не важливо</option>
                    @foreach(Config::get('product.frost_resistance') as $key => $frostResistance)
                        <option value="{{$key}}"
                            {{(isset($order->frost_resistance) && $order->frost_resistance == $key ? 'selected="selected"' :old('frost_resistance') == $key)?'selected="selected"' :''}}>
                            {{$frostResistance}}
                        </option>
                    @endforeach
                </select>
                @foreach($errors->get('frost_resistance') as $error)
                    <small class="form-text text-danger">{!! $error !!}</small>
                @endforeach
            </div>
        </div>
        <div class="row form-group">
            <div class="col col-md-3">
                <label for="water_resistance" class=" form-control-label">Водостійкість</label>
            </div>
            <div class="col-12 col-md-9">
                <select name="water_resistance" id="water_resistance"
                        class="form-control {{$errors->has('water_resistance') ? 'alert-danger' : ''}}">
                    <option value="">Не важливо</option>
                    @foreach(Config::get('product.water_resistance') as $key => $waterResistance)
                        <option value="{{$key}}"
                            {{(isset($order->water_resistance) && $order->water_resistance == $key ? 'selected="selected"' :old('water_resistance') == $key)?'selected="selected"' :''}}>
                            {{$waterResistance}}
                        </option>
                    @endforeach
                </select>
                @foreach($errors->get('water_resistance') as $error)
                    <small class="form-text text-danger">{!! $error !!}</small>
                @endforeach
            </div>
        </div>
        <div class="row form-group">
            <div class="col col-md-3">
                <label for="winter_supplement" class=" form-control-label">Зимова добавка</label>
            </div>
            <div class="col-12 col-md-9">
                <select name="winter_supplement" id="winter_supplement"
                        class="form-control {{$errors->has('winter_supplement') ? 'alert-danger' : ''}}">
                    <option value="">Не важливо</option>
                    @foreach(Config::get('product.winter_supplement') as $key => $winterSupplement)
                        <option value="{{$key}}"
                            {{(isset($order->winter_supplement) && $order->winter_supplement == $key ? 'selected="selected"' :old('winter_supplement') == $key)?'selected="selected"' :''}}>
                            {{$winterSupplement}}
                        </option>
                    @endforeach
                </select>
                @foreach($errors->get('winter_supplement') as $error)
                    <small class="form-text text-danger">{!! $error !!}</small>
                @endforeach
            </div>
        </div>
        <div class="row form-group">
            <div class="col col-md-3">
                <label for="mixture_mobility" class=" form-control-label">Рухливість суміші</label>
            </div>
            <div class="col-12 col-md-9">
                <select name="mixture_mobility" id="mixture_mobility"
                        class="form-control {{$errors->has('mixture_mobility') ? 'alert-danger' : ''}}">
                    <option value="">Не важливо</option>
                    @foreach(Config::get('product.mixture_mobility') as $key => $mixtureMobility)
                        <option value="{{$key}}"
                            {{(isset($order->mixture_mobility) && $order->mixture_mobility == $key ? 'selected="selected"' :old('mixture_mobility') == $key)?'selected="selected"' :''}}>
                            {{$mixtureMobility}}
                        </option>
                    @endforeach
                </select>
                @foreach($errors->get('mixture_mobility') as $error)
                    <small class="form-text text-danger">{!! $error !!}</small>
                @endforeach
            </div>
        </div>

        <br>
        <h2 class="display-5 my-3">Пропозиції виробників</h2>
        <hr>
        <style>
            tr.selected td{background-color: #daffda}
        </style>

        @if(count($order->offers) > 0)

        <div class="table-responsive">
            <table class="table table-borderless table-data3">
            <thead>
            <tr>
                <th>#</th>
                <th>Виробник</th>
                <th>Власник</th>
                <th>Ціна</th>
                <th>Доставка</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($order->offers as $businessIncomeRequest)
                <tr @if($businessIncomeRequest->id == $order->offer_id) class="selected" @endif>
                    <td>
                        <b>{{ $businessIncomeRequest->offer_number }}</b><br>
                        {{$businessIncomeRequest->factory->business->phone}}
                    </td>
                    <td>
                        <b>{{$businessIncomeRequest->seller->first_name}} {{$businessIncomeRequest->seller->last_name}}</b><br>
                        {{$businessIncomeRequest->seller->phone}}
                    </td>
                    <td>
                        {{$businessIncomeRequest->price}}
                    </td>
                    <td>
                        {{$businessIncomeRequest->delivery}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
        @else
            <div class="alert alert-warning" role="alert">
                Жоден виробник не відкликнувся на замовлення.
            </div>
        @endif

    </div>
</div>

@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?language=uk-UK&key={{ (env('APP_DEBUG') == true) ? env('GOOGLE_API_KEY_TEST') : env('GOOGLE_API_KEY_PRODUCTION') }}&libraries=places"></script>

    <script>
        jQuery(function($) {
            google.maps.event.addDomListener(window, 'load', buildAutocomplete());
        });
    </script>

@endsection
