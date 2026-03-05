<?php

    namespace App\Http\Controllers\Amicms\v1;

    use App\Http\Controllers\AmicmsController;
    use App\Imports\UsersImport;
    use App\Models\Business;
    use App\Models\BusinessFactories;
    use App\Models\Report;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use Image;
    use Config;
    use Maatwebsite\Excel\Facades\Excel;


    class BusinessController extends AmicmsController {
        private $layout = [];
        protected $phone;

        public function __construct() {
            $this->is_profile_auth();
            $this->layout['title'] = 'Підприємства';

        }

        public function index() {
            $business_array = Business::withTrashed();

            $query = \request()->get('q');
            if(!empty($query)) {
                $business_array->where('name', 'like', '%' . $query . '%')->orWhere('business_number', 'like', '%' . $query . '%');
            }

            $business_array = $business_array->paginate(env('AMICMS_PER_PAGE'));

            return view('amicms.business.index', ['layout' => $this->layout, 'business_array' => $business_array]);

        }

        public function create() {
            return view('amicms.business.create', ['layout' => $this->layout]);

        }

        public function store(Request $request) {
            $this->phone = str_replace([' ', '-', '+', '(', ')'], '', $request->get('phone'));
            $request->merge([
                'phone' => $this->phone,
            ]);

            $validator = Validator::make($request->all(), [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:255', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'representative' => ['required', 'string', 'max:255'],
                'password' => ['required_with:password_confirmation', 'string', 'min:6', 'confirmed'],
                'password_confirmation' => ['required', 'same:password', 'string', 'min:6'],
                ]
            );


            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При збереженні сталася помилка, подробиці дивіться нижче');
            }


            $latestEntry = User::get();

            $user = new User();
            $user->account_type = 3;
            $user->profile_number = str_pad(($latestEntry) ? count($latestEntry) + 1 : 1, 8, "0", STR_PAD_LEFT);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->phone = $this->phone;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            $businessLatestEntry = Business::get();

            $business = new Business;
            $business->user_id = $user->id;
            $business->business_number = str_pad(($businessLatestEntry) ? count($businessLatestEntry) + 1 : 1, 8, "0", STR_PAD_LEFT);
            $business->name = $request->representative;
            $business->save();

            return redirect()->route('amicms::business.index')->with('success', 'Дані успішно збережені');

        }

        public function edit($business_id) {
            $business = Business::where('id', $business_id)->withTrashed()->first();
            return view('amicms.business.edit', ['layout' => $this->layout, 'business' => $business, 'business_id'=>$business_id]);

        }

        public function update(Request $request, $business_id ) {
            $business = Business::where('id', $business_id)->withTrashed()->first();

            $this->phone = str_replace([' ', '-', '+', '(', ')'], '', $request->get('phone'));
            $request->merge([
                'phone' => $this->phone,
            ]);


            $validator = Validator::make($request->all(), [
                    'name' => ['required', 'string', 'max:255'],
                    'phone' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255'],
                    'address' => ['required', 'string'],
                    'description' => ['string'],
                ]
            );

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При збереженні сталася помилка, подробиці дивіться нижче');
            }

            $business->name = $request->name;
            $business->phone = $request->phone;
            $business->email = $request->email;
            $business->address = $request->address;
            $business->description = $request->description;
            $business->map_latitude = ($request->map_latitude ?? Config::get('map.default.map_latitude'));
            $business->map_longitude = ($request->map_longitude ?? Config::get('map.default.map_longitude'));
            $business->map_zoom = ($request->map_zoom ?? Config::get('map.default.map_zoom'));
            $business->map_rotate = ($request->map_rotate ?? Config::get('map.default.map_rotate'));
            $business->marker_latitude = ($request->marker_latitude ?? Config::get('map.default.marker_latitude'));
            $business->marker_longitude = ($request->marker_longitude ?? Config::get('map.default.marker_longitude'));
            $business->save();

            return redirect()->back()->with('success', 'Дані успішно збережені');

        }

        public function activate($user_id) {
            $user = User::find($user_id);
            $user->enabled = ($user->enabled == 0) ? 1 : 0;
            $user->save();

        }

        public function destroy($business_id) {
            $contact = Business::find($business_id);
            $contact->delete();
            return redirect()->route('amicms::business.index', ['business_id'=>$business_id])->with('success', 'Дані успішно видалені');

        }

        public function destroyWithTrash($business_id) {
            Business::onlyTrashed()->find($business_id)->forceDelete();
            return redirect()->route('amicms::business.index', ['business_id'=>$business_id])->with('success', 'Дані успішно видалені');

        }

        public function restore($business_id) {
            Business::onlyTrashed()->find($business_id)->restore();
            return redirect()->route('amicms::business.index', ['business_id'=>$business_id])->with('success', 'Дані успішно відновлено');

        }

        public function import() {
            return view('amicms.business.import', ['layout' => $this->layout]);
        }

        public function importStore(Request $request) {
            ini_set('max_execution_time', 600000);
            $import = new UsersImport;
            Excel::import($import, $request->file('file'));

            return redirect()->route('amicms::business.import.index')->with('success', 'Импорт успешно завершен');
        }

        public function visitors(Request $request, $business_id)
        {
            $technics_query = BusinessFactories::with('reports')->where('business_id', $business_id);

            if (!empty($request->get('period')) && $request->has('period')) {
                $periodExp = explode(' - ', $request->get('period'));
                $startDate = date('Y-m-d 00:00:00', strtotime($periodExp[0]));
                $endDate = date('Y-m-d 23:59:59', strtotime($periodExp[1]));

                $technics_query->whereHas('reports', function ($query1) use ($startDate, $endDate) {
                    $query1->whereBetween('created_at', [$startDate, $endDate]);
                });


            }

            $technics_array = $technics_query->get();

            $reports_array = [];
            foreach ($technics_array as $technic_key => $technic) {
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

                foreach ($technic->reports as $report) {
                    if ($technic->id == $report->technic_id) {
                        if ($report->action == 'business_factory_views') {
                            $business_factory_views = $report->count;
                        }
                        if ($report->action == 'business_profile_views') {
                            $business_profile_views = $report->count;
                        }
                        if ($report->action == 'email_views') {
                            $email_views = $report->count;
                        }

                        if ($report->action == 'phone_views') {
                            $phone_views = $report->count;
                        }

                        if ($report->action == 'www_views') {
                            $www_views = $report->count;
                        }

                        if ($report->action == 'contact_person_phone_views') {
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


            $business_factory_views_query = Report::where('action', 'business_factory_views')->where('business_id', $business_id);
            $business_profile_views_query = Report::where('action', 'business_profile_views')->where('business_id', $business_id);
            $email_views_query = Report::where('action', 'email_views')->where('business_id', $business_id);
            $phone_views_query = Report::where('action', 'phone_views')->where('business_id', $business_id);
            $www_views_query = Report::where('action', 'www_views')->where('business_id', $business_id);
            $contact_person_phone_views_query = Report::where('action', 'contact_person_phone_views')->where('business_id', $business_id);

            if (!empty($request->get('period')) && $request->has('period')) {
                $periodExp = explode(' - ', $request->get('period'));
                $startDate = date('Y-m-d 00:00:00', strtotime($periodExp[0]));
                $endDate = date('Y-m-d 23:59:59', strtotime($periodExp[1]));

                $business_factory_views_query->whereBetween('created_at', [$startDate, $endDate]);
                $business_profile_views_query->whereBetween('created_at', [$startDate, $endDate]);
                $email_views_query->whereBetween('created_at', [$startDate, $endDate]);
                $phone_views_query->whereBetween('created_at', [$startDate, $endDate]);
                $www_views_query->whereBetween('created_at', [$startDate, $endDate]);
                $contact_person_phone_views_query->whereBetween('created_at', [$startDate, $endDate]);
            }

            $business_factory_views = $business_factory_views_query->sum('count');
            $business_profile_views = $business_profile_views_query->sum('count');
            $email_views = $email_views_query->sum('count');
            $phone_views = $phone_views_query->sum('count');
            $www_views = $www_views_query->sum('count');
            $contact_person_phone_views = $contact_person_phone_views_query->sum('count');


            $metaTags = [
                'metaTitle' => (app()->getLocale() == 'ua') ? 'Статистика' : '',
                'metaKeywords' => '',
                'metaDescription' => ''
            ];

            return view('amicms.reports.visitors', [
                'layout' => $this->layout,
                'business_id' => $business_id,
                'reports_array' => $reports_array,

                'business_factory_views' => $business_factory_views,
                'business_profile_views' => $business_profile_views,
                'email_views' => $email_views,
                'phone_views' => $phone_views,
                'www_views' => $www_views,
                'contact_person_phone_views' => $contact_person_phone_views,

                'startDate' => $request->has('period') ? $startDate : null,
                'endDate' => $request->has('period') ? $endDate : null,
            ]);


        }


    }
