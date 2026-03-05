<?php

    namespace App\Http\Controllers\Business;

    use App\Http\Controllers\Controller;
    use App\Models\Notification;
    use App\Models\NotificationMessage;
    use App\Models\Offer;
    use App\Models\Order;
    use Illuminate\Http\Request;

    class AcceptedController extends Controller {
        public function __construct() {
            //
        }

        public function index() {
            $orderBy = (\request()->get('order') == 'older') ? 'asc' : 'desc';
            $offers = Offer::with(['order'])->where('seller_id', \request()->user()->id)->orderBy('created_at', $orderBy)->paginate(env('PER_PAGE', 20));
            return view('business.accepted.index', ['offers' => $offers]);

        }

        public function view($lang, $offer_id) {
            $offer = Offer::with(['order', 'seller', 'factory'])->find($offer_id);
            return view('business.accepted.view', ['offer' => $offer]);

        }

        public function update(Request $request, $lang, $offer_id, $order_id) {
            $order = Order::with('offers')->find($order_id);
            $order->status = $request->status;

            if($order->save()) {
                if($order->status == 'accepted') {
                    $business_action = 'business.order.status.accepted';
                } elseif($order->status == 'executed') {
                    $business_action = 'business.order.status.executed';
                } else {
                    $business_action = 'business.order.status.done';
                }

                $notificationText = NotificationMessage::select('id')->where('action', $business_action)->first();
                $notification = new Notification;
                $notification->user_id = $order->seller_id;
                $notification->business_id = $order->offers[0]->factory->business_id;
                $notification->business_factories_id = $order->offers[0]->factory->id;
                $notification->notification_messages_id = $notificationText->id;
                $notification->order_id = $order->id;
                $notification->is_customer = 0;
                $notification->is_sendmail = 0;
                $notification->is_new = 1;
                $notification->save();

                if($order->status == 'accepted') {
                    $customer_action = 'customer.order.status.accepted';
                } elseif($order->status == 'executed') {
                    $customer_action = 'customer.order.status.executed';
                } else {
                    $customer_action = 'customer.order.status.done';
                }

                $notificationText = NotificationMessage::select('id')->where('action', $customer_action)->first();
                $notification = new Notification;
                $notification->user_id = $order->client_id;
                $notification->business_id = $order->offers[0]->factory->business_id;
                $notification->business_factories_id = $order->offers[0]->factory->id;
                $notification->notification_messages_id = $notificationText->id;
                $notification->order_id = $order->id;
                $notification->is_customer = 1;
                $notification->is_sendmail = 0;
                $notification->is_new = 1;
                $notification->save();

            }

            return redirect()->back();

        }
    }
