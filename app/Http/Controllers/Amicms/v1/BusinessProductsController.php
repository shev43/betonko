<?php

namespace App\Http\Controllers\Amicms\v1;

use App\Http\Controllers\AmicmsController;
use App\Models\BusinessContacts;
use App\Models\BusinessFactories;
use App\Models\BusinessProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BusinessProductsController extends AmicmsController {
    private $layout = [];

    public function __construct() {
        $this->is_profile_auth();
        $this->layout['title'] = 'Підприємства';

    }

    public function index($business_id) {
        $products_array = BusinessProducts::whereHas('factory')->where('business_id', $business_id)->withTrashed()->paginate(env('AMICMS_PER_PAGE'));

        return view('amicms.business.products.index', ['layout' => $this->layout, 'business_id' => $business_id, 'products_array' => $products_array]);

    }

    public function create($business_id) {
        $factories_array = BusinessFactories::where('business_id', $business_id)->get();
        return view('amicms.business.products.create', ['layout' => $this->layout, 'business_id' => $business_id, 'factories_array'=>$factories_array]);

    }

    public function store(Request $request, $business_id) {
        $validator = Validator::make($request->all(), [
            'mark' => 'required', 'class' => 'required', 'water_resistance' => 'required',
            'winter_supplement' => 'required', 'mixture_mobility' => 'required', 'frost_resistance' => 'required',
            'factories' => 'required', 'price' => 'required']);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При збереженні сталася помилка, подробиці дивіться нижче');

        }

        $productIfExists = BusinessProducts::where('business_id', $business_id)->where('factories_id', $request->get('factories'))->where('mark', $request->get('mark'))->where('class', $request->get('class'))->where('water_resistance', $request->get('water_resistance'))->where('winter_supplement', $request->get('winter_supplement'))->where('mixture_mobility', $request->get('mixture_mobility'))->where('frost_resistance', $request->get('frost_resistance'))->where('price', $request->get('price'))->first();
        if($productIfExists !== null) {
            return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'Вы не можете создать товар с этими параметрами, поскольку он уже создан. Пожалуйста, уварите другие параметры.');

        }

        $latestEntry = BusinessProducts::get();

        $product = new BusinessProducts;
        $product->business_id = $business_id;
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

        return redirect()->route('amicms::business.products.index', ['business_id'=>$business_id])->with('success', 'Дані успішно збережені');

    }

    public function edit($business_id, $product_id) {
        $product = BusinessProducts::with('factories')->find($product_id);

        return view('amicms.business.products.edit', ['layout' => $this->layout, 'business_id' => $business_id, 'product'=>$product]);

    }

    public function update(Request $request, $business_id, $product_id) {
        $validator = Validator::make($request->all(), [
            'mark' => 'required', 'class' => 'required', 'water_resistance' => 'required',
            'winter_supplement' => 'required', 'mixture_mobility' => 'required', 'frost_resistance' => 'required',
            'factories' => 'required', 'price' => 'required']);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При збереженні сталася помилка, подробиці дивіться нижче');

        }

        $product = BusinessProducts::find($product_id);
        $product->factories_id = $request->factories;
        $product->mark = $request->mark;
        $product->class = $request->class;
        $product->water_resistance = $request->water_resistance;
        $product->winter_supplement = $request->winter_supplement;
        $product->mixture_mobility = $request->mixture_mobility;
        $product->frost_resistance = $request->frost_resistance;
        $product->price = $request->price;
        $product->save();

        return redirect()->route('amicms::business.products.index', ['business_id'=>$business_id])->with('success', 'Дані успішно збережені');

    }

    public function destroy($business_id, $factory_id) {
        BusinessProducts::find($factory_id)->delete();
        return redirect()->route('amicms::business.products.index', ['business_id'=>$business_id])->with('success', 'Дані успішно видалені');

    }

    public function destroyWithTrash($business_id, $factory_id) {
        BusinessProducts::onlyTrashed()->find($factory_id)->forceDelete();
        return redirect()->route('amicms::business.products.index', ['business_id'=>$business_id])->with('success', 'Дані успішно видалені');

    }

    public function restore($business_id, $contact_id) {
        BusinessProducts::onlyTrashed()->find($contact_id)->restore();
        return redirect()->route('amicms::business.products.index', ['business_id'=>$business_id])->with('success', 'Дані успішно відновлено');

    }

}
