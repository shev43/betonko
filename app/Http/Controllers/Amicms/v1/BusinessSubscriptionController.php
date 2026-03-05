<?php

namespace App\Http\Controllers\Amicms\v1;

use App\Http\Controllers\AmicmsController;
use App\Models\Business;
use App\Models\Subscription;
use App\Models\SubscriptionHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BusinessSubscriptionController extends AmicmsController {
    private $layout = [];

    public function __construct() {
        $this->is_profile_auth();
        $this->layout['title'] = 'Підприємства';

    }

    public function index($business_id) {
        $business = Business::with(['seller', 'subscription', 'subscription_history'])->where('id', $business_id)->withTrashed()->first();

        return view('amicms.business.subscription.index', ['layout' => $this->layout, 'business' => $business, 'business_id'=>$business_id]);

    }

    public function subscribe(Request $request, $business_id) {
        $business = Business::with('seller')->where('id', $business_id)->withTrashed()->first();

        $latestOrder = Subscription::get();
        $order_id = time();
        $period = $request->period;
        $order_number = str_pad(($latestOrder) ? count($latestOrder) + 1 : 1, 8, "0", STR_PAD_LEFT);

        $subscribe = new Subscription();
        $subscribe->seller_id = $business->user_id;
        $subscribe->business_id = $business->id;
        $subscribe->order_id = $order_id ?? null;
        $subscribe->order_number = $order_number ?? null;
        $subscribe->response = null;
        $subscribe->active_to = Carbon::now()->addMonth( $period );
        $subscribe->save();

        $subscribeHistory = new SubscriptionHistory();
        $subscribeHistory->subscription_id = $subscribe->id;
        $subscribeHistory->status = 'Approved';
        $subscribeHistory->activated_to = $subscribe->active_to;
        $subscribeHistory->added_manually = 1;
        $subscribeHistory->order_id = $subscribe->order_id;
        $subscribeHistory->order_number = $subscribe->order_number;
        $subscribeHistory->response = null;
        $subscribeHistory->save();

        return redirect()->route('amicms::business.subscription.index', ['business_id' => $business_id])->with('success', 'Подписка успешно оформлена');

    }

}
