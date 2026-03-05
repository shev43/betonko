<?php

    namespace App\Http\Controllers\Business;

    use App\Http\Controllers\Controller;
    use App\Models\Notification;
    use App\Models\NotificationMessage;
    use App\Models\Offer;
    use App\Models\Order;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class OfferController extends Controller {

        public function create(Request $request, $lang) {

            $validator = Validator::make($request->all(), [
                'order_id' => 'required', 'count' => 'required', 'price' => 'required', 'delivery' => 'required',]);
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $incomeRequest = Offer::where('order_id', $request->order_id)->where('seller_id', request()->user()->id)->first();
            if($incomeRequest) {
                return redirect()->back()->with('danger', 'Вы уже подали запрос на эту заявку');
            }

            $latestEntry = Offer::get();
            $incomeRequest = new Offer();
            $incomeRequest->seller_id = request()->user()->id;
            $incomeRequest->order_id = $request->order_id;
            $incomeRequest->factory_id = $request->factory_id;
            $incomeRequest->offer_number = str_pad(($latestEntry) ? count($latestEntry) + 1 : 1, 8, "0", STR_PAD_LEFT);
            $incomeRequest->mark = $request->mark;
            $incomeRequest->class = $request->class;
            $incomeRequest->frost_resistance = $request->frost_resistance;
            $incomeRequest->water_resistance = $request->water_resistance;
            $incomeRequest->mixture_mobility = $request->mixture_mobility;
            $incomeRequest->winter_supplement = $request->winter_supplement;
            $incomeRequest->price = $request->price;
            $incomeRequest->delivery = $request->delivery;
            $incomeRequest->status = 'new';
            $incomeRequest->save();



            $order = Order::find($request->order_id);

            $notificationText = NotificationMessage::select('id')->where('action',($request->is_tender == 1) ? 'customer.tender.offer.new' : 'customer.offer.new')->first();
            $notification = new Notification;
            $notification->user_id = $order->client_id;
            $notification->notification_messages_id = $notificationText->id;
            $notification->order_id = $incomeRequest->order_id;
            $notification->offer_id = $incomeRequest->id;
            $notification->is_customer = 1;
            $notification->is_sendmail = 0;
            $notification->is_new = 1;
            $notification->save();

            $notificationText = NotificationMessage::select('id')->where('action',($request->is_tender == 1) ? 'business.tender.offer.new' : 'business.offer.new')->first();
            $notification = new Notification;
            $notification->user_id = request()->user()->id;
            $notification->notification_messages_id = $notificationText->id;
            $notification->order_id = $incomeRequest->order_id;
            $notification->offer_id = $incomeRequest->id;
            $notification->is_customer = 0;
            $notification->is_sendmail = 0;
            $notification->is_new = 1;
            $notification->save();

            if($request->is_tender == 1) {
                return redirect()->route('business::tender.index', ['lang' => $lang])->with('success', 'Заявка успешно отправлена на согласование');
            }
            else {
                return redirect()->route('business::request.index', ['lang' => $lang])->with('success', 'Заявка успешно отправлена на согласование');
            }

        }

        public function canceled($lang, $offer_id) {
            $offer = Offer::with('order')->find($offer_id);
            $offer->status = 'canceled';
            $offer->canceled_by = 'seller';
            $offer->canceled_comment = 'Продавец удалил заявку';
            $offer->save();
            $order = Order::find($offer->order_id);
            $order->status = 'canceled';
            $order->save();

            $notificationText = NotificationMessage::select('id')->where('action', 'business.order.status.canceled_by_seller')->first();
            $notification = new Notification;
            $notification->user_id = \request()->user()->id;
            $notification->notification_messages_id = $notificationText->id;
            $notification->order_id = $offer->order_id;
            $notification->offer_id = $offer->id;
            $notification->is_customer = 0;
            $notification->is_sendmail = 0;
            $notification->is_new = 1;
            $notification->save();

            $notificationText = NotificationMessage::select('id')->where('action', 'customer.order.status.canceled_by_seller')->first();
            $notification = new Notification;
            $notification->notification_messages_id = $notificationText->id;
            $notification->user_id = $offer->order->client_id;
            $notification->order_id = $offer->order_id;
            $notification->offer_id = $offer->id;
            $notification->is_customer = 1;
            $notification->is_sendmail = 0;
            $notification->is_new = 1;
            $notification->save();

            return redirect()->route('business::request.index', ['lang' => $lang])->with('success', 'Заявка успешно отменена');

        }

    }
