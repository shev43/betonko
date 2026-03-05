<?php

    namespace App\Http\Controllers\Frontend;

    use App\Http\Controllers\Controller;
    use App\Models\Business;
    use App\Models\Report;

    class BusinessController extends Controller {
        public function view($lang, $company_id) {
            $report = Report::where('business_id', $company_id)
                ->where('action', 'business_profile_views')->firstOrCreate();

            $report->business_id = $company_id ?? null;
            $report->technic_id = null;
            $report->action = 'business_profile_views';
            $report->count = $report->count + 1;
            $report->save();


            $business = Business::with([
                'contacts', 'factories', 'products'])->where('id', $company_id)->orderByDesc('id')->first();
            return view('frontend.catalog.company', ['lang' => $lang, 'business' => $business]);

        }
    }
