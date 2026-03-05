<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


Route::group(['domain' => env('APP_URL', 'www.betonko.com.ua')], function () {
    Route::post('/setting/profile/upload', [App\Http\Controllers\Business\ProfileController::class, 'uploadFile'])->name('setting.profile.upload-logo');
    Route::post('/setting/profile/remove-file', [App\Http\Controllers\Business\ProfileController::class, 'removeFile']);

    Route::POST('/setting/company/upload', [App\Http\Controllers\Business\CompanyController::class, 'uploadFile'])->name('setting.company.upload-logo');
    Route::POST('/setting/company/remove-file', [App\Http\Controllers\Business\CompanyController::class, 'removeFile']);

    Route::POST('/setting/contacts/upload', [App\Http\Controllers\Business\ContactsController::class, 'uploadFile'])->name('setting.contacts.upload-logo');
    Route::POST('/setting/contacts/remove-file', [App\Http\Controllers\Business\ContactsController::class, 'removeFile']);

    Route::POST('/setting/factory/upload', [App\Http\Controllers\Business\FactoriesController::class, 'uploadFile'])->name('setting.factory.upload-logo');
    Route::POST('/setting/factory/remove-file', [App\Http\Controllers\Business\FactoriesController::class, 'removeFile']);

    Route::post('/customer/profile/upload', [App\Http\Controllers\Customer\ProfileController::class, 'uploadFile'])->name('customer.profile.upload-logo');
    Route::post('/customer/profile/remove-file', [App\Http\Controllers\Customer\ProfileController::class, 'removeFile']);

    Route::post('/{lang}/subscribe/success', [App\Http\Controllers\Frontend\SubscriptionController::class, 'success'])->name('subscription.success');
    Route::post('/reviews/store', [App\Http\Controllers\ServiceReviewController::class, 'store'])->name('review.store');
    Route::get('/reviews/discard/{user_id}', [App\Http\Controllers\ServiceReviewController::class, 'discard'])->name('review.discard');

    Route::get('/pdf-create',[App\Http\Controllers\Business\DashboardController::class, 'create_pdf']);

    Route::get('/{lang}/report/{action}/{business_id}/{technic_id?}', function($lang, $action, $business_id, $technic_id=null) {

        $report = App\Models\Report::where('business_id', $business_id)
            ->where('technic_id', $technic_id)
            ->where('action', $action)->firstOrCreate();

        $report->business_id = $business_id ?? null;
        $report->technic_id = $technic_id ?? null;
        $report->action = $action;
        $report->count = $report->count + 1;
//        dd($report);
        $report->save();

    });


    Route::group(['middleware' => 'setLocale', 'prefix' => '{lang?}', 'as' => 'frontend::'], function () {
        Route::get('/', [App\Http\Controllers\Frontend\PagesController::class, 'index'])->name('pages.index');
        Route::get('/catalog', [App\Http\Controllers\Frontend\CatalogController::class, 'index'])->name('catalog.index');
        Route::get('/catalog/factory-{factory_id}', [App\Http\Controllers\Frontend\CatalogController::class, 'view'])->name('catalog.view');
        Route::get('/company/{company_id}', [App\Http\Controllers\Frontend\BusinessController::class, 'view'])->name('company.view');
        Route::get('/subscribe', [App\Http\Controllers\Frontend\PagesController::class, 'subscription'])->name('subscription.index');


        Route::get('/about', function (){
            return view('frontend.pages.about');
        })->name('about');
        Route::get('/policy', function (){
            return view('frontend.pages.policy');
        })->name('policy');
        Route::get('/rules', function (){
            return view('frontend.pages.rules');
        })->name('rules');

    });

    Auth::routes();

    Route::group(['middleware' => 'setLocale', 'prefix' => '{lang?}/customer', 'as' => 'customer::'], function () {
        Route::middleware(['authClient:client'])->group(function () {
            Route::post('/register-verified', [App\Http\Controllers\Customer\Auth\RegisterController::class, 'registerVerified'])->name('profile.register.sms');
            Route::post('/register', [App\Http\Controllers\Customer\Auth\RegisterController::class, 'store'])->name('profile.register.store');
            Route::post('/register/with-order', [App\Http\Controllers\Customer\Auth\RegisterController::class, 'storeWithOrder'])->name('profile.register.storeWithOrder');


            Route::post('/login-verified', [App\Http\Controllers\Customer\Auth\LoginController::class, 'loginVerified'])->name('profile.login.sms');
            Route::post('/login', [App\Http\Controllers\Customer\Auth\LoginController::class, 'login'])->name('profile.login.send');

        });

        Route::middleware(['auth:client'])->group(function () {

            Route::get('/reviews', [App\Http\Controllers\ServiceReviewController::class, 'check'])->name('review.check');

            Route::get('/unread-notification', function () {
                $notification = App\Models\Notification::where('user_id', request()->user()->id)->where('is_new', 1)->where('is_customer', 1)->get();
                return count($notification);
            });

            Route::get('/read-notification', function (){
                $notification_array = App\Models\Notification::where('user_id', request()->user()->id)->where('is_new', 1)->where('is_customer', 1)->get();
                foreach($notification_array as $notification) {
                    $notify = App\Models\Notification::find($notification->id);
                    $notify->is_new = 0;
                    $notify->save();
                }
            });

            Route::post('/logout', [App\Http\Controllers\Customer\Auth\LoginController::class, 'logout'])->name('profile.logout');
            Route::get('/profile/index', [App\Http\Controllers\Customer\ProfileController::class, 'index'])->name('profile.index');
            Route::post('/profile/update', [App\Http\Controllers\Customer\ProfileController::class, 'update'])->name('profile.update');
            Route::get('/profile/change-phone', [App\Http\Controllers\Customer\ProfileController::class, 'phoneVerified'])->name('profile.change-phone.send');
            Route::get('/profile/phone-verified', [App\Http\Controllers\Customer\ProfileController::class, 'changePhone'])->name('profile.change-phone.sms');

            Route::get('/', [App\Http\Controllers\Frontend\PagesController::class, 'index'])->name('pages.index');
            Route::get('/catalog', [App\Http\Controllers\Frontend\CatalogController::class, 'index'])->name('catalog.index');
            Route::get('/catalog/factory-{factory_id}', [App\Http\Controllers\Frontend\CatalogController::class, 'view'])->name('catalog.view');
            Route::get('/company/{company_id}', [App\Http\Controllers\Frontend\BusinessController::class, 'view'])->name('company.view');


            Route::get('/request', [App\Http\Controllers\Customer\RequestController::class, 'index'])->name('request.index');
            Route::post('/request/create', [App\Http\Controllers\Customer\RequestController::class, 'createWithParams'])->name('request.createWithParams');
            Route::get('/request/create-duplicate/{order_id}', [App\Http\Controllers\Customer\RequestController::class, 'createDuplicateWithParams'])->name('request.create-duplicate');
            Route::post('/request/store', [App\Http\Controllers\Customer\RequestController::class, 'store'])->name('request.store');
            Route::get('/request/canceled/{order_id}', [App\Http\Controllers\Customer\RequestController::class, 'canceled'])->name('request.canceled');

            Route::get('/request/offers/{order_id}', [App\Http\Controllers\Customer\OfferController::class, 'index'])->name('request.offers.index');
            Route::get('/request/offer/{offer_id}', [App\Http\Controllers\Customer\OfferController::class, 'view'])->name('request.offer.view');
            Route::get('/request/offer/accept/{offer_id}', [App\Http\Controllers\Customer\OfferController::class, 'accept'])->name('request.offer.accept');
            Route::get('/request/offer/canceled/{offer_id}', [App\Http\Controllers\Customer\OfferController::class, 'canceled'])->name('request.offer.canceled');








            Route::get('/tender', [App\Http\Controllers\Customer\TenderController::class, 'index'])->name('tender.index');
            Route::get('/tender/create', [App\Http\Controllers\Customer\TenderController::class, 'create'])->name('tender.create');
            Route::get('/tender/create-duplicate/{order_id}', [App\Http\Controllers\Customer\TenderController::class, 'createDuplicate'])->name('tender.create-duplicate');
            Route::post('/tender/store', [App\Http\Controllers\Customer\TenderController::class, 'store'])->name('tender.store');
            Route::get('/tender/canceled/{order_id}', [App\Http\Controllers\Customer\TenderController::class, 'canceled'])->name('tender.canceled');

            Route::get('/tender/offers/{order_id}', [App\Http\Controllers\Customer\OfferController::class, 'index'])->name('tender.offers.index');
            Route::get('/tender/offer/{offer_id}', [App\Http\Controllers\Customer\OfferController::class, 'view'])->name('tender.offer.view');
            Route::get('/tender/offer/accept/{offer_id}', [App\Http\Controllers\Customer\OfferController::class, 'accept'])->name('tender.offer.accept');
            Route::get('/tender/offer/canceled/{offer_id}', [App\Http\Controllers\Customer\OfferController::class, 'canceled'])->name('tender.offer.canceled');

            Route::get('/notifications/index', [App\Http\Controllers\Customer\NotificationController::class, 'index'])->name('notifications.index');

        });

    });



    Route::group(['middleware' => 'setLocale', 'prefix' => '{lang?}/business', 'as' => 'business::'], function () {
        Route::middleware(['authBusiness:business'])->group(function () {
            Route::get('/register', [App\Http\Controllers\Business\Auth\RegisterController::class, 'showRegistrationForm'])->name('profile.register');
            Route::post('/register', [App\Http\Controllers\Business\Auth\RegisterController::class, 'register'])->name('profile.register');
            Route::post('/login', [App\Http\Controllers\Business\Auth\LoginController::class, 'login'])->name('profile.login');

            Route::get('/forgot-password', function(){
                $metaTags = [
                    'metaTitle' => (app()->getLocale() == 'ua') ? 'Відновлення доступу' : 'Home',
                    'metaKeywords' => '',
                    'metaDescription' => ''
                ];

                return view('frontend._modules.auth.business.forgot-password', ['lang'=>app()->getLocale(), 'metaTags'=>$metaTags]);

            })->name('profile.forgot-password');



            Route::post('/forgot-password', function (Request $request) {
                $request->validate(['email' => 'required|email']);

                $status = Password::sendResetLink(
                    $request->only('email')
                );

                return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);

            })->middleware('guest')->name('profile.password.email');



            Route::get('/reset-password/{token}', function ($lang, $token) {
                $metaTags = [
                    'metaTitle' => (app()->getLocale() == 'ua') ? 'Відновлення доступу' : 'Home',
                    'metaKeywords' => '',
                    'metaDescription' => ''
                ];

                return view('frontend._modules.auth.business.passwords.reset', [
                    'lang'=>app()->getLocale(),
                    'metaTags'=>$metaTags,
                    'token' => $token,
                ]);

            })->middleware('guest')->name('password.reset');





            Route::post('/reset-password', function (Request $request) {


//            dd($request->all());

                $request->validate([
                    'token' => 'required',
                    'email' => 'required|email',
                    'password' => 'required|min:6|confirmed',
                ]);

                $status = Password::reset(
                    $request->only('email', 'password', 'password_confirmation', 'token'),
                    function ($user, $password) {
                        $user->forceFill([
                            'password' => Hash::make($password)
                        ])->setRememberToken(Str::random(60));

                        $user->save();

                        event(new PasswordReset($user));

                        Auth::guard('business')->login($user);
                    }
                );

                return $status === Password::PASSWORD_RESET
                    ? redirect('/')
                    : back()->withErrors(['email' => [__($status)]]);

            })->middleware('guest')->name('password.update');


            Route::get('/activate', [App\Http\Controllers\Business\Auth\RegisterController::class, 'activate'])->name('profile.activate');
        });

        Route::middleware(['auth:business'])->group(function () {
            Route::get('/reviews', [App\Http\Controllers\ServiceReviewController::class, 'check'])->name('review.check');

            Route::get('/unread-notification', function () {
                $notification = App\Models\Notification::where('user_id', request()->user()->id)->where('is_new', 1)->where('is_customer', 0)->get();
                return count($notification);
            });

            Route::get('/read-notification', function (){
                $notification_array = App\Models\Notification::where('user_id', request()->user()->id)->where('is_new', 1)->where('is_customer', 0)->get();
                foreach($notification_array as $notification) {
                    $notify = App\Models\Notification::find($notification->id);
                    $notify->is_new = 0;
                    $notify->save();
                }
            });
            Route::post('/logout', [App\Http\Controllers\Business\Auth\LoginController::class, 'logout'])->name('profile.logout');

            Route::get('/', [App\Http\Controllers\Frontend\PagesController::class, 'index'])->name('pages.index');
            Route::get('/dashboard', [App\Http\Controllers\Business\DashboardController::class, 'index'])->name('dashboard.index');
            Route::get('/catalog', [App\Http\Controllers\Frontend\CatalogController::class, 'index'])->name('catalog.index');
            Route::get('/catalog/factory-{factory_id}', [App\Http\Controllers\Frontend\CatalogController::class, 'view'])->name('catalog.view');
            Route::get('/company/{company_id}', [App\Http\Controllers\Frontend\BusinessController::class, 'view'])->name('company.view');

            Route::get('/request/', [App\Http\Controllers\Business\RequestController::class, 'index'])->name('request.index');
            Route::get('/request/{order_id}', [App\Http\Controllers\Business\RequestController::class, 'view'])->name('request.view');

            Route::post('/offer/create', [App\Http\Controllers\Business\OfferController::class, 'create'])->name('offer.create');
            Route::get('/offer/canceled/{offer_id}', [App\Http\Controllers\Business\OfferController::class, 'canceled'])->name('offer.canceled');

            Route::get('/tender/', [App\Http\Controllers\Business\TenderController::class, 'index'])->name('tender.index');
            Route::get('/tender/{order_id}', [App\Http\Controllers\Business\TenderController::class, 'view'])->name('tender.view');

            Route::get('/accepted/', [App\Http\Controllers\Business\AcceptedController::class, 'index'])->name('accepted.index');
            Route::get('/accepted/{offer_id}', [App\Http\Controllers\Business\AcceptedController::class, 'view'])->name('accepted.view');
            Route::get('/accepted/update/{status}/{order_id}', [App\Http\Controllers\Business\AcceptedController::class, 'update'])->name('accepted.update');

            Route::get('/setting/profile', [App\Http\Controllers\Business\ProfileController::class, 'index'])->name('setting.profile.index');
            Route::post('/setting/profile/update', [App\Http\Controllers\Business\ProfileController::class, 'update'])->name('setting.profile.update');
            Route::get('/subscribe', [App\Http\Controllers\Business\SubscriptionController::class, 'index'])->name('subscription.index');
            Route::post('/subscribe/create', [App\Http\Controllers\Business\SubscriptionController::class, 'create'])->name('subscription.create');

            Route::get('/setting/company', [App\Http\Controllers\Business\CompanyController::class, 'index'])->name('setting.company.index');
            Route::post('/setting/company/update', [App\Http\Controllers\Business\CompanyController::class, 'update'])->name('setting.company.update');

            Route::get('/setting/contacts', [App\Http\Controllers\Business\ContactsController::class, 'index'])->name('setting.contacts.index');
            Route::get('/setting/contacts/create', [App\Http\Controllers\Business\ContactsController::class, 'create'])->name('setting.contacts.create');
            Route::post('/setting/contacts/store', [App\Http\Controllers\Business\ContactsController::class, 'store'])->name('setting.contacts.store');
            Route::get('/setting/contacts/edit/{contact_id}', [App\Http\Controllers\Business\ContactsController::class, 'edit'])->name('setting.contacts.edit');
            Route::post('/setting/contacts/update/{contact_id}', [App\Http\Controllers\Business\ContactsController::class, 'update'])->name('setting.contacts.update');
            Route::get('/setting/contacts/destroy/{contact_id}', [App\Http\Controllers\Business\ContactsController::class, 'destroy'])->name('setting.contacts.destroy');

            Route::get('/setting/factories', [App\Http\Controllers\Business\FactoriesController::class, 'index'])->name('setting.factories.index');
            Route::get('/setting/factories/create', [App\Http\Controllers\Business\FactoriesController::class, 'create'])->name('setting.factories.create');
            Route::post('/setting/factories/store', [App\Http\Controllers\Business\FactoriesController::class, 'store'])->name('setting.factories.store');
            Route::get('/setting/factories/edit/{factory_id}', [App\Http\Controllers\Business\FactoriesController::class, 'edit'])->name('setting.factories.edit');
            Route::post('/setting/factories/update/{factory_id}', [App\Http\Controllers\Business\FactoriesController::class, 'update'])->name('setting.factories.update');

            Route::get('/setting/product/', [App\Http\Controllers\Business\ProductController::class, 'index'])->name('setting.product.index');
            Route::get('/setting/product/create', [App\Http\Controllers\Business\ProductController::class, 'create'])->name('setting.product.create');
            Route::post('/setting/product/store', [App\Http\Controllers\Business\ProductController::class, 'store'])->name('setting.product.store');
            Route::get('/setting/product/edit/{product_id}', [App\Http\Controllers\Business\ProductController::class, 'edit'])->name('setting.product.edit');
            Route::post('/setting/product/update/{product_id}', [App\Http\Controllers\Business\ProductController::class, 'update'])->name('setting.product.update');
            Route::get('/setting/product/destroy/{product_id}', [App\Http\Controllers\Business\ProductController::class, 'destroy'])->name('setting.product.destroy');
            Route::get('/setting/notifications/index', [App\Http\Controllers\Business\NotificationController::class, 'index'])->name('setting.notifications.index');

        });

    });
});




// ADMIN


Route::group([ 'domain' => env('APP_AMICMS_URL', 'amicms.betonko.com.ua'), 'as' =>'amicms::'], function() {
    Auth::routes();

    Route::get('/', function() { return redirect(route('amicms::profile.login.form')); });

    Route::get('profile/login', [App\Http\Controllers\Amicms\v1\Auth\LoginController::class, 'showLoginForm'])->name('profile.login.form');
    Route::post('profile/login', [App\Http\Controllers\Amicms\v1\Auth\LoginController::class, 'login'])->name('profile.login');
    Route::post('profile/logout', [App\Http\Controllers\Amicms\v1\Auth\LoginController::class, 'logout'])->name('profile.logout');

    Route::get('profile', [App\Http\Controllers\Amicms\v1\ProfileController::class, 'index'])->name('profile.index');
    Route::get('profile/edit', [App\Http\Controllers\Amicms\v1\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('profile/update', [App\Http\Controllers\Amicms\v1\ProfileController::class, 'update'])->name('profile.update');
    Route::get('profile/removeFile/{user_id}', [App\Http\Controllers\Amicms\v1\ProfileController::class, 'removeFile'])->name('profile.removeFile');

    Route::get('support', [App\Http\Controllers\Amicms\v1\SupportController::class, 'index'])->name('support.index');

    Route::get('dashboard', [App\Http\Controllers\Amicms\v1\DashboardController::class, 'index'])->name('dashboard.index');



//    Users
    Route::get('business', [App\Http\Controllers\Amicms\v1\BusinessController::class, 'index'])->name('business.index');
    Route::get('business/create', [App\Http\Controllers\Amicms\v1\BusinessController::class, 'create'])->name('business.create');
    Route::post('business/store', [App\Http\Controllers\Amicms\v1\BusinessController::class, 'store'])->name('business.store');
    Route::get('business/{business_id}/activate', [App\Http\Controllers\Amicms\v1\BusinessController::class, 'activate']);

    Route::get('business/import', [App\Http\Controllers\Amicms\v1\BusinessController::class, 'import'])->name('business.import.index');
    Route::post('business/import/store', [App\Http\Controllers\Amicms\v1\BusinessController::class, 'importStore'])->name('business.import.store');


    Route::get('business/{business_id}', [App\Http\Controllers\Amicms\v1\BusinessController::class, 'edit'])->name('business.edit');
    Route::post('business/{business_id}/update', [App\Http\Controllers\Amicms\v1\BusinessController::class, 'update'])->name('business.update');

    Route::get('business/restore/{business_id}', [App\Http\Controllers\Amicms\v1\BusinessController::class, 'restore'])->name('business.restore');
    Route::get('business/destroy/{business_id}', [App\Http\Controllers\Amicms\v1\BusinessController::class, 'destroy'])->name('business.destroy');
    Route::get('business/destroy-with-trash/{business_id}', [App\Http\Controllers\Amicms\v1\BusinessController::class, 'destroyWithTrash'])->name('business.destroy-with-trash');



    Route::get('business/{business_id}/profile', [App\Http\Controllers\Amicms\v1\BusinessProfileController::class, 'index'])->name('business.profile.index');
    Route::post('business/{business_id}/profile/store', [App\Http\Controllers\Amicms\v1\BusinessProfileController::class, 'store'])->name('business.profile.store');

    Route::get('business/{business_id}/factories', [App\Http\Controllers\Amicms\v1\BusinessFactoriesController::class, 'index'])->name('business.factories.index');
    Route::get('business/{business_id}/factories/create', [App\Http\Controllers\Amicms\v1\BusinessFactoriesController::class, 'create'])->name('business.factories.create');
    Route::post('business/{business_id}/factories/store', [App\Http\Controllers\Amicms\v1\BusinessFactoriesController::class, 'store'])->name('business.factories.store');
    Route::get('business/{business_id}/factories/edit/{factory_id}', [App\Http\Controllers\Amicms\v1\BusinessFactoriesController::class, 'edit'])->name('business.factories.edit');
    Route::post('business/{business_id}/factories/update/{factory_id}', [App\Http\Controllers\Amicms\v1\BusinessFactoriesController::class, 'update'])->name('business.factories.update');
    Route::get('business/{business_id}/factories/restore/{factory_id}', [App\Http\Controllers\Amicms\v1\BusinessFactoriesController::class, 'restore'])->name('business.factories.restore');
    Route::get('business/{business_id}/factories/destroy/{factory_id}', [App\Http\Controllers\Amicms\v1\BusinessFactoriesController::class, 'destroy'])->name('business.factories.destroy');
    Route::get('business/{business_id}/factories/destroy-with-trash/{factory_id}', [App\Http\Controllers\Amicms\v1\BusinessFactoriesController::class, 'destroyWithTrash'])->name('business.factories.destroy-with-trash');

    Route::get('business/{business_id}/contacts', [App\Http\Controllers\Amicms\v1\BusinessContactsController::class, 'index'])->name('business.contacts.index');
    Route::get('business/{business_id}/contacts/create', [App\Http\Controllers\Amicms\v1\BusinessContactsController::class, 'create'])->name('business.contacts.create');
    Route::post('business/{business_id}/contacts/store', [App\Http\Controllers\Amicms\v1\BusinessContactsController::class, 'store'])->name('business.contacts.store');
    Route::get('business/{business_id}/contacts/edit/{contact_id}', [App\Http\Controllers\Amicms\v1\BusinessContactsController::class, 'edit'])->name('business.contacts.edit');
    Route::post('business/{business_id}/contacts/update/{contact_id}', [App\Http\Controllers\Amicms\v1\BusinessContactsController::class, 'update'])->name('business.contacts.update');
    Route::get('business/{business_id}/contacts/restore/{contact_id}', [App\Http\Controllers\Amicms\v1\BusinessContactsController::class, 'restore'])->name('business.contacts.restore');
    Route::get('business/{business_id}/contacts/destroy/{contact_id}', [App\Http\Controllers\Amicms\v1\BusinessContactsController::class, 'destroy'])->name('business.contacts.destroy');
    Route::get('business/{business_id}/contacts/destroy-with-trash/{contact_id}', [App\Http\Controllers\Amicms\v1\BusinessContactsController::class, 'destroyWithTrash'])->name('business.contacts.destroy-with-trash');

    Route::get('business/{business_id}/products', [App\Http\Controllers\Amicms\v1\BusinessProductsController::class, 'index'])->name('business.products.index');
    Route::get('business/{business_id}/products/create', [App\Http\Controllers\Amicms\v1\BusinessProductsController::class, 'create'])->name('business.products.create');
    Route::post('business/{business_id}/products/store', [App\Http\Controllers\Amicms\v1\BusinessProductsController::class, 'store'])->name('business.products.store');
    Route::get('business/{business_id}/products/edit/{product_id}', [App\Http\Controllers\Amicms\v1\BusinessProductsController::class, 'edit'])->name('business.products.edit');
    Route::post('business/{business_id}/products/update/{product_id}', [App\Http\Controllers\Amicms\v1\BusinessProductsController::class, 'update'])->name('business.products.update');
    Route::get('business/{business_id}/products/restore/{product_id}', [App\Http\Controllers\Amicms\v1\BusinessProductsController::class, 'restore'])->name('business.products.restore');
    Route::get('business/{business_id}/products/destroy/{product_id}', [App\Http\Controllers\Amicms\v1\BusinessProductsController::class, 'destroy'])->name('business.products.destroy');
    Route::get('business/{business_id}/products/destroy-with-trash/{product_id}', [App\Http\Controllers\Amicms\v1\BusinessProductsController::class, 'destroyWithTrash'])->name('business.products.destroy-with-trash');

    Route::get('business/{business_id}/subscription', [App\Http\Controllers\Amicms\v1\BusinessSubscriptionController::class, 'index'])->name('business.subscription.index');
    Route::post('business/{business_id}/subscription/subscribe', [App\Http\Controllers\Amicms\v1\BusinessSubscriptionController::class, 'subscribe'])->name('business.subscription.subscribe');

    Route::get('business/reports/visitors/{business_id}', [App\Http\Controllers\Amicms\v1\BusinessController::class, 'visitors'])->name('business.reports.visitors');


    Route::get('orders', [App\Http\Controllers\Amicms\v1\OrdersController::class, 'index'])->name('orders.index');
    Route::get('orders/{order_id}', [App\Http\Controllers\Amicms\v1\OrdersController::class, 'view'])->name('orders.view');
    Route::post('orders/{order_id}/update', [App\Http\Controllers\Amicms\v1\OrdersController::class, 'update'])->name('orders.update');

    Route::get('subscription', [App\Http\Controllers\Amicms\v1\SubscriptionController::class, 'index'])->name('subscription.index');
    Route::get('subscription/{business_id}', [App\Http\Controllers\Amicms\v1\SubscriptionController::class, 'view'])->name('subscription.view');
    Route::post('subscription/{business_id}/subscribe', [App\Http\Controllers\Amicms\v1\SubscriptionController::class, 'subscribe'])->name('subscription.subscribe');

    Route::get('clients', [App\Http\Controllers\Amicms\v1\ClientsController::class, 'index'])->name('clients.index');
    Route::get('clients/create', [App\Http\Controllers\Amicms\v1\ClientsController::class, 'create'])->name('clients.create');
    Route::post('clients/store', [App\Http\Controllers\Amicms\v1\ClientsController::class, 'store'])->name('clients.store');
    Route::get('clients/edit/{client_id}', [App\Http\Controllers\Amicms\v1\ClientsController::class, 'edit'])->name('clients.edit');
    Route::post('clients/update/{client_id}', [App\Http\Controllers\Amicms\v1\ClientsController::class, 'update'])->name('clients.update');
    Route::get('clients/restore/{client_id}', [App\Http\Controllers\Amicms\v1\ClientsController::class, 'restore'])->name('clients.restore');
    Route::get('clients/destroy/{client_id}', [App\Http\Controllers\Amicms\v1\ClientsController::class, 'destroy'])->name('clients.destroy');
    Route::get('clients/destroy-with-trash/{client_id}', [App\Http\Controllers\Amicms\v1\ClientsController::class, 'destroyWithTrash'])->name('clients.destroy-with-trash');

    Route::get('users', [App\Http\Controllers\Amicms\v1\UsersController::class, 'index'])->name('users.index');
    Route::get('users/create', [App\Http\Controllers\Amicms\v1\UsersController::class, 'create'])->name('users.create');
    Route::post('users/store', [App\Http\Controllers\Amicms\v1\UsersController::class, 'store'])->name('users.store');
    Route::get('users/edit/{user_id}', [App\Http\Controllers\Amicms\v1\UsersController::class, 'edit'])->name('users.edit');
    Route::post('users/update/{user_id}', [App\Http\Controllers\Amicms\v1\UsersController::class, 'update'])->name('users.update');
    Route::get('users/restore/{user_id}', [App\Http\Controllers\Amicms\v1\UsersController::class, 'restore'])->name('users.restore');
    Route::get('users/destroy/{user_id}', [App\Http\Controllers\Amicms\v1\UsersController::class, 'destroy'])->name('users.destroy');
    Route::get('users/destroy-with-trash/{user_id}', [App\Http\Controllers\Amicms\v1\UsersController::class, 'destroyWithTrash'])->name('users.destroy-with-trash');

    Route::get('mailing', [App\Http\Controllers\Amicms\v1\MailingController::class, 'index'])->name('mailing.index');
    Route::get('mailing/store', [App\Http\Controllers\Amicms\v1\MailingController::class, 'store'])->name('mailing.store');



});

