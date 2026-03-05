<?php

    namespace App\Http\Controllers\Business;

    use App\Http\Controllers\Controller;
    use App\Models\Subscription;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Maksa988\WayForPay\Collection\ProductCollection;
    use Maksa988\WayForPay\Domain\Client;
    use Maksa988\WayForPay\Facades\WayForPay;
    use WayForPay\SDK\Domain\Product;

    class SubscriptionController extends Controller {
        public function index($lang) {
            $businessOwner = User::where('id', \request()->user()->id)->first();
            $subscription = Subscription::where('seller_id', \request()->user()->id)->latest()->first();
            return view('business.subscription.index', [
                'businessOwner' => $businessOwner, 'subscription' => $subscription]);

        }

        function gateway($url, $data) {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $url, CURLOPT_POST => true, //            CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "POST", CURLOPT_HEADER => false, CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false, CURLOPT_POSTFIELDS => json_decode(json_encode($data), true),]);
            $response = curl_exec($curl);
            $response = json_decode($response, true);
            curl_close($curl);
            return $response;
        }

        public function create(Request $request, $lang) {
            $latestOrder = Subscription::get();
            $order_id = time();
            $order_number = str_pad(($latestOrder) ? count($latestOrder) + 1 : 1, 8, "0", STR_PAD_LEFT);
            $price = $request->price;
            $amount = $request->price_total;
            $period = $request->period;
            $client = new Client(\request()->user()->first_name, \request()->user()->last_name, \request()->user()->email, \request()->user()->phone ?? null, '', \request()->user()->id);
            $products = new ProductCollection([
                new Product('Оплата підписки Betonko на ' . $period . ' міс.', $price, $period),]);
            $form = WayForPay::purchase($order_id, $amount, $client, $products, 'UAH', null, 'UA', $order_number, route('subscription.success', ['lang' => app()->getLocale()]),
            )->getAsString($submitText = '', $buttonClass = 'btn-pay btn btn-primary');
            print '
        <style> .btn-pay { display: none; } </style>
        ' . $form . '
        <script src="/assets/vendor/jquery-3.2.1.min.js"></script> <script> $(".btn-pay").click(); </script> ';

        }

    }
