<?php

    namespace App\Http\Controllers\Frontend;

    use App\Http\Controllers\Controller;
    use App\Models\Business;
    use App\Models\Subscription;
    use App\Models\SubscriptionHistory;
    use App\Models\User;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class SubscriptionController extends Controller {

        public function success(Request $request, $lang) {
            $paymentResponse = json_encode($request->all());
            $paymentResponseDecode = json_decode($paymentResponse, true);
            $user = User::where('email', $request->email)->first();
            $business = Business::where('user_id', $user->id)->first();
            $subscribe = new Subscription();
            $subscribe->seller_id = $user->id;
            $subscribe->business_id = $business->id;
            $subscribe->order_id = $request->orderReference ?? null;
            $subscribe->order_number = $request->orderNo ?? null;
            $subscribe->response = $paymentResponse ?? null;
            $subscribe->active_to = ($paymentResponseDecode['transactionStatus'] == 'Approved') ? ($request->amount == '1') ? Carbon::now()->addMonth(1) : Carbon::now()->addMonth(12) : null;
            $subscribe->save();

            $subscribeHistory = new SubscriptionHistory();
            $subscribeHistory->subscription_id = $subscribe->id;
            $subscribeHistory->status = $paymentResponseDecode['transactionStatus'];
            $subscribeHistory->activated_to = $subscribe->active_to;
            $subscribeHistory->added_manually = 0;
            $subscribeHistory->order_id = $subscribe->order_id;
            $subscribeHistory->order_number = $subscribe->order_number;
            $subscribeHistory->response = $paymentResponse;
            $subscribeHistory->save();

            Auth::guard('business')->login($user);
            return redirect()->to('/');

        }

    }
