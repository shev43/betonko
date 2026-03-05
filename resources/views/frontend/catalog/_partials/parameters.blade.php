<div class="col-6 col-md-4">
    <div class="parameters-item {{is_null($product->mark) ? 'parameters-item--unknow' : ''}}">
        <svg class="icon icon-type icon-model">
            <use xlink:href="#icon-15"></use>
        </svg>
        <span><b>{{ is_null($product->mark ) ? 'н/в' : Config::get('product.mark.' . $product->mark) }}</b></span>
    </div>
</div>
<div class="col-6 col-md-4">
    <div class="parameters-item {{is_null($product->class) ? 'parameters-item--unknow' : ''}}">
        <svg class="icon icon-type icon-class">
            <use xlink:href="#icon-16"></use>
        </svg>
        <span><b>{{ is_null($product->class) ? 'н/в' : Config::get('product.class.' . $product->class) }}</b></span>
    </div>
</div>

<div class="col-6 col-md-4">
    <div class="parameters-item {{is_null($product->frost_resistance) ? 'parameters-item--unknow' : ''}}">
        <svg class="icon icon-type icon-frost">
            <use xlink:href="#icon-17"></use>
        </svg>
        <span><b>{{ is_null($product->frost_resistance ) ? 'н/в' : Config::get('product.frost_resistance.' . $product->frost_resistance) }}</b></span>
    </div>
</div>
<div class="col-6 col-md-4">
    <div class="parameters-item {{is_null($product->water_resistance ) ? 'parameters-item--unknow' : ''}}">
        <svg class="icon icon-type icon-water">
            <use xlink:href="#icon-18"></use>
        </svg>
        <span><b>{{ is_null($product->water_resistance) ? 'н/в' : Config::get('product.water_resistance.' . $product->water_resistance) }}</b></span>
    </div>
</div>
<div class="col-6 col-md-4">
    <div class="parameters-item {{is_null($product->mixture_mobility) ? 'parameters-item--unknow' : ''}}">
        <svg class="icon icon-type icon-mobility">
            <use xlink:href="#icon-19"></use>
        </svg>
        <span><b>{{ is_null($product->mixture_mobility) ? 'н/в' : Config::get('product.mixture_mobility.' . $product->mixture_mobility) }}</b></span>
    </div>
</div>
<div class="col-6 col-md-4">
    <div class="parameters-item {{is_null($product->winter_supplement) ? 'parameters-item--unknow' : ''}}">
        <svg class="icon icon-type icon-winter">
            <use xlink:href="#icon-20"></use>
        </svg>
        <span><b>{{ is_null($product->winter_supplement) ? 'н/в' : Config::get('product.winter_supplement.' . $product->winter_supplement) }}</b></span>
    </div>
</div>
