<span class="d-lg-none" style="font-size: 20px;">
@if(request()->routeIs('customer::profile.*'))<strong>Профіль</strong>@endif
@if(request()->routeIs('customer::notifications.*'))<strong>Сповіщення</strong>@endif
</span>
<button class="submenu-burger menuToggle" href="#submenu" style="float: right">
    <svg class="icon">
        <use xlink:href="#icon-gear"></use>
    </svg>
</button>
<nav class="submenu justify-content-center" id="submenu">
    <a class="submenu-item py-2 {{ (request()->routeIs('customer::profile.*')) ? 'active' : '' }}" href="{{route('customer::profile.index', ['lang'=>app()->getLocale()])}}"><span>Профіль</span></a>
    <a class="submenu-item py-2 {{ (request()->routeIs('customer::notifications.*')) ? 'active' : '' }}" href="{{route('customer::notifications.index', ['lang'=>app()->getLocale()])}}"><span>Сповіщення</span>
        <span id="notificationCount" class="d-none badge badge-pill badge-warning position-absolute" style="margin-left: 130px;margin-top: -30px;font-size: 13px;"></span>
        @if(!Auth::guest() && Auth::guard('client')->check())
            <script>
                unreadNotification = setTimeout(function () {
                    $.get('/ua/customer/unread-notification').done(function (data) {
                        if (data > 0) {
                            $('#notificationCount').removeClass('d-none');
                            $('#notificationCount').text(data);
                        } else {
                            $('#notificationCount').addClass('d-none');
                        }
                    });
                }, 300);

                $(function () {
                    unreadNotification;
                });
            </script>
        @endif

    </a>
    <button class="close menuToggle" href="#submenu">
        <svg class="icon">
            <use xlink:href="#icon-5"></use>
        </svg>
    </button>
</nav>
