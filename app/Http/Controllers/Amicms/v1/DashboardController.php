<?php

namespace App\Http\Controllers\Amicms\v1;

use App\Http\Controllers\AmicmsController;
use App\Models\Business;
use App\Models\BusinessFactories;
use App\Models\Report;
use Illuminate\Http\Request;

class DashboardController extends AmicmsController {
    private $layout = [];

    public function __construct() {
        $this->is_profile_auth();
        $this->layout['title'] = 'Панель інструментів';

    }

    public function index(Request $request) {
        $technics_query = BusinessFactories::with('reports');
        if(!empty($request->get('period')) && $request->has('period')) {
            $periodExp = explode(' - ', $request->get('period'));
            $startDate = date('Y-m-d 00:00:00', strtotime($periodExp[0]));
            $endDate = date('Y-m-d 23:59:59', strtotime($periodExp[1]));

            $technics_query->whereHas('reports', function($query1) use ($startDate, $endDate) {
                $query1->whereBetween('created_at', [$startDate, $endDate]);
            });




        }

        $technics_array = $technics_query->get();

        $reports_array = [];
        foreach($technics_array as $technic_key => $technic) {
            $reports_array[$technic_key]['id'] = $technic->id;
            $reports_array[$technic_key]['business_id'] = $technic->business_id;
            $reports_array[$technic_key]['name'] = $technic->name;
            $reports_array[$technic_key]['photo'] = $technic->photo;

            $business_factory_views = 0;
            $business_profile_views = 0;
            $email_views = 0;
            $phone_views = 0;
            $www_views = 0;
            $contact_person_phone_views = 0;

            foreach($technic->reports as $report) {
                if($technic->id == $report->technic_id) {
                    if($report->action == 'business_factory_views') {
                        $business_factory_views = $report->count;
                    }
                    if($report->action == 'business_profile_views') {
                        $business_profile_views = $report->count;
                    }
                    if($report->action == 'email_views') {
                        $email_views = $report->count;
                    }

                    if($report->action == 'phone_views') {
                        $phone_views = $report->count;
                    }

                    if($report->action == 'www_views') {
                        $www_views = $report->count;
                    }

                    if($report->action == 'contact_person_phone_views') {
                        $contact_person_phone_views = $report->count;
                    }
                }

            }


            $reports_array[$technic_key]['business_factory_views'] = $business_factory_views ?? null;
            $reports_array[$technic_key]['business_profile_views'] = $business_profile_views ?? null;
            $reports_array[$technic_key]['email_views'] = $email_views ?? null;
            $reports_array[$technic_key]['phone_views'] = $phone_views ?? null;
            $reports_array[$technic_key]['www_views'] = $www_views ?? null;
            $reports_array[$technic_key]['contact_person_phone_views'] = $contact_person_phone_views ?? null;

        }

//        dd($reports_array);



        $business_factory_views_query = Report::where('action', 'business_factory_views');
        $business_profile_views_query = Report::where('action', 'business_profile_views');
        $email_views_query = Report::where('action', 'email_views');
        $phone_views_query = Report::where('action', 'phone_views');
        $www_views_query = Report::where('action', 'www_views');
        $contact_person_phone_views_query = Report::where('action', 'contact_person_phone_views');

        $business_register_views = Business::query();

        if(!empty($request->get('period')) && $request->has('period')) {
            $periodExp = explode(' - ', $request->get('period'));
            $startDate = date('Y-m-d 00:00:00', strtotime($periodExp[0]));
            $endDate = date('Y-m-d 23:59:59', strtotime($periodExp[1]));

            $business_factory_views_query->whereBetween('created_at', [$startDate, $endDate]);
            $business_profile_views_query->whereBetween('created_at', [$startDate, $endDate]);
            $email_views_query->whereBetween('created_at', [$startDate, $endDate]);
            $phone_views_query->whereBetween('created_at', [$startDate, $endDate]);
            $www_views_query->whereBetween('created_at', [$startDate, $endDate]);
            $contact_person_phone_views_query->whereBetween('created_at', [$startDate, $endDate]);
            $business_register_views->whereBetween('created_at', [$startDate, $endDate])->get();

        }

        $business_factory_views = $business_factory_views_query->sum('count');
        $business_profile_views = $business_profile_views_query->sum('count');
        $email_views = $email_views_query->sum('count');
        $phone_views = $phone_views_query->sum('count');
        $www_views = $www_views_query->sum('count');
        $contact_person_phone_views = $contact_person_phone_views_query->sum('count');

        $business_register_views = $business_register_views->get();

        $metaTags = [
            'metaTitle' => (app()->getLocale() == 'ua') ? 'Статистика' : '',
            'metaKeywords' => '',
            'metaDescription' => ''
        ];

        return view('amicms.dashboard.index', [
            'layout' => $this->layout,
            'reports_array'=>$reports_array,

            'business_register_views' => count($business_register_views),
            'business_factory_views' => $business_factory_views,
            'business_profile_views' => $business_profile_views,
            'email_views' => $email_views,
            'phone_views' => $phone_views,
            'www_views' => $www_views,
            'contact_person_phone_views' => $contact_person_phone_views,

            'startDate'=> $request->has('period') ?  $startDate : null,
            'endDate'=> $request->has('period') ?  $endDate : null,
        ]);

    }

}
