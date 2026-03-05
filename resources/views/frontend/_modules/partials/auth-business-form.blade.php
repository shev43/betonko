<div class="tab-pane fade" id="seller" role="tabpanel" aria-labelledby="seller-tab">
    <div class="seller-login">
        <div class="step-1">
            <form method="post" action="{{route('business::profile.login', ['lang'=>app()->getLocale()])}}" id="send-business-login">
                @csrf
                <input name="referer" type="hidden" value="{{ request()->get('referer') ?? (Auth::guard('client')->check()) ? route('business::subscription.index', ['lang'=>app()->getLocale()])  : '' }}">
                <div class="invalid-feedback" style="margin-bottom: 20px;"></div>
                <div class="form-group">
                    <label for="email">Електронна пошта:</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="sample@email.address">
                </div>
                <div class="form-group">
                    <label>Пароль:</label>
                    <div class="form-pass">
                        <input class="form-pass-checkbox" type="checkbox" id="password" value="0">
                        <label class="form-pass-label" for="password">
                            <svg>
                                <use xlink:href="#icon-14"></use>
                            </svg>
                        </label>
                        <input type="password" class="form-control" name="password" placeholder="мінімум 8 символів" autocomplete="off">
                    </div>
                    <div class="invalid-feedback"></div>

                </div>

                <div class="form-group">
                    <button class="btn btn-default">Увійти</button>
                </div>
            </form>

            <div class="form-group">
                <label>Бажаєте стати партнером?</label>
                <a class="btn btn-border_dark" href="{{route('business::profile.register', ['lang'=>app()->getLocale()])}}">Зареєструватися</a>
            </div>
        </div>
    </div>
</div>
