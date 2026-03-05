<?php

    namespace App\Http\Controllers\Customer;

    use App\Http\Controllers\Controller;
    use App\Models\Notification;

    class NotificationController extends Controller {
        public function index() {
            $notification_array = Notification::with('message', 'order')->where('user_id', request()->user()->id)->where('is_customer', 1)->orderByDesc('id')->paginate();
            return view('customer.settings.notification.index', ['notification_array'=>$notification_array]);
        }

    }
