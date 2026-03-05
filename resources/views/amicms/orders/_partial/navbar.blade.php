<nav>
    <div class="nav nav-tabs justify-content-center">
        <a class="nav-item nav-link {{ (request()->routeIs('amicms::business.profile.*')) ? 'active' : '' }}" href="{{ route('amicms::business.profile.index', ['business_id'=>$business_id]) }}">
            <i class="fas fa-user"></i>
            Профіль
        </a>

        <a class="nav-item nav-link {{ (request()->routeIs('amicms::business.view')) ? 'active' : '' }}" href="{{ route('amicms::business.view', ['business_id'=>$business_id]) }}">
            <i class="fas fa-warehouse"></i>
            Підприємства
        </a>

        <a class="nav-item nav-link {{ (request()->routeIs('amicms::business.contacts.*')) ? 'active' : '' }}" href="{{ route('amicms::business.contacts.index', ['business_id'=>$business_id]) }}">
            <i class="fa fa-phone-square"></i>
            Контакти
        </a>

        <a class="nav-item nav-link {{ (request()->routeIs('amicms::business.factories.*')) ? 'active' : '' }}" href="{{ route('amicms::business.factories.index', ['business_id'=>$business_id]) }}">
            <i class="fas fa-warehouse"></i>
            Заводи
        </a>

        <a class="nav-item nav-link {{ (request()->routeIs('amicms::business.products.*')) ? 'active' : '' }}" href="{{ route('amicms::business.products.index', ['business_id'=>$business_id]) }}">
            <i class="fa fa-shopping-cart"></i>
            Продукція
        </a>

        <a class="nav-item nav-link {{ (request()->routeIs('amicms::business.subscription.*')) ? 'active' : '' }}" href="{{ route('amicms::business.subscription.index', ['business_id'=>$business_id]) }}">
            <i class="far fa-credit-card"></i>
            Преміум підписки
        </a>
    </div>
</nav>
