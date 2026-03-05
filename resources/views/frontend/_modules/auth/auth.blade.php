<div class="modal fade" tabindex="-1" id="authModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <svg>
                    <use xlink:href="#icon-5"></use>
                </svg>
            </button>
            <div class="modal-inner">
                <h3 class="heading">Особистий кабінет</h3>
                <ul class="nav nav-tabs" id="authModalTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="business-tab" data-toggle="tab" href="#business" role="tab" aria-controls="business" aria-selected="false">Партнер</a>
                    </li>
                </ul>
                <div class="tab-content" id="authModalTabContent">
                    <div class="tab-pane fade active show" id="business" role="tabpanel" aria-labelledby="business-tab">
                        <section class="login">
                            @include('frontend._modules.auth.business.login')
                        </section>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
