require('./bootstrap');

require('jquery-mask-plugin')

require('flatpickr')
require('./flatpickr-locale')

let wNumb = require('wnumb')
let noUiSlider = require('nouislider')



function initFormPass(){
    $(document).on('change', '.form-pass-checkbox', function() {
        $(this).siblings('.form-control').attr('type', function(index, attr){
            return attr == 'password' ? 'text' : 'password';
        });
    });

    $(document).on('change', '.form-pass-checkbox-confirm', function() {
        $(this).siblings('.form-control').attr('type', function(index, attr){
            return attr == 'password' ? 'text' : 'password';
        });
    });
}

function initMenu(){
    $(document).on('click', '.menuToggle', function() {
        $($(this).attr('href')).toggleClass('show');
    });

    $(document).on('click', '.close.menuToggle', function() {
        $($(this).attr('href')).toggleClass('show');
    });

    $(document).on('click', 'nav#menu', function() {
        $(this).toggleClass('show');
    });

    $(document).on('click', 'nav#submenu', function() {
        $(this).toggleClass('show');
    });
}

function initBgPremium(){
    if ($('.premium-bg').length) {
        if (window.matchMedia('(min-width: 768px)').matches){
            $('.premium-bg').css('right', '50%');
        } else if (window.matchMedia('(max-width: 767.8px)').matches){
            $('.premium-bg').css('right', -$('.premium-bg').parent('.premium-side').offset().left);
        }
        $('.premium-bg').css('left', -$('.premium-bg').parent('.premium-side').offset().left);
    }
}

function confirmDelete() {
    $('#confirm-delete').on('show.bs.modal', function(e) {
        $('.btn-ok').click(function(data) {
            $(this).attr("disabled", true);
            let href = $(e.relatedTarget).data('href');
            if(typeof href !== "undefined") {
                location.href = href;
            }
        });
    });

}

function confirmCanceled() {
    $('#confirm-canceled').on('show.bs.modal', function(e) {
        $('.btn-ok').click(function(data) {
            $(this).attr("disabled", true);
            let href = $(e.relatedTarget).data('href');
            if(typeof href !== "undefined") {
                location.href = href;
            }
        });

    });

}

// ORDER
function calcOrderPrice() {
    let count = $('form.order-form input[name="count"]').val();

    $('form.order-form #price-min').text(
        count * $('form.order-form input#start').val()
    );

    $('form.order-form #price-max').text(
        count * $('form.order-form input#end').val()
    );
}

function initRangeSlider() {
    $('.range, .rangeInit').each(function() {
        var obj = $(this);
        var slider = obj.find('.range-slider');
        var start = obj.find('.start');
        var end = obj.find('.end');
        var inputs = [start[0], end[0]];

        noUiSlider.create(slider[0], {
            start: [slider.data('start'), slider.data('end')],
            connect: true,
            range: {
                'min': slider.data('min'),
                'max': slider.data('max')
            },
            step: slider.data('step'),
            format: wNumb({
                decimals: 0
            })
        });

        slider[0].noUiSlider.on('update', function (values, handle) {
            inputs[handle].value = values[handle];
            calcOrderPrice();
        });

        inputs.forEach(function (input, handle) {
            input.addEventListener('change', function () {
                slider[0].noUiSlider.setHandle(handle, this.value);
            });
        });
    });
}

// BusinessIncomeRequest
function calculatePriceForRequest() {
    let price = parseFloat($('#BusinessIncomeRequest input[name="price"]').val());
    let delivery = parseFloat($('#BusinessIncomeRequest input[name="delivery"]').val());
    let count = parseInt($('#BusinessIncomeRequest input[name="count"]').val());

    $('#BusinessIncomeRequest .calculate-price > span').text(
        Number(Math.round((price * count) +'e2')+'e-2')
    );

    $('#BusinessIncomeRequest .calculate-price-total > span').text(
        Number(Math.round((price * count + delivery) +'e2')+'e-2')
    );
}

buildAutocomplete = function () {
    const acInputs = $(".autocomplete");
    const options = {
        fields: ["geometry"],
        strictBounds: false,
        componentRestrictions: {country: "ua"}
    };

    const autocomplete = new google.maps.places.Autocomplete(acInputs[0], options);

    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        const place = autocomplete.getPlace();

        let location_lat_destination = $('form').find('.location_lat_destination');
        let location_lng_destination = $('form').find('.location_lng_destination');
        if(typeof location_lat_destination.val() !== "undefined" && typeof location_lng_destination.val() !== "undefined") {
            location_lat_destination.remove();
            location_lng_destination.remove();
        }

        $(acInputs).parent().append('<input class="location_lat_destination" type="hidden" name="location_lat" value="' + place.geometry.location.lat() + '" />');
        $(acInputs).parent().append('<input class="location_lng_destination" type="hidden" name="location_lng" value="'+ place.geometry.location.lng() + '" />');

    });


    return buildAutocomplete;
}

function initDatepicker(){
    $('.datepickerStatic input').flatpickr({
        inline: true,
        mode: 'range',
        minDate: 'today',
        dateFormat: 'd.m.Y',
        monthSelectorType: 'static',
        prevArrow: '<svg><use xlink:href="#icon-left"></use></svg>',
        nextArrow: '<svg><use xlink:href="#icon-right"></use></svg>',
        locale: 'uk'
    });
}



$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {
    $('.show-phone-number').click(function(e) {
        e.preventDefault();
        let phone = $(this).attr('data-phone');

        $(this).parent().text(phone);
        $(this).addClass('hidden');

    })



    $('input[name=phone], input[name=contact_phone], input.disabled-phone').mask('+38 099 999-99-99');

    let startResendTimer = function (timer) {
        timer.text(timer.data('second'));
        timer.parent().show();
        timer.parent().parent().find(".resend-login-sms, .resend-register-sms").hide();
        timer.parent().parent().find(".resend-change-phone-sms, .resend-register-sms").hide();

        let timeLeft = parseInt(timer.data('second'));
        var downloadTimer = setInterval(function () {
            if (timeLeft <= 0) {
                clearInterval(downloadTimer);
                timer.parent().hide();
                timer.parent().parent().find(".resend-login-sms, .resend-register-sms").show();
                timer.parent().parent().find(".resend-change-phone-sms, .resend-register-sms").show();
            } else {
                timer.text(timeLeft);
            }
            timeLeft -= 1;
        }, 1000);
    }

    let setActionStep = function (block, step) {
        block.children('div').hide();
        if (step === 'loader') {
            block.find(".loader").show();
        } else {
            block.find(".step-" + step).show();
        }
    }

    let showLoginForm = function () {
        $("div.auth-inner div#client").show();
        $("div.auth-inner div.client-register").hide();
        $("div.auth-inner div.client-login").show();

        setActionStep($('div.auth-inner div.client-login'), 1);
    }

    $("#authModal").on('show.bs.modal', function (e) {
        var trigger = $(e.relatedTarget);
        var action = trigger.data('auth-action');

        // Activate client tab by default
        $('#authModalTab #client-tab').tab('show');
        $('#authModalTabContent #client').show();
        $('#authModalTabContent #seller').hide();

        if (action === 'register') {
            $("div.auth-inner div.client-login").hide();
            $("div.auth-inner div.client-register").show();
            setActionStep($('div.auth-inner div.client-register'), 1);
        } else {
            showLoginForm();
        }
    });

    $("div.form-group-sms input[type='text']").keyup(function (e) {
        var keyCode = e.keyCode || e.which;

        if (keyCode === 8) {
            // backspace
            if (!this.value.length) {
                $(this).prev('input[type=text]').focus();
            }

        } else {
            if (this.value.length === this.maxLength) {
                $(this).next('input[type=text]').focus();
            }
        }
    });

    $("#authModalTab #client-tab").click(function () {
        $('#authModalTabContent #client').show();
        $('#authModalTabContent #seller').hide();
    });

    $("#authModalTab #seller-tab").click(function () {
        $('#authModalTabContent #seller').show();
        $('#authModalTabContent #client').hide();
    });


    $(".go-to-register").click(function () {
        $("div.auth-inner div#client").show();
        $("div.auth-inner div.client-login").hide();
        $("div.auth-inner div.client-register").show();

        // setActionStep($('div.auth-inner div#authModalTabContent'), 1);
        setActionStep($('div.auth-inner div.client-register'), 1);
    });

    $(".go-to-login").click(function () {
        showLoginForm();
    });

    $(".resend-login-sms").click(function () {
        $("#send-login-sms").submit();
    });

    $(".resend-register-sms").click(function () {
        $("#send-register-sms").submit();
    });

    // Client Login
    $("#send-login-sms").submit(function (e) {
        e.preventDefault();

        let form = $(this);
        let loginBlock = form.closest('div.client-login');
        setActionStep($('#authModalTabContent'), 'loader');

        form.find('.invalid-feedback').text('');
        form.find('input').removeClass('is-invalid');

        $.post(form.attr('action'), form.serialize()).done(function (data) {
            $('#authModalTabContent #client').show();
            // $('#authModalTabContent #seller').show();
            $('#authModalTabContent .client-login').show();
            $('#authModalTabContent .loader').hide();
            setActionStep(loginBlock, 2);
            startResendTimer(loginBlock.find(".step-2 .timer"));
            loginBlock.find(".step-2").find('input[name=c1]').focus();

            $("#send-login input[name='phone']").val(form.find("input[name='phone']").val());
        }).fail(function (data) {
            $('#authModalTabContent #client').show();
            // $('#authModalTabContent #seller').show();
            $('#authModalTabContent .client-login').show();
            $('#authModalTabContent .loader').hide();
            setActionStep(loginBlock, 1);
            $.each(data.responseJSON.errors, function (key, value) {
                form.find('input[name="' + key + '"]')
                    .addClass('is-invalid')
                    .parent()
                    .find('.invalid-feedback')
                    .text(value);
            });
        });
    });

    $("#send-login").submit(function (e) {
        e.preventDefault();

        $('div.seller-login').find('.loader').hide();

        let form = $(this);
        let loginBlock = form.closest('div.client-login');

        setActionStep($('#authModalTabContent'), 'loader');

        $(this).find('input[name="code"]').val('');
        let c1 = $(this).find('input[name="c1"]').val();
        let c2 = $(this).find('input[name="c2"]').val();
        let c3 = $(this).find('input[name="c3"]').val();
        let c4 = $(this).find('input[name="c4"]').val();

        $(this).find('input[name="code"]').val(c1 + c2 + c3 + c4);

        form.find('.invalid-feedback').text('');
        form.find('input').removeClass('is-invalid');

        $.post(form.attr('action'), form.serialize()).done(function (data) {
            let ref = '/ua/customer/catalog';
            location.href=ref;

        }).fail(function (data) {

            $('#authModalTabContent #client').show();
            // $('#authModalTabContent #seller').show();
            $('#authModalTabContent .loader').hide();

            setActionStep(loginBlock, 2);

            loginBlock.find('div.form-group-sms input[type="text"]').val('');

            $.each(data.responseJSON.errors, function (key, value) {
                form.find('div.login-code-error').append(value);
            });
        });
    });

    // Client Register
    $("#send-register-sms").submit(function (e) {
        e.preventDefault();

        let form = $(this);
        let loginBlock = form.closest('div.client-register');
        setActionStep($('#authModalTabContent'), 'loader');

        form.find('.invalid-feedback').text('');
        form.find('input').removeClass('is-invalid');


        $.post(form.attr('action'), form.serialize()).done(function (data) {
            $('#authModalTabContent #client').show();
            // $('#authModalTabContent #seller').show();
            // $('#authModalTabContent .client-login').show();
            $('#authModalTabContent .loader').hide();

            setActionStep($('div.auth-inner div.client-register'), 2);
            startResendTimer(loginBlock.find(".step-2 .timer"));
            loginBlock.find(".step-2").find('input[name=c1]').focus();

            $("#send-register input[name='phone']").val(form.find("input[name='phone']").val());
            $("#send-register input[name='first_name']").val(form.find("input[name='first_name']").val());
            $("#send-register input[name='last_name']").val(form.find("input[name='last_name']").val());
        }).fail(function (data) {
            $('#authModalTabContent #client').show();
            // $('#authModalTabContent #seller').show();
            $('#authModalTabContent .client-login').hide();
            $('#authModalTabContent .client-register').show();
            $('#authModalTabContent .loader').hide();

            setActionStep(loginBlock, 1);
            $.each(data.responseJSON.errors, function (key, value) {
                form.find('input[name="' + key + '"]')
                    .addClass('is-invalid')
                    .parent()
                    .find('.invalid-feedback')
                    .text(value);
            });
        });
    });

    $("#send-register").submit(function (e) {
        e.preventDefault();

        let form = $(this);
        let loginBlock = form.closest('div.client-register');
        setActionStep($('#authModalTabContent'), 'loader');

        form.find('.invalid-feedback').text('');
        form.find('input').removeClass('is-invalid');

        $(this).find('input[name="code"]').val('');

        let c1 = $(this).find('input[name="c1"]').val();
        let c2 = $(this).find('input[name="c2"]').val();
        let c3 = $(this).find('input[name="c3"]').val();
        let c4 = $(this).find('input[name="c4"]').val();

        $(this).find('input[name="code"]').val(c1 + c2 + c3 + c4);
        $.post(form.attr('action'), form.serialize()).done(function (data) {
            location.reload();
        }).fail(function (data) {
            $('#authModalTabContent #client').show();
            $('#authModalTabContent .client-login').hide();
            $('#authModalTabContent .client-register').show();
            $('#authModalTabContent .loader').hide();
            setActionStep(loginBlock, 2);
            loginBlock.find('div.form-group-sms input[type="text"]').val('');

            $.each(data.responseJSON.errors, function (key, value) {
                form.find('div.login-code-error').append(value);
            });
        }).always(function () {
            loginBlock.find('div.loader').hide();
        });
    });

    // Business Login
    $("#send-business-login").submit(function (e) {
        e.preventDefault();

        let form = $(this);
        let loginBlock = form.closest('#seller .seller-login');
        setActionStep($('#authModalTabContent'), 'loader');

        form.find('.invalid-feedback').text('');

        $.post(form.attr('action'), form.serialize()).done(function (responses) {
            // let ref = form.find('input[name=referer]').val();

            // if(ref == '') {
                ref = '/ua/business/dashboard/';
            // }
            location.href=ref;
        }).fail(function (data) {

            // $('#authModalTabContent #client').show();
            $('#authModalTabContent #seller').show();
            $('#authModalTabContent .loader').hide();

            setActionStep(loginBlock, 1);

            $.each(data.responseJSON.errors, function (key, value) {
                form.find('input[name="' + key + '"]')
                    .addClass('is-invalid')
                    .parent().parent()
                    .find('.invalid-feedback')
                    .text(value)
                    .show();
            });
        });
    });

    $('form.order-form input#start, form.order-form input#end').on("input", function () {
        calcOrderPrice();
    });

    $('form.order-form input[name="count"]').change(function () {

        if ($('form.order-form #estimated-product-price').length) {
            let count = $('form.order-form input[name="count"]').val(),
                price = $('#estimated-product-price').data('price');

            $('form.order-form #estimated-product-price').text(count * price);

        } else {
            calcOrderPrice();
        }
    });

    $('form.order-form').on('keyup keypress', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    $('.btnStatFilter').click(function(e) {
        e.preventDefault();
        $('#formStatFilter').submit();
    });


    $('form#order').on('submit', function (e) {
        $(this).find('[type="submit"]').prop('disabled', true);
        return true;
    });

    $('form.order-form .one-active-checkbox input:checkbox').click(function () {
        if ($(this).is(':checked')) {
            $(this).closest('.one-active-checkbox').find('input:checkbox').not(this).prop('checked', false);
            var value = $(this).val();
        } else {
            $(this).closest('.one-active-checkbox').find('input:checkbox').not(this).prop('checked', true);
            var value = $(this).closest('.one-active-checkbox').find('input:checkbox').not(this).val();
        }

        let addressBlock = $('.address-block');
        let map = $('.map');

        $("input[name='" + $(this).data('field') + "']").val(value);

        if (value === 'self') {
            addressBlock.addClass('disabled').find('input').prop("disabled", true);
            map.addClass('disabled');
        } else {
            addressBlock.removeClass('disabled').find('input').prop("disabled", false);
            map.removeClass('disabled');
        }
    });

    $('#dataModal .select-date').click(function () {
        $('form.order-form input[name="date_of_delivery"]').val(
            $('#dataModal input.datepickerStaticValue').val()
        );
    });

    $('#BusinessIncomeRequest #select-product-btn').click(function () {
        let product = $('input[name=get_product]:checked', '#BusinessIncomeRequest').val();
        let product_price = $('input[name=get_product]:checked', '#BusinessIncomeRequest').data('price');
        let product_mark = $('input[name=get_product]:checked', '#BusinessIncomeRequest').data('mark');
        let product_class = $('input[name=get_product]:checked', '#BusinessIncomeRequest').data('class');
        let product_frost_resistance = $('input[name=get_product]:checked', '#BusinessIncomeRequest').data('frost_resistance');
        let product_water_resistance = $('input[name=get_product]:checked', '#BusinessIncomeRequest').data('water_resistance');
        let product_mixture_mobility = $('input[name=get_product]:checked', '#BusinessIncomeRequest').data('mixture_mobility');
        let product_winter_supplement = $('input[name=get_product]:checked', '#BusinessIncomeRequest').data('winter_supplement');
        let product_factory_id = $('input[name=get_product]:checked', '#BusinessIncomeRequest').data('factories_id');
        $('#modalParameters').modal('toggle');

        if (product) {
            $("input[name=mark]").val(product_mark);
            $("input[name=class]").val(product_class);
            $("input[name=frost_resistance]").val(product_frost_resistance);
            $("input[name=water_resistance]").val(product_water_resistance);
            $("input[name=mixture_mobility]").val(product_mixture_mobility);
            $("input[name=winter_supplement]").val(product_winter_supplement);
            $("input[name=factory_id]").val(product_factory_id);

            $('#BusinessIncomeRequest .product-error').attr("style", "display:none !important");

            $('#BusinessIncomeRequest .js-product-selection').hide();
            $('#BusinessIncomeRequest .parameters_product-list > div.parameters').hide();
            $('#BusinessIncomeRequest .parameters_product-list > div.product-' + product).show();

            $('#BusinessIncomeRequest input[name="price"]').val(
                parseFloat(product_price)
            );
            calculatePriceForRequest();
        }
    });

    $('#BusinessIncomeRequest .parameters_product-list .parameters-refresh').click(function (e) {
        e.preventDefault();

        $('#BusinessIncomeRequest .js-product-selection').show();
        $('#BusinessIncomeRequest .parameters_product-list > div.parameters').hide();

        $("#product").val('');
        $('#BusinessIncomeRequest #modalParameters input[name="get_product"]').prop('checked', false);
    });

    $('form#BusinessIncomeRequest input[name="price"], form#BusinessIncomeRequest input[name="delivery"]').change(function () {
        calculatePriceForRequest();
    });


    // BusinessSettingProfile
    $('#businessSettingsProfilePhoto input#business-image-loader').change(function () {
        let uploader = $(this);

        if ($(this).val() !== '') {
            let form_data = new FormData();
            form_data.append('photo', this.files[0]);
            $('#image-input-error').text('');

            $.ajax({
                type:'POST',
                url: uploader.data('upload'),
                data: form_data,
                contentType: false,
                processData: false,
                success: (response) => {
                    if (response) {
                        $('#businessSettingsProfilePhoto img.seller_cabinet-settings-logo').attr('src', '/storage/users/' + response);
                        $('form#businessSetting').find('input[name="photo"]').val(response);
                        $('#businessSettingsProfilePhoto .btn-delete').parent().parent().removeClass('d-none');
                    }
                }
            });
        }
    });
    $('#businessSettingsProfilePhoto .btn-delete').click(function (e) {
        e.preventDefault();

        $.post('/setting/profile/remove-file?filename='+$('form#businessSetting').find('input[name="photo"]').val() );

        let form = $('#businessSettingsProfilePhoto');

        form.find('input#business-image-loader').val('');
        $('form#businessSetting').find('input[name="photo"]').val('');
        form.find("#request-errors").text('');


        form.find('img.seller_cabinet-settings-logo').attr('src', form.find('img.seller_cabinet-settings-logo').data('empty'));
        $('#businessSettingsProfilePhoto .btn-delete').parent().parent().addClass('d-none');

    });

    // BusinessSettingCompany
    $('#businessSettingsCompanyPhoto input#business-image-loader').change(function () {
        let uploader = $(this);

        if ($(this).val() !== '') {
            let form_data = new FormData();
            form_data.append('photo', this.files[0]);
            $('#image-input-error').text('');

            $.ajax({
                type:'POST',
                url: uploader.data('upload'),
                data: form_data,
                contentType: false,
                processData: false,
                success: (response) => {
                    if (response) {
                        $('#businessSettingsCompanyPhoto img.seller_cabinet-settings-logo').attr('src', '/storage/business/' + response);
                        $('form#businessSetting').find('input[name="photo"]').val(response);
                        $('#businessSettingsCompanyPhoto .btn-delete').parent().parent().removeClass('d-none');

                    }
                }
            });
        }
    });
    $('#businessSettingsCompanyPhoto .btn-delete').click(function (e) {
        e.preventDefault();

        $.post('/setting/company/remove-file?filename='+$('form#businessSetting').find('input[name="photo"]').val() );

        let form = $('#businessSettingsCompanyPhoto');

        form.find('input#business-image-loader').val('');
        $('form#businessSetting').find('input[name="photo"]').val('');
        form.find("#request-errors").text('');

        $('#businessSettingsCompanyPhoto .btn-delete').parent().parent().addClass('d-none');

        form.find('img.seller_cabinet-settings-logo').attr('src', form.find('img.seller_cabinet-settings-logo').data('empty'));
    });

    // BusinessSettingContacts
    $('#businessSettingContactsPhoto input#business-image-loader').change(function () {
        let uploader = $(this);

        if ($(this).val() !== '') {
            let form_data = new FormData();
            form_data.append('photo', this.files[0]);
            $('#image-input-error').text('');

            $.ajax({
                type:'POST',
                url: uploader.data('upload'),
                data: form_data,
                contentType: false,
                processData: false,
                success: (response) => {
                    if (response) {
                        $('#businessSettingContactsPhoto img.seller_cabinet-settings-logo').attr('src', '/storage/users/' + response);
                        $('form#businessSetting').find('input[name="photo"]').val(response);
                        $('#businessSettingContactsPhoto .btn-delete').parent().parent().removeClass('d-none');

                    }
                }
            });
        }
    });
    $('#businessSettingContactsPhoto .btn-delete').click(function (e) {
        e.preventDefault();

        $.post('/setting/contacts/remove-file?filename='+$('form#businessSetting').find('input[name="photo"]').val() );

        let form = $('#businessSettingContactsPhoto');

        form.find('input#business-image-loader').val('');
        $('form#businessSetting').find('input[name="photo"]').val('');
        form.find("#request-errors").text('');
        $('#businessSettingContactsPhoto .btn-delete').parent().parent().addClass('d-none');

        form.find('img.seller_cabinet-settings-logo').attr('src', form.find('img.seller_cabinet-settings-logo').data('empty'));
    });

    // BusinessSettingFactory
    $('#businessSettingFactoryPhoto input#business-image-loader').change(function () {
        let uploader = $(this);

        if ($(this).val() !== '') {
            let form_data = new FormData();
            form_data.append('photo', this.files[0]);
            $('#image-input-error').text('');

            $.ajax({
                type:'POST',
                url: uploader.data('upload'),
                data: form_data,
                contentType: false,
                processData: false,
                success: (response) => {
                    if (response) {
                        $('#businessSettingFactoryPhoto img.seller_cabinet-settings-logo').attr('src', '/storage/factory/' + response);
                        $('form#businessFactory').find('input[name="photo"]').val(response);
                        $('#businessSettingFactoryPhoto .btn-delete').parent().parent().removeClass('d-none');

                    }
                }
            });
        }
    });
    $('#businessSettingFactoryPhoto .btn-delete').click(function (e) {
        e.preventDefault();

        $.post('/setting/factory/remove-file?filename='+$('form#businessFactory').find('input[name="photo"]').val() );

        let form = $('#businessSettingFactoryPhoto');

        form.find('input#business-image-loader').val('');
        $('form#businessFactory').find('input[name="photo"]').val('');
        form.find("#request-errors").text('');
        $('#businessSettingFactoryPhoto .btn-delete').parent().parent().addClass('d-none');

        form.find('img.seller_cabinet-settings-logo').attr('src', form.find('img.seller_cabinet-settings-logo').data('empty'));
    });


    // ClientProfile
    $('#customerProfilePhoto input#customer-image-loader').change(function () {
        let uploader = $(this);

        if ($(this).val() !== '') {
            let form_data = new FormData();
            form_data.append('photo', this.files[0]);
            $('#image-input-error').text('');

            $.ajax({
                type:'POST',
                url: uploader.data('upload'),
                data: form_data,
                contentType: false,
                processData: false,
                success: (response) => {
                    if (response) {
                        $('#customerProfilePhoto img.customer_cabinet-settings-logo').attr('src', '/storage/users/' + response);
                        $('form#customerProfile').find('input[name="photo"]').val(response);
                        $('#customerProfilePhoto .btn-delete').parent().parent().removeClass('d-none');

                    }
                }
            });
        }
    });
    $('#customerProfilePhoto .delete').click(function (e) {
        e.preventDefault();

        $.post('/customer/profile/remove-file?filename='+$('form#customerProfile').find('input[name="photo"]').val() );

        let form = $('#customerProfilePhoto');

        form.find('input#customer-image-loader').val('');
        $('form#customerProfile').find('input[name="photo"]').val('');
        form.find("#request-errors").text('');
        $('#customerProfilePhoto .btn-delete').parent().parent().addClass('d-none');


        form.find('img.customer_cabinet-settings-logo').attr('src', form.find('img.customer_cabinet-settings-logo').data('empty'));
    });




    $('form#order, form#businessSetting, form#customerProfile, form#businessFactory, form#order-without-client').on('keyup keypress', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    // SORT
    $('form.orderType select').change(function () {
        $(this).closest('form').submit();
    });

    $('#BusinessIncomeRequest #modalParameters').on('hidden.bs.modal', function (event) {
        $('#BusinessIncomeRequest #modalParameters input[name="get_product"]').prop('checked', false);
    });

    var clicked = false;
    $('a.btn, a.status, a.btn-ok').click(function (e) {
        e.preventDefault();

        let href = $(this).attr('href');
        if(typeof href !== "undefined") {
            location.href = $(this).attr('href');
        }

        if (clicked === false) {
            clicked = true;
        }
    })


    $("form").submit(function (e) {

        $(this).find("button[type=submit]").attr("disabled", true);
        $('#authModal').find("button[type=submit]").attr("disabled", false);

        return true;

    });

    $(document).on('hidden.bs.modal', function (event) {
        $('form').find("button[type=submit]").attr("disabled", false);
    });


    $("#filterForm .selectpicker").change(function (){
        if($(this).val() == 'support-tab') {
            $("#filterForm #address").removeClass('disabled')
            $("#filterForm #address").removeAttr('readonly')
            $("#filterForm #address").removeAttr('disabled')
        } else {
            $("#filterForm #address").addClass('disabled')
            $("#filterForm #address").attr('readonly', true)
            $("#filterForm #address").attr('disabled', true)
        }
    })

    $("#filterForm [name=region]").change(function (){
        $('#filterForm').submit();
    })



// Customer change phone
    $(".resend-change-phone-sms").click(function () {
        $("#customerProfileSendChangePhone").submit();
    });


    $("#btnChangePhone").click(function () {
        $("#customerProfileSendChangePhone").submit();
    });

    $("#customerProfileSendChangePhone").submit(function (e) {
        e.preventDefault();

        let form = $(this);
        let phoneBlock = form.closest('div.change-phone');

        form.find('.invalid-feedback').text('');
        form.find('input').removeClass('is-invalid');

        $.get(form.attr('action'), form.serialize()).done(function (data) {
            phoneBlock.find(".send-change-phone").hide()
            phoneBlock.find(".send-confirm-code").show()
            startResendTimer(phoneBlock.find(".send-confirm-code .timer"));

            $("#customerProfileSendSmsCode input[name='phone']").val(form.find("input[name='phone']").val());
        }).fail(function (data) {
            phoneBlock.find(".send-change-phone").show()
            $.each(data.responseJSON.errors, function (key, value) {
                form.find('input[name="phone"]')
                    .addClass('is-invalid')
                    .parent()
                    .find('.invalid-feedback')
                    .text(value);
            });
        });
    });

    $("#customerProfileSendSmsCode").submit(function (e) {
        e.preventDefault();

        let form = $(this);
        let phoneBlock = form.closest('div.change-phone');

        $(this).find('input[name="code"]').val('');
        let c1 = $(this).find('input[name="c1"]').val();
        let c2 = $(this).find('input[name="c2"]').val();
        let c3 = $(this).find('input[name="c3"]').val();
        let c4 = $(this).find('input[name="c4"]').val();

        $(this).find('input[name="code"]').val(c1 + c2 + c3 + c4);

        form.find('.invalid-feedback').text('');
        form.find('input').removeClass('is-invalid');

        $.get(form.attr('action'), form.serialize()).done(function (data) {
            location.reload();
        }).fail(function (data) {
            $('.change-phone .send-confirm-code').show();

            phoneBlock.find('div.form-group-sms input[type="text"]').val('');

            $.each(data.responseJSON.errors, function (key, value) {
                $('#customerProfileSendSmsCode').find('.uncorrect-sms-code').text(value);
            });
        });
    });

    $('#reviewServiceModal #reviewForm').submit(function(e) {
        e.preventDefault();

        let form = $(this);

        $.post(form.attr('action'), form.serialize()).done(function (response) {
            if(response) {
                $(form).addClass('d-none');
                $('#reviewServiceModal #reviewSuccess').removeClass('d-none');

                setTimeout(function() {
                    $('#reviewServiceModal').find('.close').click();

                }, 3000);
            }
        });

    });


    $(window).on('load resize orientationchange', function() {
        initBgPremium()
    });

    $('[popover]').each(function() {
        var obj = $(this);
        obj.popover({
            placement: 'top',
            html: true,
            template: '<div class="popover" role="tooltip"><div class="popover-header"></div><div class="popover-body"></div></div>',
            title: function() {
                return $(this).data('title');
            },
            content: function() {
                return '<a href="'+ $(this).data('link') +'"><b>'+ $(this).data('text') +'</b></a>'
            },
            trigger: 'focus'
        });
    });

    $('[popover]').hover(function() {
        $(this).find('a').css('border', 'none');
        $(this).focus();
    });

    setTimeout(function () {
        $("#offer_details_status").fadeOut(300);
    }, 10000);

    setTimeout(function () {
        calcOrderPrice;

    }, 1000);


    // INIT
    initFormPass();
    initMenu();
    confirmDelete();
    confirmCanceled();
    calculatePriceForRequest();
    initRangeSlider();
    initDatepicker();

});


