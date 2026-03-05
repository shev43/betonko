<?php

    namespace App\Http\Controllers\Business;

    use App\Http\Controllers\Controller;
    use App\Models\Business;
    use App\Models\BusinessFactories;
    use App\Models\BusinessIncomeRequest;
    use App\Models\BusinessProducts;
    use App\Models\Offer;
    use App\Models\Order;
    use App\Models\Subscription;
    use function request;

    class TenderController extends Controller {
        public function __construct() {

        }

        public function index() {
            $requests = Order::doesnthave('offer')->where('is_tender', '1')->where('status', 'new')->orderBy('created_at', 'desc')->paginate(env('PER_PAGE', 20));
            $subscription = Subscription::where('seller_id', request()->user()->id)->latest()->first();
            return view('business.tender.index', ['requests' => $requests, 'subscription' => $subscription]);

        }

        public function view($lang, $order_id) {
            $order = Order::with('client', 'offer')->find($order_id);

            $currentOffer = Offer::where('order_id', $order_id)->first();

            $business = Business::where('user_id', request()->user()->id)->first();

            $buildBusinessFactories = BusinessFactories::where('business_id', $business->id);

            $buildBusinessFactories->has('products')->with('products', function($query) use ($order) {
                if(!empty($order->mark) && $order->mark !== 'н/в') {
                    $query->where('mark', $order->mark);
                }
                if(!empty($order->class) && $order->class !== 'н/в') {
                    $query->Where('class', $order->class);
                }
                if(!empty($order->water_resistance) && $order->water_resistance !== 'н/в') {
                    $query->Where('water_resistance', $order->water_resistance);
                }
                if(!empty($order->winter_supplement) && $order->winter_supplement !== 'н/в') {
                    $query->Where('winter_supplement', $order->winter_supplement);
                }
                if(!empty($order->mixture_mobility) && $order->mixture_mobility !== 'н/в') {
                    $query->Where('mixture_mobility', $order->mixture_mobility);
                }
                if(!empty($order->frost_resistance) && $order->frost_resistance !== 'н/в') {
                    $query->Where('frost_resistance', $order->frost_resistance);
                }
            });

            $businessFactories = $buildBusinessFactories->orderBy('id')->get();


            $buildBusinessProduct = BusinessProducts::where('business_id', $business->id);
            if(!empty($order->mark) && $order->mark !== 'н/в') {
                $buildBusinessProduct->where('mark', $order->mark);
            }
            if(!empty($order->class) && $order->class !== 'н/в') {
                $buildBusinessProduct->where('class', $order->class);
            }
            if(!empty($order->water_resistance) && $order->water_resistance !== 'н/в') {
                $buildBusinessProduct->where('water_resistance', $order->water_resistance);
            }
            if(!empty($order->winter_supplement) && $order->winter_supplement !== 'н/в') {
                $buildBusinessProduct->where('winter_supplement', $order->winter_supplement);
            }
            if(!empty($order->mixture_mobility) && $order->mixture_mobility !== 'н/в') {
                $buildBusinessProduct->where('mixture_mobility', $order->mixture_mobility);
            }
            if(!empty($order->frost_resistance) && $order->frost_resistance !== 'н/в') {
                $buildBusinessProduct->where('frost_resistance', $order->frost_resistance);
            }

            $businessProduct = $buildBusinessProduct->first();

            return view('business.tender.view', [
                'order' => $order, 'currentOffer'=>$currentOffer, 'factories' => $businessFactories, 'order_product' => $businessProduct]);

        }

    }
