<?php

    namespace App\Http\Controllers\Customer;

    use App\Http\Controllers\Controller;
    use App\Models\Notification;
    use App\Models\NotificationMessage;
    use App\Models\Offer;
    use App\Models\Order;
    use Illuminate\Http\Request;

    class OfferController extends Controller {

        public function index($lang, $order_id) {
            $orderBy = (\request()->get('order') == 'older') ? 'asc' : 'desc';
            $offers = Offer::with(['order', 'seller'])->where('order_id', $order_id)->orderBy('created_at', $orderBy)->paginate(env('PER_PAGE', 20));
            return view('customer.offers.index', ['offers' => $offers]);
        }

        public function view($lang, $offer_id) {
            $offer = Offer::with(['order', 'factory'])->find($offer_id);
            return view('customer.offers.view', ['lang' => $lang, 'offer' => $offer]);

        }

        public function accept(Request $request, $lang, $offer_id) {
            $offer = Offer::find($offer_id);
            $order = Order::where('id', $offer->order_id)->first();
            if($order->is_tender == 1) {
                $rejectOffers = Offer::where('order_id', $order->id)->where('id', '<>', $offer_id)->get();
                foreach($rejectOffers as $reject) {
                    $rejectOffer = Offer::find($reject->id);
                    $rejectOffer->status = 'canceled';
                    $rejectOffer->canceled_by = 'client';
                    $rejectOffer->canceled_comment = 'Покупець обрав іншого продавця';
                    $rejectOffer->save();

                    $notificationText = NotificationMessage::select('id')->where('action', 'business.tender.canceled_by_buyer')->first();
                    $notification = new Notification;
                    $notification->user_id = $rejectOffer->seller_id;
                    $notification->notification_messages_id = $notificationText->id;
                    $notification->order_id = $order->id;
                    $notification->offer_id = $offer_id;
                    $notification->is_customer = 0;
                    $notification->is_sendmail = 0;
                    $notification->is_new = 1;
                    $notification->save();
                }
                $order->seller_id = $offer->seller_id;
            }
            $order->offers_id = $offer_id;
            $order->status = 'accepted';
            $order->save();

            $notificationText = NotificationMessage::select('id')->where('action', 'customer.order.status.accepted')->first();
            $notification = new Notification;
            $notification->user_id = request()->user()->id;
            $notification->notification_messages_id = $notificationText->id;
            $notification->order_id = $order->id;
            $notification->offer_id = $offer_id;
            $notification->is_customer = 1;
            $notification->is_sendmail = 0;
            $notification->is_new = 1;
            $notification->save();

            $notificationText = NotificationMessage::select('id')->where('action', ($request->is_tender == 1) ? 'business.tender.accepted_by_buyer' : 'business.offer.accepted')->first();
            $notification = new Notification;
            $notification->user_id = $order->seller_id;
            $notification->notification_messages_id = $notificationText->id;
            $notification->order_id = $order->id;
            $notification->offer_id = $offer_id;
            $notification->is_customer = 0;
            $notification->is_sendmail = 0;
            $notification->is_new = 1;
            $notification->save();


            if($request->is_tender == 0) {
                return redirect()->route('customer::request.index', ['lang' => $lang])->with('offer_details_status_accepted', 'Success');
            } else {
                return redirect()->route('customer::tender.index', ['lang' => $lang])->with('offer_details_status_accepted', 'Success');
            }

        }

        public function canceled(Request $request, $lang, $offer_id) {
            $offer = Offer::find($offer_id);
            $offer->status = 'canceled';
            $offer->canceled_by = 'client';
            $offer->canceled_comment = 'Покупець відмінив заявку';
            $offer->save();
            $order = Order::find($offer->order_id);
            $order->status = 'canceled';
            $order->save();

            $notificationText = NotificationMessage::select('id')->where('action', 'business.order.status.canceled_by_buyer')->first();
            $notification = new Notification;
            $notification->user_id = $offer->seller_id;
            $notification->notification_messages_id = $notificationText->id;
            $notification->order_id = $offer->order_id;
            $notification->offer_id = $offer->id;
            $notification->is_customer = 0;
            $notification->is_sendmail = 0;
            $notification->is_new = 1;
            $notification->save();

            $notificationText = NotificationMessage::select('id')->where('action', 'customer.order.status.canceled_by_buyer')->first();
            $notification = new Notification;
            $notification->user_id = \request()->user()->id;
            $notification->notification_messages_id = $notificationText->id;
            $notification->order_id = $offer->order_id;
            $notification->offer_id = $offer->id;
            $notification->is_customer = 1;
            $notification->is_sendmail = 0;
            $notification->is_new = 1;
            $notification->save();


            if($request->is_tender == 0) {
                return redirect()->route('customer::request.index', ['lang' => $lang])->with('offer_details_status_canceled', 'Success');;
            } else {
                return redirect()->route('customer::tender.index', ['lang' => $lang])->with('offer_details_status_canceled', 'Success');;
            }

        }

    }
