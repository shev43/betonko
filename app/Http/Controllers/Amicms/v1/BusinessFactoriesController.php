<?php

    namespace App\Http\Controllers\Amicms\v1;

    use App\Http\Controllers\AmicmsController;
    use App\Models\BusinessContacts;
    use App\Models\BusinessFactories;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use Config;

    class BusinessFactoriesController extends AmicmsController {
        private $layout = [];

        public function __construct() {
            $this->is_profile_auth();
            $this->layout['title'] = 'Підприємства';

        }

        protected function address_component($latitude, $longitude) {
            $key = env('APP_DEBUG') == true ? env('GOOGLE_API_KEY_TEST') : env('GOOGLE_API_KEY_PRODUCTION');
            $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$latitude.",".$longitude."&sensor=false&language=uk-UK&key=".$key;

            $json = file_get_contents($url);

            $json = json_decode($json, true);
            $parse_address_component = [];

            foreach($json['results'][0]['address_components'] as $results) {
                if($results['types'][0] == 'administrative_area_level_1' && !empty($results['long_name'])) {
                    $parse_address_component = $results['long_name'];
                } else if($results['types'][0] == 'locality' && !empty($results['long_name'])) {
                    if($results['long_name'] == 'Київ' || $results['long_name'] == 'місто Київ') {
                        $parse_address_component = 'Київська область';
                    } else {
                        $parse_address_component = $results['long_name'];
                    }
                }
            }

//        dd($parse_address_component );
            return $parse_address_component;
        }

        public function index($business_id) {
            $factories_array = BusinessFactories::where('business_id', $business_id)->withTrashed()->paginate(env('AMICMS_PER_PAGE'));

            return view('amicms.business.factories.index', ['layout' => $this->layout, 'business_id' => $business_id, 'factories_array' => $factories_array]);

        }

        public function create($business_id) {
            $contacts = BusinessContacts::where('business_id', $business_id)->get();

            return view('amicms.business.factories.create', ['layout' => $this->layout, 'business_id' => $business_id, 'contacts'=>$contacts]);

        }

        public function store(Request $request, $business_id) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'address' => 'required',
                'contacts' => 'required|array'
            ]);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При збереженні сталася помилка, подробиці дивіться нижче');

            }

            $latestEntry = BusinessFactories::get();

            $factory = new BusinessFactories;
            $factory->business_id = $business_id;
            $factory->contacts_id = implode(',', $request->get('contacts'));
            $factory->factory_number = str_pad(($latestEntry) ? count($latestEntry) + 1 : 1, 8, "0", STR_PAD_LEFT);
            $factory->name = $request->name;
            $factory->address = $request->address;
            $factory->region = $this->address_component($request->marker_latitude, $request->marker_longitude);

            $factory->map_latitude = ($request->map_latitude ?? Config::get('map.default.map_latitude'));
            $factory->map_longitude = ($request->map_longitude ?? Config::get('map.default.map_longitude'));
            $factory->map_zoom = ($request->map_zoom ?? Config::get('map.default.map_zoom'));
            $factory->map_rotate = ($request->map_rotate ?? Config::get('map.default.map_rotate'));
            $factory->marker_latitude = ($request->marker_latitude ?? Config::get('map.default.marker_latitude'));
            $factory->marker_longitude = ($request->marker_longitude ?? Config::get('map.default.marker_longitude'));
            $factory->photo = ($request->photo ?? null);
            $factory->save();

            return redirect()->route('amicms::business.factories.index', ['business_id'=>$business_id])->with('success', 'Дані успішно збережені');

        }

        public function edit($business_id, $factory_id) {
            $contacts = BusinessContacts::where('business_id', $business_id)->get();
            $factory = BusinessFactories::find($factory_id);

            return view('amicms.business.factories.edit', ['layout' => $this->layout, 'business_id' => $business_id, 'contacts'=>$contacts, 'factory'=>$factory]);

        }

        public function update(Request $request, $business_id, $factory_id) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'address' => 'required',
                'contacts' => 'required|array'
            ]);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При збереженні сталася помилка, подробиці дивіться нижче');

            }
            $factory = BusinessFactories::find($factory_id);
            $factory->contacts_id = implode(',', $request->get('contacts'));
            $factory->name = $request->name;
            $factory->address = $request->address;
            $factory->region = $this->address_component($request->marker_latitude, $request->marker_longitude);
            $factory->map_latitude = ($request->map_latitude ?? Config::get('map.default.map_latitude'));
            $factory->map_longitude = ($request->map_longitude ?? Config::get('map.default.map_longitude'));
            $factory->map_zoom = ($request->map_zoom ?? Config::get('map.default.map_zoom'));
            $factory->map_rotate = ($request->map_rotate ?? Config::get('map.default.map_rotate'));
            $factory->marker_latitude = ($request->marker_latitude ?? Config::get('map.default.marker_latitude'));
            $factory->marker_longitude = ($request->marker_longitude ?? Config::get('map.default.marker_longitude'));

            $factory->photo = ($request->photo ?? null);
            $factory->save();

            return redirect()->route('amicms::business.factories.index', ['business_id'=>$business_id])->with('success', 'Дані успішно збережені');

        }

        public function destroy($business_id, $factory_id) {
            BusinessFactories::find($factory_id)->delete();
            return redirect()->route('amicms::business.factories.index', ['business_id'=>$business_id])->with('success', 'Дані успішно видалені');

        }

        public function destroyWithTrash($business_id, $factory_id) {
            BusinessFactories::onlyTrashed()->find($factory_id)->forceDelete();
            return redirect()->route('amicms::business.factories.index', ['business_id'=>$business_id])->with('success', 'Дані успішно видалені');

        }

        public function restore($business_id, $contact_id) {
            BusinessFactories::onlyTrashed()->find($contact_id)->restore();
            return redirect()->route('amicms::business.factories.index', ['business_id'=>$business_id])->with('success', 'Дані успішно відновлено');

        }

    }
