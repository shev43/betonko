<?php

    namespace App\Http\Controllers\Business;

    use App\Http\Controllers\Controller;
    use App\Models\Business;
    use App\Models\BusinessFactories;
    use App\Models\BusinessIncomeRequest;
    use App\Models\BusinessProducts;
    use App\Models\Order;
    use function request;

    class RequestController extends Controller {
        public function __construct() {

        }

        public function index() {
            $requests = Order::with('offers')->where('seller_id', request()->user()->id)->where('is_tender', '0')->where('is_tender', '0')->where('status', 'new')->orderByDesc('created_at')->paginate(env('PER_PAGE', 20));
            return view('business.request.index', ['requests' => $requests]);

        }

        public function view($lang, $order_id) {
            $order = Order::with('client', 'offer')->find($order_id);
            $business = Business::where('user_id', request()->user()->id)->first();
            $buildBusinessFactories = BusinessFactories::where('business_id', $business->id);
            $buildBusinessFactories->has('products')->with('products', function($query) use ($order) {
                if($order->mark && $order->mark !== 'н/в') {
                    $query->where('mark', $order->mark);
                }
                if($order->class && $order->class !== 'н/в') {
                    $query->where('class', $order->class);
                }
                if($order->water_resistance && $order->water_resistance !== 'н/в') {
                    $query->where('water_resistance', $order->water_resistance);
                }
                if($order->winter_supplement && $order->winter_supplement !== 'н/в') {
                    $query->where('winter_supplement', $order->winter_supplement);
                }
                if($order->mixture_mobility && $order->mixture_mobility !== 'н/в') {
                    $query->where('mixture_mobility', $order->mixture_mobility);
                }
                if($order->frost_resistance && $order->frost_resistance !== 'н/в') {
                    $query->where('frost_resistance', $order->frost_resistance);
                }
            });
            $buildBusinessProduct = BusinessProducts::where('business_id', $business->id);
            if($order->mark && $order->mark !== 'н/в') {
                $buildBusinessProduct->where('mark', $order->mark);
            }
            if($order->class && $order->class !== 'н/в') {
                $buildBusinessProduct->where('class', $order->class);
            }
            if($order->water_resistance && $order->water_resistance !== 'н/в') {
                $buildBusinessProduct->where('water_resistance', $order->water_resistance);
            }
            if($order->winter_supplement && $order->winter_supplement !== 'н/в') {
                $buildBusinessProduct->where('winter_supplement', $order->winter_supplement);
            }
            if($order->mixture_mobility && $order->mixture_mobility !== 'н/в') {
                $buildBusinessProduct->where('mixture_mobility', $order->mixture_mobility);
            }
            if($order->frost_resistance && $order->frost_resistance !== 'н/в') {
                $buildBusinessProduct->where('frost_resistance', $order->frost_resistance);
            }
            $businessFactories = $buildBusinessFactories->orderBy('id')->get();
            $businessProduct = $buildBusinessProduct->first();
            return view('business.request.view', [
                'order' => $order, 'factories' => $businessFactories, 'order_product' => $businessProduct]);

        }

    }
