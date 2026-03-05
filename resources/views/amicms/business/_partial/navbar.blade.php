<div class="columns-panel-item-group">
    <a class="columns-panel-item columns-panel-item-link {{ (request()->routeIs('amicms::business.profile.*')) ? 'active' : '' }}" href="{{ route('amicms::business.profile.index', ['business_id'=>$business_id]) }}">
        <div class="d-flex align-items-center">
            <i class="feather font-size-lg icon-user"></i>
            <span class="ms-3">Профіль</span>
        </div>
    </a>

    <a class="columns-panel-item columns-panel-item-link {{ (request()->routeIs('amicms::business.edit')) ? 'active' : '' }}" href="{{ route('amicms::business.edit', ['business_id'=>$business_id]) }}">
        <div class="d-flex align-items-center">
            <i class="feather font-size-lg icon-bell"></i>
            <span class="ms-3">Підприємства</span>
        </div>
    </a>

    <a class="columns-panel-item columns-panel-item-link {{ (request()->routeIs('amicms::business.contacts.*')) ? 'active' : '' }}" href="{{ route('amicms::business.contacts.index', ['business_id'=>$business_id]) }}">
        <div class="d-flex align-items-center">
            <i class="feather font-size-lg icon-lock"></i>
            <span class="ms-3">Контакти</span>
        </div>
    </a>
    <a class="columns-panel-item columns-panel-item-link {{ (request()->routeIs('amicms::business.factories.*')) ? 'active' : '' }}" href="{{ route('amicms::business.factories.index', ['business_id'=>$business_id]) }}">
        <div class="d-flex align-items-center">
            <i class="feather font-size-lg icon-link-2"></i>
            <span class="ms-3">Заводи</span>
        </div>
    </a>
    <a class="columns-panel-item columns-panel-item-link {{ (request()->routeIs('amicms::business.products.*')) ? 'active' : '' }}" href="{{ route('amicms::business.products.index', ['business_id'=>$business_id]) }}">
        <div class="d-flex align-items-center">
            <i class="feather font-size-lg icon-link-2"></i>
            <span class="ms-3">Продукція</span>
        </div>
    </a>
    <a class="columns-panel-item columns-panel-item-link {{ (request()->routeIs('amicms::business.subscription.*')) ? 'active' : '' }}" href="{{ route('amicms::business.subscription.index', ['business_id'=>$business_id]) }}">
        <div class="d-flex align-items-center">
            <i class="feather font-size-lg icon-link-2"></i>
            <span class="ms-3">Преміум підписки</span>
        </div>
    </a>
</div>
