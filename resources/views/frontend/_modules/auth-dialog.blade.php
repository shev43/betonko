<div class="modal auth fade" tabindex="-1" id="authModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <svg>
                    <use xlink:href="#icon-5"></use>
                </svg>
            </button>
            <div class="modal-inner auth-inner">
                <h3 class="heading">Увійти в кабінет</h3>

                    <ul class="nav nav-tabs" id="authModalTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="client-tab" data-toggle="tab" href="#client" role="tab"
                               aria-controls="client" aria-selected="true">Покупець</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="seller-tab" data-toggle="tab" href="#seller" role="tab"
                               aria-controls="seller" aria-selected="false">Партнер</a>
                        </li>
                    </ul>

                <div class="tab-content" id="authModalTabContent">
                    @include('frontend._modules.loader')

                    <div class="tab-pane fade show active" id="client" role="tabpanel" aria-labelledby="client-tab">
                        <div class="client-login">
                            @include('frontend._modules.auth.customer.login')
                        </div>
                        <div class="client-register" style="display: none">
                            @include('frontend._modules.auth.customer.register')
                        </div>
                    </div>

                    @include('frontend._modules.partials.auth-business-form')
                </div>
            </div>
        </div>
    </div>
</div>
