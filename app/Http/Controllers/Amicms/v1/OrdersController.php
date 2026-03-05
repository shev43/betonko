<?php

namespace App\Http\Controllers\Amicms\v1;

use App\Http\Controllers\AmicmsController;
use App\Models\Order;
use Illuminate\Http\Request;
use Config;

class OrdersController extends AmicmsController {
    private $layout = [];

    public function __construct() {
        $this->is_profile_auth();
        $this->layout['title'] = 'Замовлення';

    }

    public function index() {
        $orders_array = Order::with(['client', 'offers'])->orderByDesc('created_at')->paginate(env('AMICMS_PER_PAGE'));
        return view('amicms.orders.index', ['layout' => $this->layout, 'orders_array' => $orders_array]);

    }

    public function view($order_id) {
        $order = Order::with(['client', 'offers'])->find($order_id);

        return view('amicms.orders.edit', ['layout' => $this->layout, 'order' => $order]);

    }

    public function update(Request $request, $order_id) {
        $request->contact_phone = str_replace([' ', '-', '+', '(', ')'], '', $request->contact_phone);

        $order = Order::find($order_id);
        $order->date_of_delivery = $request->end_date_of_delivery;
        $order->count = $request->count;
        $order->min_price = $request->min_price;
        $order->max_price = $request->max_price;
        $order->type_of_delivery = $request->type_of_delivery;
        $order->contact_first_name = $request->contact_first_name;
        $order->contact_last_name = $request->contact_last_name;
        $order->contact_phone = $request->contact_phone;
        $order->address = $request->address;
        $order->map_latitude = ($request->map_latitude ?? Config::get('map.default.map_latitude'));
        $order->map_longitude = ($request->map_longitude ?? Config::get('map.default.map_longitude'));
        $order->map_zoom = ($request->map_zoom ?? Config::get('map.default.map_zoom'));
        $order->map_rotate = ($request->map_rotate ?? Config::get('map.default.map_rotate'));
        $order->marker_latitude = ($request->marker_latitude ?? Config::get('map.default.marker_latitude'));
        $order->marker_longitude = ($request->marker_longitude ?? Config::get('map.default.marker_longitude'));
        $order->mark = $request->mark;
        $order->class = $request->class;
        $order->frost_resistance = $request->frost_resistance;
        $order->winter_supplement = $request->winter_supplement;
        $order->mixture_mobility = $request->mixture_mobility;
        $order->save();


        return redirect()->route('amicms::orders.index')->with('success', 'Дані успішно збережені');

    }

}
