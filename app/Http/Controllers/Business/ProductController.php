<?php

    namespace App\Http\Controllers\Business;

    use App\Http\Controllers\Controller;
    use App\Models\Business;
    use App\Models\BusinessProductFactories;
    use App\Models\BusinessProducts;
    use App\Models\Notification;
    use App\Models\NotificationMessage;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class ProductController extends Controller {
        public function __construct() {

        }

        public function index() {
            $business = Business::where('user_id', \request()->user()->id)->first();
            $products = BusinessProducts::where('business_id', $business->id)->paginate(env('PER_PAGE', 20));
            return view('business.settings.products.index', ['products' => $products]);

        }

        public function create() {
            $business = Business::with('factories')->where('user_id', \request()->user()->id)->first();
            if(count($business->factories) == 0) {
                return redirect()->route('business::setting.factories.create', ['lang' => app()->getLocale()]);
            }
            return view('business.settings.products.create', ['business' => $business]);

        }

        public function store(Request $request) {
            $business = Business::where('user_id', \request()->user()->id)->first();
            $validator = Validator::make($request->all(), [
                'mark' => 'required', 'class' => 'required', 'water_resistance' => 'required',
                'winter_supplement' => 'required', 'mixture_mobility' => 'required', 'frost_resistance' => 'required',
                'factories' => 'required', 'price' => 'required',]);
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При сохранении произошла ошибка, подробности смотрите ниже');

            }

            $productIfExists = BusinessProducts::where('business_id', $business->id)->where('factories_id', $request->get('factories'))->where('mark', $request->get('mark'))->where('class', $request->get('class'))->where('water_resistance', $request->get('water_resistance'))->where('winter_supplement', $request->get('winter_supplement'))->where('mixture_mobility', $request->get('mixture_mobility'))->where('frost_resistance', $request->get('frost_resistance'))->where('price', $request->get('price'))->first();
            if($productIfExists !== null) {
                return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'Вы не можете создать товар с этими параметрами, поскольку он уже создан. Пожалуйста, уварите другие параметры.');

            }

            $latestEntry = BusinessProducts::get();
            $product = new BusinessProducts;
            $product->business_id = $business->id;
            $product->factories_id = $request->get('factories');
            $product->product_number = str_pad(($latestEntry) ? count($latestEntry) + 1 : 1, 8, "0", STR_PAD_LEFT);
            $product->mark = $request->mark;
            $product->class = $request->class;
            $product->water_resistance = $request->water_resistance;
            $product->winter_supplement = $request->winter_supplement;
            $product->mixture_mobility = $request->mixture_mobility;
            $product->frost_resistance = $request->frost_resistance;
            $product->price = $request->price;
            $product->save();

            $notificationText = NotificationMessage::select('id')->where('action', 'business.product.adding')->first();
            $notification = new Notification;
            $notification->user_id = request()->user()->id;
            $notification->business_id = $business->id;
            $notification->business_factories_id = $product->factories_id;
            $notification->business_product_id = $product->id;
            $notification->notification_messages_id = $notificationText->id;
            $notification->is_customer = 0;
            $notification->is_sendmail = 0;
            $notification->is_new = 1;
            $notification->save();

            return redirect()->route('business::setting.product.index', ['lang' => app()->getLocale()])->with('success', 'Success');
        }

        public function edit($lang, $product_id) {
            $product = BusinessProducts::with('factories')->find($product_id);
            return view('business.settings.products.edit', ['product' => $product]);

        }

        public function update(Request $request, $lang, $product_id) {
            $validator = Validator::make($request->all(), [
                'mark' => 'required', 'class' => 'required', 'water_resistance' => 'required',
                'winter_supplement' => 'required', 'mixture_mobility' => 'required', 'frost_resistance' => 'required',
                'factories' => 'required', 'price' => 'required',]);
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При сохранении произошла ошибка, подробности смотрите ниже');

            }
            $product = BusinessProducts::find($product_id);
            $product->factories_id = $request->get('factories');
            $product->mark = $request->mark;
            $product->class = $request->class;
            $product->water_resistance = $request->water_resistance;
            $product->winter_supplement = $request->winter_supplement;
            $product->mixture_mobility = $request->mixture_mobility;
            $product->frost_resistance = $request->frost_resistance;
            $product->price = $request->price;
            $product->save();

            $notificationText = NotificationMessage::select('id')->where('action', 'business.product.edited')->first();
            $notification = new Notification;
            $notification->user_id = request()->user()->id;
            $notification->business_id = $product->business_id;
            $notification->business_factories_id = $product->factories_id;
            $notification->business_product_id = $product->id;
            $notification->notification_messages_id = $notificationText->id;
            $notification->is_customer = 0;
            $notification->is_sendmail = 0;
            $notification->is_new = 1;
            $notification->save();

            return redirect()->route('business::setting.product.index', ['lang' => $lang])->with('success', 'Success');
        }

        public function destroy($lang, $product_id) {
            $product = BusinessProducts::find($product_id);

            $notificationText = NotificationMessage::select('id')->where('action', 'business.product.deleted')->first();
            $notification = new Notification;
            $notification->user_id = request()->user()->id;
            $notification->business_id = $product->business_id;
            $notification->business_factories_id = $product->factories_id;
            $notification->business_product_id = $product->id;
            $notification->notification_messages_id = $notificationText->id;
            $notification->is_customer = 0;
            $notification->is_sendmail = 0;
            $notification->is_new = 1;
            $notification->save();

            $product->delete();
            return redirect()->route('business::setting.product.index', ['lang' => $lang])->with('success', 'Success');

        }

    }
