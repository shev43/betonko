<span class="d-lg-none" style="font-size: 20px;">
    @if(request()->routeIs('business::setting.profile.*'))<strong>Профіль</strong>@endif
    @if(request()->routeIs('business::setting.company.*'))<strong>Підприємство</strong>@endif
    @if(request()->routeIs('business::setting.contacts.*'))<strong>Контактні особи</strong>@endif
    @if(request()->routeIs('business::setting.factories.*'))<strong>Заводи</strong>@endif
    @if(request()->routeIs('business::setting.product.*'))<strong>Продукція</strong>@endif
</span>

<button class="submenu-burger menuToggle" href="#submenu" style="float: right">
    <svg class="icon">
        <use xlink:href="#icon-gear"></use>
    </svg>
</button>
<nav class="submenu justify-content-center" id="submenu">
    <a class="submenu-item py-2 {{ (request()->routeIs('business::setting.profile.*')) ? 'active' : '' }}" href="{{route('business::setting.profile.index', ['lang'=>app()->getLocale()])}}"><span>Профіль</span></a>
    <a class="submenu-item py-2 {{ (request()->routeIs('business::setting.company.*')) ? 'active' : '' }}" href="{{route('business::setting.company.index', ['lang'=>app()->getLocale()])}}"><span>Підприємство</span></a>
    <a class="submenu-item py-2 {{ (request()->routeIs('business::setting.contacts.*')) ? 'active' : '' }}" href="{{route('business::setting.contacts.index', ['lang'=>app()->getLocale()])}}">Контактні особи</a>
    <a class="submenu-item py-2 {{ (request()->routeIs('business::setting.factories.*')) ? 'active' : '' }}" href="{{route('business::setting.factories.index', ['lang'=>app()->getLocale()])}}">Заводи</a>
    <a class="submenu-item py-2 {{ (request()->routeIs('business::setting.product.*')) ? 'active' : '' }}" href="{{route('business::setting.product.index', ['lang'=>app()->getLocale()])}}">Продукція</a>
    <button class="close menuToggle" href="#submenu">
        <svg class="icon">
            <use xlink:href="#icon-5"></use>
        </svg>
    </button>

</nav>
