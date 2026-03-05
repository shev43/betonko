<div class="modal auth fade" tabindex="-1" id="contact_usModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <svg>
                    <use xlink:href="#icon-5"></use>
                </svg>
            </button>
            <div class="modal-inner auth-inner">
                <h3 class="heading" style="margin-bottom: 20px;">Зворотній зв'язок</h3>


                <ul class="nav nav-tabs" id="authModalTab" role="tablist" style="margin-bottom: 30px;">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="client-tab" data-toggle="tab" href="#client" role="tab"
                           aria-controls="home" aria-selected="false">Підтримка</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="seller-tab" data-toggle="tab" href="#seller" role="tab"
                           aria-controls="profile" aria-selected="true">Відгук</a>
                    </li>
                </ul>


                <div>
                    <div class="client-login">
                        @include('frontend._modules.loader')
                        <div class="step-1">
                            <form method="post" action="" id="send-contact_us-sms">
                                @csrf
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label for="user-phone">Номер телефону:</label>
                                    <input type="text" class="form-control bfh-phone" id="user-phone" name="phone" placeholder="+38 xxx xxx-xx-xx">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label for="user-email">Email:</label>
                                    <input type="email" class="form-control " id="user-email" name="email"
                                           placeholder="E-mail">
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="form-group" style="margin-bottom: 35px;">
                                    <label for="comment">Коментар:</label>
                                    <textarea class="form-control" name="comment" style="max-height:70px;min-height:70px;height:70px;"></textarea>
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="form-group" style="margin-bottom: 0px;">
                                    <button type="submit" class="btn btn-default">Надіслати</button>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>


            </div>
        </div>
    </div>
</div>
