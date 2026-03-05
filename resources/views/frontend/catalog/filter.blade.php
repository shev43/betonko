<div class="order-form range">
    <div class="row d-flex justify-content-end">
        <div class="col-12 col-md-6">
            <div class="form-group ">
                <div class="">
                    <select name="region" class="selectpicker {{$errors->has('region') ? 'alert-danger' : ''}}" title="Вся Україна" data-style="form-control">
                        <option value="">Вся Україна</option>
                        @foreach($regions as $region)
                            <option value="{{$region->name}}"
                                {{old('region') == $region->name || app('request')->input('region') == $region->name ? 'selected="selected"' :''}}>
                                {{$region->name}}
                            </option>
                        @endforeach
                    </select>
                    @foreach($errors->get('region') as $error)
                        <small class="form-text text-danger">{!! $error !!}</small>
                    @endforeach
                </div>
            </div>
        </div>


    </div>

</div>
