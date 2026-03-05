<?php

    namespace App\Http\Controllers\Frontend;

    use App\Http\Controllers\Controller;
    use App\Models\BusinessFactories;
    use App\Models\City;
    use App\Models\Report;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class CatalogController extends Controller {
        public function index() {

            $buildFactories = BusinessFactories::query();


            if(!empty(request()->get('region'))) {
                $buildFactories->where('region', 'like', '%' . request()->get('region') . '%');

            }

            $businessFactories = $buildFactories->paginate(env('PER_PAGE', 20));

            $regions = City::get();

            return view('frontend.catalog.index', ['businessFactories' => $businessFactories, 'regions'=>$regions]);

        }

        public function view($lang, $factory_id) {

            $businessFactory = BusinessFactories::with([
                'business', 'products', 'contacts'])->where('id', $factory_id)->first();


            $report = Report::where('business_id', $businessFactory->business_id)
                ->where('technic_id', $businessFactory->id)
                ->where('action', 'business_factory_views')->firstOrCreate();

            $report->business_id = $businessFactory->business_id ?? null;
            $report->technic_id = $businessFactory->id ?? null;
            $report->action = 'business_factory_views';
            $report->count = $report->count + 1;
            $report->save();


            return view('frontend.catalog.factory', ['businessFactory' => $businessFactory]);

        }

    }
