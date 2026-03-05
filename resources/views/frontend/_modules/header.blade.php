<header class="header sticky-top">
    <div class="container">
        <div class="header-body">
            <div class="header-logo">
                @if(Auth::guard('client')->check())
                    <a href="{{ route('customer::pages.index', ['lang'=>app()->getLocale()]) }}">
                        @include('frontend._modules.logo')
                    </a>
                @elseif(Auth::guard('business')->check())
                    <a href="{{ route('business::pages.index', ['lang'=>app()->getLocale()]) }}">
                        @include('frontend._modules.logo')
                    </a>
                @else
                    <a href="{{ route('frontend::pages.index', ['lang'=>app()->getLocale()]) }}">
                        @include('frontend._modules.logo')
                    </a>
                @endif
            </div>

            @if(Auth::guard('client')->check() || Auth::guard('business')->check())

                @if(Auth::guard('business')->check())
                    <button class="burger menuToggle" href="#menu">
                        <svg class="icon">
                            <use xlink:href="#icon-burger"></use>
                        </svg>
                        <span id="notificationBadge" class="d-none badge badge-pill badge-warning position-absolute" style="margin-top: -32px;margin-left: 28px;font-size: 8px;">&nbsp;</span>
                    </button>
                    <nav class="menu" id="menu">
                        <a class="menu-item {{ (request()->routeIs('business::dashboard.*')) ? 'active' : '' }}" href="{{route('business::dashboard.index', ['lang'=>app()->getLocale()])}}"><span>Статистика</span></a>
                        <a class="menu-item {{ (request()->routeIs('business::setting*')) ? 'active' : '' }}" href="{{route('business::setting.profile.index', ['lang'=>app()->getLocale()])}}">
                            <span class="d-md-none d-flex pr-2">Налаштування</span>
                            <svg class="icon">
                                <use xlink:href="#icon-gear"></use>
                            </svg>
                        </a>
                        <a href="#" class="menu-item d-md-none d-flex" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <span class="pr-2">Вихід</span>
                            <svg class="icon">
                                <use xlink:href="#icon-7-1"></use>
                            </svg>
                        </a>
                        <button class="close menuToggle" href="#menu">
                            <svg class="icon">
                                <use xlink:href="#icon-5"></use>
                            </svg>
                        </button>
                    </nav>

                    <a href="" class="header-btn d-md-flex d-none" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <span>Вихід</span> <img src="{{ asset('img/layout/icon-exit.svg') }}" alt=""> </a>
                    <form id="logout-form" action="{{route('business::profile.logout', ['lang'=>app()->getLocale()])}}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endif
            @else
                <div class="header-nav-guest">
                    <a href="{{ route('frontend::catalog.index', ['lang'=>app()->getLocale()]) }}" class="header-nav-guest-link">Каталог</a>
                    <span class="header-nav-guest-lang">UA / RU</span>
                    <a href="#" class="header-btn-login" data-toggle="modal" data-target="#authModal" data-auth-action="login">Вхід</a>
                    <a href="#" class="header-btn-register" data-toggle="modal" data-target="#authModal" data-auth-action="register">Реєстрація</a>
                </div>
            @endif
        </div>
    </div>
</header>
