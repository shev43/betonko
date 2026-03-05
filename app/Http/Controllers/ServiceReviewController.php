<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ServiceReview;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceReviewController extends Controller {

    public function check() {
        $order = Order::where((Auth::guard('client')->check()) ? 'client_id' : 'seller_id', \request()->user()->id)->where('status', 'done')->get();
        if(count($order) == 5) {
            return true;
        }
        return false;
    }

    public function store(Request $request) {
        $review = new ServiceReview;
        $review->user_id = $request->user_id;
        $review->question = implode(',', $request->question);
        $review->comment = $request->comment;
        if($review->save()) {
            $user = User::find($request->user_id);
            (Auth::guard('client')->check()) ? $user->is_customer_service_review = 1 : $user->is_business_service_review = 1;
            $user->save();

            return $review;
        }

        return false;

    }

    public function discard($user_id) {
        $user = User::find($user_id);
        (Auth::guard('client')->check()) ? $user->is_customer_service_review = 2 : $user->is_business_service_review = 2;
        $user->save();
    }

}
