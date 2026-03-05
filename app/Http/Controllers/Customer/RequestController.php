<?php

    namespace App\Http\Controllers\Customer;

    use App\Http\Controllers\Controller;
    use App\Models\BusinessProducts;
    use App\Models\Notification;
    use App\Models\NotificationMessage;
    use App\Models\Offer;
    use App\Models\Order;
    use Carbon\Carbon;
    use Illuminate\Http\Request;

    class RequestController extends Controller {

        protected $phone;

        public function __construct() {
            //        $this->middleware('auth');
        }

        public function index() {
            $orderBy = (\request()->get('order') == 'older') ? 'asc' : 'desc';
            $orders = Order::with('offers')->where('is_tender', 0)->where('client_id', \request()->user()->id)->orderBy('created_at', $orderBy)->paginate(env('PER_PAGE', 20));
            return view('customer.request.index', ['orders' => $orders]);

        }

        public function createWithParams(Request $request, $lang) {
            $product = BusinessProducts::with('business')->find($request->product_id);
            return view('customer.request.create', ['product' => $product]);

        }

        public function createDuplicateWithParams($lang, $order_id) {
            $order = Order::find($order_id);
            return view('customer.request.create-duplicate', ['lang'=>$lang, 'order' => $order]);

        }

        public function store(Request $request, $lang) {
            $explode_date_of_delivery = explode('-', trim(str_replace(' ', '', str_replace('—', '-', $request->date_of_delivery))));
            $date_of_delivery[0] = Carbon::parse($explode_date_of_delivery[0])->format('Y-m-d');
            $date_of_delivery[1] = (!empty($explode_date_of_delivery[1])) ? Carbon::parse($explode_date_of_delivery[1])->format('Y-m-d') : Carbon::parse($explode_date_of_delivery[0])->format('Y-m-d');
            $this->phone = str_replace([' ', '-', '+', '(', ')'], '', $request->get('contact_phone'));
            $latestOrder = Order::get();
            $order = new Order;
            $order->client_id = $request->user()->id;
            $order->seller_id = $request->seller_id;
            $order->factory_id = $request->factory_id;
            $order->is_tender = $request->is_tender;
            $order->order_number = str_pad(($latestOrder) ? count($latestOrder) + 1 : 1, 8, "0", STR_PAD_LEFT);
            $order->mark = $request->mark;
            $order->class = $request->class;
            $order->frost_resistance = $request->frost_resistance;
            $order->water_resistance = $request->water_resistance;
            $order->mixture_mobility = $request->mixture_mobility;
            $order->winter_supplement = $request->winter_supplement;
            $order->count = $request->count;
            $order->min_price = $request->min_price;
            $order->max_price = $request->max_price;
            $order->contact_first_name = $request->contact_first_name;
            $order->contact_last_name = $request->contact_last_name;
            $order->contact_phone = $this->phone;
            $order->comment = $request->comment;
            $order->address = $request->address;
            $order->type_of_delivery = $request->type_of_delivery;
            $order->date_of_delivery = $date_of_delivery[0];
            $order->start_date_of_delivery = $date_of_delivery[0];
            $order->end_date_of_delivery = $date_of_delivery[1];
            $order->map_latitude = ($request->map_latitude ?? 0);
            $order->map_longitude = ($request->map_longitude ?? 0);
            $order->map_zoom = ($request->map_zoom ?? 0);
            $order->map_rotate = ($request->map_rotate ?? 0);
            $order->marker_latitude = ($request->marker_latitude ?? 0);
            $order->marker_longitude = ($request->marker_longitude ?? 0);
            $order->status = 'new';
            $order->save();

            $notificationText = NotificationMessage::select('id')->where('action','customer.order.status.new')->first();
            $notification = new Notification;
            $notification->user_id = request()->user()->id;
            $notification->notification_messages_id = $notificationText->id;
            $notification->order_id = $order->id;
            $notification->is_customer = 1;
            $notification->is_sendmail = 0;
            $notification->is_new = 1;
            $notification->save();

            $notificationText = NotificationMessage::select('id')->where('action','business.order.status.new')->first();
            $notification = new Notification;
            $notification->user_id = $request->seller_id;
            $notification->notification_messages_id = $notificationText->id;
            $notification->order_id = $order->id;
            $notification->is_customer = 0;
            $notification->is_sendmail = 0;
            $notification->is_new = 1;
            $notification->save();

            return redirect()->route('customer::request.index', ['lang' => $lang])->with('offer_details_status_new', 'Success');

        }

        public function canceled($lang, $order_id) {
            $order = Order::find($order_id);
            $rejectOffers = Offer::where('order_id', $order->id)->get();
            foreach($rejectOffers as $reject) {
                $rejectOffer = Offer::find($reject->id);
                $rejectOffer->status = 'canceled';
                $rejectOffer->canceled_by = 'client';
                $rejectOffer->canceled_comment = 'Покупець відмінив заявку';
                $rejectOffer->save();
            }

            $notificationText = NotificationMessage::select('id')->where('action', 'customer.order.status.canceled_by_buyer')->first();
            $notification = new Notification;
            $notification->notification_messages_id = $notificationText->id;
            $notification->user_id = $order->client_id;
            $notification->order_id = $order->id;
            $notification->is_customer = 1;
            $notification->is_sendmail = 0;
            $notification->is_new = 1;
            $notification->save();

            if(!empty($order->seller_id)) {
                $notificationText = NotificationMessage::select('id')->where('action', 'business.order.status.canceled_by_buyer')->first();
                $notification = new Notification;
                $notification->notification_messages_id = $notificationText->id;
                $notification->user_id = $order->seller_id;
                $notification->order_id = $order->id;
                $notification->is_customer = 0;
                $notification->is_sendmail = 0;
                $notification->is_new = 1;
                $notification->save();
            }

            $order->status = 'canceled';
            $order->save();
            return redirect()->route('customer::request.index', ['lang' => $lang])->with('offer_details_status_canceled', 'Success');

        }

    }
